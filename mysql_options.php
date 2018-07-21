<?php
include_once 'pdo_connect.php';

//Чтение ОПЦИЙ ЗАЯВКИ все 4 для добавления в расценку

if (isset($_POST['req_options'])){
    $reqid = $_POST['req_options'];

    $statement = $pdo->prepare("SELECT ov_op,ov_tp,ov_wt,ov_firstobp FROM `requests` WHERE `requests_id` = ?");
    try {
        $pdo->beginTransaction();
        $statement->execute(array($reqid));
        $pdo->commit();

        $result = $statement->fetch();

        print(json_encode(array('op'=>$result['ov_op'],'firstobp'=>$result['ov_firstobp'],'tp'=>$result['ov_tp'],'wt'=>$result['ov_wt'])));

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
}


//Чтение ОПЦИЙ ПОЗИЦИИ все 4 для добавления в расценку

if ( isset($_POST['pos_options'])){
    try{
        $posid = ($_POST["pos_options"]);

        $statement=$pdo->prepare("SELECT `ov_op`,`ov_firstobp`,`ov_tp`,`ov_wt` FROM `req_positions` WHERE req_positionid = ?");

        $pdo->beginTransaction();
        $statement->execute(array($posid));
        $pdo->commit();

        $result = $statement->fetch();

        print(json_encode(array('op'=>$result['ov_op'],'firstobp'=>$result['ov_firstobp'],'tp'=>$result['ov_tp'], 'wt'=>$result['ov_wt'])));

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
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
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
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
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
};
/**/