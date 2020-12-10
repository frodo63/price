<?php
/**/
include_once 'pdo_connect.php';
/**/
//ОБНОВЛЕНИЕ товаров, поставщиков и покупателей
if(isset($_POST['table_c']) && isset($_POST['thename']) && isset($_POST['uid']) && isset($_POST['onec_id']) && isset($_POST['dataver'])){

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
    $dataver = $_POST['dataver'];

    //Общий принцип Соотнесения двух баз:
    //        Есть 4 варианта ситуации:
    //         1. bd = ltk, innerid = ''      Добавляем новое в ltk и все.
    //         2. bd = ltk, innerid != ''     Соотносим с существующей болванкой, ничего не добавляем.
    //         3. bd=ip, innerid = ''         Создаем в ltk болванку, создаем в ip новое и соотносим с ней.
    //         4. bd=ip, innerid = !''        Создаем в ip новое и cоотносим с существующим в ltk.
    //

    //Если $database = 'ltk'
    if($_POST['db'] == 'ltk'){

        if($table == "trades"){
            $check_name = $pdo->prepare("SELECT `name`,`onec_id`,`nameid`,`tare` FROM `allnames` 
            LEFT JOIN `trades` ON `allnames`.`nameid` = `trades`.`trades_nameid` 
            WHERE `trades`.`trades_uid` = ?");
            $update_tare = $pdo->prepare("UPDATE `trades` SET `tare` = ? WHERE `trades_uid` = ?");//Дополнительный запрос для обновления тары
        }else{
            $check_name = $pdo->prepare("SELECT `name`,$onec_column,`nameid` FROM `allnames` 
            LEFT JOIN $table ON `allnames`.`nameid` = $nameid_column 
            WHERE $table.$uid_column = ?");
        }

        $update_name = $pdo->prepare("UPDATE `allnames` SET `name` = ? WHERE `nameid` = ?");//$check_name_fetched['nameid']
        $update_onec_id = $pdo->prepare("UPDATE $table SET $onec_column = ? WHERE $uid_column = ?");//$uid
        $update_dataver = $pdo->prepare("UPDATE $table SET `dataver` = ? WHERE $uid_column = ?");//$uid

        try{
            $pdo->beginTransaction();
            // Надо сравнить имя.
            //1. Получаем имя.
            $check_name->execute(array($uid));
            $check_name_fetched = $check_name->fetch(PDO::FETCH_ASSOC);

            //2. Сравниваем и сразу обновляем
            if($check_name_fetched['name'] != $thename){
                $update_name->execute(array($thename,$check_name_fetched['nameid']));
            }
            if($check_name_fetched['onec_id'] != $onec_id){
                $update_onec_id->execute(array($onec_id,$uid));
            }
            if($table =="trades"){
                if($check_name_fetched['tare'] != $thetare){
                    $update_tare->execute(array($thetare,$uid));
                }
            }
            //В конце обновления нужно синхронизировать ВерсиюДанных
            $update_dataver->execute(array($dataver,$uid));

            $pdo->commit();
            echo "Получилось! Обновлена запись $thename в таблице $table.";
        } catch( PDOException $Exception ) {
            $pdo->rollback();
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
    }
};

//ДОБАВЛЕНИЕ заявки из окна списка заявок///////////////////////////////////////////////////
/*if(isset($_POST['byer']) && isset($_POST['thename'])){

    $byer = $_POST['byer'];
    $thename = $_POST['thename'];
    $created = date("Y-m-d");

    //////////////////////////////////////////////////////////////


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

    echo "Получилось! Добавлена Заявка  " . $thename . " .";

};*/
/////////////////////////////////////////////////////////////////////

//Обновление заявки из модуля 1С///////////////////////////////////////////////////
if(isset($_POST['byer']) &&
    isset($_POST['created']) &&
    isset($_POST['uid']) &&
    isset($_POST['dataver']) &&
    isset($_POST['onec_id'])){

    $byer = $_POST['byer'];
    $created = $_POST['created'];
    $uid = $_POST['uid'];
    $dataver = $_POST['dataver'];
    $onec_num = $_POST['onec_id'];


    /**//////////////////////////////////////////////////////////////

        //Запросы
        //Опции заказа от покупателя врядли понадобятся, так как заказ уже существует, и у него, скорее всего уже прописаны опции.
        //$request_options = $database->prepare("SELECT byers.ov_tp,byers.ov_firstobp,byers.ov_wt FROM byers where byers.byers_id=?");//Опции заявки из Покупателя
        $check_request = $database->prepare("SELECT * FROM `requests` WHERE `requests_uid` = ?");//Получили данные заказа из программы
        //Предварительно считаем, что заказ не может быть задублирован, удаление будлей не делаем.

        $update_byersid = $database->prepare("UPDATE `requests` SET `byersid` = ? WHERE `requests_uid` = ?");
        $update_1c_num = $database->prepare("UPDATE `requests` SET `1c_num` = ? WHERE `requests_uid` = ?");
        $update_created = $database->prepare("UPDATE `requests` SET `created` = ? WHERE `requests_uid` = ?");
        $update_dataver = $database->prepare("UPDATE `requests` SET `dataver` = ? WHERE `requests_uid` = ?");
    try {

        $database->beginTransaction();
        $check_request->execute(array($uid));
        $check_request_fetched = $check_request->fetchAll(PDO::FETCH_ASSOC);

        if($check_request_fetched[0]['byersid'] != $byer){$update_byersid->execute(array($byer,$uid));}
        if($check_request_fetched[0]['1c_num'] != $onec_num){$update_1c_num->execute(array($onec_num,$uid));}
        if($check_request_fetched[0]['created'] != $created){$update_created->execute(array($created,$uid));}

        $update_dataver->execute(array($dataver,$uid));

        echo $check_request_fetched[0]['requests_id'];//Отдаем айди в 1с
        $database->commit();

        /*echo "Получилось! Обновлен заказ №$onec_num от $created из 1C. Дальше - обновляем позиции.";*/

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////
};
/////////////////////////////////////////////////////////////////////

//ОБНОВЛЕНИЕ ПОЗИЦИИ из модуля 1С/////////////////////////////////////////////////

if(
    isset($_POST['reqid']) &&
    isset($_POST['posname']) &&
    isset($_POST['trades_uid']) &&
    isset($_POST['1с_kol']) &&
    isset($_POST['1с_price']) &&
    isset($_POST['1с_sum']) &&
    isset($_POST['line_num'])
){


    try {

        $reqid = $_POST['reqid'];
        $posname = $_POST['posname'];
        $trades_uid = $_POST['trades_uid'];
        $line_num = $_POST['line_num'];
        $kol = $_POST['1с_kol'];
        $price = $_POST['1с_price'];
        $sum = $_POST['1с_sum'];


        //////////////////////////////////////////////////////////////
        //ПРИ ОБНОВЛЕНИИ СПИСКА ПОЗИЦИЙ РАСЦЕНКИ ОБНОВЛЯТЬ НЕ НУЖНО. НУЖНО ОТСЛЕДИТЬ, КАКОЙ ТОВАР В ПОЗИЦИИ ЗАКРЕПЛЕН И ПО ВОЗМОЖНОСТИ ПРИВЯЗАТЬ К ЭТОЙ ПОЗИЦИИ РАСЦЕНКУ С ЭТИМ ТОВАРОМ
        //НЕЗАДЕЙСТВОВАННЫЕ РАСЦЕНКИ НЕ СТОИТ УДАЛЯТЬ, ПУСТЬ ИХ БУДЕТ ВИДНО. НАДО ТОЛЬКО ТОЧНО СНЯТЬ ПОБЕДИТЕЛЕЙ, ЕСЛИ ТАКИЕ БУДУТ.
        //Получили trades_id(ТоварАйдишник). ТЕПЕРЬ МОЖНО ОТСЛЕДИТЬ, КАКИЕ РАСЦЕНКИ ИЗ ПРИВЯЗАННЫХ К ПОЗИЦИЯМ ЗАКАЗА, ОТНОСЯТСЯ К ЭТОМУ ТОВАРУ И ПРИВЯЗАТЬ ИХ К ЭТОЙ ПОЗИЦИИ.
        //У расценки есть positionid и tradeid

        //Раздалбывать заказ надо не при первом же изменении ВерсииДанных. Может, добавить проверки,
        // что, мол, вот изменилась ценк/количество - тогда  обновляем?

        //$get_positions = $database->prepare("SELECT `requests_id`,`positionid`,`winnerid`,`pricings`.`pricingid`,`line_num`,`tradeid`,`pos_name`,`kol`,`price`,`queen`,`req_positions`.`ov_op`,`req_positions`.`ov_firstobp`,`req_positions`.`ov_tp`,`req_positions`.`ov_wt`,`purchase_id`,`purchased`,`req_positionid` FROM req_positions LEFT JOIN pricings ON req_positionid=positionid LEFT JOIN requests ON requestid=requests_id LEFT JOIN trades ON pricings.tradeid = trades.trades_id WHERE trades.`trades_uid`=? AND requests_id=?");
        $get_positions = $database->prepare("SELECT * FROM `pricings` LEFT JOIN req_positions ON `pricings`.`positionid` = `req_positions`.`req_positionid` LEFT JOIN `requests` ON `req_positions`.`requestid`=`requests`.`requests_id` LEFT JOIN `trades` ON `pricings`.`tradeid` = `trades`.`trades_id` WHERE `trades`.`trades_uid`=? AND `requests`.`requests_id`=?");
        $delete_positions = $database->prepare("DELETE FROM req_positions WHERE `req_positionid`=?");
        $insert_position = $database->prepare("INSERT INTO `req_positions`(
                                `pos_name`,
                                `requestid`,
                                `line_num`,
                                `winnerid`,
                                `queen`,
                                `ov_op`,
                                `ov_firstobp`,
                                `ov_tp`,
                                `ov_wt`,
                                `purchase_id`,
                                `purchased`) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $update_pricings = $database->prepare("UPDATE pricings SET positionid = ? WHERE pricingid = ?");
        $update_pricing_winner = $database->prepare("UPDATE pricings SET `kol`=?, `price`=? WHERE pricingid = ?");



            $database->beginTransaction();

            $get_positions->execute(array($trades_uid, $reqid));
            $get_positions_fetched = $get_positions->fetchAll(PDO::FETCH_ASSOC);

            //Добавляем новую позицию, скопировав основные данные из старой.
            $insert_position->execute(array(
                $posname,
                $reqid,
                $line_num,
                $get_positions_fetched[0]['pricingid'],
                $get_positions_fetched[0]['queen'],
                $get_positions_fetched[0]['ov_op'],
                $get_positions_fetched[0]['ov_firstobp'],
                $get_positions_fetched[0]['ov_tp'],
                $get_positions_fetched[0]['ov_wt'],
                $get_positions_fetched[0]['purchase_id'],
                $get_positions_fetched[0]['purchased']));

            //Получим ID вновь добавленной позиции
            $the_positionid = $database->lastInsertId('req_positions');

            //В какую-то расценку надо вставить kol-price-sum. Но в какую? Если она одна - как это понять? Если  - их несколько, как понять ,в какую вставить новую цену?
            //По идее, это должен быть виннер.
            $update_pricing_winner->execute(array($kol,$price,$get_positions_fetched[0]['pricingid']));

            //Старую позицию надо удалить
            $delete_positions->execute(array($get_positions_fetched[0]['req_positionid']));
            //В расценки по данному товару довавить id вновь добавленной позиции
            foreach ($get_positions_fetched as $prcng){
                $update_pricings->execute(array($the_positionid, $prcng['pricingid']));
            }
            //TODO: И эту расценку надо сделать виннером
        echo $the_positionid;
            $database->commit();
        } catch( PDOException $Exception ) {
            $database->rollback();
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
};
//////////////////////////////////////////////////////////////////////

///ДОБАВЛЕНИЕ ПОЗИЦИИ ИЗ ОКНА СИНХРОНИЗАЦИИ
/*if (
    isset($_POST['sync_reqid']) &&
    isset($_POST['sync_posname']) &&
    isset($_POST['sync_linenum'])
){
    $reqid = $_POST['sync_reqid'];
    $posname = $_POST['sync_posname'];
    $linenum = $_POST['sync_linenum'];


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

}*/

//ОБНОВЛЕНИЕ ПЛАТЕЖКИ из модуля 1С/////////////////////////////////////////////////
if(isset($_POST['requestid']) &&/*есть*/
    isset($_POST['payments_uid']) &&/*есть*/
    isset($_POST['payments_requests_uid']) &&/*есть*/
    isset($_POST['byersid']) &&/*есть*/
    isset($_POST['onec_id']) &&/*есть*/
    isset($_POST['dataver']) &&/*есть*/
    isset($_POST['payed']) &&/*есть*/
    isset($_POST['number']) &&/*есть*/
    isset($_POST['sum'])/*есть*/
){
    $requestid = $_POST['requestid'];
    $payments_uid = $_POST['payments_uid'];
    $payments_req_uid = $_POST['payments_requests_uid'];
    $byersid = $_POST['byersid'];
    $onec_id = $_POST['onec_id'];
    $dataver = $_POST['dataver'];
    $payed = $_POST['payed'];
    $number = $_POST['number'];
    $sum = $_POST['sum'];

    $get_payment = $database->prepare("SELECT * FROM `payments` WHERE `payments_uid` = ? AND `payments_requests_uid` = ?");
    $update_payments_requests_uid = $database->prepare("UPDATE `payments` SET `payments_requests_uid` = ? WHERE `payments_uid` = ? AND `requestid` = ?");
    $update_requestid = $database->prepare("UPDATE `payments` SET `requestid` = ? WHERE `payments_uid` = ? AND `payments_requests_uid` = ?");
    $update_byersid = $database->prepare("UPDATE `payments` SET `byersid` = ? WHERE `payments_uid` = ? AND `payments_requests_uid` = ?");
    $update_onec_id = $database->prepare("UPDATE `payments` SET `onec_id` = ? WHERE `payments_uid` = ? AND `payments_requests_uid` = ?");
    $update_dataver = $database->prepare("UPDATE `payments` SET `dataver` = ? WHERE `payments_uid` = ? AND `payments_requests_uid` = ?");
    $update_payed = $database->prepare("UPDATE `payments` SET `payed` = ? WHERE `payments_uid` = ? AND `payments_requests_uid` = ?");
    $update_number = $database->prepare("UPDATE `payments` SET `number` = ? WHERE `payments_uid` = ? AND `payments_requests_uid` = ?");
    $update_sum = $database->prepare("UPDATE `payments` SET `sum` = ? WHERE `payments_uid` = ? AND `payments_requests_uid` = ?");

    try {
        $database->beginTransaction();

        $get_payment->execute(array($payments_uid, $payments_req_uid));
        $get_payment_fetched = $get_payment->fetch(PDO::FETCH_ASSOC);

        //Нашел траблему. В платежках есть requrstid, Но payments_requests_uid не был заполнен.
        //Надо сделать автозаполнение, если payments_requests_uid = пустой, то заполнить его из строки запроса ($payments_req_uid = $_POST['payments_requests_uid'];)
        if(/*($get_payment_fetched['payments_requests_uid'] != $payments_req_uid) || */($get_payment_fetched['payments_requests_uid'] != "") || !$get_payment_fetched['payments_requests_uid']){
            $update_payments_requests_uid->execute(array($payments_req_uid, $payments_uid, $requestid));
        }

        //2. Сравниваем и сразу обновляем
        if($get_payment_fetched['requestid'] != $requestid){$update_requestid->execute(array($requestid,$payments_uid, $payments_req_uid));}
        if($get_payment_fetched['byersid'] != $byersid){$update_byersid->execute(array($byersid,$payments_uid, $payments_req_uid));}
        if($get_payment_fetched['onec_id'] != $onec_id){$update_onec_id->execute(array($onec_id,$payments_uid, $payments_req_uid));}
        if($get_payment_fetched['payed'] != $payed){$update_payed->execute(array($payed,$payments_uid, $payments_req_uid));}
        if($get_payment_fetched['number'] != $number){$update_number->execute(array($number,$payments_uid, $payments_req_uid));}
        if($get_payment_fetched['sum'] != $sum){$update_sum->execute(array($sum,$payments_uid, $payments_req_uid));}

        //По-любому обновляем версию данных
        $update_dataver->execute(array($dataver,$payments_uid, $payments_req_uid));

        $database->commit();
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        $database->rollback();
    }
    

    echo "Получилось! Обновлена платежка  на сумму $sum в заявку $requestid.";

};
//////////////////////////////////////////////////////////////////////

//Добавление расценки в МОДУЛЕ ВЫГРУЗКИ ДАННЫХ

/*if(
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

    //Надо сделать запрос для опций
    $op = 21;

    try{
        $database->beginTransaction();

        $getoptions = $database->prepare("SELECT `ov_tp`,`ov_firstobp`,`ov_wt` FROM byers WHERE `byers_id` = ?");
        $getoptions->execute(array($byer));

        $getoptions_fetched = $getoptions->fetch(PDO::FETCH_ASSOC);

        $tp = $getoptions_fetched['ov_tp'];
        $firstobp = $getoptions_fetched['ov_firstobp'];
        $wtime = $getoptions_fetched['ov_wt'];

        $addpricing = $database->prepare("INSERT INTO `pricings`(`positionid`,`tradeid`,`sellerid`,`zak`,`kol`,`price`,`fixed`,`op`,`tp`,`firstobp`,`wtime`,`opr`,`rent`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $addpricing->execute(array($positionid,$tradeid,$sellerid,$zak,$kol,$price,$fixed,$op,$tp,$firstobp,$wtime,$opr,$rent));

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
}*/

//Обновление закупки в модуле 1С/////////////////////////////////////////////////
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
    $trade_uid = $_POST['trade_uid'];

    $seller_uid = $_POST['seller_uid'];
    $line_num = $_POST['line_num'];
    $incdoc_num = $_POST['incdoc_num'];
    $incdoc_date = $_POST['incdoc_date'];
    $kol = $_POST['kol'];
    $price = $_POST['price'];
    $sum = $_POST['sum'];

    $dataver = $_POST['dataver'];

    /*try {
        $statement = $database->prepare("INSERT INTO `purchases`(`purchases_uid`,`seller_uid`,`line_num`,`trade_uid`,`incdoc_num`,`incdoc_date`,`kol`,`price`,`sum`,`dataver`) VALUES(?,?,?,?,?,?,?,?,?,?)");

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
        $statement->execute();
        $database->commit();

    }*/

    $get_purchase = $database->prepare("SELECT * FROM `purchases` WHERE `purchases_uid` = ? AND `trade_uid` = ?");
    $delete_purchase = $database->prepare("DELETE FROM `purchases` WHERE `purchases_id` = ?");

    $update_seller_uid = $database->prepare("UPDATE `purchases` SET `seller_uid` = ? WHERE `purchases_uid` = ? AND `trade_uid` = ?");
    $update_line_num = $database->prepare("UPDATE `purchases` SET `line_num` = ? WHERE `purchases_uid` = ? AND `trade_uid` = ?");
    $update_incdoc_num = $database->prepare("UPDATE `purchases` SET `incdoc_num` = ? WHERE `purchases_uid` = ? AND `trade_uid` = ?");
    $update_incdoc_date = $database->prepare("UPDATE `purchases` SET `incdoc_date` = ? WHERE `purchases_uid` = ? AND `trade_uid` = ?");
    $update_kol = $database->prepare("UPDATE `purchases` SET `kol` = ? WHERE `purchases_uid` = ? AND `trade_uid` = ?");
    $update_price = $database->prepare("UPDATE `purchases` SET `price` = ? WHERE `purchases_uid` = ? AND `trade_uid` = ?");
    $update_sum = $database->prepare("UPDATE `purchases` SET `sum` = ? WHERE `purchases_uid` = ? AND `trade_uid` = ?");

    $update_dataver = $database->prepare("UPDATE `purchases` SET `dataver` = ? WHERE `purchases_uid` = ? AND `trade_uid` = ?");

    try {
        $database->beginTransaction();
        $get_purchase->execute(array($purchases_uid, $trade_uid));
        $get_purchase_fetched = $get_purchase->fetchAll(PDO::FETCH_ASSOC);

        //Проверяем, есть ли лишние закупки. Удаляем, если есть.
        if (count($get_purchase_fetched) > 1){
            foreach ($get_purchase_fetched as $n=>$purchase_to_delete) {
                if($n>0){
                    //DELETE $purchase_to_delete
                    $delete_purchase->execute(array($purchase_to_delete['purchases_id']));
                }
            }
        }

        //2. Сравниваем и сразу обновляем
        if($get_purchase_fetched[0]['seller_uid'] != $seller_uid){$update_seller_uid->execute(array($seller_uid,$purchases_uid,$trade_uid));}
        if($get_purchase_fetched[0]['line_num'] != $line_num){$update_line_num->execute(array($line_num,$purchases_uid,$trade_uid));}
        if($get_purchase_fetched[0]['incdoc_num'] != $incdoc_num){$update_incdoc_num->execute(array($incdoc_num,$purchases_uid,$trade_uid));}
        if($get_purchase_fetched[0]['incdoc_date'] != $incdoc_date){$update_incdoc_date->execute(array($incdoc_date,$purchases_uid,$trade_uid));}
        if($get_purchase_fetched[0]['kol'] != $kol){$update_kol->execute(array($kol,$purchases_uid,$trade_uid));}
        if($get_purchase_fetched[0]['price'] != $price){$update_price->execute(array($price,$purchases_uid,$trade_uid));}
        if($get_purchase_fetched[0]['sum'] != $sum){$update_sum->execute(array($sum,$purchases_uid,$trade_uid));}
        //По-любому обновляем версию данных
        $update_dataver->execute(array($dataver,$purchases_uid,$trade_uid));

        $database->commit();
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Обновлена приходная накладная №$incdoc_num от  $incdoc_date на сумму $sum .";

};
//////////////////////////////////////////////////////////////////////


//Обновление Реализации Для Р-1 в модуле 1С/////////////////////////////////////////////////
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

    /*try {
        $statement = $database->prepare("INSERT INTO `executes`(`executes_uid`,`requests_uid`,`executed`,`execute_1c_num`,`sum`,`dataver`) VALUES(?,?,?,?,?,?)");

        $statement->bindParam(1, $executes_uid);
        $statement->bindParam(2, $requests_uid);
        $statement->bindParam(3, $executed);
        $statement->bindParam(4, $execute_1c_num);
        $statement->bindParam(5, $sum);
        $statement->bindParam(6, $dataver);

        $database->beginTransaction();
        $statement->execute();
        $database->commit();*/

    $get_execute = $database->prepare("SELECT * FROM `executes` WHERE `executes_uid` = ?");
    $delete_execute = $database->prepare("DELETE FROM `executes` WHERE `executes_id` = ?");

    $update_requests_uid = $database->prepare("UPDATE `executes` SET `requests_uid` = ? WHERE `executes_uid` = ?");
    $update_executed = $database->prepare("UPDATE `executes` SET `executed` = ? WHERE `executes_uid` = ?");
    $update_execute_1c_num = $database->prepare("UPDATE `executes` SET `execute_1c_num` = ? WHERE `executes_uid` = ?");
    $update_sum = $database->prepare("UPDATE `executes` SET `sum` = ? WHERE `executes_uid` = ?");

    $update_dataver = $database->prepare("UPDATE `executes` SET `dataver` = ? WHERE `executes_uid` = ?");

    try {
        $database->beginTransaction();
        $get_execute->execute(array($executes_uid));
        $get_execute_fetched = $get_execute->fetchAll(PDO::FETCH_ASSOC);

        //Проверяем, есть ли лишние закупки. Удаляем, если есть.
        if (count($get_execute_fetched) > 1){
            foreach ($get_execute_fetched as $n=>$execute_to_delete) {
                if($n>0){
                    //DELETE $purchase_to_delete
                    $delete_execute->execute(array($execute_to_delete['executes_id']));
                }
            }
        }

        //2. Сравниваем и сразу обновляем
        if($get_execute_fetched[0]['requests_uid'] != $requests_uid){$update_requests_uid->execute(array($requests_uid,$executes_uid));}
        if($get_execute_fetched[0]['executed'] != $executed){$update_executed->execute(array($executed,$executes_uid));}
        if($get_execute_fetched[0]['execute_1c_num'] != $execute_1c_num){$update_execute_1c_num->execute(array($execute_1c_num,$executes_uid));}
        if($get_execute_fetched[0]['sum'] != $sum){$update_sum->execute(array($sum,$executes_uid));}

        //По-любому обновляем версию данных
        $update_dataver->execute(array($dataver,$executes_uid));

        $database->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Обновлена расходная накладная для отчета Р-1 №$execute_1c_num от  $executed на сумму $sum .";

};
//////////////////////////////////////////////////////////////////////

//Обновление Реализации товара в модуле 1С/////////////////////////////////////////////////
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
    $trades_uid = $_POST['trades_uid'];//нет
    $kol = $_POST['kol'];
    $price = $_POST['price'];
    $sum = $_POST['sum'];
    $dataver = $_POST['dataver'];

    /**//////////////////////////////////////////////////////////////

    /*try {
        $statement = $database->prepare("INSERT INTO `exec_trades`(`exec_trades_uid`,`byers_uid`,`exec_1c_num`,`executed`,`line_num`,`trades_uid`,`kol`,`price`,`sum`,`dataver`) VALUES(?,?,?,?,?,?,?,?,?,?)");

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
        $statement->execute();
        $database->commit();*/

    $get_exec_trade = $database->prepare("SELECT * FROM `exec_trades` WHERE `exec_trades_uid` = ? AND `trades_uid` = ?");
    $delete_exec_trade = $database->prepare("DELETE FROM `exec_trades` WHERE `exec_trades_id` = ?");

    $update_byers_uid = $database->prepare("UPDATE `exec_trades` SET `byers_uid` = ? WHERE `exec_trades_uid` = ? AND `trades_uid` = ?");
    $update_executed = $database->prepare("UPDATE `exec_trades` SET `executed` = ? WHERE `exec_trades_uid` = ? AND `trades_uid` = ?");
    $update_exec_1c_num = $database->prepare("UPDATE `exec_trades` SET `exec_1c_num` = ? WHERE `exec_trades_uid` = ? AND `trades_uid` = ?");

    $update_line_num = $database->prepare("UPDATE `exec_trades` SET `line_num` = ? WHERE `exec_trades_uid` = ? AND `trades_uid` = ?");
    $update_kol = $database->prepare("UPDATE `exec_trades` SET `kol` = ? WHERE `exec_trades_uid` = ? AND `trades_uid` = ?");
    $update_price = $database->prepare("UPDATE `exec_trades` SET `price` = ? WHERE `exec_trades_uid` = ? AND `trades_uid` = ?");
    $update_sum = $database->prepare("UPDATE `exec_trades` SET `sum` = ? WHERE `exec_trades_uid` = ? AND `trades_uid` = ?");

    $update_dataver = $database->prepare("UPDATE `exec_trades` SET `dataver` = ? WHERE `exec_trades_uid` = ?");

    try {
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

        //2. Сравниваем и сразу обновляем
        if($get_exec_trade_fetched[0]['byers_uid'] != $byers_uid){$update_byers_uid->execute(array($byers_uid,$exec_trades_uid,$trades_uid));}
        if($get_exec_trade_fetched[0]['executed'] != $executed){$update_executed->execute(array($executed,$exec_trades_uid,$trades_uid));}
        if($get_exec_trade_fetched[0]['exec_1c_num'] != $exec_1c_num){$update_exec_1c_num->execute(array($exec_1c_num,$exec_trades_uid,$trades_uid));}
        if($get_exec_trade_fetched[0]['line_num'] != $line_num){$update_line_num->execute(array($line_num,$exec_trades_uid,$trades_uid));}
        if($get_exec_trade_fetched[0]['kol'] != $kol){$update_kol->execute(array($kol,$exec_trades_uid,$trades_uid));}
        if($get_exec_trade_fetched[0]['price'] != $price){$update_price->execute(array($price,$exec_trades_uid,$trades_uid));}
        if($get_exec_trade_fetched[0]['sum'] != $sum){$update_sum->execute(array($sum,$exec_trades_uid,$trades_uid));}


        //По-любому обновляем версию данных
        $update_dataver->execute(array($dataver,$exec_trades_uid));

        $database->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Обновлена реализация товара по накладной №$exec_1c_num от  $executed на сумму $sum .";

};
//////////////////////////////////////////////////////////////////////


//Обновление Транспортных в модуле 1С/////////////////////////////////////////////////
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

    /*try {
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
        $database->commit();*/

    $get_transports = $database->prepare("SELECT * FROM `transports` WHERE `purchases_uid` = ?");
    $delete_transports = $database->prepare("DELETE FROM `transports` WHERE `purchases_uid` = ?");

    $update_seller_uid = $database->prepare("UPDATE `transports` SET `seller_uid` = ? WHERE `purchases_uid` = ?");
    $update_incdoc_num = $database->prepare("UPDATE `transports` SET `incdoc_num` = ? WHERE `purchases_uid` = ?");
    $update_incdoc_date = $database->prepare("UPDATE `transports` SET `incdoc_date` = ? WHERE `purchases_uid` = ?");
    $update_sum = $database->prepare("UPDATE `transports` SET `sum` = ? WHERE `purchases_uid` = ?");
    $update_comment = $database->prepare("UPDATE `transports` SET `comment` = ? WHERE `purchases_uid` = ?");

    $update_dataver = $database->prepare("UPDATE `transports` SET `dataver` = ? WHERE `purchases_uid` = ?");

    try {
        $database->beginTransaction();
        $get_transports->execute(array($purchases_uid));
        $get_transports_fetched = $get_transports->fetchAll(PDO::FETCH_ASSOC);

        //Проверяем, есть ли лишние закупки. Удаляем, если есть.
        if (count($get_transports_fetched) > 1){
            foreach ($get_transports_fetched as $n=>$transports_to_delete) {
                if($n>0){
                    //DELETE $purchase_to_delete
                    $delete_transports->execute(array($transports_to_delete['purchases_id']));
                }
            }
        }

        //2. Сравниваем и сразу обновляем
        if($get_transports_fetched[0]['seller_uid'] != $seller_uid){$update_seller_uid->execute(array($seller_uid,$purchases_uid));}
        if($get_transports_fetched[0]['incdoc_num'] != $incdoc_num){$update_incdoc_num->execute(array($incdoc_num,$purchases_uid));}
        if($get_transports_fetched[0]['incdoc_date'] != $incdoc_date){$update_incdoc_date->execute(array($incdoc_date,$purchases_uid));}
        if($get_transports_fetched[0]['sum'] != $sum){$update_sum->execute(array($sum,$purchases_uid));}
        if($get_transports_fetched[0]['comment'] != $comment){$update_comment->execute(array($comment,$purchases_uid));}

        //По-любому обновляем версию данных
        $update_dataver->execute(array($dataver,$purchases_uid));

        $database->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Обновлена транспортная накладная №$incdoc_num от  incdoc_date на сумму $sum .";

};
//////////////////////////////////////////////////////////////////////
