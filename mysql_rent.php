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
if (isset($_POST['request']) && isset($_POST['count'])){
    $reqid = $_POST['request'];
    $countrent = $pdo->prepare("
SELECT `rent` FROM 
(SELECT `winnerid` FROM `req_positions` WHERE `requestid` = ?) AS a INNER JOIN 
(SELECT `rent`,`pricingid` FROM `pricings`) AS b ON a.`winnerid` = b.`pricingid`");
    $stm = $pdo->prepare("UPDATE `requests` SET `req_rent`=? WHERE `requests_id`=?");
    try{
        $pdo->beginTransaction();
        $countrent->execute(array($reqid));
        $pdo->commit();
        $result=array();
        foreach ($countrent as $row){
            $result[] = $row['rent'];
        };

        /*Если нет победителей*/
        if(count($result)==0){
            $pdo->beginTransaction();
            $stm->execute(array(0, $reqid));
            $pdo->commit();
            echo "0.00";
        }else{/*Если они есть*/
            $rent = array_sum($result)/count($result);
            $pdo->beginTransaction();
            $stm->execute(array($rent, $reqid));
            $pdo->commit();

            echo number_format($rent, 2, '.', ' ');
        };

    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }
};
/***/























