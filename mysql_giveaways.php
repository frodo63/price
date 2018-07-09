<?php
include_once 'pdo_connect.php';

if (isset($_POST['the_byer'])){
    try {
        $the_byer = $_POST['the_byer'];
        $statement = $pdo->prepare("SELECT created,requests_id,1c_num,name,req_sum FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid WHERE requests.byersid = ?");
        $pdo->beginTransaction();
        $statement->execute(array($the_byer));
        $pdo->commit();

        $result="<table><thead><tr><th>Дата</th><th>Номер заявки</th><th>Номер заказа в 1С</th><th>Название</th><th>Сумма заявки</th></tr></thead><tbody>";

        foreach ($statement as $row){
            $result.="<tr>";
            $result.="<td>".$row['created']."</td>";
            $result.="<td>".$row['requests_id']."</td>";
            $result.="<td>".$row['1c_num']."</td>";
            $result.="<td><input class='collapse_ga_request' ga_request='". $row['requests_id'] ."' type='button' value='W'><span>".$row['name']."</span>
<div class='ga_contents' ga_request='". $row['requests_id'] ."'><div class='ga_c_payments'></div><div class='ga_c_positions'></div><div class='ga_c_giveaways'></div></div></td>";
            $result.="<td>".$row['req_sum']."</td>";
        };

        $result.="</tr></tbody></table>";
        print $result;

    }catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    };

};

if (isset($_POST['the_request'])){
    try {
        $the_request = $_POST['the_request'];
        $onhands;

        $get_payments = $pdo->prepare("SELECT payed,payments_id,number,amount,requestid FROM `payments` WHERE requestid=?");
        $get_positions = $pdo->prepare("SELECT name, kol, oh, firstoh FROM (SELECT * FROM (SELECT trades_id,name FROM trades LEFT JOIN allnames ON trades_nameid=nameid) AS a LEFT JOIN pricings ON a.trades_id=tradeid) AS b left join req_positions on b.pricingid=req_positions.winnerid WHERE req_positions.requestid=?");
        $get_giveaways = $pdo->prepare("SELECT given_away,comment,giveaway_sum FROM `giveaways` WHERE requestid=?");

        $pdo->beginTransaction();
        $get_payments->execute(array($the_request));
        $get_positions->execute(array($the_request));
        $get_giveaways->execute(array($the_request));
        $pdo->commit();

        $result1="<table><thead><tr><th>Дата</th><th>Номер п/п</th><th>Сумма платежки</th></tr></thead><tbody>";
        foreach ($get_payments as $row){
            $result1 .="<tr><td>".$row['payed']."</td><td>".$row['number']."</td><td>".$row['amount']."</td></tr>";
        };
        $result1 .="</tbody></table>";

        $result2="<table><thead><tr><th>Товар</th><th>Кол-во</th><th>Начислено, на шт</th><th>Сумма к выдаче</th></tr></thead><tbody>";
        foreach ($get_positions as $row){

            if((int)$row['oh'] == 0){
                $onhands = (int)$row['firstoh'];
            }else{
                $onhands = (int)$row['oh'];
            };

            $result2 .="<tr><td>".$row['name']."</td><td>".$row['kol']."</td><td>".$onhands."</td><td>".(int)$row['kol']*(int)$onhands."</td></tr>";
        };
        $result2 .="</tbody></table>";

        $result3="<table><thead><tr><th>Дата</th><th>Комментарий</th><th>Сумма</th></tr></thead><tbody>";
        foreach ($get_giveaways as $row){
            $result3 .="<tr><td>".$row['given_away']."</td><td>".$row['comment']."</td><td>".$row['giveaway_sum']."</td></tr>";
        };
        $result3 .="</tbody></table>";

        print(json_encode(array('data1'=>$result1,'data2'=>$result2,'data3'=>$result3)));

    }catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    };

};