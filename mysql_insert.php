<?php
include_once 'pdo_connect.php';
//ДОБАВЛЕНИЕ В обе базы товаров, поставщиков или покупателей
if(isset($_POST['table_c']) && isset($_POST['thename']) && isset($_POST['uid']) && isset($_POST['onec_id']) && isset($_POST['innerid'])){

    $table_c = $_POST['table_c'];
    switch($table_c){
        case 1:
            $table = 'byers';
            break;
        case 2:
            $table = 'sellers';
            break;
        case 3:
            $table = 'trades';
            if(isset($_POST['thetare'])){
                $thetare = $_POST['thetare'];
            }
            break;
    }

    $nameid_column = $table . '_nameid';
    $uid_column = $table . '_uid';
    $id_column = $table . '_id';
    $thename = $_POST['thename'];
    $uid = $_POST['uid'];
    $onec_id = $_POST['onec_id'];
    $innerid = $_POST['innerid'];

    /*Общий принцип Соотнесения двух баз:
            * Есть 4 варианта ситуации:
            * 1. bd = ltk, innerid = ''      Добавляем новое в ltk и все.
            * 2. bd = ltk, innerid != ''     Соотносим с существующей болванкой, ничего не добавляем.
            * 3. bd=ip, innerid = ''         Создаем в ltk болванку, создаем в ip новое и соотносим с ней.
            * 4. bd=ip, innerid = !''        Создаем в ip новое и cоотносим с существующим в ltk.
            */

    //Если $database = 'ltk'
    if($_POST['db'] == 'ltk'){
        if($innerid == ''){
            //Вариант 1. Добавляем новое в ltk и все.

            $statement = $database->prepare("INSERT INTO `allnames`(`name`) VALUES(?)");
            try {
                $database->beginTransaction();
                $statement->execute(array($thename));
                $theID = $database->lastInsertId();

                if($table =="trades"){
                    $insert_sql = "INSERT INTO `$table`(`$nameid_column`,`$uid_column`,`onec_id`,`tare`) VALUES(?,?,?,?)";
                    $var_array = array($theID,$uid,$onec_id,$thetare);
                }else{
                    $insert_sql = "INSERT INTO `$table`(`$nameid_column`,`$uid_column`,`onec_id`) VALUES(?,?,?)";
                    $var_array = array($theID,$uid,$onec_id,);
                }

                $statement = $database->prepare($insert_sql);
                $statement->execute($var_array);

                $database->commit();

            } catch( PDOException $Exception ) {
                $database->rollback();
                print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
            }
            echo "Вариант 1. Получилось! Добавлена запись $thename в таблицу $table.";

        }else{
            //Вариант 2. Соотносим с существующей болванкой, ничего не добавляем.
            $statement = $pdo->prepare("UPDATE `$table` SET `$uid_column` = ?,`onec_id` = ? WHERE `$id_column` = ?");

            try {
                $pdo->beginTransaction();

                $statement->execute(array($uid,$onec_id,$innerid));

                $pdo->commit();

            } catch( PDOException $Exception ) {
                $pdo->rollback();
                print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
            }
            echo "Вариант 2. Соотнесение с существующей болванкой прошло успешно!";
        }
    }
    //Если $database = 'ip'
    if($_POST['db'] == 'ip'){
        if($innerid == ''){
            //Вариант 3. Создаем в ltk болванку, создаем в ip новое и соотносим с ней.
            //Добавляем в ltk болванку
            $statement = $pdo->prepare("INSERT INTO `allnames`(`name`) VALUES(?)");
            try {
                $pdo->beginTransaction();
                $statement->execute(array($thename));
                $theID = $pdo->lastInsertId();

                if($table =="trades"){
                    $insert_sql = "INSERT INTO `trades`(`trades_nameid`,`ip_uid`,`tare`) VALUES(?,?,?)";
                    $var_array = array($theID,$uid,$thetare);
                }else{
                    $insert_sql = "INSERT INTO `$table`(`$nameid_column`,`ip_uid`) VALUES(?,?)";
                    $var_array = (array($theID,$uid));
                }

                $statement = $pdo->prepare($insert_sql);
                $statement->execute($var_array);
                $pdo->commit();
            } catch( PDOException $Exception ) {
                $pdo->rollback();
                print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
            }

                //Болванка добавлена. Теперь можно и в ip базу добавить
            try {
                $pdoip->beginTransaction();

                $statement = $pdoip->prepare("INSERT INTO `allnames`(`name`) VALUES(?)");
                $statement->execute(array($thename));
                $theID = $pdoip->lastInsertId();

                if($table == "trades"){
                    $ip_insert_sql = "INSERT INTO `trades`(`trades_nameid`,`trades_uid`,`onec_id`,`tare`) VALUES(?,?,?,?)";
                    $ip_var_array = array($theID,$uid,$onec_id,$thetare);
                }else{
                    $ip_insert_sql = "INSERT INTO `$table`(`$nameid_column`,`$uid_column`,`onec_id`) VALUES(?,?,?)";
                    $ip_var_array = (array($theID,$uid,$onec_id));
                }

                $statement = $pdoip->prepare($ip_insert_sql);
                $statement->execute($ip_var_array);
                $pdoip->commit();

            } catch( PDOException $Exception ) {
                $pdoip->rollback();
                print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
            }
            echo "Вариант 3. Создали в ltk болванку, создали в ip новое и соотнесли с ней.";
        }else{
            //Вариант 4. Создаем в ip новое и cоотносим с существующим в ltk.
            //Создаем в ip
            try {
                $pdoip->beginTransaction();

                $statement = $pdoip->prepare("INSERT INTO `allnames`(`name`) VALUES(?)");
                $statement->execute(array($thename));
                $theID = $pdoip->lastInsertId();

                if($table == "trades"){
                    $ip_insert_sql = "INSERT INTO `trades`(`trades_nameid`,`trades_uid`,`onec_id`,`tare`) VALUES(?,?,?,?)";
                    $ip_var_array = array($theID,$uid,$onec_id,$thetare);
                }else{
                    $ip_insert_sql = "INSERT INTO `$table`(`$nameid_column`,`$uid_column`,`onec_id`) VALUES(?,?,?)";
                    $ip_var_array = (array($theID,$uid,$onec_id));
                }

                $statement = $pdoip->prepare($ip_insert_sql);
                $statement->execute($ip_var_array);
                $pdoip->commit();

            } catch( PDOException $Exception ) {
                $pdoip->rollback();
                print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
            }
            //Соотносим с ltk
            try {
                $pdo->beginTransaction();

                    $ip_insert_sql = "UPDATE `$table` SET `ip_uid` = ? WHERE $id_column = ?";
                    $ip_var_array = array($uid,$innerid);

                $statement = $pdo->prepare($ip_insert_sql);
                $statement->execute($ip_var_array);

                $pdo->commit();

            } catch( PDOException $Exception ) {
                $pdo->rollback();
                print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
            }
            echo "Вариант 4. Создали в ip новое и cоотнесли с существующим в ltk.";
        }
    }
};

//ДОБАВЛЕНИЕ заявки из окна списка заявок///////////////////////////////////////////////////
if(isset($_POST['byer']) && isset($_POST['thename'])){

    $byer = $_POST['byer'];
    $thename = $_POST['thename'];
    $created = date("Y-m-d");

    /**//////////////////////////////////////////////////////////////


    try {

        //Запросы
        $statement = $database->prepare("INSERT INTO `allnames`(`name`) VALUES(?)");//Имя заявки
        $request_options = $database->prepare("SELECT byers.ov_tp,byers.ov_firstobp,byers.ov_wt FROM byers where byers.byers_id=?");//Опции заявки из Покупателя
        $stmt = $database->prepare("INSERT INTO `requests`(`created`,`requests_nameid`,`byersid`,`ov_op`,`ov_firstobp`,`ov_tp`,`ov_wt`) VALUES(?,?,?,?,?,?,?)");//Сама заявка


        $database->beginTransaction();
        $statement->execute(array($thename));
        $theID = $database->lastInsertId();

        $request_options->execute(array($byer));
        $result = $request_options->fetch();

        //Опции заявки
        $ov_op = 21; //Наша дефолтная наценка
        $ov_tp = $result['ov_tp'];
        $ov_firstobp = $result['ov_firstobp'];
        $ov_wt = $result['ov_wt'];

        $stmt->execute(array($created, $theID, $byer, $ov_op, $ov_firstobp, $ov_tp, $ov_wt));
        $database->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
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
        $request_options = $database->prepare("SELECT byers.ov_tp,byers.ov_firstobp,byers.ov_wt FROM byers where byers.byers_id=?");//Опции заявки из Покупателя
        $stmt = $database->prepare("INSERT INTO `requests`(`created`,`byersid`,`ov_op`,`ov_firstobp`,`ov_tp`,`ov_wt`,`requests_uid`,`1c_num`) VALUES(?,?,?,?,?,?,?,?)");//Сама заявка


        $database->beginTransaction();

        $request_options->execute(array($byer));
        $result = $request_options->fetch();

        //Опции заявки
        $ov_op = 21; //Наша дефолтная наценка
        $ov_tp = $result['ov_tp'];
        $ov_firstobp = $result['ov_firstobp'];
        $ov_wt = $result['ov_wt'];

        $stmt->execute(array($created, $byer, $ov_op, $ov_firstobp, $ov_tp, $ov_wt, $uid, $onec_id));
        $database->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
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


        $database->beginTransaction();
        $line_num_check = $database->prepare("SELECT COUNT(*) FROM `req_positions` WHERE requestid = ?");

        $statement = $database->prepare("INSERT INTO `req_positions`(`pos_name`,`requestid`,`line_num`) VALUES(?,?,?)");

        $line_num_check->execute(array($reqid));
        $line_num_array = $line_num_check->fetch();
        $line_num = ++$line_num_array['COUNT(*)'];

        echo "Строк :" . $line_num;
        $statement->execute(array($posname,$reqid,$line_num));
        $database->commit();
        echo "Получилось! Добавлена запись $posname в заявку $reqid.";

    } catch( PDOException $Exception ) {
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////
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
        $database->beginTransaction();
        $statement = $database->prepare("INSERT INTO `req_positions`(`requestid`,`pos_name`,`line_num`) VALUES(?,?,?)");
        $statement->execute(array($reqid,$posname,$linenum));

        ///////////////////////////////////////////////
        $database->commit();

        echo "Позиция добавлена.";

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

}


/////////////////////////////////////////////////////////////////////

//Развоое добавление единичек в таблицу позиций
/*if (isset($_POST['dothe1s'])){

    try{
        $gettherids = $database->prepare("SELECT requests_id FROM requests");
        $gettherids->execute();
        $gottherids = $gettherids->fetchAll(PDO::FETCH_ASSOC);

        foreach ($gottherids as $gottherid){


            $database->beginTransaction();
            $the1 = $gottherid['requests_id'];

            $statement = $database->prepare("SELECT COUNT(*) FROM req_positions WHERE requestid = ?");
            $update_statement = $database->prepare("UPDATE req_positions SET line_num = 1 WHERE requestid = ?");

            $statement->execute(array($the1));
            $the1_array = $statement->fetch();
            $thenum = $the1_array['COUNT(*)'];

            if($thenum == 1){
                $update_statement->execute(array($the1));
            }
            $database->commit();

        }

        echo"Done";



    } catch( PDOException $Exception ) {
    // Note The Typecast To An Integer!
    $database->rollback();
    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
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
        $statement = $database->prepare("INSERT INTO `payments`(`requestid`,`payed`,`number`,`sum`) VALUES(?,?,?,?)");

        $statement->bindParam(1, $reqid);
        $statement->bindParam(2, $payment_date);
        $statement->bindParam(3, $num);
        $statement->bindParam(4, $sum);

        $database->beginTransaction();
        $statement->execute();
        $database->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
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
        $statement = $database->prepare("INSERT INTO `payments`(`number`,`payed`,`payments_uid`,`onec_id`,`sum`,`requestid`) VALUES(?,?,?,?,?,?)");

        $statement->bindParam(1, $number);
        $statement->bindParam(2, $payed);
        $statement->bindParam(3, $uid);
        $statement->bindParam(4, $onec_id);
        $statement->bindParam(5, $sum);
        $statement->bindParam(6, $requestid);

        $database->beginTransaction();
        $statement->execute();
        $database->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
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
        $statement = $database->prepare("INSERT INTO `giveaways`(`byersid`,`given_away`,`comment`,`giveaway_sum`) VALUES(?,?,?,?)");

        $statement->bindParam(1, $byersid);
        $statement->bindParam(2, $giveaway_date);
        $statement->bindParam(3, $comment);
        $statement->bindParam(4, $sum);

        $database->beginTransaction();
        $statement->execute();
        $database->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
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
    $fixed = 0;
    $op = $_POST['op'];
    $tp = $_POST['tp'];
    $firstobp = $_POST['firstobp'];
    $wtime = $_POST['wt'];
    $opr = 0;
    $rent = 0;

    try{
        $addpricing = $database->prepare("INSERT INTO `pricings`(`positionid`,`tradeid`,`sellerid`,`zak`,`kol`,`price`,`fixed`,`op`,`tp`,`firstobp`,`wtime`,`opr`,`rent`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $addpricing->execute(array($positionid,$tradeid,$sellerid,$zak,$kol,$price,$fixed,$op,$tp,$firstobp,$wtime,$opr,$rent));

        //Добавляем Победителя к только что добавленной позиции из только что добавленной расценки
        $lastpricingid = $database->lastInsertId();

        echo "Расценка № " . $lastpricingid . " добавлена";

        $addwinner = $database->prepare("UPDATE req_positions SET winnerid = ? WHERE req_positionid = ?");
        $addwinner->execute(array($lastpricingid,$positionid));

        echo "Победитель назначен";

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}
