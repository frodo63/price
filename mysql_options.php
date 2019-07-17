<?php
include_once 'pdo_connect.php';

//Опции по дате периода
if (isset($_POST['period'])){
    $period = $_POST['period'];

    $statement = $pdo->prepare("UPDATE `options` SET `ga_period` = ? WHERE options_id = 'general'");
    try {
        $pdo->beginTransaction();
        $statement->execute(array($period));
        $pdo->commit();
        echo "Опция общего периода изменена на ".$period;

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}

//Чтение ОПЦИЙ ЗАЯВКИ все 4 для добавления в расценку
if (isset($_POST['req_options'])){
    $reqid = $_POST['req_options'];

    $statement = $database->prepare("SELECT ov_op,ov_tp,ov_wt,ov_firstobp FROM `requests` WHERE `requests_id` = ?");
    try {
        $database->beginTransaction();
        $statement->execute(array($reqid));
        $database->commit();

        $result = $statement->fetch();

        print(json_encode(array('op'=>$result['ov_op'],'firstobp'=>$result['ov_firstobp'],'tp'=>$result['ov_tp'],'wt'=>$result['ov_wt'])));

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}

//Чтение ОПЦИЙ ПОЗИЦИИ все 4 для добавления в расценку
if ( isset($_POST['pos_options'])){
    try{
        $posid = ($_POST["pos_options"]);

        $statement=$database->prepare("SELECT `ov_op`,`ov_firstobp`,`ov_tp`,`ov_wt` FROM `req_positions` WHERE req_positionid = ?");

        $database->beginTransaction();
        $statement->execute(array($posid));
        $database->commit();

        $result = $statement->fetch();

        print(json_encode(array('op'=>$result['ov_op'],'firstobp'=>$result['ov_firstobp'],'tp'=>$result['ov_tp'], 'wt'=>$result['ov_wt'])));

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

/*ЧТЕНИЕ Имени позиции и статуса королевы*/
if ( isset($_POST['name_and_queen'])){
    try{
        $posid = ($_POST["name_and_queen"]);

        $statement=$pdo->prepare("SELECT `pos_name`,`queen` FROM `req_positions` WHERE req_positionid = ?");

        $pdo->beginTransaction();
        $statement->execute(array($posid));
        $pdo->commit();

        $result = $statement->fetch();

        print(json_encode(array('name'=>$result['pos_name'],'queen'=>$result['queen'])));

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

/*УДАЛЕНИЕ статуса королевы*/
if ( isset($_POST['minus_queen'])){
    try{
        $posid = ($_POST["minus_queen"]);

        $statement=$pdo->prepare("UPDATE `req_positions` SET `queen` = 0 WHERE req_positionid = ?");

        $pdo->beginTransaction();
        $statement->execute(array($posid));
        $pdo->commit();


        $result = "Статус особой расценки с позиции ".$posid." снят.";

        print $result;

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

/*ЧТЕНИЕ ОПЦИЙ ТОВАРА*/
    if (isset($_POST['trade_options'])){
        $tradeid = $_POST['trade_options'];

        $statement = $database->prepare("SELECT `trades_id`,`nameid`,`name`,`tare` FROM `trades` LEFT JOIN `allnames` ON allnames.nameid=`trades`.`trades_nameid` WHERE `trades_id` = ?");
        try {
            $database->beginTransaction();
            $statement->execute(array($tradeid));
            $database->commit();

            $result = $statement->fetch();

            print(json_encode(array('trades_id'=>$result['trades_id'],'tradenameid'=>$result['nameid'],'tradename'=>$result['name'],'tare'=>$result['tare'])));

        } catch( PDOException $Exception ) {$database->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}
    }
/**/

/*ЧТЕНИЕ ОПЦИЙ ПОКУПАТЕЛЯ*/
if (isset($_POST['byer_options'])){
    $byerid = $_POST['byer_options'];

    $statement = $database->prepare("SELECT `byers_id`,`nameid`,`name`,`ov_tp`,`ov_firstobp`,`ov_wt`,`comment` FROM `byers` LEFT JOIN `allnames` ON allnames.nameid=`byers`.`byers_nameid` WHERE `byers_id` = ?");
    try {
        $database->beginTransaction();
        $statement->execute(array($byerid));
        $database->commit();

        $result = $statement->fetch();

        print(json_encode(array('name'=>$result['name'],'ov_tp'=>round($result['ov_tp'],2),'ov_firstobp'=>round($result['ov_firstobp'],2),'ov_wt'=>round($result['ov_wt'],2),'comment'=>$result['comment'])));

    } catch( PDOException $Exception ) {$database->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}
}
/**/
