<?php
include_once 'pdo_connect.php';

if (isset($_POST['the_byer'])){
    try {
        $the_byer = $_POST['the_byer'];
        $vidlist = $pdo->prepare("SELECT a.byers_id as b_id,
                                                   a.name as b_name,
                                                   b.requests_id as req_id,
                                                   b.1c_num as 1c_num,
                                                   b.req_sum as req_sum,
                                                   b.reqname as reqname,
                                                   b.given_away as vid_date,
                                                   b.giveaways_id as vid_id,
                                                   b.comment as vid_comment,
                                                   b.giveaway_sum as vid_sum FROM (SELECT byers_id,name FROM `byers` LEFT JOIN `allnames` ON byers_nameid=nameid) AS a LEFT JOIN (SELECT requests_id,1c_num,req_sum,given_away,giveaways_id,comment,giveaway_sum,byersid,name as reqname FROM (SELECT * FROM `requests` LEFT JOIN `allnames` ON requests_nameid=nameid) AS c LEFT JOIN `giveaways` ON c.requests_id=requestid) AS b ON a.byers_id = b.byersid WHERE a.byers_id = ? AND b.giveaways_id IS NOT NULL ORDER BY b.giveaways_id");

        $pdo->beginTransaction();
        $vidlist->execute(array($the_byer));
        $pdo->commit();

        $result.="<table><thead><tr>
<th>Номер заказа в 1С</th>
<th>Сумма заказа</th>
<th>Дата выдачи</th>
<th>Комментарий</th>
<th>Сумма выдачи</th></tr></thead><tbody>";

        foreach ($vidlist as $row){
            $result.="<tr vid_num='". $row['requests_id'] ."'>";
            $result.="<td>".$row['1c_num']."</td>";
            $result.="<td>".$row['req_sum']."</td>";
            $result.="<td>".$row['vid_date']."</td>";
            $result.="<td>".$row['vid_comment']."</td>";
            $result.="<td>".$row['vid_sum']."</td>";
            $result.="</tr>";
        };

        $result.="</tr></tbody></table>";
        print $result;

    }catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }

};