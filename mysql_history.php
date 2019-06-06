<?php
include_once 'pdo_connect.php';
//Показываем базе покупателя и товар, чтобы посмотреть старые цены
if (isset($_POST['post_byersid']) && isset($_POST['post_tradeid'])){
    $post_byer = $_POST['post_byersid'];
    $post_trade = $_POST['post_tradeid'];
    $n = 1;

    $statement=$pdo->prepare("SELECT created,name,requests_id,req_positionid,pricingid,tradeid,sellerid,zak,price,rent FROM 
(SELECT byersid,requests_id,req_positionid,created FROM `requests` LEFT JOIN `req_positions` ON requests.requests_id=req_positions.requestid WHERE byersid=?) 
AS a LEFT JOIN (SELECT * FROM (SELECT * FROM `pricings` LEFT JOIN sellers ON pricings.sellerid=sellers.sellers_id) AS s LEFT JOIN allnames ON s.sellers_nameid=allnames.nameid) as pr ON a.req_positionid=pr.positionid WHERE pr.winner=1 AND pr.tradeid=? ORDER BY created DESC LIMIT 10");
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
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
};

//Показываем базе поставщика и тару, чтобы посмотреть, почем возили к себе
if (isset($_POST['post_seller']) && isset($_POST['post_tare'])){
    $post_seller = $_POST['post_seller'];
    $post_tare = $_POST['post_tare'];

    try{
        $get_name=$pdo->prepare("SELECT name FROM sellers LEFT JOIN allnames ON sellers_nameid = nameid WHERE sellers_id = ?");
        $statement=$pdo->prepare("SELECT created,trade_name,kol,tzr,tzrknam FROM (SELECT sellerid,tradeid,pricingid,trade_name,a.tare,kol,tzr,tzrknam FROM `pricings` LEFT JOIN (SELECT trades_id,name AS trade_name,tare FROM trades LEFT JOIN allnames ON trades.trades_nameid = allnames.nameid) AS a ON pricings.tradeid = a.trades_id) AS b LEFT JOIN (SELECT created,requests_id,byersid,winnerid FROM requests LEFT JOIN req_positions ON requests_id = requestid) AS c ON b.pricingid = c.winnerid WHERE (sellerid=?) AND (tare=?) ORDER BY created DESC LIMIT 10");

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
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }

}

//Показываем базе покупателя и тару, чтобы посмотреть, почем возили к покупателю
if (isset($_POST['post_byer']) && isset($_POST['post_tare'])){
    $post_byer = $_POST['post_byer'];
    $post_tare = $_POST['post_tare'];

    try{
        $get_name=$pdo->prepare("SELECT name FROM byers LEFT JOIN allnames ON byers_nameid = nameid WHERE byers_id = ?");
        $statement=$pdo->prepare("SELECT created,trade_name,kol,tzr,tzrkpok FROM (SELECT sellerid,tradeid,pricingid,trade_name,a.tare,kol,tzr,tzrkpok FROM `pricings` LEFT JOIN (SELECT trades_id,name AS trade_name,tare FROM trades LEFT JOIN allnames ON trades.trades_nameid = allnames.nameid) AS a ON pricings.tradeid = a.trades_id) AS b LEFT JOIN (SELECT created,requests_id,byersid,winnerid FROM requests LEFT JOIN req_positions ON requests_id = requestid) AS c ON b.pricingid = c.winnerid WHERE (byersid=?) AND (tare=?) ORDER BY created DESC LIMIT 10");

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
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
}

//Показываем базе товар, чтобы посмотреть, от кого и почем возили
if (isset($_POST['post_trade_hist'])){
    $tradeid = $_POST['post_trade_hist'];

    try{
        $get_uid=$pdo->prepare("SELECT trades_uid FROM trades WHERE trades_id = ?");
        $get_purchases = $pdo->prepare("SELECT * FROM purchases WHERE trade_uid = ? ORDER BY incdoc_date DESC LIMIT 10");

        $getname_trade = $pdo->prepare("SELECT name FROM trades LEFT JOIN allnames ON trades.trades_nameid = allnames.nameid WHERE trades_id = ?");

        $getname_seller = $pdo->prepare("SELECT name FROM sellers LEFT JOIN allnames ON sellers.sellers_nameid = allnames.nameid WHERE sellers_uid = ?");

        $pdo->beginTransaction();
        $get_uid->execute(array($tradeid));
        $get_uid_fetched = $get_uid->fetch(PDO::FETCH_ASSOC);

        $get_purchases->execute(array($get_uid_fetched['trades_uid']));
        $get_purchases_fetched = $get_purchases->fetchAll(PDO::FETCH_ASSOC);

        $getname_trade->execute(array($tradeid));
        $getname_trade_fetched = $getname_trade->fetch(PDO::FETCH_ASSOC);
        $trade = $getname_trade_fetched['name'];

        $result = "<input class='button_enlarge' type='button' value='↕'><br><span>Покупали \"".$trade."\"</span><br><table class='hystory-seller'><thead><tr> 
                    <th>когда</th>                   
                    <th>от кого</th>
                    <th>сколько</th>
                    <th>почем</th>
                    </tr></thead><tbody>";

        foreach ($get_purchases_fetched as $pur){

            $getname_seller->execute(array($pur['seller_uid']));
            $getname_seller_fetched = $getname_seller->fetch(PDO::FETCH_ASSOC);
            $seller = $getname_seller_fetched['name'];

            $phpdate = strtotime( $pur['incdoc_date'] );
            $mysqldate = date( 'd.m.Y', $phpdate );

            $result .="<tr>";
            $result .="<td>".$mysqldate."</td>";
            $result .="<td>".$seller."</td>";
            $result .="<td>".$pur['kol']."</td>";
            $result .="<td>".number_format($pur['price'],2,'.',' ')."</td>";
            $result .="</tr>";

        }

        $pdo->commit();

        $result .="</tbody></table>";

        print $result;

    }catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }

}

//Показываем базе поставщика, чтобы посмотреть, что от него вообще возили
if (isset($_POST['post_seller_hist'])){
    $sellerid = $_POST['post_seller_hist'];

    /*
     * 1.Получаем uid
     * 2.Получаем данные из таблицы purchases
     * */

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
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }

}