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
    //$stm = $pdo->prepare("UPDATE `requests` SET `req_rent`=? WHERE `requests_id`=?");
    try{
        $pdo->beginTransaction();
        $countrent->execute(array($reqid));
        $pdo->commit();

        $c=$countrent->fetchAll(PDO::FETCH_ASSOC);

        $result="
                <table>
                <tr>Рентабельность заказа</tr>
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
        /*ФОРМУЛА РАСЧЕТА*/

        foreach ($c as $row){
            ++$wincount;//Увеличиваем на 1 счетчик виннеров
            /*Делаем*/
            $result.="
                <tr>
                <td>" . $row['pricingid'] . "</td>
                <td>" . $row['price'] . "</td>";

            switch ($row['fixed']) {
                case '0':
                    $nam = $row['opr'];
                    break;
                case '1':
                    $nam = $row['rop'];
                    break;
            };

            $result .="<td>" . $nam . "</td>";
            $result .="<td>" . $row['kol'] . "</td>
                <td>" . $row['wtime'] . "</td>
                </tr>
                ";
            /*Разметку*/
            /*формула расчета:*/

            $form_top[] = $row['nam'] * $row['kol'] * (1 - 0.02 * $row['wtime']);
            $form_bot[] = $row['price'] * $row['kol'];

            /*закончилась формула*/
        };
        $result .="</table><br>";

        /*Проверка готовности к общему расчету через count*/

        $mm = $poscount-$wincount;

        if ($mm > 0){
            print "<span>Расчет общей рентабельности невозможен.<br><br>a)выберите победителя в каждой из позиций<br>b)удалите ненужные позиции.</span><br><br>";
            echo ("Разница: ". $mm . " Позиций: " . $poscount . ". Победителей: " . $wincount);
        }else{
            print (var_dump($form_top));
            print (var_dump($form_bot));

            print ($result);
            print "<br><br>";
            echo ("Разница: ". $mm . " Позиций: " . $poscount . ". Победителей: " . $wincount);
        }


        /**/



        /*Если нет победителей*/
        //if(count($result)==0){
         //   $pdo->beginTransaction();
         //   $stm->execute(array(0, $reqid));
         //   $pdo->commit();
            //echo "0.00";
        //}else{/*Если они есть*/
        //    $rent = array_sum($result)/count($result);
        //    $pdo->beginTransaction();
        //    $stm->execute(array($rent, $reqid));
        //    $pdo->commit();

            //echo number_format($rent, 2, '.', ' ');
        //};

    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    };
};
/***/























