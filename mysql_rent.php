<?php
include_once 'pdo_connect.php';


/*Делаем победителя*/
if(isset($_POST['plus_winid']) && isset($_POST['posid'])){
    $winid = $_POST['plus_winid'];//ID победителя
    $posid = $_POST['posid'];//ID позиции

    //Задача - добыть имя Поставщика - победителя. Из расценки его вытащим
    //Запрос:
    $getvars = $pdo->prepare("SELECT `name`,`price`,`kol`,`rent` FROM (SELECT sellerid,pricingid,price,kol,rent FROM pricings WHERE pricingid = ?) AS a LEFT JOIN (SELECT sellers_id,name FROM sellers LEFT JOIN allnames ON sellers.sellers_nameid=allnames.nameid) AS b ON a.sellerid = b.sellers_id");
    $changewinner = $pdo->prepare("UPDATE `req_positions` SET `winnerid` = ? WHERE `req_positionid` = ?");
    $makeequal = $pdo->prepare("UPDATE `pricings` SET `winner`=0 WHERE `positionid` = ? AND `winner` = 1");
    $makewinner = $pdo->prepare("UPDATE `pricings` SET `winner`=1 WHERE `pricingid` = ?");

    try{
        //$pdo->beginTransaction();
        $changewinner->execute(array($winid, $posid));
        $makeequal->execute(array($posid));
        $makewinner->execute(array($winid));
        $getvars->execute(array($winid));
        //$pdo->commit();

        $w = $getvars->fetchAll(PDO::FETCH_ASSOC);
        print json_encode(array(
            "data1"=>$w[0]['name'],
            "data2"=>(int)$w[0]['price']*(int)$w[0]['kol'],
            "data3"=>$w[0]['rent']
            ));

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
};

/*Отменяем победителя*/
if(isset($_POST['minus_winid']) && isset($_POST['posid'])){
    $losid = $_POST['minus_winid'];
    $posid = $_POST['posid'];

    $erasewinner = $pdo->prepare("UPDATE `req_positions` SET `winnerid` = 0 WHERE `req_positionid` = ?");
    $makeloser = $pdo->prepare("UPDATE `pricings` SET `winner`= 0 WHERE `pricingid` = ?");

    try{
        $pdo->beginTransaction();
        $erasewinner->execute(array($posid));
        $makeloser->execute(array($losid));
        $pdo->commit();
        echo 'Победитель отменен.';

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
};

/*РАСЧЕТ ОБЩЕЙ РЕНТАБЕЛЬНОСТИ*/
if (isset($_POST['request'])){
    $reqid = (int)$_POST['request'];
    $wincount == 0;
    $getvars = $pdo->prepare("SELECT `req_positionid`,`winnerid` FROM req_positions WHERE `req_positions`.`requestid` = ?");
    $nam == 0;//Переменная, в зависимости от того, зафиксирована расценка или нет
    $countrent = $pdo->prepare("SELECT * FROM (SELECT `winnerid` FROM `req_positions` WHERE `requestid` = ?) AS a LEFT JOIN (SELECT `kol`,`price`,`rop`,`opr`,`fixed`,`wtime`,`pricingid`,`name`,`tradeid` FROM `pricings` AS c LEFT JOIN (SELECT `trades_id`,`name` FROM `trades` LEFT JOIN `allnames` ON `trades`.`trades_nameid`=`allnames`.`nameid`) AS d ON c.`tradeid`=d.`trades_id`) AS b ON a.`winnerid` = b.`pricingid`");
    $save_rent = $pdo->prepare("UPDATE `requests` SET `req_rent`=? WHERE `requests_id`=?");
    $save_sum = $pdo->prepare("UPDATE `requests` SET `req_sum`=? WHERE `requests_id`=?");
    try{
        $pdo->beginTransaction();
        $countrent->execute(array($reqid));
        $getvars->execute(array($reqid));
        $pdo->commit();

        /*Число рядов в массиве покажет количество позиций*/
        $poscount = $getvars->rowCount();
        /*Число победителей считается перебором и сравнением с 0*/
        $p=$getvars->fetchAll(PDO::FETCH_ASSOC);
        foreach ($p as $row){
            if ($row['1'] !== 0){
                ++$wincount;
            }
        }

        $c=$countrent->fetchAll(PDO::FETCH_ASSOC);

        $result="
                <table>
                <thead>                
                <th>Номенклатура</th>
                <th>Наши</th> 
                <th>Количество</th>
                <th>Отсрочка</th>
                <th>Цена</th>
                </thead>";

        /*ФОРМУЛА РАСЧЕТА И ПЕРЕМЕННЫЕ К НЕЙ*/
        $form_top = [];
        $form_bot = [];


        //Переменные для демонстрационной дроби
        $dem_top;
        $dem_bot;
        /*ФОРМУЛА РАСЧЕТА*/

        foreach ($c as $row){
            /*Временные переменные для приведения к числу*/
            $pricingid=(int)$row['pricingid'];
            $price=(int)$row['price'];
            $fixed=(int)$row['fixed'];
            $opr=(int)$row['opr'];
            $rop=(int)$row['rop'];
            $kol=(int)$row['kol'];
            $wtime=(int)$row['wtime'];

            switch ($fixed) {
                case 0:$nam = $opr;
                break;
                case 1:$nam = $rop;
                break;
            };
            $result.= "<tr><td class ='pricingid'>" . $row['name'] . "</td>";
            $result .="<td class ='nam'>" . $nam . "</td>";
            $result.= "<td class ='kol'>" . $kol . "</td>";
            $result .="<td class ='wtime'>" . $wtime . "</td>";
            $result.= "<td class ='price'>" . $price . "</td></tr>";

            /*формула расчета:*/
            $form_top[] = $nam * $kol * (1 - (0.015 * $wtime));
            $form_bot[] = $price * $kol;
            /*закончилась формула*/

            /*Показательная дробь*/
            $dem_top .=$nam . " * " . $kol . " * " . "(1 - (0.015 * " . $wtime . ")) + ";
            $dem_bot .="(" . $row['price'] . " * " . $row['kol'].") + ";
            /*Закончилась показательная дробь*/
        };
        $result .="</table><br>";

        if (((int)$poscount - (int)$wincount) > 0){
            /*Посылаем ноль в графу общей рентабельности*/
            $pdo->beginTransaction();
            $save_rent->execute(array(0, $reqid));
            $pdo->commit();

            /*Посылаем ноль в графу общей рентабельности*/
            $pdo->beginTransaction();
            $save_sum->execute(array(0, $reqid));
            $pdo->commit();

            print (json_encode(array(
                "data1"=>"<span>Расчет общей рентабельности невозможен.<br><br>a)выберите победителя в каждой из позиций<br>b)удалите ненужные позиции.</span>
            <br><br><span>Разница: " . ((int)$poscount - (int)$wincount) . " Позиций: " . $poscount . " Победителей: " . $wincount . "</span>",
                "data2"=>"0.00",
                "data3"=>"0.00")));

        };
        if (((int)$poscount - (int)$wincount) == 0){
            $top;
            $bot;
            foreach($form_top as $key=>$value){$top = $top + $value;}
            foreach($form_bot as $key=>$value){$bot = $bot + $value;}

            $dem_top = substr($dem_top, 0, -3);//Срезаем лишние плюсы с демонстрационных строк
            $dem_bot = substr($dem_bot, 0, -3);

            /*расчет рентабельности*/

            $rent = number_format((int)$top/(int)$bot*100, 2);

            //Сохраняем в базу рентабельность заказа
            $pdo->beginTransaction();
            $save_rent->execute(array($rent, $reqid));
            $pdo->commit();

            //Сохраняем в базу сумму заказа
            $pdo->beginTransaction();
            $save_sum->execute(array($bot, $reqid));
            $pdo->commit();

            print (json_encode(array("data1"=>"Расчет рентабельности: <br><br><table class ='demo'><tr><td>" . $dem_top . "</td></tr><tr><td>" . $dem_bot . "</td></tr></table><br><br><span> Общая рентабельность: " . $rent . " % </span> " . $result . " <br><br><span>Разница: " . ((int)$poscount - (int)$wincount) . " Позиций: " . (int)$poscount . " Победителей: " . (int)$wincount . "</span>","data2"=>$rent,"data3"=>$bot)));

        };




    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
};
/***/























