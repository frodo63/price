<?php
include_once 'pdo_connect.php';

if(isset($_POST['table_c']) && isset($_POST['thename'])){

    $table_c = $_POST['table_c'];
    switch($table_c){
        case 1:
            $table = 'byers';
            break;
        case 2:
            $table = 'sellers';
            break;
    }
    $nameid_column = $table . '_nameid';

    $thename = $_POST['thename'];
    if(isset($_POST['uid']) && isset($_POST['onec_id'])){
        $uid = $_POST['uid'];
        $uid_column = $table . '_uid';
        $onec_id = $_POST['onec_id'];
    }

    /**//////////////////////////////////////////////////////////////
    $statement = $pdo->prepare("INSERT INTO `allnames`(`name`) VALUES(?)");
    try {
        $pdo->beginTransaction();
        $statement->execute(array($thename));
        $theID = $pdo->lastInsertId();


        if(isset($_POST['uid']) && isset($_POST['onec_id'])){
            $statement = $pdo->prepare("INSERT INTO `$table`(`$nameid_column`,`$uid_column`,`onec_id`) VALUES(?,?,?)");
            $statement->execute(array($theID,$uid,$onec_id));
            $pdo->commit();
        }else{
            $statement = $pdo->prepare("INSERT INTO `$table`(`$nameid_column`) VALUES(?)");
            $statement->execute(array($theID));
            $pdo->commit();
        }


    } catch( PDOException $Exception ) {
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Добавлена запись $thename в таблицу $table.";

};

//ДОБАВЛЕНИЕ ТОВАРА////////////////////////////////////////////////////
if(isset($_POST['trade_name']) && isset($_POST['trade_tare'])){

    $trade_name = $_POST['trade_name'];
    $trade_tare = $_POST['trade_tare'];
    if(isset($_POST['uid']) && isset($_POST['onec_id'])){
        $uid = $_POST['uid'];
        $onec_id = $_POST['onec_id'];
    }



    $statement = $pdo->prepare("INSERT INTO `allnames`(`name`) VALUES(?)");
    try {
        $pdo->beginTransaction();
        $statement->execute(array($trade_name));

        $theID = $pdo->lastInsertId();


        if(isset($uid) && isset($onec_id)){
            $statement = $pdo->prepare("INSERT INTO `trades`(`trades_nameid`,`tare`,`trades_uid`,`onec_id`) VALUES(?,?,?,?)");
            $statement->execute(array($theID,$trade_tare,$uid,$onec_id));
            unset($uid, $onec_id);
        }else{
            $statement = $pdo->prepare("INSERT INTO `trades`(`trades_nameid`,`tare`) VALUES(?,?)");
            $statement->execute(array($theID,$trade_tare));
        }


        $pdo->commit();



    } catch( PDOException $Exception ) {
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }


    echo "Добавлен товар $thename.";
};
///////////////////////////////////////////////////////////////////////

//ДОБАВЛЕНИЕ заявки ///////////////////////////////////////////////////
if(isset($_POST['byer']) && isset($_POST['thename'])){

    $byer = $_POST['byer'];
    $thename = $_POST['thename'];
    $created = date("Y-m-d");

    /**//////////////////////////////////////////////////////////////


    try {

        //Запросы
        $statement = $pdo->prepare("INSERT INTO `allnames`(`name`) VALUES(?)");//Имя заявки
        $request_options = $pdo->prepare("SELECT byers.ov_tp,byers.ov_firstobp,byers.ov_wt FROM byers where byers.byers_id=?");//Опции заявки из Покупателя
        $stmt = $pdo->prepare("INSERT INTO `requests`(`created`,`requests_nameid`,`byersid`,`ov_op`,`ov_firstobp`,`ov_tp`,`ov_wt`) VALUES(?,?,?,?,?,?,?)");//Сама заявка


        $pdo->beginTransaction();
        $statement->execute(array($thename));
        $theID = $pdo->lastInsertId();

        $request_options->execute(array($byer));
        $result = $request_options->fetch();

        //Опции заявки
        $ov_op = 21; //Наша дефолтная наценка
        $ov_tp = $result['ov_tp'];
        $ov_firstobp = $result['ov_firstobp'];
        $ov_wt = $result['ov_wt'];

        $stmt->execute(array($created, $theID, $byer, $ov_op, $ov_firstobp, $ov_tp, $ov_wt));
        $pdo->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Добавлена Заявка  " . $thename . " .";

};
/////////////////////////////////////////////////////////////////////

///ДОБАВЛЕНИЕ ПОЗИЦИИ////////////////////////////////////////////////
if(isset($_POST['reqid']) && isset($_POST['posname'])){

    $reqid = $_POST['reqid'];
    $posname = $_POST['posname'];

    /**//////////////////////////////////////////////////////////////

    try {
        $pdo->beginTransaction();
        $statement = $pdo->prepare("INSERT INTO `req_positions`(`pos_name`,`requestid`) VALUES(?,?)");

        $statement->bindParam(1, $posname);
        $statement->bindParam(2, $reqid);

        $statement->execute();
        $pdo->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Добавлена запись $posname в заявку $reqid.";

};
//////////////////////////////////////////////////////////////////////

//ДОБАВЛЕНИЕ ПЛАТЕЖКИ/////////////////////////////////////////////////
if(isset($_POST['reqid']) && isset($_POST['payment_date']) && isset($_POST['num']) && isset($_POST['sum'])){

    $reqid = $_POST['reqid'];
    $payment_date = $_POST['payment_date'];
    $num = $_POST['num'];
    $sum = $_POST['sum'];

    /**//////////////////////////////////////////////////////////////

    try {
        $statement = $pdo->prepare("INSERT INTO `payments`(`requestid`,`payed`,`number`,`sum`) VALUES(?,?,?,?)");

        $statement->bindParam(1, $reqid);
        $statement->bindParam(2, $payment_date);
        $statement->bindParam(3, $num);
        $statement->bindParam(4, $sum);

        $pdo->beginTransaction();
        $statement->execute();
        $pdo->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Добавлена платежка  на сумму $sum в заявку $reqid.";

};
//////////////////////////////////////////////////////////////////////

//ДОБАВЛЕНИЕ ВЫДАЧИ///////////////////////////////////////////////////
if(isset($_POST['reqid']) && isset($_POST['giveaway_date']) && isset($_POST['comment']) && isset($_POST['sum'])){

    $reqid = $_POST['reqid'];
    $giveaway_date = $_POST['giveaway_date'];
    $comment = $_POST['comment'];
    $sum = $_POST['sum'];

    /**//////////////////////////////////////////////////////////////

    try {
        $statement = $pdo->prepare("INSERT INTO `giveaways`(`requestid`,`given_away`,`comment`,`giveaway_sum`) VALUES(?,?,?,?)");

        $statement->bindParam(1, $reqid);
        $statement->bindParam(2, $giveaway_date);
        $statement->bindParam(3, $comment);
        $statement->bindParam(4, $sum);

        $pdo->beginTransaction();
        $statement->execute();
        $pdo->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Добавлена выдача на сумму $sum в заявку $reqid.";

};
//////////////////////////////////////////////////////////////////////
