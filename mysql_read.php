<?php
include_once 'pdo_connect.php';

/*Форматирование числа и округление до 2 знаков*/
function number_f($num)
{
    return number_format(round($num, 2), 2, '.', ' ');
}

/*ЧТЕНИЕ ВСЕГО ПОЛНЫМИ И НЕ СОВСЕМ ПОЛНЫМИ ТАБЛИЦАМИ*/
if(isset($_POST['table'])){
    $table = $_POST['table'];
    $tablenid = $table . '_nameid';
    $dbs_array=array(array($pdo,'ltk',array(),'ЛТК'),array($pdoip,'ip',array(),'ИП УСВ'));
    $result = "";

    if ($table == 'requests') {
        //Блок рисовки результатов поиска из ВПСПВ
        if (isset($_POST['category']) && isset($_POST['theid'])){
            //Рисование заявок из обеих баз по результатам из Великой Поисковой Строки Поиска Всего
            //
            $category = $_POST['category'];
            $theid = $_POST['theid'];
            /*Список заявок по покупателю*/
            if($category == 'byer'){
                try {
                    //Логика использования сдвоенной базы ПОкупателей.
                    //Если у заявленного покупателя в базе лтк есть ip_uid - берем из базы лтк uid, берем из базы ип trades_id
                    //и выбираем из базы ип данные по этому покупателю. Код для покупателей должен быть вне цикла форич

                    $check_lkt_byer = $pdo->prepare("SELECT ip_uid FROM byers WHERE byers_id = ?");
                    $check_lkt_byer->execute(array($theid));
                    $check_lkt_byer_fetched = $check_lkt_byer->fetch(PDO::FETCH_ASSOC);

                    //ip_uid по умолчанию равен null, и мы берем данные из одной базы ЛТК
                    $statement = $pdo->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum 
                                        FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        WHERE a.byersid = ? ORDER BY req_date DESC");
                    //////////////////////////////////////////////////////////////////////////
                    $pdo->beginTransaction();
                    $statement->execute(array($theid));
                    $stmt_fetched = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $dbs_array[0][2] = $stmt_fetched;
                    $pdo->commit();

                    if ($check_lkt_byer_fetched['ip_uid']){
                        //Когда же ip_uid не равен null, мы добавляем данные из базы ИП
                        $statement_ip = $pdoip->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_uid AS b_uid,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum 
                                        FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        WHERE b.byers_uid = ? ORDER BY req_date DESC");
                        //////////////////////////////////////////////////////////////////////////
                        $pdoip->beginTransaction();
                        $statement_ip->execute(array($check_lkt_byer_fetched['ip_uid']));
                        $stmt_ip_fetched = $statement_ip->fetchAll(PDO::FETCH_ASSOC);
                        $dbs_array[1][2] = $stmt_ip_fetched;
                        $pdoip->commit();
                    }
                } catch( PDOException $Exception ) {
                    // Note The Typecast To An Integer!
                    $pdo->rollback();
                    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
                }
            };
            /*Список заявок по названию заявки*/
            if($category == 'request'){

                if(isset($_POST['is_onec'])){
                    $statement = $pdo->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum
                                        FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        WHERE a.requests_uid = ? ORDER BY req_date DESC");
                }else{
                    $statement = $pdo->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum
                                        FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        WHERE a.requests_id = ? ORDER BY req_date DESC");
                }
                $statement_ip = $pdoip->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum
                                        FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        WHERE a.requests_id = ? ORDER BY req_date DESC");
                //Выводится в любом случае одна заявка, надо, чтобы шел поиск по базе ип по номеру заявки в 1С. Не страшно, сделаем.
                //Дифференциация базы, из какой заявка. Должна быть индикация в выпадающем списке, из какой базы заявка.
                if($_POST['db'] == "ltk"){
                    try {
                        $pdo->beginTransaction();
                        $statement->execute(array($theid));
                        $stmt_fetched = $statement->fetchAll(PDO::FETCH_ASSOC);
                        $dbs_array[0][2] = $stmt_fetched;
                        $pdo->commit();
                    } catch( PDOException $Exception ) {$pdo->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}
                }
                if($_POST['db'] == "ip"){
                    try {
                        $pdoip->beginTransaction();
                        $statement_ip->execute(array($theid));
                        $stmt_ip_fetched = $statement_ip->fetchAll(PDO::FETCH_ASSOC);
                        $dbs_array[1][2] = $stmt_ip_fetched;
                        $pdoip->commit();
                    } catch( PDOException $Exception ) {$pdoip->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}
                }
            };
            /*Список заявок по Поставщику*/
            if($category == 'seller'){

                $getids=$pdo->prepare("SELECT b.`requestid` AS reqid FROM 
            ((SELECT `sellerid`,`positionid` FROM `pricings`) AS a INNER JOIN (SELECT `req_positionid`, `requestid` FROM `req_positions`) AS b 
            ON a.`positionid`= b.`req_positionid`) 
            WHERE a.`sellerid` = ?");

                $getids_ip=$pdoip->prepare("SELECT b.`requestid` AS reqid FROM
                                   (SELECT `sellerid`,`positionid`,`sellers_uid` FROM `pricings` LEFT JOIN prices_ip.sellers ON prices_ip.pricings.sellerid=prices_ip.sellers.sellers_id) AS a INNER JOIN (SELECT `req_positionid`, `requestid` FROM `req_positions`) AS b
                                       ON a.`positionid`= b.`req_positionid` WHERE a.`sellers_uid` = ?");

                $check_lkt_seller = $pdo->prepare("SELECT ip_uid FROM sellers WHERE sellers_id = ?");
                $check_lkt_seller->execute(array($theid));
                $check_lkt_seller_fetched = $check_lkt_seller->fetch(PDO::FETCH_ASSOC);

                //Логика использования сдвоенной базы Поставщиков.
                //Если у заявленного поставщика в базе лтк есть ip_uid - берем из базы лтк uid, берем из базы ип sellers_id
                //и выбираем из базы ип данные по этому поставщику.

                try {
                    $pdo->beginTransaction();
                    $getids->execute(array($theid));
                    $getids_fetched = $getids->fetchAll(PDO::FETCH_ASSOC);
                    $ids=array();
                    foreach ($getids_fetched as $row){$ids[] = $row['reqid'];}
                        /*Айдишники из массива в строку с сепаратором запятая*/
                        $ids=implode(",", array_unique($ids));
                        $statement = $pdo->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name
                                            FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                            WHERE `a`.`requests_id` IN (".$ids.") ORDER BY req_date DESC");


                        $statement->execute();
                        $stmt_fetched = $statement->fetchAll(PDO::FETCH_ASSOC);
                        $dbs_array[0][2] = $stmt_fetched;
                        $pdo->commit();

                } catch( PDOException $Exception ) {$pdo->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}

                if($check_lkt_seller_fetched['ip_uid']){
                    try {
                        $pdoip->beginTransaction();
                        $getids_ip->execute(array($check_lkt_seller_fetched['ip_uid']));
                        $getids_ip_fetched = $getids_ip->fetchAll(PDO::FETCH_ASSOC);
                        $ids=array();
                        foreach ($getids_ip_fetched as $row){$ids[] = $row['reqid'];}
                        /*Айдишники из массива в строку с сепаратором запятая*/
                        $ids=implode(",", array_unique($ids));
                        $statement = $pdoip->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name
                                            FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                            WHERE `a`.`requests_id` IN (".$ids.") ORDER BY req_date DESC");


                        $statement->execute();
                        $stmt_fetched = $statement->fetchAll(PDO::FETCH_ASSOC);
                        $dbs_array[1][2] = $stmt_fetched;
                        $pdoip->commit();

                    } catch( PDOException $Exception ) {$pdoip->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}

                }

            };
            /*Список заявок по товару*/
            if($category == 'trade'){

                $getids=$pdo->prepare("SELECT b.`requestid` AS reqid FROM 
            ((SELECT `tradeid`,`positionid` FROM `pricings`) AS a JOIN (SELECT `req_positionid`, `requestid` FROM `req_positions`) AS b 
            ON a.`positionid`= b.`req_positionid`) 
            WHERE a.`tradeid` = ?");
                $getids_ip=$pdoip->prepare("SELECT b.`requestid` AS reqid FROM 
            ((SELECT `tradeid`,`positionid` FROM `pricings`) AS a JOIN (SELECT `req_positionid`, `requestid` FROM `req_positions`) AS b 
            ON a.`positionid`= b.`req_positionid`) 
            WHERE a.`tradeid` = ?");

                try {
                    $pdo->beginTransaction();
                    $getids->execute(array($theid));
                    /*Создаем пустой массив, кидаем все результаты в массив ids*/
                    $ids = array();
                    foreach ($getids as $row) {$ids[] = $row['reqid'];};

                        /*Айдишники из массива в cтроку с сепаратором запятая*/
                        $ids = implode(",", array_unique($ids));
                        $statement = $pdo->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name
                                            FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                            WHERE a.requests_id IN (".$ids.") ORDER BY req_date DESC");
                        $statement->execute();
                        $stmt_fetched = $statement->fetchAll(PDO::FETCH_ASSOC);
                        $dbs_array[0][2] = $stmt_fetched;
                        $pdo->commit();
                } catch( PDOException $Exception ) {$pdo->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}

                try {
                    $pdoip->beginTransaction();

                    //Прилетает айдишник товара.
                    //Мы одним запросом получаем его айдишник в обеих базах.
                    $get_trade_info=$pdo->prepare("SELECT b.trades_id as trades_id FROM prices.trades as a LEFT JOIN prices_ip.trades as b ON a.ip_uid=b.trades_uid WHERE a.trades_id=?");
                    $get_trade_info->execute(array($theid));
                    $get_trade_info_fetched = $get_trade_info->fetch(PDO::FETCH_ASSOC);

                    $getids_ip->execute(array($get_trade_info_fetched['trades_id']));
                    /*Создаем пустой массив, кидаем все результаты в массив ids*/
                    $ids = array();
                    foreach ($getids_ip as $row) {$ids[] = $row['reqid'];};

                    $new_array_of_ids = array_values(array_unique($ids));

                    /*Айдишники из массива в cтроку с сепаратором запятая*/
                    $ids = implode(",", $new_array_of_ids);
                    $statement = $pdoip->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name
                                            FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT byers_id,byers_nameid,name FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid WHERE a.requests_id IN (".$ids.") ORDER BY req_date DESC");
                    $statement->execute();
                    $stmt_fetched = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $dbs_array[1][2] = $stmt_fetched;
                    $pdoip->commit();
                } catch( PDOException $Exception ) {$pdoip->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}
            };
        }/*Временной интервал*/
        else if(isset($_POST['from']) && isset($_POST['to'])) {
            $from = $_POST['from'];
            $to = $_POST['to'];
            $filterbyer = $_POST['filterbyer'];
            $result = "";

                if($filterbyer == 'none'){
                    foreach ($dbs_array as $k=>$database) {
                        try {
                            $statement = $database[0]->prepare("SELECT                                       
                                            a.created AS req_date,
                                            a.requests_id AS req_id,
                                            a.requests_nameid AS req_nameid,
                                            a.requests_uid AS req_uid,
                                            a.name AS req_name,
                                            a.req_rent AS rent,
                                            a.req_sum AS sum,
                                            a.1c_num AS 1c_num,
                                            b.byers_id AS b_id,
                                            b.byers_nameid AS b_nameid,
                                            b.name AS b_name
                                            FROM (SELECT * FROM (SELECT * FROM requests WHERE `created` BETWEEN ? AND ?) AS x LEFT JOIN allnames ON x.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                            ORDER BY req_date DESC");

                            $database[0]->beginTransaction();
                            $statement->execute(array($from, $to));
                            $stmt_fetched = $statement->fetchAll(PDO::FETCH_ASSOC);
                            $dbs_array[$k][2] = $stmt_fetched;
                            $database[0]->commit();
                        } catch (PDOException $Exception) {
                            // Note The Typecast To An Integer!
                            $pdo->rollback();
                            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode();
                        }
                    }
                }else{

                        //Логика использования сдвоенной базы ПОкупателей.
                        //Если у заявленного покупателя в базе лтк есть ip_uid - берем из базы лтк uid, берем из базы ип trades_id
                        //и выбираем из базы ип данные по этому покупателю. Код для покупателей должен быть вне цикла форич
                        $check_lkt_byer = $pdo->prepare("SELECT ip_uid FROM byers WHERE byers_id = ?");
                        $check_lkt_byer->execute(array($filterbyer));
                        $check_lkt_byer_fetched = $check_lkt_byer->fetch(PDO::FETCH_ASSOC);

                        //ip_uid по умолчанию равен null, и мы берем данные из одной базы ЛТК
                        $statement = $pdo->prepare("SELECT                                       
                                            a.created AS req_date,
                                            a.requests_id AS req_id,
                                            a.requests_nameid AS req_nameid,
                                            a.requests_uid AS req_uid,
                                            a.name AS req_name,
                                            a.req_rent AS rent,
                                            a.req_sum AS sum,
                                            a.1c_num AS 1c_num,
                                            b.byers_id AS b_id,
                                            b.byers_nameid AS b_nameid,
                                            b.name AS b_name
                                            FROM (SELECT * FROM 
                                                  
                                                  (SELECT * FROM requests) AS x LEFT JOIN allnames ON x.requests_nameid=allnames.nameid)AS a 
                                                  
                                                  LEFT JOIN 
                                                  
                                                  (SELECT * FROM byers AS t LEFT JOIN allnames ON t.byers_nameid=allnames.nameid) AS b 
                                                  
                                                  ON b.byers_id=a.byersid WHERE (a.created BETWEEN ? AND ?) AND (`b`.`byers_id` = ?) ORDER BY req_date DESC");
                        ///////////////////////////////////////////////////////////////////////////
                    try {
                        $pdo->beginTransaction();
                        $statement->execute(array($from, $to, $filterbyer));
                        $stmt_fetched = $statement->fetchAll(PDO::FETCH_ASSOC);
                        $dbs_array[0][2] = $stmt_fetched;
                        $pdo->commit();
                    }catch( PDOException $Exception ) {$pdoip->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}

                    if($check_lkt_byer_fetched['ip_uid']){
                        //Когда же ip_uid не равен null, мы добавляем данные из базы ИП
                        $statement = $pdoip->prepare("SELECT                                       
                                            a.created AS req_date,
                                            a.requests_id AS req_id,
                                            a.requests_nameid AS req_nameid,
                                            a.requests_uid AS req_uid,
                                            a.name AS req_name,
                                            a.req_rent AS rent,
                                            a.req_sum AS sum,
                                            a.1c_num AS 1c_num,
                                            b.byers_id AS b_id,
                                            b.byers_nameid AS b_nameid,
                                            b.name AS b_name
                                            FROM (SELECT * FROM 
                                                  
                                                  (SELECT * FROM requests) AS x LEFT JOIN allnames ON x.requests_nameid=allnames.nameid)AS a 
                                                  
                                                  LEFT JOIN 
                                                  
                                                  (SELECT * FROM byers AS t LEFT JOIN allnames ON t.byers_nameid=allnames.nameid) AS b 
                                                  
                                                  ON b.byers_id=a.byersid WHERE (a.created BETWEEN ? AND ?) AND (`b`.`byers_uid` = ?) ORDER BY req_date DESC");
                        try {
                            $pdoip->beginTransaction();
                            $statement->execute(array($from,$to,$check_lkt_byer_fetched['ip_uid']));
                            $stmt_fetched = $statement->fetchAll(PDO::FETCH_ASSOC);
                            $dbs_array[1][2] = $stmt_fetched;
                            $pdoip->commit();
                        }catch( PDOException $Exception ) {$pdoip->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}
                    }
                }

        }/*Общий список заявок*/else{
            foreach ($dbs_array as $k=>$database) {
                try {
                    $statement = $database[0]->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name
                                        FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        WHERE a.created BETWEEN '2019-01-01' AND '2020-12-31'
                                        ORDER BY req_date DESC");
                    $database[0]->beginTransaction();
                    $statement->execute();
                    $stmt_fetched = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $dbs_array[$k][2] = $stmt_fetched;
                    $database[0]->commit();

                } catch (PDOException $Exception) {
                    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode();
                }
            }
        }

            $result .= "<table><thead><tr><th>Дата</th><th>№ в 1С</th><th>Покупатель</th><th>Название заявки</th><th>Рент</th><th>Сумма</th><th></th></tr></thead>";
            //РИСОВАНИЕ ЗАЯВОК////////////////////////////////////////////////////////////////////////////////////////////////////////
            foreach ($dbs_array as $database){

                //Перед рисованием
                if(count($database[2]) == 0){
                    $result .= "<tr><td></td><td></td><td></td><td><span>Заявок в базе $database[3] не обнаружено.</span></td><td></td><td></td><td></td></tr>";
                }else{
                    $result .= "<tr><td></td><td></td><td></td><td><span>По данным базы $database[3]: </span></td><td></td><td></td><td></td></tr>";
                }


                foreach ($database[2] as $row){

                    $get_executals = $database[0]->prepare("SELECT * FROM executes WHERE requests_uid = ?");
                    $get_executals->execute(array($row['req_uid']));
                    $get_executals_fetched = $get_executals->fetchAll(PDO::FETCH_ASSOC);

                    $get_paymentals = $database[0]->prepare("SELECT * FROM payments WHERE requestid = ?");
                    $get_paymentals->execute(array($row['req_id']));
                    $get_paymentals_fetched = $get_paymentals->fetchAll(PDO::FETCH_ASSOC);

                    /*Заголовок заказа////////////////////////////////////////////////////////////////////////////////////////////////*/
                    $phpdate = strtotime( $row['req_date'] );
                    $mysqldate = date( 'd.m.y', $phpdate );
                    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

                    $result .= "<tr database = '".$database[1]."' requestid =" . $row['req_id'] . " byerid =".$row['b_id'].">
            <td class='req_date'><span>" . $mysqldate . "</span></td>
            <td class='1c_num'><span>" . $row['1c_num'] . "</span><br><span>".$database[3]."</span></td>
            <td byerid=" . $row['b_id'] . " name=" . $row['b_nameid'] . "><span>". $row['b_name'] ."</span></td>
            <td category='requests' name =".$row['req_nameid'].">";

                    $result .="<input type='button' requestid =".$row['req_id']." value=♢ class='collapse' name =".$row['req_nameid'].">";

                    //Решаем цвет рентабельности
                    if(round($row['rent'], 2) < 10){$rent_color_class = 'red_rent';}
                    if(round($row['rent'], 2) >= 10){$rent_color_class = 'yellow_rent';}
                    if(round($row['rent'], 2) >= 15){$rent_color_class = 'green_rent';}
                    if(round($row['rent'], 2) == 0){$rent_color_class = 'null_rent';}

                    if(count($get_executals_fetched) > 0){
                        //$result .="<br><input type='button' value='ТОРГ-12' class='show_executals'><div style='display: none;' class='req_executals'>";
                        foreach($get_executals_fetched as $exe){

                            /*Заголовок дата////////////////////////////////////////////////////////////////////////////////////////////////*/
                            $phpdate = strtotime( $exe['executed'] );
                            $mysqldate = date( 'd.m.y', $phpdate );
                            /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

                            $result .="<span style='color: green'>Накладная № ".$exe['execute_1c_num']." от ".$mysqldate." на сумму ".$exe['sum']."</span><br>";
                            unset($mysqldate);
                        }
                        $result .="</div>";
                    }else{
                        //Решаем цвет рентабельности
                        $rent_color_class = 'null_rent';
                        if(count($get_paymentals_fetched) > 0){
                            //Ждем реализации
                            $result .="<span style='color: red'>Ждём реализацию.</span><br>";
                        };
                    };

                    if(count($get_paymentals_fetched) > 0){
                        //$result .="<input type='button' value='₽' class='show_paymentals'><div style='display: none;' class='req_paymentals'>";
                        foreach($get_paymentals_fetched as $pay){
                            /*Заголовок дата////////////////////////////////////////////////////////////////////////////////////////////////*/
                            $phpdate = strtotime( $pay['payed'] );
                            $mysqldate = date( 'd.m.y', $phpdate );
                            /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

                            $result .="<span style='color: blue'>Платеж № ".$pay['number']." от ".$mysqldate." на сумму ".$pay['sum']."</span><br>";
                            unset($mysqldate);
                        }
                        $result .="</div>";
                    }else{
                        //Решаем цвет рентабельности
                        $rent_color_class = 'null_rent';
                        if(count($get_executals_fetched) > 0){
                            //Ждем оплаты
                            $result .="<span style='color: red'>Ждём оплату.</span><br>";
                        };
                    };

                    if(count($get_executals_fetched) > 0 && count($get_paymentals_fetched) > 0 && round($row['rent'], 2) == 0){
                        $rent_color_class = 'needs_attention';
                    };

                    /*Заголовок заказа////////////////////////////////////////////////////////////////////////////////////////////////*/
                    $phpdate = strtotime( $row['req_date'] );
                    $mysqldate = date( 'd.m.y', $phpdate );
                    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

                    $result .="<div class='contents' id=".$row['req_nameid'].">
                        <h3 class='req_header_".$row['req_id']."'>Заказ от <span class='date'>".$mysqldate."</span> на сумму <span class='reqsumma'>".number_format($row['sum'],2,'.',' ')."&nbsp</span><br> Номер в 1С: <span class='1c_num'>".$row['1c_num']."</span> <h3/><br>
                        <input type='button' class='edit_options' value='Опции' requestid='".$row['req_id']."'>";
                        //$result .="<input type='button' class='edit_1c_num' value='Номер в 1С и дата' requestid='".$row['req_id']."'>";
                    $result .="<input type='button' value='Вернуть в Р-1' class='r1_show' requestid='".$row['req_id']."'>              
                        <input type='button' class='add_pos' value='+позиция'>
                        <div class='add-pos-inputs'>
                        <input type='text' class='trade' name='new_req_name' placeholder='Название позиции' size='50'>
                        <div class='sres'></div>
                        <input type='button' name =" . $row['req_id'] . " value='Добавить' class='addpos' database = '".$database[1]."'>
                    </div>
                    
                    <div class='positions'></div>
                    <div class='rentcount'></div>            
                    </td>";

                    $result .=" <td class = '" . $rent_color_class . " rent_whole'>".round($row['rent'], 2)."</td>
                        <td class = 'sum_whole'>" .number_format(round($row['sum'], 2), 2, '.', ' '). "</td>
                        <td class = 'req_buttons'>";
                        //<td class = 'req_buttons'><input type='button' requestid =" . $row['req_id'] . " value='R' class='edit' name =".$row['req_nameid'].">
        $result .= "<input type='button' requestid =" . $row['req_id'] . " value='X' class='reqdelete' name =".$row['req_nameid']."></td></tr>";
                }
            }
        $result .= "</table>";
        print $result;
    }
    else if ($table == 'givaways') {
        try {
            /*ОПЦИИ ДАТЫ*/
            /*Смотрим, какой период сейчас выставлен по умолчанию*/
            /*$ga_period = $pdo->prepare("SELECT * FROM `options` WHERE options_id = 'general'");
            $ga_period->execute();
            $ga_period_fetched = $ga_period->fetch(PDO::FETCH_ASSOC);
            $ga_period_current = $ga_period_fetched['ga_period'];
            $ga_periods = array(
                array("year",'С начала года'),
                array("quarter",'С начала квартала'),
                array("month",'С начала месяца')
            );*/
            //ТЕКУЩУЮ ОПЦИЮ ВЫДЕЛИТЬ ЗЕЛЕНЫМ ЦВЕТОМ
            /*foreach($ga_periods as $gap){
                if($gap[0] == $ga_period_current){
                    echo "<input type='button' class='date_option green' period='".$gap[0]."' value='".$gap[1]."'>";

                }else{
                    echo "<input type='button' class='date_option' period='".$gap[0]."' value='".$gap[1]."'>";
                }
            };*/
            /*ОПЦИИ ДАТЫ*/

            //Сейчс скрипт берет всех покупателей из базы
            $statement = $pdo->prepare("SELECT byers.byers_id AS b_id,byers.byers_nameid AS b_nid,allnames.name AS b_name FROM `byers` LEFT JOIN `allnames` ON byers.byers_nameid=allnames.nameid WHERE (byers.ov_tp > 0 OR byers.ov_tp <> NULL) ORDER BY b_name");
            $gotrequests = $pdo->prepare("SELECT requests_id FROM requests WHERE (requests.byersid = ? AND requests.r1_hidden = 0)");
            $gotrequests_ip = $pdoip->prepare("SELECT requests_id FROM requests WHERE (requests.byersid = ? AND requests.r1_hidden = 0)");
            //Нужно из byersid ltk получить byersid ip
            $getbyersidip = $pdo->prepare("SELECT prices_ip.byers.byers_id as byersid_ip FROM prices.byers LEFT JOIN prices_ip.byers ON prices.byers.ip_uid = prices_ip.byers.byers_uid WHERE prices.byers.byers_id = ?");
            $statement->execute();
            $result = "<ul class='byer_req_list'>";

            foreach ($statement as $row) {
                $ga_bid = $row['b_id'];
                $getbyersidip->execute(array($ga_bid));
                $getbyersidip_fetched = $getbyersidip->fetch(PDO::FETCH_ASSOC);

                //Проверка на наличие заявок
                $gotsome = array();
                $gotsome_ip = array();
                $gotrequests->execute(array($ga_bid));
                if($getbyersidip_fetched['byersid_ip']){
                    $gotrequests_ip->execute(array($getbyersidip_fetched['byersid_ip']));
                    $gotsome_ip = $gotrequests_ip->fetchall(PDO::FETCH_ASSOC);
                }

                $gotsome = $gotrequests->fetchall(PDO::FETCH_ASSOC);
                if(count($gotsome)>0 || count($gotsome_ip)>0){

                    $result .= "<li byerid =" . $row['b_id'] . "><input type='button' name =" . $row['b_nid'] . " ga_byer =" . $row['b_id'] . " value='♢' class='collapse_ga_byer w'>
                                <span class='name'>" . $row['b_name'] . "</span>
                                <div class='ga_byer_requests' ga_byer ='" . $row['b_id'] . "' year></div>
                            </li>";
                }
            }
            $result .= "</ul>";
            print $result;


        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
        /**//////////////////////////////////////////////////////////////ЧТЕНИЕ СПИСКА ЗАЯВОК
    }
    else if(($table == 'byers')) {
        /**//////////////////////////////////////////////////////////////ЧТЕНИЕ ПОКУПАТЕЛИ
        ///Как выглядит список товаров/покупателей/поставщиков:
        ///Ну, по идее, так же как и сейчас

        $statement = $pdo->prepare("SELECT name, byers_id, nameid, ov_tp, ov_firstobp, ov_wt, comment, onec_id, ip_uid  FROM $table  LEFT JOIN `allnames` ON allnames.nameid=$table.$tablenid GROUP BY name");
        $statement_ip = $pdoip->prepare("SELECT name, byers_id, nameid, ov_tp, ov_firstobp, ov_wt, comment, onec_id/*, ip_uid*/  FROM $table  LEFT JOIN `allnames` ON allnames.nameid=$table.$tablenid GROUP BY name");

        $result = "<table><thead><tr><th>Покупатель</th><th>%</th><th>Обн</th><th>Отсрочка</th><th>Коммент</th><th>Номер в 1С</th><th>Соотнесение</th><th>Опции</th></tr></thead>";

        try {
            $pdo->beginTransaction();
            $statement->execute();
            $pdo->commit();
            foreach ($statement as $row)
            {
                $result .= "<tr database = 'ltk'><td category='" . $table . "' name =" . $row['nameid'] . ">";
                $result .= "<span class='name' byerid=" . $row['byers_id'] . " name =" . $row['nameid'] . ">" . $row['name'] . "</span></td>
                                <td class='ov_tp'><span>" . $row['ov_tp'] . "<span/></td>
                                <td class='ov_firstobp'><span>" . $row['ov_firstobp'] . "<span/></td>
                                <td class='ov_wt'><span>" . $row['ov_wt'] . "<span/></td>
                                <td class='comment'><span>" . $row['comment'] . "<span/></td>";

                if($row['onec_id']){$result .= "<td class='onec_id'><span>" . $row['onec_id'] . "<span/></td>";
                }elseif ($row['ip_uid']){$result .= "<td class='onec_id'><span style='color: grey'>Болванка<span/></td>";}else{$result .= "<td class='onec_id'><span style='color: blue'>Нет ни в одной базе, есть старые расценки.<span/></td>";}

                $result .= "<td class='synced'><span>" . $row['ip_uid'] . "<span/></td>
                <td class = 'item_buttons'>
                <input type='button' byerid =" . $row['byers_id'] . " value='E' class='edit_options_byer'>
                <input type='button' byerid =" . $row['byers_id'] . " value='X' class='delete'></td></tr>";
            }
        } catch( PDOException $Exception ) {
            $pdo->rollback();
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }

        try {
            $pdoip->beginTransaction();
            $statement_ip->execute();
            $pdoip->commit();
            foreach ($statement_ip as $row)
            {
                $result .= "<tr database = 'ip'><td category='" . $table . "' name =" . $row['nameid'] . ">";
                $result .= "<span class='name' byerid=" . $row['byers_id'] . " name =" . $row['nameid'] . ">" . $row['name'] . "</span></td>
                                <td class='ov_tp'><span>" . $row['ov_tp'] . "<span/></td>
                                <td class='ov_firstobp'><span>" . $row['ov_firstobp'] . "<span/></td>
                                <td class='ov_wt'><span>" . $row['ov_wt'] . "<span/></td>
                                <td class='comment'><span>" . $row['comment'] . "<span/></td>";
                $result .= "<td class='onec_id'><span>" . $row['onec_id'] . "<span/></td>";
                $result .= "<td class='synced'></td>";
                $result .= "<td class = 'item_buttons'>
                <input type='button' name =" . $row['nameid'] . " value='R' class='edit'>
                <input type='button' name =" . $row['nameid'] . " value='X' class='delete'></td></tr>";
            }
        } catch( PDOException $Exception ) {
            $pdoip->rollback();
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
        $result.="</table>";
        print $result;
        /**//////////////////////////////////////////////////////////////
    }
    else if ($table == 'trades'){

        $statement = $pdo->prepare("SELECT `trades_id`,`nameid`,`name`,`tare`,`onec_id`,`ip_uid` FROM `trades` LEFT JOIN `allnames` ON allnames.nameid=`trades`.`trades_nameid`");
        $statement_ip = $pdoip->prepare("SELECT `trades_id`,`nameid`,`name`,`tare`,`onec_id` FROM `trades` LEFT JOIN `allnames` ON allnames.nameid=`trades`.`trades_nameid`");

        try {
            $statement->execute();
            $result = "<table><thead><tr><th>Наименование</th><th>Тип тары</th><th>Номер в 1С</th><th>Соотнесение</th><th></th></tr></thead>";
            foreach ($statement as $row)
            {
                $result .= "<tr database='ltk'><td category='trades' name =" . $row['nameid'] . ">";
                $result .= "<span class='trade_name' tradeid=" . $row['trades_id'] . " name =" . $row['nameid'] . ">" . $row['name'] . "</span></td>
                                <td class='trade_tare' tradeid=" . $row['trades_id'] . "><span>" . $row['tare'] . "<span/></td>";

                if($row['onec_id']){$result .= "<td class='trade_onec_id'><span>" . $row['onec_id'] . "<span/></td>";
                }elseif ($row['ip_uid']){$result .= "<td class='trade_onec_id'><span style='color: grey'>Болванка<span/></td>";}else{$result .= "<td class='trade_onec_id'><span style='color: blue'>Нет ни в одной базе, есть старые расценки.<span/></td>";}

                $result .= "<td class='trade_synched'><span>" . $row['ip_uid'] . "<span/></td>
                <td class = 'item_buttons'>
                <input type='button' name =" . $row['nameid'] . " tradeid =" . $row['trades_id'] . " value='E' class='edit_options_trade'>
                <input type='button' name =" . $row['nameid'] . " value='X' class='delete'></td></tr>";
            }

        } catch(PDOExeption $e) {
            $pdo->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }

        try {
            $statement_ip->execute();
            foreach ($statement_ip as $row)
            {
                $result .= "<tr database='ip'><td category='trades' name =" . $row['nameid'] . ">";
                $result .= "<span class='trade_name' tradeid=" . $row['trades_id'] . " name =" . $row['nameid'] . ">" . $row['name'] . "</span></td>
                                <td class='trade_tare' tradeid=" . $row['trades_id'] . "><span>" . $row['tare'] . "<span/></td>";

                if($row['onec_id']){$result .= "<td class='trade_onec_id'><span>" . $row['onec_id'] . "<span/></td>";
                }elseif ($row['ip_uid']){$result .= "<td class='trade_onec_id'><span style='color: grey'>Болванка<span/></td>";}else{$result .= "<td class='trade_onec_id'><span style='color: blue'>Нет ни в одной базе, есть старые расценки.<span/></td>";}

                if(isset($row['ip_uid'])){
                    $result .= "<td class='trade_synched'><span>" . $row['ip_uid'] . "<span/></td>";
                }
                $result .= "<td class = 'item_buttons'>
                <input type='button' name =" . $row['nameid'] . " tradeid =" . $row['trades_id'] . " value='E' class='edit_options_trade'>
                <input type='button' name =" . $row['nameid'] . " value='X' class='delete'></td></tr>";
            }
            $result.="</table>";
            print $result;

        } catch(PDOExeption $e) {
            $pdoip->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    }
    else if ($table == 'sellers'){
        /**//////////////////////////////////////////////////////////////ЧТЕНИЕ ПОСТАВЩИКИ
        try {

            $statement = $pdo->prepare("SELECT *  FROM sellers  LEFT JOIN `allnames` ON allnames.nameid=sellers.sellers_nameid GROUP BY name");
            $statement_ip = $pdoip->prepare("SELECT *  FROM sellers  LEFT JOIN `allnames` ON allnames.nameid=sellers.sellers_nameid GROUP BY name");

            $statement->execute();
            $statement_ip->execute();

            $result = "<table>";
            foreach ($statement as $row)
            {
                $result .= "<tr database='ltk' sellerid=".$row['sellers_id']."><td category='".$table."' name =".$row['nameid'].">";
                $result .= "<span class='name' name =".$row['nameid'].">".$row['name']."</span></td>                
                <td class = 'item_buttons'>
         <input type='button' sellerid=".$row['sellers_id']." name =" . $row['nameid'] . " value='R' class='edit'>
         <input type='button' sellerid=".$row['sellers_id']." name =" . $row['nameid'] . " value='X' class='delete'></td></tr>";
            }
            foreach ($statement_ip as $row)
            {
                $result .= "<tr database='ltk' sellerid=".$row['sellers_id']."><td category='".$table."' name =".$row['nameid'].">";
                $result .= "<span class='name' name =".$row['nameid'].">".$row['name']."</span></td>                
                <td class = 'item_buttons'>
         <input type='button' sellerid=".$row['sellers_id']." name =" . $row['nameid'] . " value='R' class='edit'>
         <input type='button' sellerid=".$row['sellers_id']." name =" . $row['nameid'] . " value='X' class='delete'></td></tr>";
            }
            $result.="</table><!--<script src='js/mysql_edc.js'></script>-->";

            print $result;



        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
        /**//////////////////////////////////////////////////////////////
    }
    else if ($table == 'zp'){
        try{




            $result ="<!--<select class='zp_show_year'>
              <option>2020</option>
              <option>2021</option>
            </select>-->";

            $result .= "<h1>Зарплатная ведомость за 2020 год</h1>";

            $result .="<h3 class='header_count' style='cursor: pointer'>Начислить</h3>
            <div class='add_zp_count'>                
            
            <select class='zp_count_year'>
              <option>2020</option>
              <option>2021</option>
            </select>
            
            <select class='zp_count_worker' size='10'>
              <option>Марина</option>
              <option>Сергей</option>
              <option>Дмитрий</option>
              <option>Ирина</option>
              <option>Тимур</option>
              <option>Милана</option>
              <option>Литовкин</option>
              <option>Проценты Сергей</option>
              <option>Гагарина</option>
              <option>Павлова</option>
            </select>  
            
            <select class='zp_count_month' size='12'>
              <option>Январь</option>
              <option>Февраль</option>
              <option>Март</option>
              <option>Апрель</option>
              <option>Май</option>
              <option>Июнь</option>
              <option>Июль</option>
              <option>Август</option>
              <option>Сентябрь</option>
              <option>Октябрь</option>
              <option>Ноябрь</option>
              <option>Декабрь</option>
            </select>
            
            <input type='number' class='zp_count_amount' style='text-align: center' placeholder='Сумма'>
            <input type='button' value='Начислить' id='add_zp_count'>
            
            
            
            </div>";
            $result .="<h3 class='header_give' style='cursor: pointer'>Выдать</h3>
            <div class='add_zp_give'>              
            
            <select class='zp_give_worker' size='10'>
              <option worker='Марина'>Марина</option>
              <option worker='Сергей'>Сергей</option>
              <option worker='Дмитрий'>Дмитрий</option>
              <option worker='Ирина'>Ирина</option>
              <option worker='Тимур'>Тимур</option>
              <option worker='Милана'>Милана</option>
              <option worker='Литовкин'>Литовкин</option>
              <option worker='Проценты Сергей'>Проценты Сергей</option>              
              <option worker='Гагарина'>Гагарина</option>
              <option worker='Павлова'>Павлова</option>
            </select>
            
            <select class='zp_give_source' size='6'>
              <option>Юни ЗП</option>
              <option>ИП Услуги</option>
              <option>ТКС</option>
              <option>Учредитель</option>
              <option>Касса</option>              
            </select>
            
            <input class='zp_give_date' type='date'size='1' value='2020-01-01'>
            
            <!--<select class='zp_count_year'>
              <option>2020</option>
              <option>2021</option>
            </select>
            
            <select class='zp_count_month'>
              <option>Январь</option>
              <option>Февраль</option>
              <option>Март</option>
              <option>Апрель</option>
              <option>Май</option>
              <option>Июнь</option>
              <option>Июль</option>
              <option>Август</option>
              <option>Сентябрь</option>
              <option>Октябрь</option>
              <option>Ноябрь</option>
              <option>Декабрь</option>
            </select>-->
            
            <input type='number' class='zp_give_amount' style='text-align: center' placeholder='Сумма'>
            <input type='text' class='zp_give_comment' style='text-align: center' placeholder='Комментарий'>
            <input type='button' value='Выдать' id='add_zp_give'>
            
            
            
            </div><div class='where_details'></div>";

            
            
            $result .="<br><br><table>";
            $result .="
                <thead>
                      <th></th>
                      <th>Январь</th>
                      <th>Февраль</th>
                      <th>Март</th>
                      <th>Апрель</th>
                      <th>Май</th>
                      <th>Июнь</th>
                      <th>Июль</th>
                      <th>Август</th>
                      <th>Сентябрь</th>
                      <th>Октябрь</th>
                      <th>Ноябрь</th>
                      <th>Декабрь</th>
                      <th>Сумма</th>
                      <th>Выдано</th>
                      <th>Долг</th>
                </thead>";

            $workers = ['Марина', 'Сергей', 'Дмитрий', 'Тимур', 'Ирина', 'Милана', 'Литовкин', 'Проценты Сергей', 'Гагарина', 'Павлова'];
            $months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

            $zp_counts = $pdo->prepare("SELECT * FROM zp_count WHERE worker = ?");
            $zp_gives = $pdo->prepare("SELECT * FROM zp_give WHERE worker = ? ORDER BY given ASC");

            foreach ($workers as $worker)
            {
                $zp_counts->execute(array($worker));
                $zp_gives->execute(array($worker));

                $counts_fetched = $zp_counts->fetchAll(PDO::FETCH_ASSOC);
                $gives_fetched = $zp_gives->fetchAll(PDO::FETCH_ASSOC);

                $result .= "<tr worker='".$worker."'>";
                $result .= "<td>".$worker."</td>";



                $counted_sum = 0;
                foreach ($months as $month){
                    $result .= "<td style='text-align: center'>";
                    $month_sum = 0;
                    foreach($counts_fetched as $zp_count){

                        if($zp_count['month'] == $month){

                            $counted_sum = $counted_sum + $zp_count['amount'];
                            $month_sum = $month_sum + $zp_count['amount'];
                        }
                    }
                    $result .= "<span>".number_format($month_sum,'0','.',' ')."</span>";
                    $result .= "</td>";
                }

                $result .= "<td style='text-align: center' class='counted_sum'>".number_format($counted_sum,'0','.',' ')."</td>";

                $given_sum = 0;
                $gives_count = 0;
                $gives_list = "";
                foreach($gives_fetched as $zp_give){
                    $gives_count = $gives_count+1;
                    $given_sum = $given_sum + $zp_give['amount'];

                    $phpdate = strtotime( $zp_give['given'] );
                    $zp_give['given'] = date( 'd.m', $phpdate );

                    $gives_list .="<span source='".$zp_give['source']."'>".$zp_give['given']." (".$zp_give['source'].") ~ ".number_format($zp_give['amount'],'2',',',' ')." ".$zp_give['comment']."</span>";
                }

                $result .= "<td style='text-align: center' class='given_sum'>".number_format($given_sum,'2','.',' ')."<div class='give_details'><span>Выдачи ".$worker.": </span><br><div class='show_them_flex'>".$gives_list."</div></div></td>";

                $debt = $counted_sum - $given_sum;

                $result .= "<td style='text-align: center' class='debt'>".number_format($debt,'0','.',' ')."</td>";

                $result .= "</tr>";
            };

            $result .="</table>";

            print $result;

        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
    };
};
/*///////////////////////////////////////////////////*/

/*СОДЕРЖИМОЕ ЗАЯВКИ - СПИСОК ПОЗИЦИЙ///////////////////////////////////////////////////////////////////////////////////////////////////*/
if (isset($_POST['requestid'])){

    $req_id=$_POST['requestid'];

    $result="";
    try{
        $nowinners = $database->prepare("SELECT `pos_name`, `req_positionid`, `line_num`, `winnerid` FROM `req_positions` WHERE `requestid`=? ORDER BY `line_num` ASC");
        $winners = $database->prepare("SELECT `requestid`, `req_positionid`, `line_num`, `pos_name`, `name`, `rent`, `price`, `kol` FROM (SELECT * FROM ((SELECT * FROM `pricings`) AS a LEFT JOIN (SELECT `sellers_id`, `name` FROM(sellers LEFT JOIN allnames ON sellers.sellers_nameid=allnames.nameid)) AS b ON a.`sellerid` = b.`sellers_id`)) AS a LEFT JOIN req_positions ON a.`pricingid` = req_positions.winnerid WHERE `req_positionid`=?");
        $nowinners->execute(array($req_id));
        $nowinners_fetched = $nowinners->fetchAll(PDO::FETCH_ASSOC);
        $result .= "<br><table><thead><th>№</th><th>Название позиции</th><th>Цена</th><th>Сумма</th><th>Поб</th><th>Рент</th><th>Опции</th></thead><tbody>";
        foreach ($nowinners_fetched as $row)
        {
            if ($row['winnerid']!=0){//Если в позиции назначен победитель
                $winners->execute(array($row['req_positionid']));
                $winners_fetched = $winners->fetchAll(PDO::FETCH_ASSOC);
                foreach ($winners_fetched as $win)
                {
                    $price = number_format(round($win['price'],2),'2','.', ' ');
                    $pr = round($win['price'],2)*round($win['kol'],2);
                    $pr=number_format($pr,'2','.',' ');

                    $result .= "<tr position =".$win['req_positionid'].">";
                    $result .= "<td> ".$win['line_num'].".</td>";
                    $result .= "<td category='positions'>";
                    $result .= "<input type='button' request=".$req_id." position =".$win['req_positionid']." value=♢ class='collapsepos'>";
                    $result .= "<span class='name'>" . $win['pos_name'] . "</span>";
                    $result .= "<div class='pricings'>";
                    $result .= "</div>";
                    $result .= "</td>";
                    $result .= "<td class='pr'>".$price."</td>";
                    $result .= "<td class='pr'>".$pr."</td><!--Сумма-->";
                    $result .= "<td class='winname'>".$win['name']."</td>";
                    $result .= "<td class='rent'>".round($win['rent'], 2)."</td>";
                    $result .= "<td class = 'pos_buttons'>";
                    $result .= "<input type='button' position =" . $win['req_positionid'] . " value='R' class='edit'>";
                    $result .= "<input type='button' position =" . $win['req_positionid'] . " value='X' class='posdelete'>";
                    $result .= "<input type='button' req_op_id='".$req_id."' pos_op_id=". $win['req_positionid'] ." value='Опции' class='edit_options_pos'>";
                    $result .= "</td></tr>";

                };
            }else{
                $result .= "<tr position =".$row['req_positionid']."><td> ".$row['line_num'].".</td>
            <td category='positions'>
                <input type='button' position =".$row['req_positionid']." value=♢ class='collapsepos'>
                <span class='name'>" . $row['pos_name'] . "</span>
                <div class='pricings'>
                </div>
                </td>  
                <td>
                <input type='button' position =" . $row['req_positionid'] . " value='R' class='edit'>
                <input type='button' position =" . $row['req_positionid'] . " value='X' class='posdelete'>
                <input type='button' req_op_id='".$req_id."' pos_op_id=". $row['req_positionid'] ." value='...' class='edit_options_pos'>
                </td></tr>";

            };
        }
        $result.="</tbody></table>";
        $result.= "<input type='button' requestid='" . $req_id . "' class = 'check_rent' value='Рассчитать сумму и рентабельность сделки'>";



        echo $result;

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

};

/*СОДЕРЖИМОЕ ПОЗИЦИИ - СПИСОК РАСЦЕНОК/////////////////////////////////////////////////////////////////////////////////////////////*/
if (isset($_POST['positionid'])){
    $pos_id=$_POST['positionid'];

    try{
        $statement = $database->prepare("SELECT  c.pricingid AS pricingid,
                                            c.firstoh AS firstoh,
                                            c.rop AS rop,
                                            c.oh AS oh,
                                            c.tradeid AS tradeid,
                                            c.zak AS zak,
                                            c.kol AS kol,
                                            c.fixed AS fixed,
                                            c.tzr AS tzr,
                                            c.opr AS opr,
                                            c.tpr AS tpr,
                                            c.clearp AS clearp,
                                            c.price AS price,
                                            c.rent AS rent,
                                            c.winner AS winner,
                                            c.sellerid AS sellerid,
                                            c.sellers_id AS sellers_id,
                                            c.name AS seller_name,
                                            d.name AS trade_name,
                                            d.tare AS trade_tare,
                                            d.trades_id AS trades_id
                                             FROM (SELECT * FROM (SELECT `pricingid`, `firstoh`, `rop`, `oh`, `tradeid`, `sellerid`, `zak`, `kol`, `fixed`, `tzr`, `opr`, `tpr`,
        `clearp`, `price`, `rent`, `winner` FROM `pricings` WHERE `positionid`=?) AS a LEFT JOIN (SELECT `name`, `sellers_id`, `sellers_nameid` FROM `allnames` LEFT JOIN `sellers` ON `allnames`.`nameid`=`sellers`.`sellers_nameid`) AS b ON a.sellerid=b.sellers_id) as c LEFT JOIN (SELECT `name`, `tare`, `trades_id`, `trades_nameid` FROM `allnames` LEFT JOIN `trades` ON `allnames`.`nameid`=`trades`.`trades_nameid`) AS d ON c.tradeid=d.trades_id");
        $statement->execute(array($pos_id));
        if($statement->rowCount() == 0) {$result = "Здесь еще нет расценок.<input class ='addpricing' positionid='".$pos_id."' value='Расценить новое?' type ='button'><script src='js/mysql_edc.js'></script>";
        } else{
            /*ДЕЛАЕМ ТАБЛИЦУ!!!*/
            $result = "<table class='pricing-list'><thead><tr>
                    <th>Продавец</th>    
                    <th>Товар</th>                    
                    <th>Закуп</th>
                    <th>Кол-во</th>
                    <!--<th>Сумма закупа</th>-->
                    <th>Σ ТЗР</th>
                    <th>Нам</th>
                    <!--<th>Им</th>-->
                    <th>Чист%</th>                    
                    <th>Цена</th>                    
                    <th>Рент</th>
                    <th>Опции</th>
                    </tr></thead>";
            foreach ($statement as $row) {
                switch ($row['fixed']) {
                    case '0':
                        $nam = number_format($row['opr'] * $row['kol'], 0, '.', ' ');
                        $im = number_format($row['firstoh'] * $row['kol'], 0, '.', ' ');
                        break;
                    case '1':
                        $nam = number_format($row['rop'] * $row['kol'], 0, '.', ' ');
                        $im = number_format($row['oh'] * $row['kol'], 0, '.', ' ');
                        break;
                };

                if($row['winner'] == 1){
                    $result .= "<tr class=\"win\" pricingid =". $row['pricingid'] .">";
                }else{
                    $result .= "<tr pricingid =". $row['pricingid'] .">";
                };
                $result .="<td class=pr-seller-name>" . $row['seller_name'] . "</td>
                <td class='pr-trade-name' tare='" . $row['trade_tare'] . "'>" . $row['trade_name'] . "</td>                
                <td>" . number_format($row['zak'], 2, '.', ' ') . "</td>
                <td>" . $row['kol'] . "</td>
                <!--УБРАНО Сумма закупа для экономии места 14.06.17<td>--><!--</td>-->
                <td>" . number_format($row['tzr']*$row['kol'], 0, '.', ' ') . "</td>
                <td>" . $nam . "</td>
                <!--УБРАНО ИМ для экономии места 22.06.17<td></td>-->
                <td>" . round($row['clearp'], 2) . "</td>
                <td>" . round($row['price'], 2) . "</td>
                <td class='pr-rent'>" . number_format($row['rent'], 2, '.', ' ') . "</td>
                <td>
                <div class='del-ren-pricing'>
                <input type='button' pricing =" . $row['pricingid'] . " value='E' class='editpricing'>
                <input type='button' pricing =" . $row['pricingid'] . " value='X' class='delpricing'>";
                if($row['winner'] == 1){
                    $result.="<input type='button' pricing =" . $row['pricingid'] . " value='П' class='winner'>";
                }else{$result.="<input type='button' pricing =" . $row['pricingid'] . " value='*' class='winner'>";}

                $result.="</div></td></tr>";
            }
            $result.="<!--<script src='js/mysql_edc.js'></script>--></tbody></table><input class ='addpricing' positionid='".$pos_id."' value='Расценить новое?' type ='button'>";
        };

        echo $result;

    } catch( PDOException $Exception ) {print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}

};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*ЧТЕНИЕ РАСЦЕНКИ*//////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['pricingid'])){
    $pricing_id=$_POST['pricingid'];
    try{
        $database->beginTransaction();
        $statement = $database->prepare("SELECT * FROM `pricings` as a  LEFT JOIN (SELECT created, req_positionid, 1c_num as num FROM req_positions LEFT JOIN requests ON req_positions.requestid = requests.requests_id) AS b on a.positionid=b.req_positionid WHERE `pricingid`=?");
        $statement->execute(array($pricing_id));
        $result = $statement->fetch();

        $phpdate = strtotime( $result['created'] );
        $result['created'] = date( 'd.m.y', $phpdate );

        echo json_encode($result);/*Перевели массив расценки в формат JSON*/
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//ЧТЕНИЕ ДАТЫ ЗАЯВКИ
if ( isset($_POST['chng_number']) ){
    try{
        $id_number = $_POST['chng_number'];

        $statement=$pdo->prepare("SELECT created FROM requests WHERE requests_id = ?");

        $pdo->beginTransaction();
        $statement->execute(array($id_number));
        $pdo->commit();

        $result = $statement->fetch();

        $phpdate = strtotime( $result['created'] );
        $result = date( 'd.m.y', $phpdate );

        print $result;

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

//ЧТЕНИЕ 1С Номера ЗАЯВКИ
if ( isset($_POST['chng_number_1c']) ){
    try{
        $id_number = $_POST['chng_number_1c'];

        $statement=$pdo->prepare("SELECT 1c_num FROM requests WHERE requests_id = ?");

        $pdo->beginTransaction();
        $statement->execute(array($id_number));
        $pdo->commit();

        $result = $statement->fetch();
        $new1c_num = $result['1c_num'];

        print $new1c_num;

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

//Чтение ОПЦИЙ ЗАЯВКИ ПО ОДНОЙ
if ( isset($_POST['c_c']) &&  isset($_POST['reqid'])){
    try{
        $reqid = ($_POST["reqid"]);
        $c_c = ($_POST["c_c"]);

        switch($c_c)
        {
            case 1:
                $column = 'ov_op';
                break;
            case 2:
                $column = 'ov_tp';
                break;
            case 3:
                $column = 'ov_firstobp';
                break;
            case 4:
                $column = 'ov_wt';
                break;
        }

        $statement=$pdo->prepare("SELECT $column FROM `requests` WHERE requests_id = ?");

        $pdo->beginTransaction();
        $statement->execute(array($reqid));
        $pdo->commit();

        $result = $statement->fetch();

        print $result[$column];

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

//Чтение ОПЦИЙ ПОЗИЦИИ ПО ОДНОЙ
if ( isset($_POST['pos_c_c']) &&  isset($_POST['posid'])){
    try{
        $posid = ($_POST["posid"]);
        $c_c = ($_POST["pos_c_c"]);

        switch($c_c)
        {
            case 1:
                $column = 'ov_op';
                break;
            case 2:
                $column = 'ov_tp';
                break;
            case 3:
                $column = 'ov_firstobp';
                break;
            case 4:
                $column = 'ov_wt';
                break;
        }

        $statement=$database->prepare("SELECT $column FROM `req_positions` WHERE req_positionid = ?");

        $database->beginTransaction();
        $statement->execute(array($posid));
        $database->commit();

        $result = $statement->fetch();

        print $result[$column];

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

//ЧТЕНИЕ ПЛАТЕЖКИ
if(isset($_POST['pay_reqid']) && isset($_POST['pay_id'])){
    $paymentid = $_POST['pay_id'];
    $requestid = $_POST['pay_reqid'];
    try{
        $database->beginTransaction();
        $statement = $database->prepare("SELECT * FROM `payments` WHERE payments_id=? AND requestid=?");
        $statement->execute(array($paymentid,$requestid));
        $database->commit();
        $result = $statement->fetch();
        echo json_encode($result);/*Перевели массив расценки в формат JSON*/
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}
/**/

//ЧТЕНИЕ ВЫДАЧИ
if(isset($_POST['byersid']) && isset($_POST['give_id'])){
    $giveawayid = $_POST['give_id'];
    $byersid = $_POST['byersid'];

    try{
        $database->beginTransaction();
        $statement = $database->prepare("SELECT * FROM `giveaways` WHERE giveaways_id=? AND byersid=?");
        $statement->execute(array($giveawayid,$byersid));
        $database->commit();
        $result = $statement->fetch();
        echo json_encode($result);/*Перевели массив расценки в формат JSON*/
    } catch( PDOException $Exception ) {
        $database->rollback();
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

}
/**/

//ИНФА ПОКУПАТЕЛЯ В ОКНЕ РАСЦЕНКИ
if(isset($_POST['byerid_info'])){
    $byer = $_POST['byerid_info'];
    $get_byer_info = $database->prepare("SELECT ov_firstobp,ov_tp,ov_wt,comment,name FROM byers LEFT JOIN allnames a on byers.byers_nameid = a.nameid WHERE byers_id = ?");
    $get_byer_info->execute(array($byer));
    $gbi_f = $get_byer_info->fetch(PDO::FETCH_ASSOC);

echo"<div>
<span>".$gbi_f['name']."</span><br>
<span>отсрочка</span> - <span>".$gbi_f['ov_wt']."</span><br>
<span>енот</span> - <span>".$gbi_f['ov_tp']."</span><br>
<span>обнал</span> - <span>".$gbi_f['ov_firstobp']."</span><br>
<span>".$gbi_f['comment']."</span><br>
<input type='button' value='Заполнить' id='byer_info_fill' wt='".$gbi_f['ov_wt']."' tp='".$gbi_f['ov_tp']."' firstobp='".$gbi_f['ov_firstobp']."'>
</div>";
}

if(isset($_POST['winner_trade'])){
    $posid = $_POST['winner_trade'];
    try{
        $database->beginTransaction();
        $stmt = $database->prepare("SELECT name,trades_id,tare FROM req_positions LEFT JOIN pricings ON winnerid=pricingid LEFT JOIN trades ON tradeid=trades_id LEFT JOIN allnames ON trades.trades_nameid = allnames.nameid WHERE req_positionid=?");
        $stmt->execute(array($posid));
        $database->commit();
        $stmt_fetched = $stmt->fetch(PDO::FETCH_ASSOC);
        print(json_encode(array('data1'=>$stmt_fetched['trades_id'],'data2'=>$stmt_fetched['name'],'data3'=>$stmt_fetched['tare'])));
    }catch( PDOException $Exception ) {
        $database->rollback();
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

}

//ИНФА список накладных в расценке
if(isset($_POST['executes_list'])){
    $reqid= $_POST['executes_list'];
    $get_exe_list = $database->prepare("SELECT executed,execute_1c_num,sum FROM executes LEFT JOIN requests ON executes.requests_uid=requests.requests_uid WHERE requests_id = ?");

    try{
        $get_exe_list->execute(array($reqid));
        $get_exe_list_fetched = $get_exe_list->fetchAll(PDO::FETCH_ASSOC);
        echo "<ul>";
        foreach($get_exe_list_fetched as $exe){

            /*Заголовок заказа////////////////////////////////////////////////////////////////////////////////////////////////*/
            $phpdate = strtotime( $exe['executed'] );
            $mysqldate = date( 'd.m.y', $phpdate );
            /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

            echo "<li>".$exe['execute_1c_num']." от ".$mysqldate." - ".$exe['sum']."</li>";
            unset($mysqldate);
        }
        echo "</ul>";

    }catch( PDOException $Exception ) {
    $database->rollback();
    // Note The Typecast To An Integer!
    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
}
}

//Возврат byers_id по 1c_num из 1С при добавлении заказа из модуля 1C
if(isset($_POST['1c_module_num'])){
    $onecnum= $_POST['1c_module_num'];
    $get_byers_id = $database->prepare("SELECT byers_id FROM byers WHERE onec_id = ?");

    try{
        $database->beginTransaction();
        $get_byers_id->execute(array($onecnum));
        $get_byers_id_fetched = $get_byers_id->fetch(PDO::FETCH_ASSOC);

        if(isset($get_byers_id_fetched["byers_id"])){
            echo $get_byers_id_fetched["byers_id"];
        }else{
            echo "NONE";
        }

    }catch( PDOException $Exception ) {
        $database->rollback();
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}

//Возврат trades_id по 1c_num из 1С при добавлении заказа из модуля 1C
if(isset($_POST['1c_trades_module_num'])){
    $onecnum= $_POST['1c_trades_module_num'];
    $get_trades_id = $database->prepare("SELECT trades_id FROM trades WHERE onec_id = ?");

    try{
        $database->beginTransaction();
        $get_trades_id->execute(array($onecnum));
        $get_trades_id_fetched = $get_trades_id->fetch(PDO::FETCH_ASSOC);

        echo $get_trades_id_fetched["trades_id"];

    }catch( PDOException $Exception ) {
        $database->rollback();
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}

//Возврат trade_id по 1c_num из 1С при добавлении расценки заказа из модуля 1C
if(isset($_POST['1c_module_num_trades'])){
    $onecnum= $_POST['1c_module_num_trades'];
    $get_trades_id = $database->prepare("SELECT trades_id FROM trades WHERE onec_id = ?");

    try{
        $database->beginTransaction();
        $get_trades_id->execute(array($onecnum));
        $get_trades_id_fetched = $get_trades_id->fetch(PDO::FETCH_ASSOC);

        echo $get_trades_id_fetched["trades_id"];

    }catch( PDOException $Exception ) {
        $database->rollback();
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}

//Возврат requestid по requests_uid из 1С при добавлении заказа из модуля 1c
if(isset($_POST['1c_module_request_uid'])){
    $uid= $_POST['1c_module_request_uid'];
    $get_requestid = $database->prepare("SELECT requests_id FROM prices.requests WHERE requests_uid = ?");

    try{
        $database->beginTransaction();
        $get_requestid->execute(array($uid));
        $get_requestid_fetched = $get_requestid->fetch(PDO::FETCH_ASSOC);

        if(isset($get_requestid_fetched["requests_id"])){
            echo $get_requestid_fetched["requests_id"];
        }else{
            echo "NONE";
        }
        //echo gettype();

    }catch( PDOException $Exception ) {
        $database->rollback();
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}

//Возврат requests_uid и dataver по requests_uid из 1С при добавлении заказа из модуля 1c
if(isset($_POST['requests_list_uid']) && isset($_POST['requests_list_dataver'])){
    $uid= $_POST['requests_list_uid'];
    $dataver= $_POST['requests_list_dataver'];
    $check_request = $database->prepare("SELECT requests_uid, dataver FROM prices.requests WHERE requests_uid = ?");
    try{
        $database->beginTransaction();
        $check_request->execute(array($uid));
        $check_request_fetched = $check_request->fetchAll(PDO::FETCH_ASSOC);
        if(isset($check_request_fetched[0]["requests_uid"]))
        {
            if($dataver == $check_request_fetched[0]["dataver"])
            {
                print 2;   //Просто открываем
            }else
                {
                    print 3;   //Обновляем
                }
        }else
            {
                print 1;       //Добавляем
            }
    }catch( PDOException $Exception ) {
        $database->rollback();
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}
