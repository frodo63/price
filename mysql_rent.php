<?php
include_once 'pdo_connect.php';


/*Делаем победителя*/
if(isset($_POST['plus_winid']) && isset($_POST['posid'])){
    $winid = $_POST['plus_winid'];
    $posid = $_POST['posid'];


    $changewinner = $pdo->prepare("UPDATE `req_positions` SET `winnerid` = ? WHERE `req_positionid` = ?");
    $makeequal = $pdo->prepare("UPDATE `pricings` SET `winner`=0 WHERE `positionid` = ? AND `winner` = 1");
    $makewinner = $pdo->prepare("UPDATE `pricings` SET `winner`=1 WHERE `pricingid` = ?");

    try{
        $pdo->beginTransaction();
        $changewinner->execute(array($winid, $posid));
        $makeequal->execute(array($posid));
        $makewinner->execute(array($winid));
        $pdo->commit();
        echo 'Победитель назначен.';

    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
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

    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }
};

/*РАСЧЕТ ОБЩЕЙ РЕНТАБЕЛЬНОСТИ*/
if (isset($_POST['request']) && isset($_POST['poscount'])){
    $reqid = $_POST['request'];
    $poscount = $_POST['poscount'];
    $wincount = 0;
    $nam = 0;//Переменная, в зависимости от того, зафиксирована расценка или нет
    $countrent = $pdo->prepare("
SELECT `pricingid`,`price`,`rop`,`opr`,`fixed`,`kol`,`wtime` FROM 
(SELECT `winnerid` FROM `req_positions` WHERE `requestid` = ?) AS a INNER JOIN 
(SELECT `kol`,`price`,`rop`,`opr`,`fixed`,`wtime`,`pricingid` FROM `pricings`) AS b ON a.`winnerid` = b.`pricingid`");
    $stm = $pdo->prepare("UPDATE `requests` SET `req_rent`=? WHERE `requests_id`=?");
    try{
        $pdo->beginTransaction();
        $countrent->execute(array($reqid));
        $pdo->commit();

        $c=$countrent->fetchAll(PDO::FETCH_ASSOC);

        $result="
                <table>
                <thead>
                <th>Номер расценки</th>
                <th>Цена</th>
                <th>Наши</th>
                <th>Количество</th>
                <th>Отсрочка</th>                
                </thead>";

        /*ФОРМУЛА РАСЧЕТА И ПЕРЕМЕННЫЕ К НЕЙ*/
        $form_top = [];
        $form_bot = [];


        //Переменные для демонстрационной дроби
        $dem_top;
        $dem_bot;
        /*ФОРМУЛА РАСЧЕТА*/

        foreach ($c as $row){
            ++$wincount;//Увеличиваем на 1 счетчик виннеров

            /*Временные переменные для приведения к числу*/
            $pricingid=intval($row['pricingid']);
            $price=intval($row['price']);
            $fixed=intval($row['fixed']);
            $opr=intval($row['opr']);
            $rop=intval($row['rop']);
            $kol=intval($row['kol']);
            $wtime=intval($row['wtime']);




            $result.="
                <tr>
                <td class ='pricingid'>" . $pricingid . "</td>
                <td class ='price'>" . $price . "</td>";

            switch ($fixed) {
                case 0:
                    $nam = $opr;
                    break;
                case 1:
                    $nam = $rop;
                    break;
            };

            /*Показательная дробь*/
            $dem_top .=$nam . " * " . $kol . " * " . "(1 - (0.02 * " . $wtime . ")) + ";
            $dem_bot .="(" . $row['price'] . " * " . $row['kol'].") + ";
            /*Закончилась показательная дробь*/

            $result .="<td class ='nam'>" . $nam . "</td>";
            $result .="<td class ='kol'>" . $kol . "</td>
                <td class ='wtime'>" . $wtime . "</td>
                </tr>
                ";
            /*Разметку*/
            /*формула расчета:*/

            $form_top[] = $nam * $kol * (1 - (0.02 * $wtime));
            $form_bot[] = $price * $kol;

            /*закончилась формула*/
        };
        $result .="</table><br>";

        /*Проверка готовности к общему расчету через count*/

        $mm = $poscount-$wincount;

        if ($mm > 0){
            /*Посылаем ноль в графу общей рентабельности*/
            $pdo->beginTransaction();
            $stm->execute(array(0, $reqid));
            $pdo->commit();

            echo json_encode(array("data1"=>"<span>Расчет общей рентабельности невозможен.<br><br>a)выберите победителя в каждой из позиций<br>b)удалите ненужные позиции.</span>
            <br><br><span>Разница: ". $mm . " Позиций: " . $poscount . ". Победителей: " . $wincount . "</span>","data2"=>"0.00"));

        }else{
            $top;
            $bot;
            foreach($form_top as $key=>$value){$top = $top + $value;}
            foreach($form_bot as $key=>$value){$bot = $bot + $value;}

            $dem_top = substr($dem_top, 0, -3);//Срезаем лишние плюсы с демонстрационных строк
            $dem_bot = substr($dem_bot, 0, -3);

            /*расчет рентабельности*/

            $rent = number_format($top/$bot*100, 2);

            $pdo->beginTransaction();
            $stm->execute(array($rent, $reqid));
            $pdo->commit();

            echo json_encode(array("data1"=>"Расчет рентабельности: <br><br><table class ='demo'><tr><td>" . $dem_top . "</td></tr><tr><td>" . $dem_bot . "</td></tr></table><br><br>
            <span> Общая рентабельность: " . $rent . "% </span> . $result . 
            <br><br><span>Разница: ". $mm . " Позиций: " . $poscount . ". Победителей: " . $wincount . "</span>","data2"=>$rent));
        }



    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    };
};
/***/























