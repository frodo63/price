<?php
include_once 'pdo_connect.php';

if (isset($_POST['post_byersid']) && isset($_POST['post_tradeid'])){
    $post_byer = $_POST['post_byersid'];
    $post_trade = $_POST['post_tradeid'];

    $statement=$pdo->prepare("SELECT created,name,requests_id,req_positionid,pricingid,tradeid,sellerid,zak,price,rent FROM 
(SELECT byersid,requests_id,req_positionid,created FROM `requests` LEFT JOIN `req_positions` ON requests.requests_id=req_positions.requestid WHERE byersid=?) 
AS a LEFT JOIN (SELECT * FROM (SELECT * FROM `pricings` LEFT JOIN sellers ON pricings.sellerid=sellers.sellers_id) AS s LEFT JOIN allnames ON s.sellers_nameid=allnames.nameid) as pr ON a.req_positionid=pr.positionid WHERE pr.winner=1 AND pricings.tradeid=?");

    $pdo->beginTransaction();
    $statement->execute(array($post_byer,$post_trade));
    $pdo->commit();

    $result = "<table class='hystory-list' tradeid='".$row['tradeid']."'><thead><tr>
                    <th>Когда</th>    
                    <th>У кого</th>                    
                    <th>Закуп</th>
                    <th>Цена</th>
                    <th>Рент</th>
                    </tr></thead><tbody>";
    foreach ($statement as $row) {
        $result .= "<tr post_reqid='".$row['requests_id']." post_posid='".$row['req_positionid']."' post_prid='".$row['pricingid']."'>";
        $result .="<td>" . $row['created'] . "</td>
                <td >" . $row['name'] . "</td>                
                <td>" . $row['zak'] . "</td>
                <td>" . $row['price'] . "</td>
                <td>" . $row['rent'] . "</td>";
        $result.="</div></td></tr>";
        };

        $result.="</tbody></table>";

        print $result;
};