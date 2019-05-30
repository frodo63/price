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

//ДОБАВЛЕНИЕ заявки из окна списка заявок///////////////////////////////////////////////////
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

//ДОБАВЛЕНИЕ заявки из окна синхронизации///////////////////////////////////////////////////
if(isset($_POST['byer']) && isset($_POST['created']) && isset($_POST['uid']) && isset($_POST['onec_id'])){

    $byer = $_POST['byer'];
    $created = $_POST['created'];
    $uid = $_POST['uid'];
    $onec_id = $_POST['onec_id'];

    /**//////////////////////////////////////////////////////////////


    try {

        //Запросы
        $request_options = $pdo->prepare("SELECT byers.ov_tp,byers.ov_firstobp,byers.ov_wt FROM byers where byers.byers_id=?");//Опции заявки из Покупателя
        $stmt = $pdo->prepare("INSERT INTO `requests`(`created`,`byersid`,`ov_op`,`ov_firstobp`,`ov_tp`,`ov_wt`,`requests_uid`,`1c_num`) VALUES(?,?,?,?,?,?,?,?)");//Сама заявка


        $pdo->beginTransaction();

        $request_options->execute(array($byer));
        $result = $request_options->fetch();

        //Опции заявки
        $ov_op = 21; //Наша дефолтная наценка
        $ov_tp = $result['ov_tp'];
        $ov_firstobp = $result['ov_firstobp'];
        $ov_wt = $result['ov_wt'];

        $stmt->execute(array($created, $byer, $ov_op, $ov_firstobp, $ov_tp, $ov_wt, $uid, $onec_id));
        $pdo->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Добавлена Заявка из 1C.";

};
/////////////////////////////////////////////////////////////////////

///ДОБАВЛЕНИЕ ПОЗИЦИИ/////////////////////////////////////////////////
if(isset($_POST['reqid']) && isset($_POST['posname'])){

    $reqid = $_POST['reqid'];
    $posname = $_POST['posname'];

    /**//////////////////////////////////////////////////////////////

    try {
        //Проверка номера строки


        $pdo->beginTransaction();
        $line_num_check = $pdo->prepare("SELECT COUNT(*) FROM `req_positions` WHERE requestid = ?");

        $statement = $pdo->prepare("INSERT INTO `req_positions`(`pos_name`,`requestid`,`line_num`) VALUES(?,?,?)");

        $line_num_check->execute(array($reqid));
        $line_num_array = $line_num_check->fetch();
        $line_num = ++$line_num_array['COUNT(*)'];

        $statement->bindParam(1, $posname);
        $statement->bindParam(2, $reqid);
        $statement->bindParam(3, $line_num);

        echo "Строк :" . $line_num;
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

///ДОБАВЛЕНИЕ ПОЗИЦИИ ИЗ ОКНА СИНХРОНИЗАЦИИ
if (
    isset($_POST['sync_reqid']) &&
    isset($_POST['sync_posname']) &&
    isset($_POST['sync_linenum'])
){
    $reqid = $_POST['sync_reqid'];
    $posname = $_POST['sync_posname'];
    $linenum = $_POST['sync_linenum'];
    /**//////////////////////////////////////////////////////////////

    try {
        $pdo->beginTransaction();
        $statement = $pdo->prepare("INSERT INTO `req_positions`(`requestid`,`pos_name`,`line_num`) VALUES(?,?,?)");
        $statement->execute(array($reqid,$posname,$linenum));

        ///////////////////////////////////////////////
        $pdo->commit();

        echo "Позиция добавлена";

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }

}


/////////////////////////////////////////////////////////////////////

//Развоое добавление единичек в таблицу позиций
/*if (isset($_POST['dothe1s'])){

    try{
        $gettherids = $pdo->prepare("SELECT requests_id FROM requests");
        $gettherids->execute();
        $gottherids = $gettherids->fetchAll(PDO::FETCH_ASSOC);

        foreach ($gottherids as $gottherid){


            $pdo->beginTransaction();
            $the1 = $gottherid['requests_id'];

            $statement = $pdo->prepare("SELECT COUNT(*) FROM req_positions WHERE requestid = ?");
            $update_statement = $pdo->prepare("UPDATE req_positions SET line_num = 1 WHERE requestid = ?");

            $statement->execute(array($the1));
            $the1_array = $statement->fetch();
            $thenum = $the1_array['COUNT(*)'];

            if($thenum == 1){
                $update_statement->execute(array($the1));
            }
            $pdo->commit();

        }

        echo"Done";



    } catch( PDOException $Exception ) {
    // Note The Typecast To An Integer!
    $pdo->rollback();
    throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
}

}*/

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

//ДОБАВЛЕНИЕ ПЛАТЕЖКИ ИЗ ОКНА СИНХРОНИЗАЦИИ/////////////////////////////////////////////////
if(isset($_POST['number']) && isset($_POST['payed']) && isset($_POST['uid']) && isset($_POST['onec_id']) && isset($_POST['sum']) && isset($_POST['requestid'])){

    $number = $_POST['number'];
    $payed = $_POST['payed'];
    $uid = $_POST['uid'];
    $onec_id = $_POST['onec_id'];
    $sum = $_POST['sum'];
    $requestid = $_POST['requestid'];

    /**//////////////////////////////////////////////////////////////

    try {
        $statement = $pdo->prepare("INSERT INTO `payments`(`number`,`payed`,`payments_uid`,`onec_id`,`sum`,`requestid`) VALUES(?,?,?,?,?,?)");

        $statement->bindParam(1, $number);
        $statement->bindParam(2, $payed);
        $statement->bindParam(3, $uid);
        $statement->bindParam(4, $onec_id);
        $statement->bindParam(5, $sum);
        $statement->bindParam(6, $requestid);

        $pdo->beginTransaction();
        $statement->execute();
        $pdo->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Добавлена платежка  на сумму $sum в заявку $requestid.";

};
//////////////////////////////////////////////////////////////////////

//ДОБАВЛЕНИЕ ВЫДАЧИ///////////////////////////////////////////////////
if(isset($_POST['byersid']) && isset($_POST['giveaway_date']) && isset($_POST['comment']) && isset($_POST['sum'])){

    $byersid = $_POST['byersid'];
    $giveaway_date = $_POST['giveaway_date'];
    $comment = $_POST['comment'];
    $sum = $_POST['sum'];

    /**//////////////////////////////////////////////////////////////

    try {
        $statement = $pdo->prepare("INSERT INTO `giveaways`(`byersid`,`given_away`,`comment`,`giveaway_sum`) VALUES(?,?,?,?)");

        $statement->bindParam(1, $byersid);
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

    echo "Получилось! Добавлена выдача на сумму $sum";

};
//////////////////////////////////////////////////////////////////////

/*Добавление расценки в окне СИНХРОНИЗАЦИИ*/

if(
    isset($_POST['positionid']) &&
    isset($_POST['tradeid']) &&
    isset($_POST['kol']) &&
    isset($_POST['price']) &&
    isset($_POST['op']) &&
    isset($_POST['tp']) &&
    isset($_POST['firstobp']) &&
    isset($_POST['wt'])
){
    //Переменные для добавления расценки
    $positionid = $_POST['positionid'];//ID последнрей добавленной позиции
    $tradeid = $_POST['tradeid'];
    $sellerid = 0;
    $zak = 0;
    $kol = $_POST['kol'];
    $price = $_POST['price'];
    $winner = 1;
    $fixed = 0;
    $op = $_POST['op'];
    $tp = $_POST['tp'];
    $firstobp = $_POST['firstobp'];
    $wtime = $_POST['wt'];
    $opr = 0;
    $rent = 0;

    try{
        $addpricing = $pdo->prepare("INSERT INTO `pricings`(`positionid`,`tradeid`,`sellerid`,`zak`,`kol`,`price`,`winner`,`fixed`,`op`,`tp`,`firstobp`,`wtime`,`opr`,`rent`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $addpricing->execute(array($positionid,$tradeid,$sellerid,$zak,$kol,$price,$winner,$fixed,$op,$tp,$firstobp,$wtime,$opr,$rent));

        //Добавляем Победителя к только что добавленной позиции из только что добавленной расценки
        $lastpricingid = $pdo->lastInsertId();

        echo "Расценка № " . $lastpricingid . " добавлена";

        $addwinner = $pdo->prepare("UPDATE req_positions SET winnerid = ? WHERE req_positionid = ?");
        $addwinner->execute(array($lastpricingid,$positionid));

        echo "Победитель назначен";

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
}
