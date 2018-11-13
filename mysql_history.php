<?php
include_once 'pdo_connect.php';
//Показываем базе покупателя и товар, чтобы посмотреть старые цены
if (isset($_POST['post_byersid']) && isset($_POST['post_tradeid'])){
    $post_byer = $_POST['post_byersid'];
    $post_trade = $_POST['post_tradeid'];
    $n = 1;

    $statement=$pdo->prepare("SELECT created,name,requests_id,req_positionid,pricingid,tradeid,sellerid,zak,price,rent FROM 
(SELECT byersid,requests_id,req_positionid,created FROM `requests` LEFT JOIN `req_positions` ON requests.requests_id=req_positions.requestid WHERE byersid=?) 
AS a LEFT JOIN (SELECT * FROM (SELECT * FROM `pricings` LEFT JOIN sellers ON pricings.sellerid=sellers.sellers_id) AS s LEFT JOIN allnames ON s.sellers_nameid=allnames.nameid) as pr ON a.req_positionid=pr.positionid WHERE pr.winner=1 AND pr.tradeid=?");
    $byerinfo=$pdo->prepare("SELECT * FROM byers WHERE byers_id=?");

    try{
    $pdo->beginTransaction();
    $statement->execute(array($post_byer,$post_trade));
    $byerinfo->execute(array($post_byer));
    $b_info = $byerinfo->fetch();
    $pdo->commit();

    $result = "<span>Обнал:&nbsp".$b_info['ov_firstobp']."&nbspЕнот:&nbsp".$b_info['ov_tp']."&nbspОтсрочка:&nbsp".$b_info['ov_wt']."&nbspКоммент:&nbsp".$b_info['comment']."</span>";
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
        $result .="<td>".$n."</td><td>" . $row['created'] . "</td>
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
        $statement=$pdo->prepare("SELECT created,trade_name,kol,tzr,tzrknam FROM (SELECT sellerid,tradeid,pricingid,trade_name,a.tare,kol,tzr,tzrknam FROM `pricings` LEFT JOIN (SELECT trades_id,name AS trade_name,tare FROM trades LEFT JOIN allnames ON trades.trades_nameid = allnames.nameid) AS a ON pricings.tradeid = a.trades_id) AS b LEFT JOIN (SELECT created,requests_id,byersid,winnerid FROM requests LEFT JOIN req_positions ON requests_id = requestid) AS c ON b.pricingid = c.winnerid WHERE (sellerid=?) AND (tare=?)");

        $pdo->beginTransaction();
        $statement->execute(array($post_seller,$post_tare));
        $pdo->commit();

        $result .= "<table class='hystory-knam'><thead><tr> 
                    <th>когда</th>                   
                    <th>что</th>
                    <th>кол-во</th>
                    <th>кнам(всего)</th>
                    </tr></thead><tbody>";
        foreach ($statement as $row) {
            $result .= "<tr>
                <td>" . $row['created'] . "</td>
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
        $statement=$pdo->prepare("SELECT created,trade_name,kol,tzr,tzrkpok FROM (SELECT sellerid,tradeid,pricingid,trade_name,a.tare,kol,tzr,tzrkpok FROM `pricings` LEFT JOIN (SELECT trades_id,name AS trade_name,tare FROM trades LEFT JOIN allnames ON trades.trades_nameid = allnames.nameid) AS a ON pricings.tradeid = a.trades_id) AS b LEFT JOIN (SELECT created,requests_id,byersid,winnerid FROM requests LEFT JOIN req_positions ON requests_id = requestid) AS c ON b.pricingid = c.winnerid WHERE (byersid=?) AND (tare=?)");

        $pdo->beginTransaction();
        $statement->execute(array($post_byer,$post_tare));
        $pdo->commit();

        $result .= "<table class='hystory-knam'><thead><tr> 
                    <th>когда</th>                   
                    <th>что</th>
                    <th>кол-во</th>
                    <th>кпок(всего)</th>
                    </tr></thead><tbody>";
        foreach ($statement as $row) {
            $result .= "<tr>
                <td>" . $row['created'] . "</td>
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