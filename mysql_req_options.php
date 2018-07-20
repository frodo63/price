<?php
include_once 'pdo_connect.php';

if (isset($_POST['req_options'])){
    $reqid = $_POST['req_options'];

    $statement = $pdo->prepare("SELECT ov_op,ov_tp,ov_wt,ov_firstobp FROM `requests` WHERE `requests_id` = ?");
    try {
        $pdo->beginTransaction();
        $statement->execute(array($reqid));
        $pdo->commit();

        $result = $statement->fetch();

        $ov_op = $result['ov_op'];
        $ov_firstobp = $result['ov_firstobp'];
        $ov_tp = $result['ov_tp'];
        $ov_wt = $result['ov_wt'];

        print(json_encode(array('op'=>$ov_op,'firstobp'=>$ov_firstobp,'tp'=>$ov_tp,'wt'=>$ov_wt)));

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
}