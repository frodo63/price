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
            "data2"=>round($w[0]['price']*$w[0]['kol'], 2),
            "data3"=>$w[0]['rent']
            ));

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
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
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};

/*Читаем данные по победителю*/
if(isset($_POST['read_winid'])){
    $winid = $_POST['read_winid'];//ID победителя

    //Задача - добыть имя Поставщика - победителя. Из расценки его вытащим
    //Запрос:
    $getvars = $pdo->prepare("SELECT `name`,`price`,`kol`,`rent` FROM (SELECT sellerid,pricingid,price,kol,rent FROM pricings WHERE pricingid = ?) AS a LEFT JOIN (SELECT sellers_id,name FROM sellers LEFT JOIN allnames ON sellers.sellers_nameid=allnames.nameid) AS b ON a.sellerid = b.sellers_id");
    try{
        $pdo->beginTransaction();
        $getvars->execute(array($winid));
        $pdo->commit();

        $w = $getvars->fetchAll(PDO::FETCH_ASSOC);
        print json_encode(array(
            "data1"=>$w[0]['name'],
            "data2"=>round($w[0]['price']*$w[0]['kol'], 2),
            "data3"=>$w[0]['rent']
        ));

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};

/*РАСЧЕТ ОБЩЕЙ РЕНТАБЕЛЬНОСТИ*/
if (isset($_POST['request'])){
    $reqid = $_POST['request'];
    $wincount = 0;
    $getvars = $database->prepare("SELECT `req_positionid`,`winnerid` FROM req_positions WHERE `req_positions`.`requestid` = ?");
    $nam == 0;//Переменная, в зависимости от того, зафиксирована расценка или нет
    $countrent = $database->prepare("SELECT * FROM (SELECT `winnerid` FROM `req_positions` WHERE `requestid` = ? AND `winnerid` != 0 ) AS a LEFT JOIN (SELECT `kol`,`price`,`rop`,`opr`,`fixed`,`wtime`,`pricingid`,`name`,`tradeid` FROM `pricings` AS c LEFT JOIN (SELECT `trades_id`,`name` FROM `trades` LEFT JOIN `allnames` ON `trades`.`trades_nameid`=`allnames`.`nameid`) AS d ON c.`tradeid`=d.`trades_id`) AS b ON a.`winnerid` = b.`pricingid`");
    $save_rent = $database->prepare("UPDATE `requests` SET `req_rent`=? WHERE `requests_id`=?");
    $save_sum = $database->prepare("UPDATE `requests` SET `req_sum`=? WHERE `requests_id`=?");
    try{
        $database->beginTransaction();
        $countrent->execute(array($reqid));
        $getvars->execute(array($reqid));
        $database->commit();

        /*Число рядов в массиве покажет количество позиций*/

        /*Убрал подсчет общй позиций*/
        //$poscount = $getvars->rowCount();

        /*Число победителей считается перебором и сравнением с 0*/
        $p=$getvars->fetchAll(PDO::FETCH_ASSOC);
        foreach ($p as $row){
            if ($row['winnerid'] !== '0'){
                ++$wincount;
            }
        }

        $c=$countrent->fetchAll(PDO::FETCH_ASSOC);
        $c_count = $countrent->rowCount();

        $result="
                <table class='rent-table'>
                <thead>                
                <th>Номенклатура</th>
                <th>Наши</th> 
                <th>Количество</th>
                <th>Сумма</th>
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
            $pricingid=$row['pricingid'];
            $price = round($row['price'], 3);
            $fixed=$row['fixed'];
            $opr = round($row['opr'], 2);
            $rop = round($row['rop'], 2);
            $kol = round($row['kol'], 2);
            $wtime = round($row['wtime'], 2);

            switch ($fixed) {
                case 0:$nam = $opr;
                break;
                case 1:$nam = $rop;
                break;
            };
            $result.= "<tr><td class ='pricingid'>" . $row['name'] . "</td>";
            $result .="<td class ='nam'>" . round($nam, 2) . "</td>";
            $result.= "<td class ='kol'>" . $kol . "</td>";
            $result.= "<td class ='sum'>" . round($nam, 2)*$kol . "</td>";
            $result .="<td class ='wtime'>" . $wtime . "</td>";
            $result.= "<td class ='price'>" . $price . "</td></tr>";

            /*формула расчета:*/
            $form_top[] = $nam * $kol;
            $form_bot[] = $price * $kol;
            /*закончилась формула*/

            /*Показательная дробь*/
            $dem_top .=$nam . " * " . $kol . " + ";
            $dem_bot .="(" . round($row['price'],2) . " * " . $row['kol'].") + ";
            /*Закончилась показательная дробь*/
        };
        $result .="</table><br>";

        //Убрал расчет разницы, заменил на сравнение rowCount($c)  с 0
        //$countdif = round($poscount,0) - round($wincount,0);


        if ($c_count == 0){
            /*Посылаем ноль в графу общей рентабельности*/
            $database->beginTransaction();
            $save_rent->execute(array(0, $reqid));
            $database->commit();

            /*Посылаем ноль в графу суммы заявки*/
            $database->beginTransaction();
            $save_sum->execute(array(0, $reqid));
            $database->commit();

            print (json_encode(array(
                "data1"=>"<span>Расчет общей суммы и рентабельности невозможен.<br><br>Назначьте хотя бы одного победителя.</span><br>",
                "data2"=>"0.00",
                "data3"=>"0.00")));

        };
        if ($c_count > 0){
            $top;
            $bot;

            /*расчет рентабельности*/
            $top = round(array_sum($form_top), 3);
            $bot = round(array_sum($form_bot), 3);
            $rent = round($top/$bot*100, 2);

            $dem_top = substr($dem_top, 0, -3);//Срезаем лишние плюсы с демонстрационных строк
            $dem_bot = substr($dem_bot, 0, -3);

            //Сохраняем в базу рентабельность заказа
            $database->beginTransaction();
            $save_rent->execute(array($rent, $reqid));
            $database->commit();

            //Сохраняем в базу сумму заказа
            $database->beginTransaction();
            $save_sum->execute(array($bot, $reqid));
            $database->commit();
            print (json_encode(array("data1"=>"Расчет рентабельности: <br><br><table class ='demo'><tr><td>" . $dem_top . "</td></tr><tr><td>" . $dem_bot . "</td></tr></table><br><br><span> Общая рентабельность: " . $rent . " % </span> " . $result . " <br><br>","data2"=>$rent,"data3"=>number_format($bot,2,'.',' ')." руб.")));
        };

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/***/























