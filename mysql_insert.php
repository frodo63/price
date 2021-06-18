<?php
include_once 'pdo_connect.php';
//ДОБАВЛЕНИЕ В обе базы товаров, поставщиков или покупателей
if(isset($_POST['table_c']) && isset($_POST['thename']) && isset($_POST['uid']) && isset($_POST['onec_id'])){

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
    $onec_column = 'onec_id';

    //Общий принцип Соотнесения двух баз:
    //        Есть 4 варианта ситуации:
    //         1. bd = ltk, innerid = ''      Добавляем новое в ltk и все.
    //         2. bd = ltk, innerid != ''     Соотносим с существующей болванкой, ничего не добавляем.
    //         3. bd=ip, innerid = ''         Создаем в ltk болванку, создаем в ip новое и соотносим с ней.
    //         4. bd=ip, innerid = !''        Создаем в ip новое и cоотносим с существующим в ltk.
    //

    //Если $database = 'ltk'
    if($_POST['db'] == 'ltk'){

            $statement = $pdo->prepare("INSERT INTO `allnames`(`name`) VALUES(?)");
            try {
                $pdo->beginTransaction();
                $statement->execute(array($thename));
                $theID = $pdo->lastInsertId();

                if($table =="trades"){
                    $insert_sql = "INSERT INTO `trades` (`trades_nameid`, `trades_uid`, `trades`.`onec_id`,`trades`.`tare`) VALUES(?,?,?,?)";
                    $var_array = array($theID,$uid,$onec_id,$thetare);
                }else{
                    $insert_sql = "INSERT INTO $table ($nameid_column, $uid_column, $onec_column) VALUES(?,?,?)";
                    $var_array = array($theID,$uid,$onec_id,);
                }

                $statement = $pdo->prepare($insert_sql);
                $statement->execute($var_array);

                $pdo->commit();

            } catch( PDOException $Exception ) {
                $pdo->rollback();
                print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
            }
            echo "Вариант 1. Получилось! Добавлена запись $thename в таблицу $table.";
    }
    //Если $database = 'ip'
    if($_POST['db'] == 'ip'){
        try {
                $pdoip->beginTransaction();

                $statement = $pdoip->prepare("INSERT INTO `allnames`(`name`) VALUES(?)");
                $statement->execute(array($thename));
                $theID = $pdoip->lastInsertId();

                if($table == "trades"){
                    $ip_insert_sql = "INSERT INTO `trades`(`trades_nameid`,`trades_uid`,`onec_id`,`tare`) VALUES(?,?,?,?)";
                    $ip_var_array = array($theID,$uid,$onec_id,$thetare);
                }else{
                    $ip_insert_sql = "INSERT INTO $table($nameid_column,$uid_column,onec_id`) VALUES(?,?,?)";
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

//ДОБАВЛЕНИЕ заявки из модуля 1С///////////////////////////////////////////////////
if(isset($_POST['byer']) &&
    isset($_POST['created']) &&
    isset($_POST['uid']) &&
    isset($_POST['dataver']) &&
    isset($_POST['onec_id'])){

    $byer = $_POST['byer'];
    $created = $_POST['created'];
    $uid = $_POST['uid'];
    $dataver = $_POST['dataver'];
    $onec_id = $_POST['onec_id'];

    /**//////////////////////////////////////////////////////////////


    try {

        //Запросы
        $request_options = $database->prepare("SELECT byers.ov_tp,byers.ov_firstobp,byers.ov_wt FROM byers where byers.byers_id=?");//Опции заявки из Покупателя
        $stmt = $database->prepare("INSERT INTO `requests`(`created`,`byersid`,`ov_op`,`ov_firstobp`,`ov_tp`,`ov_wt`,`requests_uid`,`1c_num`,`dataver`) VALUES(?,?,?,?,?,?,?,?,?)");//Сама заявка


        $database->beginTransaction();

        $request_options->execute(array($byer));
        $result = $request_options->fetch();

        //Опции заявки
        $ov_op = 21; //Наша дефолтная наценка
        $ov_tp = $result['ov_tp'];
        $ov_firstobp = $result['ov_firstobp'];
        $ov_wt = $result['ov_wt'];

        $stmt->execute(array($created, $byer, $ov_op, $ov_firstobp, $ov_tp, $ov_wt, $uid, $onec_id,$dataver));
        echo $database->lastInsertId();//Отдаем айди в 1с
        $database->commit();

        /*echo "Получилось! Добавлена Заявка из 1C.";*/

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////
};
/////////////////////////////////////////////////////////////////////

///ДОБАВЛЕНИЕ ПОЗИЦИИ из модуля 1С/////////////////////////////////////////////////
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

        $statement->execute(array($posname,$reqid,$line_num));
        echo $database->lastInsertId();//Отдаем айди в 1с
        $database->commit();
        /*echo "Получилось! Добавлена запись $posname в заявку $reqid.";*/

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

//ДОБАВЛЕНИЕ ПЛАТЕЖКИ ИЗ модуля 1С/////////////////////////////////////////////////
if(isset($_POST['requestid']) &&
    isset($_POST['payments_uid']) &&
    isset($_POST['payments_requests_uid']) &&
    isset($_POST['byersid']) &&
    isset($_POST['onec_id']) &&
    isset($_POST['dataver']) &&
    isset($_POST['payed']) &&
    isset($_POST['number']) &&
    isset($_POST['sum']) &&
    isset($_POST['comment'])
){
    if($_POST['requestid'] == "NONE"){
        //Если не указан заказ, то надо просто добавить платежку, без заказа
        return false;
    }else{
        $requestid = $_POST['requestid'];
    }
    $payments_uid = $_POST['payments_uid'];
    $payments_req_uid = $_POST['payments_requests_uid'];
    $byersid = $_POST['byersid'];
    $onec_id = $_POST['onec_id'];
    $dataver = $_POST['dataver'];
    $payed = $_POST['payed'];
    $number = $_POST['number'];
    $sum = $_POST['sum'];
    $comment = $_POST['comment'];

    /**//////////////////////////////////////////////////////////////

    try {
        $statement = $database->prepare("INSERT INTO `payments`(`requestid`,`payments_requests_uid`,`payments_uid`,`byersid`,`onec_id`,`dataver`,`payed`,`number`,`sum`,`comment`) VALUES(?,?,?,?,?,?,?,?,?,?)");

        $check_duplicates = $database->prepare("SELECT * FROM `payments` WHERE `payments_uid` = ? AND `payments_requests_uid`=?");
        $delete_duplicates = $database->prepare("DELETE FROM `payments` WHERE payments_id = ?");

        $statement->bindParam(1, $requestid);
        $statement->bindParam(2, $payments_req_uid);
        $statement->bindParam(3, $payments_uid);
        $statement->bindParam(4, $byersid);
        $statement->bindParam(5, $onec_id);
        $statement->bindParam(6, $dataver);
        $statement->bindParam(7, $payed);
        $statement->bindParam(8, $number);
        $statement->bindParam(9, $sum);
        $statement->bindParam(10, $comment);


        $database->beginTransaction();
        $check_duplicates->execute(array($payments_uid, $payments_req_uid));
        $is_there_duplicates_fetched = $check_duplicates->fetchAll(PDO::FETCH_ASSOC);
        if(count($is_there_duplicates_fetched) > 0){
            return "NOT UNIQUE PAYMENT";
        }else{
            $statement->execute();
            $database->commit();
        }

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
if(isset($_POST['byersid']) && isset($_POST['giveaway_date']) && isset($_POST['comment']) && isset($_POST['sum']) && isset($_POST['give_year'])){

    $byersid = $_POST['byersid'];
    $giveaway_date = $_POST['giveaway_date'];
    $comment = $_POST['comment'];
    $sum = $_POST['sum'];
    $give_year = $_POST['give_year'];

    /**//////////////////////////////////////////////////////////////

    try {
        $statement = $database->prepare("INSERT INTO `giveaways`(`byersid`,`given_away`,`comment`,`giveaway_sum`,`year_given`) VALUES(?,?,?,?,?)");

        $statement->bindParam(1, $byersid);
        $statement->bindParam(2, $giveaway_date);
        $statement->bindParam(3, $comment);
        $statement->bindParam(4, $sum);
        $statement->bindParam(5, $give_year);

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

/*Добавление расценки в модуле 1С*/

if(
    isset($_POST['1с_positionid']) &&
    isset($_POST['1с_tradeid']) &&
    isset($_POST['1с_byer']) &&
    isset($_POST['1с_kol']) &&
    isset($_POST['1с_price'])
){
    //Переменные для добавления расценки
    $positionid = $_POST['1с_positionid'];//ID последнрей добавленной позиции
    $tradeid = $_POST['1с_tradeid'];
    $sellerid = 0;
    $zak = 0;
    $kol = $_POST['1с_kol'];
    $price = $_POST['1с_price'];
    $byer = $_POST['1с_byer'];
    $fixed = 0;
    $opr = 0;
    $rent = 0;

    /*Надо сделать запрос для опций*/
    $op = 21;

    try{
        $database->beginTransaction();

        $getoptions = $database->prepare("SELECT `ov_tp`,`ov_firstobp`,`ov_wt` FROM byers WHERE `byers_id` = ?");
        $getoptions->execute(array($byer));

        $getoptions_fetched = $getoptions->fetch(PDO::FETCH_ASSOC);

        $tp = $getoptions_fetched['ov_tp'];
        $firstobp = $getoptions_fetched['ov_firstobp'];
        $wtime = $getoptions_fetched['ov_wt'];

        $addpricing = $database->prepare("INSERT INTO `pricings`(`positionid`,`tradeid`,`sellerid`,`zak`,`kol`,`price`,`fixed`,`op`,`tp`,`firstobp`,`wtime`,`opr`,`rent`,`winner`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $addpricing->execute(array($positionid,$tradeid,$sellerid,$zak,$kol,$price,$fixed,$op,$tp,$firstobp,$wtime,$opr,$rent,1));

        //Добавляем Победителя к только что добавленной позиции из только что добавленной расценки
        $lastpricingid = $database->lastInsertId();

        echo "Расценка № " . $lastpricingid . " добавлена";

        $addwinner = $database->prepare("UPDATE req_positions SET winnerid = ? WHERE req_positionid = ?");
        $addwinner->execute(array($lastpricingid,$positionid));

        echo "Победитель назначен";

        $database->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}

//Добавление Выдачи зарплаты в модуле 1С
if(
    isset($_POST['give_date']) &&
    isset($_POST['give_worker']) &&
    isset($_POST['give_amount'])
){
    //Переменные для добавления выдачи наличных
    $give_date = $_POST['give_date'];
    $give_worker = $_POST['give_worker'];
    $give_amount = $_POST['give_amount'];
    $give_source = $_POST['give_source'];
    $give_comment = $_POST['give_comment'];
    $now_time = date('Y-m-d H:i:s');

    try{
        $addgiving = $database->prepare("INSERT INTO `zp_give`(`given`,`worker`,`amount`,`input_time`,`source`,`comment`) VALUES(?,?,?,?,?,?)");
        $addgiving->execute(array($give_date,$give_worker,$give_amount,$now_time,$give_source,$give_comment));

        echo $give_amount." р. выдано ".$give_worker." через ". $give_source ." .";

        //Вернуть input_time, в общем списке выделить цветом только что добавленную выдачу . json надо!

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}


//Добавление Начисления Зарплаты в модуле 1С
if(
    isset($_POST['count_year']) &&
    isset($_POST['count_month']) &&
    isset($_POST['count_worker']) &&
    isset($_POST['count_amount'])
){
    //Переменные для добавления начисления наличных
    $count_year = $_POST['count_year'];
    $count_month = $_POST['count_month'];
    $count_worker = $_POST['count_worker'];
    $count_amount = $_POST['count_amount'];

    try{
        $addcount = $database->prepare("INSERT INTO `zp_count`(`year`, `month`, `worker`,`amount`) VALUES(?,?,?,?)");
        $addcount->execute(array($count_year,$count_month,$count_worker,$count_amount));

        echo $count_worker." начислено ".$count_amount." р. за ".$count_month." ".$count_year." года.";

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}

//Добавление закупки в модуле 1С/////////////////////////////////////////////////
if(isset($_POST['purchases_uid']) &&
    isset($_POST['seller_uid']) &&
    isset($_POST['line_num']) &&
    isset($_POST['trade_uid']) &&
    isset($_POST['incdoc_num']) &&
    isset($_POST['incdoc_date']) &&
    isset($_POST['kol']) &&
    isset($_POST['price']) &&
    isset($_POST['sum']) &&
    isset($_POST['dataver'])
){
    $purchases_uid = $_POST['purchases_uid'];
    $seller_uid = $_POST['seller_uid'];
    $line_num = $_POST['line_num'];
    $trade_uid = $_POST['trade_uid'];
    $incdoc_num = $_POST['incdoc_num'];
    $incdoc_date = $_POST['incdoc_date'];
    $kol = $_POST['kol'];
    $price = $_POST['price'];
    $sum = $_POST['sum'];
    $dataver = $_POST['dataver'];

    /**//////////////////////////////////////////////////////////////

    try {
        $statement = $database->prepare("INSERT INTO `purchases`(`purchases_uid`,`seller_uid`,`line_num`,`trade_uid`,`incdoc_num`,`incdoc_date`,`kol`,`price`,`sum`,`dataver`) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $get_purchase = $database->prepare("SELECT * FROM `purchases` WHERE `purchases_uid` = ? AND `trade_uid` = ?");
        $delete_purchase = $database->prepare("DELETE FROM `purchases` WHERE `purchases_id` = ?");

        $statement->bindParam(1, $purchases_uid);
        $statement->bindParam(2, $seller_uid);
        $statement->bindParam(3, $line_num);
        $statement->bindParam(4, $trade_uid);
        $statement->bindParam(5, $incdoc_num);
        $statement->bindParam(6, $incdoc_date);
        $statement->bindParam(7, $kol);
        $statement->bindParam(8, $price);
        $statement->bindParam(9, $sum);
        $statement->bindParam(10, $dataver);

        $database->beginTransaction();

        //Проверяем, есть ли лишние закупки. Удаляем, если есть.
        $get_purchase->execute(array($purchases_uid, $trade_uid));
        $get_purchase_fetched = $get_purchase->fetchAll(PDO::FETCH_ASSOC);
        if (count($get_purchase_fetched) > 1){
            foreach ($get_purchase_fetched as $n=>$purchase_to_delete) {
                if($n>0){
                    //DELETE $purchase_to_delete
                    $delete_purchase->execute(array($purchase_to_delete['purchases_id']));
                }
            }
        }

        $statement->execute();
        $database->commit();

        echo "Получилось! Добавлена приходная накладная №$incdoc_num от  $incdoc_date на сумму $sum .";

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////



};
//////////////////////////////////////////////////////////////////////


//Добавление Реализации Для Р-1 в модуле 1С/////////////////////////////////////////////////
if(isset($_POST['executes_uid']) &&
    isset($_POST['requests_uid']) &&
    isset($_POST['executed']) &&
    isset($_POST['execute_1c_num']) &&
    isset($_POST['sum']) &&
    isset($_POST['dataver'])
){
    $executes_uid = $_POST['executes_uid'];
    $requests_uid = $_POST['requests_uid'];
    $executed = $_POST['executed'];
    $execute_1c_num = $_POST['execute_1c_num'];
    $sum = $_POST['sum'];
    $dataver = $_POST['dataver'];

    /**//////////////////////////////////////////////////////////////

    try {
        $statement = $database->prepare("INSERT INTO `executes`(`executes_uid`,`requests_uid`,`executed`,`execute_1c_num`,`sum`,`dataver`) VALUES(?,?,?,?,?,?)");



        $statement->bindParam(1, $executes_uid);
        $statement->bindParam(2, $requests_uid);
        $statement->bindParam(3, $executed);
        $statement->bindParam(4, $execute_1c_num);
        $statement->bindParam(5, $sum);
        $statement->bindParam(6, $dataver);

        $database->beginTransaction();




        $statement->execute();
        $database->commit();
        echo "Получилось! Добавлена расходная накладная для отчета Р-1 №$execute_1c_num от  $executed на сумму $sum .";

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////



};
//////////////////////////////////////////////////////////////////////

//Добавление Реализации товара в модуле 1С/////////////////////////////////////////////////
if(isset($_POST['exec_trades_uid']) &&
    isset($_POST['byers_uid']) &&
    isset($_POST['exec_1c_num']) &&
    isset($_POST['executed']) &&
    isset($_POST['line_num']) &&
    isset($_POST['trades_uid']) &&
    isset($_POST['kol']) &&
    isset($_POST['price']) &&
    isset($_POST['sum']) &&
    isset($_POST['dataver'])
){
    $exec_trades_uid = $_POST['exec_trades_uid'];
    $byers_uid = $_POST['byers_uid'];
    $exec_1c_num = $_POST['exec_1c_num'];
    $executed = $_POST['executed'];
    $line_num = $_POST['line_num'];
    $trades_uid = $_POST['trades_uid'];
    $kol = $_POST['kol'];
    $price = $_POST['price'];
    $sum = $_POST['sum'];
    $dataver = $_POST['dataver'];

    /**//////////////////////////////////////////////////////////////

    try {
        $statement = $database->prepare("INSERT INTO `exec_trades`(`exec_trades_uid`,`byers_uid`,`exec_1c_num`,`executed`,`line_num`,`trades_uid`,`kol`,`price`,`sum`,`dataver`) VALUES(?,?,?,?,?,?,?,?,?,?)");
        $get_exec_trade = $database->prepare("SELECT * FROM `exec_trades` WHERE `exec_trades_uid` = ? AND `trades_uid` = ?");
        $delete_exec_trade = $database->prepare("DELETE FROM `exec_trades` WHERE `exec_trades_id` = ?");

        $statement->bindParam(1, $exec_trades_uid);
        $statement->bindParam(2, $byers_uid);
        $statement->bindParam(3, $exec_1c_num);
        $statement->bindParam(4, $executed);
        $statement->bindParam(5, $line_num);
        $statement->bindParam(6, $trades_uid);
        $statement->bindParam(7, $kol);
        $statement->bindParam(8, $price);
        $statement->bindParam(9, $sum);
        $statement->bindParam(10, $dataver);

        $database->beginTransaction();

        //Проверяем, есть ли лишние закупки. Удаляем, если есть.
        $get_exec_trade->execute(array($exec_trades_uid, $trades_uid));
        $get_exec_trade_fetched = $get_exec_trade->fetchAll(PDO::FETCH_ASSOC);
        if (count($get_exec_trade_fetched) > 1){
            foreach ($get_exec_trade_fetched as $n=>$exec_trade_to_delete) {
                if($n>0){
                    //DELETE $purchase_to_delete
                    $delete_exec_trade->execute(array($exec_trade_to_delete['exec_trades_id']));
                }
            }
        }

        $statement->execute();
        $database->commit();

        echo "Получилось! Добавлена расходная накладная №$exec_1c_num от  $executed на сумму $sum .";

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////



};
//////////////////////////////////////////////////////////////////////


//Добавление Транспортных в модуле 1С/////////////////////////////////////////////////
if(isset($_POST['purchases_uid']) &&
    isset($_POST['seller_uid']) &&
    isset($_POST['incdoc_num']) &&
    isset($_POST['incdoc_date']) &&
    isset($_POST['sum']) &&
    isset($_POST['comment']) &&
    isset($_POST['dataver'])
){
    $purchases_uid = $_POST['purchases_uid'];
    $seller_uid = $_POST['seller_uid'];
    $incdoc_num = $_POST['incdoc_num'];
    $incdoc_date = $_POST['incdoc_date'];
    $sum = $_POST['sum'];
    $comment = $_POST['comment'];
    $dataver = $_POST['dataver'];

    /**//////////////////////////////////////////////////////////////

    try {
        $statement = $database->prepare("INSERT INTO `transports`(`purchases_uid`,`seller_uid`,`incdoc_num`,`incdoc_date`,`sum`,`comment`,`dataver`) VALUES(?,?,?,?,?,?,?)");

        $statement->bindParam(1, $purchases_uid);
        $statement->bindParam(2, $seller_uid);
        $statement->bindParam(3, $incdoc_num);
        $statement->bindParam(4, $incdoc_date);
        $statement->bindParam(5, $sum);
        $statement->bindParam(6, $comment);
        $statement->bindParam(7, $dataver);

        $database->beginTransaction();
        $statement->execute();
        $database->commit();

        echo "Получилось! Добавлена транспортная накладная №$incdoc_num от  $incdoc_date на сумму $sum .";

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Добавлена транспортная накладная №$incdoc_num от  $incdoc_date на сумму $sum .";

};
//////////////////////////////////////////////////////////////////////
