<?php
include_once 'pdo_connect.php';
//Показываем базе покупателя и товар, чтобы посмотреть старые цены из обеих баз
if (isset($_POST['post_byersid']) && isset($_POST['post_tradeid'])){
    $post_byer = $_POST['post_byersid'];
    $post_trade = $_POST['post_tradeid'];
    $n = 1;

    $statement=$pdo->prepare("SELECT created,name,requests_id,req_positionid,pricingid,tradeid,sellerid,zak,price,rent FROM 
(SELECT byersid,requests_id,req_positionid,created FROM `requests` LEFT JOIN `req_positions` ON requests.requests_id=req_positions.requestid WHERE byersid=?) 
AS a LEFT JOIN (SELECT * FROM (SELECT * FROM `pricings` LEFT JOIN sellers ON pricings.sellerid=sellers.sellers_id) AS s LEFT JOIN allnames ON s.sellers_nameid=allnames.nameid) as pr ON a.req_positionid=pr.positionid WHERE pr.winner=1 AND pr.tradeid=? ORDER BY created DESC");
    $byerinfo=$pdo->prepare("SELECT * FROM byers WHERE byers_id=?");

    try{
        $pdo->beginTransaction();
        $statement->execute(array($post_byer,$post_trade));
        $byerinfo->execute(array($post_byer));
        $b_info = $byerinfo->fetch();
        $pdo->commit();

        $result = "<br><input class='button_enlarge' type='button' value='↕'><br><span>Обнал:&nbsp".$b_info['ov_firstobp']."&nbspЕнот:&nbsp".$b_info['ov_tp']."&nbspОтсрочка:&nbsp".$b_info['ov_wt']."&nbspКоммент:&nbsp".$b_info['comment']."</span><br><br>";
        $result .= "<table class='hystory-list'><thead><tr>
                    <th>№</th>    
                    <th>Когда</th>    
                    <th>У кого</th>                    
                    <th>Закуп</th>
                    <th>Цена</th>
                    <th>Рент</th>
                    </tr></thead><tbody>";
        foreach ($statement as $row) {
            $result .= "<tr post_reqid='".$row['requests_id']." post_posid='".$row['req_positionid']."' post_prid='".$row['pricingid']."'>";

            $phpdate = strtotime( $row['created'] );
            $mysqldate = date( 'd.m.y', $phpdate );

            $result .="<td>".$n."</td><td>" . $mysqldate . "</td>
                <td >" . $row['name'] . "</td>                
                <td>" . $row['zak'] . "</td>
                <td>" . $row['price'] . "</td>
                <td>" . $row['rent'] . "</td>";
            $result.="</div></td></tr>";
            ++$n;
        };

        $result.="</tbody></table>";

        print $result;

    }catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};

//Показываем базе поставщика и тару, чтобы посмотреть, почем возили к себе из обеих баз
if (isset($_POST['post_seller']) && isset($_POST['post_tare'])){
    $post_seller = $_POST['post_seller'];
    $post_tare = $_POST['post_tare'];

    try{
        $get_name=$pdo->prepare("SELECT name FROM sellers LEFT JOIN allnames ON sellers_nameid = nameid WHERE sellers_id = ?");
        $statement=$pdo->prepare("SELECT created,trade_name,kol,tzr,tzrknam FROM (SELECT sellerid,tradeid,pricingid,trade_name,a.tare,kol,tzr,tzrknam FROM `pricings` LEFT JOIN (SELECT trades_id,name AS trade_name,tare FROM trades LEFT JOIN allnames ON trades.trades_nameid = allnames.nameid) AS a ON pricings.tradeid = a.trades_id) AS b LEFT JOIN (SELECT created,requests_id,byersid,winnerid FROM requests LEFT JOIN req_positions ON requests_id = requestid) AS c ON b.pricingid = c.winnerid WHERE (sellerid=?) AND (tare=?) ORDER BY created DESC");

        $pdo->beginTransaction();
        $get_name->execute(array($post_seller));
        $statement->execute(array($post_seller,$post_tare));
        $pdo->commit();

        $aaa=$get_name->fetch();

        $result .= "<br><input class='button_enlarge' type='button' value='↕'><br><span>Возили от поставщика \"".$aaa['name']."\", тара типа :\"".$post_tare."\"</span><br><br><table class='hystory-knam'><thead><tr> 
                    <th>когда</th>                   
                    <th>что</th>
                    <th>кол-во</th>
                    <th>кнам(всего)</th>
                    </tr></thead><tbody>";
        foreach ($statement as $row) {

            $phpdate = strtotime( $row['created'] );
            $mysqldate = date( 'd.m.y', $phpdate );

            $result .= "<tr>
                <td>" . $mysqldate . "</td>
                <td >" . $row['trade_name'] . "</td>                
                <td>" . $row['kol'] . "</td>
                <td>" . $row['tzrknam'] . "(".$row['tzr'].")</td></tr>";
        };
        $result.="</tbody></table>";
        print $result;

    }catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

}

//Показываем базе покупателя и тару, чтобы посмотреть, почем возили к покупателю из обеих баз
if (isset($_POST['post_byer']) && isset($_POST['post_tare'])){
    $post_byer = $_POST['post_byer'];
    $post_tare = $_POST['post_tare'];

    try{
        $get_name=$pdo->prepare("SELECT name FROM byers LEFT JOIN allnames ON byers_nameid = nameid WHERE byers_id = ?");
        $statement=$pdo->prepare("SELECT created,trade_name,kol,tzr,tzrkpok FROM (SELECT sellerid,tradeid,pricingid,trade_name,a.tare,kol,tzr,tzrkpok FROM `pricings` LEFT JOIN (SELECT trades_id,name AS trade_name,tare FROM trades LEFT JOIN allnames ON trades.trades_nameid = allnames.nameid) AS a ON pricings.tradeid = a.trades_id) AS b LEFT JOIN (SELECT created,requests_id,byersid,winnerid FROM requests LEFT JOIN req_positions ON requests_id = requestid) AS c ON b.pricingid = c.winnerid WHERE (byersid=?) AND (tare=?) ORDER BY created DESC");

        $pdo->beginTransaction();
        $get_name->execute(array($post_byer));
        $statement->execute(array($post_byer,$post_tare));
        $pdo->commit();

        $aaa=$get_name->fetch();

        $result .= "<br><input class='button_enlarge' type='button' value='↕'><br><span>Возили к покупателю \"".$aaa['name']."\", тара типа :\"".$post_tare."\"</span><br><br><table class='hystory-knam'><thead><tr> 
                    <th>когда</th>                   
                    <th>что</th>
                    <th>кол-во</th>
                    <th>кпок(всего)</th>
                    </tr></thead><tbody>";
        foreach ($statement as $row) {

            $phpdate = strtotime( $row['created'] );
            $mysqldate = date( 'd.m.y', $phpdate );

            $result .= "<tr>
                <td>" . $mysqldate . "</td>
                <td >" . $row['trade_name'] . "</td>                
                <td>" . $row['kol'] . "</td>
                <td>" . $row['tzrkpok'] . "(".$row['tzr'].")</td></tr>";
        };
        $result.="</tbody></table>";
        print $result;

    }catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}

//Показываем базе товар, чтобы посмотреть, у кого и почем покупали из обеих баз
if (isset($_POST['post_trade_hist']) && isset($_POST['trade_posid_hist'])){
    $tradeid = $_POST['post_trade_hist'];
    $posid = $_POST['trade_posid_hist'];
    $resulting_purs = array();


        //1. Дополняем массив dbs_array() четвертым значение для каждой базы  - это юайдишник итема
        switch($_POST['db']){
            case 'ltk':
                try{
                    $get_uids = $pdo->prepare("SELECT a.trades_uid as ltk_uid, b.trades_uid as ip_uid FROM prices.trades as a LEFT JOIN prices_ip.trades as b ON a.ip_uid=b.trades_uid WHERE a.trades_id=?");
                    $pdo->beginTransaction();
                    $get_uids->execute(array($tradeid));
                    $pdo->commit();
                    $get_uids_fetched = $get_uids->fetch(PDO::FETCH_ASSOC);
                    $dbs_array[0][4] = $get_uids_fetched['ltk_uid'];
                    $dbs_array[1][4] = $get_uids_fetched['ip_uid'];

                    //print ($dbs_array[0][4]);
                    //print ("<br>");
                    //print ($dbs_array[1][4]);

                }catch( PDOException $Exception ) {$pdo->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}

                break;

            case 'ip':
                try{
                    $get_uids = $pdoip->prepare("SELECT a.trades_uid as ltk_uid, b.trades_uid as ip_uid FROM prices_ip.trades as b LEFT JOIN prices.trades as a ON b.trades_uid=a.ip_uid WHERE b.trades_id=?");
                    $pdoip->beginTransaction();
                    $get_uids->execute(array($tradeid));
                    $pdoip->commit();
                    $get_uids_fetched = $get_uids->fetch(PDO::FETCH_ASSOC);
                    $dbs_array[0][4] = $get_uids_fetched['ltk_uid'];
                    $dbs_array[1][4] = $get_uids_fetched['ip_uid'];

                    //print ($dbs_array[0][4]);
                    //print ("<br>");
                    //print ($dbs_array[1][4]);

                }catch( PDOException $Exception ) {$pdoip->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}
                break;
        }

        // 2. Получаем данные с баз
        foreach ($dbs_array as $database){

            $getname_trade = $database[0]->prepare("SELECT name FROM trades LEFT JOIN allnames ON trades.trades_nameid = allnames.nameid WHERE trades_uid = ?");//Имя товара
            $get_purchases = $database[0]->prepare("SELECT * FROM purchases WHERE trade_uid = ? ORDER BY incdoc_date DESC");//Показываем 10 последних закупок с этим товаром
            $getname_seller = $database[0]->prepare("SELECT name FROM sellers LEFT JOIN allnames ON sellers.sellers_nameid = allnames.nameid WHERE sellers_uid = ?");//Из закупки берем uid поставщика и получаем его имя
            $get_position_data = $database[0]->prepare("SELECT purchased, purchase_id FROM req_positions WHERE req_positionid = ?");//Получаем данные по привязанным закупкам у текущей позиции

            $database[0]->beginTransaction();

            $get_purchases->execute(array($database[4]));
            $get_purchases_fetched = $get_purchases->fetchAll(PDO::FETCH_ASSOC);

            $getname_trade->execute(array($database[4]));
            $getname_trade_fetched = $getname_trade->fetch(PDO::FETCH_ASSOC);
            $trade_name = $getname_trade_fetched['name'];

            $get_position_data->execute(array($posid));
            $get_position_data_fetched = $get_position_data->fetch(PDO::FETCH_ASSOC);



            foreach ($get_purchases_fetched as $pur) {
                $getname_seller->execute(array($pur['seller_uid']));
                $getname_seller_fetched = $getname_seller->fetch(PDO::FETCH_ASSOC);
                $seller_name = $getname_seller_fetched['name'];

                $phpdate = strtotime($pur['incdoc_date']);
                $mysqldate = date('d.m.Y', $phpdate);

                if($get_position_data_fetched['purchase_id'] == $pur['purchases_id']){
                    $respur ="<tr class='pointed'>";
                }else{
                    $respur ="<tr>";
                }
                $respur .="<td>".$mysqldate."</td>";
                $respur .="<td>".$pur['incdoc_num']."</td>";
                $respur .="<td>".$seller_name."</td>";
                $respur .="<td>".$pur['kol']."</td>";
                $respur .="<td>".number_format($pur['price'],2,'.',' ')."</td>";
                $respur .="<td>".$database[3]."</td>";
                $respur .="<td><input type='button' value='+' class='attach_pur' date='".$pur['incdoc_date']."' pur_id='".$pur['purchases_id']."'database = '".$database[1]."'></td>";
                $respur .="</tr>";
                $resulting_purs[$pur['incdoc_date']] = $respur;
            }
            $database[0]->commit();
        }

        krsort($resulting_purs);

    // 3. Рисуем красоту
    $result = "<input class='button_enlarge' type='button' value='↕'><br><span>Покупали \"".$trade_name."\"</span><br><table class='hystory-seller'><thead><tr> 
                    <th>когда</th>                   
                    <th>ВхДок</th>
                    <th>от кого</th>
                    <th>сколько</th>
                    <th>почем</th>
                    <th>в базе</th>
                    <th>закрепить</th>
                    </tr></thead><tbody>";

    foreach($resulting_purs as $k=>$purchase){
        $result .= $purchase;
    }

    //for($i=0;$i<=10;++$i){
    //    $result .= $resulting_purs[$i];
    //}

    $result .="</tbody></table>";

    print $result;

}

//Показываем базе поставщика, чтобы посмотреть, что от него вообще возили из обеих баз
if (isset($_POST['post_seller_hist'])){
    $sellerid = $_POST['post_seller_hist'];

    /*
     * 1.Получаем uid
     * 2.Получаем имена
     * 3.Получаем данные из таблицы purchases
     * */

    /*
     * 1. Дополняем массив dbs_array() четвертым значением для каждой базы  - это юайдишник поставщика
     * */
    switch($_POST['db']){
        case 'ltk':
            try{
                $get_uids = $pdo->prepare("SELECT a.sellers_uid as ltk_uid, b.sellers_uid as ip_uid FROM prices.sellers as a LEFT JOIN prices_ip.sellers as b ON a.ip_uid=b.sellers_uid WHERE a.sellers_id=?");
                $pdo->beginTransaction();
                $get_uids->execute(array($sellerid));
                $pdo->commit();
                $get_uids_fetched = $get_uids->fetch(PDO::FETCH_ASSOC);
                $dbs_array[0][4] = $get_uids_fetched['ltk_uid'];
                $dbs_array[1][4] = $get_uids_fetched['ip_uid'];

                //print ($dbs_array[0][4]);
                //print ("<br>");
                //print ($dbs_array[1][4]);

            }catch( PDOException $Exception ) {$pdo->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}

            break;

        case 'ip':
            try{
                $get_uids = $pdoip->prepare("SELECT a.trades_uid as ltk_uid, b.trades_uid as ip_uid FROM prices_ip.trades as b LEFT JOIN prices.trades as a ON b.trades_uid=a.ip_uid WHERE b.trades_id=?");
                $pdoip->beginTransaction();
                $get_uids->execute(array($sellerid));
                $pdoip->commit();
                $get_uids_fetched = $get_uids->fetch(PDO::FETCH_ASSOC);
                $dbs_array[0][4] = $get_uids_fetched['ltk_uid'];
                $dbs_array[1][4] = $get_uids_fetched['ip_uid'];

                //print ($dbs_array[0][4]);
                //print ("<br>");
                //print ($dbs_array[1][4]);

            }catch( PDOException $Exception ) {$pdoip->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}
            break;
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    try{
        $get_uid=$pdo->prepare("SELECT sellers_uid FROM sellers WHERE sellers_id = ?");
        $get_purchases = $pdo->prepare("SELECT * FROM purchases WHERE seller_uid = ? ORDER BY incdoc_date DESC");

        $getname_trade = $pdo->prepare("SELECT name FROM trades LEFT JOIN allnames ON trades.trades_nameid = allnames.nameid WHERE trades_uid = ?");
        $getname_seller = $pdo->prepare("SELECT name FROM sellers LEFT JOIN allnames ON sellers.sellers_nameid = allnames.nameid WHERE sellers_id = ?");

        $getname_seller->execute(array($sellerid));
        $getname_seller_fetched = $getname_seller->fetch(PDO::FETCH_ASSOC);
        $seller = $getname_seller_fetched['name'];

        $pdo->beginTransaction();
        $get_uid->execute(array($sellerid));
        $get_uid_fetched = $get_uid->fetch(PDO::FETCH_ASSOC);

        $get_purchases->execute(array($get_uid_fetched['sellers_uid']));
        $get_purchases_fetched = $get_purchases->fetchAll(PDO::FETCH_ASSOC);

        $result = "<input class='button_enlarge' type='button' value='↕'><br><span>Покупали у \"".$seller."\"</span><br><table class='hystory-seller'><thead><tr> 
                    <th>когда</th>                   
                    <th>что</th>
                    <th>сколько</th>
                    <th>почем</th>
                    </tr></thead><tbody>";

        foreach ($get_purchases_fetched as $pur){
            $getname_trade->execute(array($pur['trade_uid']));
            $getname_trade_fetched = $getname_trade->fetch(PDO::FETCH_ASSOC);
            $trade = $getname_trade_fetched['name'];

            $phpdate = strtotime( $pur['incdoc_date'] );
            $mysqldate = date( 'd.m.Y', $phpdate );

            $result .="<tr>";
            $result .="<td>".$mysqldate."</td>";
            $result .="<td>".$trade."</td>";
            $result .="<td>".$pur['kol']."</td>";
            $result .="<td>".number_format($pur['price'],2,'.',' ')."</td>";
            $result .="</tr>";
        }

        $pdo->commit();

        $result.="</tbody></table>";
        print $result;

    }catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

}

//ИСТОРИЯ ТРАНСПОРТНЫХ
if (isset($_POST['transports_history'])){
    $posid = $_POST['transports_history'];

    try{
        $get_purchased=$pdo->prepare("SELECT purchased FROM req_positions WHERE req_positionid = ?");
        $get_transports_history = $pdo->prepare("SELECT seller_uid, incdoc_date, sum FROM transports WHERE incdoc_date BETWEEN ? AND ? ORDER BY incdoc_date ASC");
        $get_seller_name = $pdo->prepare("SELECT name FROM sellers LEFT JOIN allnames ON sellers.sellers_nameid = allnames.nameid WHERE sellers_uid = ?");

        $pdo->beginTransaction();
        $get_purchased->execute(array($posid));
        $get_purchased_fetched = $get_purchased->fetch(PDO::FETCH_ASSOC);

        if ($get_purchased_fetched['purchased']){

            $from = $get_purchased_fetched['purchased'];
            $to = date( 'Y-m-d', strtotime($from." + 1 week") );

            $get_transports_history->execute(array($from, $to));

            $get_transports_history_fetched = $get_transports_history->fetchAll(PDO::FETCH_ASSOC);

            $pdo->commit();

            $phpdate = strtotime( $from );
            $mysqlfrom = date( 'd.m.y', $phpdate );

            $phpdate = strtotime( $to );
            $mysqlto = date( 'd.m.y', $phpdate );

            $result = "<input class='button_enlarge' type='button' value='↕'><br><span>Заказы транспортных компаний : c " . $mysqlfrom . " до " . $mysqlto . "</span><br><table class='hystory-transports'><thead><tr> 
                    <th>когда</th>                   
                    <th>кем</th>
                    <th>почем</th>
                    </tr></thead><tbody>";

            foreach ($get_transports_history_fetched as $tran){
                $result .= "<tr>";

                $phpdate = strtotime( $tran['incdoc_date'] );
                $mysqldate = date( 'd.m.y', $phpdate );

                $seller_uid = $tran['seller_uid'];
                $get_seller_name->execute(array($seller_uid));
                $gotname = $get_seller_name->fetch(PDO::FETCH_ASSOC);

                $result .="<td>".$mysqldate."</td>";
                $result .="<td>".$gotname['name']."</td>";
                $result .="<td>".$tran['sum']."</td>";

                $result .= "</tr>";

            }

            $result.="</tbody></table>";

        }else{
            $result = "Прикрепите поступление к данной позиции.";
        }


        print $result;

    }catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}

/**/