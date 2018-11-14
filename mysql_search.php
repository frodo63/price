<?php
include_once 'pdo_connect.php';
/*Описание большого поискового окна*/
if (isset($_POST['sline'])){
    $sline = $_POST['sline'];

    $statement = $pdo->prepare("
SELECT name, nameid, byers_id, sellers_id, trades_id, requests_id, created, byersid, byers_name FROM `allnames`
  LEFT JOIN `byers` ON nameid=byers_nameid
  LEFT JOIN `sellers` ON nameid=sellers_nameid
  LEFT JOIN `trades` ON nameid=trades_nameid
  LEFT JOIN (SELECT requests_id,created,byersid,name as byers_name,requests_nameid FROM `requests` LEFT JOIN byers ON byersid=byers_id LEFT OUTER JOIN allnames ON byers_nameid=allnames.nameid) AS a ON nameid=a.requests_nameid
WHERE name LIKE concat('%', ?, '%') GROUP BY byers_name,name");
    $statement->execute(array($sline));
    $result ='<ul>';
    $byers='';
    $sellers='';
    $trades='';
    $requests='';
    foreach ($statement as $row){

        if($row['byers_id']){
            $byers .= "<li tabindex=0 category='byer' theid=".$row['byers_id']." nameid=" . $row['nameid'] . "><span>" . $row['name'] . "</span><div class='note'>клиент</div></li>";
        };
        if($row['sellers_id']){
            $sellers .= "<li tabindex=0 category='seller' theid=".$row['sellers_id']." nameid=" . $row['nameid'] . "><span>" . $row['name'] . "</span><div class='note'>поставщик</div></li>";
        };
        if($row['trades_id']){
            $trades .= "<li tabindex=0 category='trade' theid=".$row['trades_id']." nameid=" . $row['nameid'] . "><span>" . $row['name'] . "</span><div class='note'>товар</div></li>";
        };
        if($row['requests_id']){

            $phpdate = strtotime( $row['created'] );
            $mysqldate = date( 'd.m.y', $phpdate );

            $requests .= "<li tabindex=0 category='request' theid=".$row['requests_id']." nameid=" . $row['nameid'] . "><span>$mysqldate ---- " . $row['byers_name'] . " ---- " . $row['name'] . "</span><div class='note'>заявка</div></li>";
        };
    };


    $result .= $byers.$sellers.$trades.$requests;
    $result .= "</ul><!--<script src='js/mysql_searching.js'>-->";

    print $result;

};

//ПОИСК ПОКУПАТЕЛЯ///////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['sbyer'])){
    $sline = $_POST['sbyer'];

    $statement = $pdo->prepare("
        SELECT name, nameid, byers_id FROM `allnames`
        INNER JOIN `byers` ON nameid=byers_nameid  
        WHERE name LIKE '%{$sline}%' GROUP BY nameid");

    $statement->execute();
    $result ='<ul>';
    $byers='';
    foreach ($statement as $row){
        $byers .= "<li category='byer' byers_id=".$row['byers_id']." nameid=" . $row['nameid'] . "><p>" . $row['name'] . "</p><div class='note'>клиент</div></li>";
    };
    $result .= $byers;
    $result .= "</ul><!--<script src='js/mysql_searching.js'>-->";

    print $result;
};

//ПОИСК ТОВАРА///////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['strade'])){
    $sline = $_POST['strade'];

    $statement = $pdo->prepare("
        SELECT name, nameid, trades_id,tare FROM `allnames`
        INNER JOIN `trades` ON nameid=trades_nameid  
        WHERE name LIKE '%{$sline}%' GROUP BY nameid");

    $statement->execute();
    $result ='<ul>';
    $trades='';
    foreach ($statement as $row){
        $trades .= "<li category='trade' trades_id=".$row['trades_id']." nameid=" . $row['nameid'] . " tare=" . $row['tare'] . "><p>" . $row['name'] . "</p><div class='note'>товар</div></li>";
    };
    $result .= $trades;
    $result .= "</ul><!--<script src='js/mysql_searching.js'>-->";

    print $result;
};

//ПОИСК ПОСТАВЩИКА///////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['sseller'])){
    $sline = $_POST['sseller'];

    $statement = $pdo->prepare("
        SELECT name, nameid, sellers_id FROM `allnames`
        INNER JOIN `sellers` ON nameid=sellers_nameid  
        WHERE name LIKE '%{$sline}%' GROUP BY nameid");

    $statement->execute();
    $result ='<ul>';
    $sellers='';
    foreach ($statement as $row){
        $sellers .= "<li category='seller' sellers_id=".$row['sellers_id']." nameid=" . $row['nameid'] . "><p>" . $row['name'] . "</p><div class='note'>поставщик</div></li>";
    };
    $result .= $sellers;
    $result .= "</ul><!--<script src='js/mysql_searching.js'>-->";

    print $result;
};

//ПОИСК номера в 1С
//ПОИСК номера в 1С///////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['1c_num'])){
    $sline = $_POST['1c_num'];

    $statement = $pdo->prepare("
        SELECT * FROM `allnames` 
        LEFT JOIN 
        (
            SELECT requests_id,created,byersid,name as byers_name,requests_nameid,`1c_num` FROM `requests` 
            LEFT JOIN 
                byers ON byersid=byers_id 
                LEFT JOIN 
                allnames ON byers_nameid=allnames.nameid
        ) 
        AS a ON nameid=a.requests_nameid WHERE `1c_num`=?");
        

    $statement->execute(array($sline));
    $result ='<ul>';
    $sellers='';
    foreach ($statement as $row){

        $phpdate = strtotime( $row['created'] );
        $mysqldate = date( 'd.m.y', $phpdate );

        $sellers .= "<li category='request' byersid=".$row['byersid']." requests_id=".$row['requests_id']." nameid=" . $row['nameid'] . "><p>$mysqldate " . $row['byers_name'] . " ---- " . $row['name'] . " ---- номер в 1C ".$row['1c_num']."</p><div class='note'>заявка</div></li>";
    };
    $result .= $sellers;
    $result .= "</ul><!--<script src='js/mysql_searching.js'>-->";

    print $result;
};