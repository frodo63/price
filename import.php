<?php
include_once 'pdo_connect.php';

if(file_exists('import csv.csv')){
    $file_aray = file('import csv.csv');
    $payments_list = array();
    foreach($file_aray as $payments){
        $payments_details_tmp =  explode(';',$payments);
        $payments_details = array();
        $payments_details["payed"] = $payments_details_tmp[0];
        $payments_details["number"] = $payments_details_tmp[1];
        $payments_details["paysum"] = $payments_details_tmp[2];
        $payments_details["name"] = $payments_details_tmp[3];
        $payments_details["created"] = $payments_details_tmp[4];
        $payments_details["1c_num"] = $payments_details_tmp[5];
        $payments_details["reqsum"] = $payments_details_tmp[6];
        $payments_list[]=$payments_details;
    }

    echo"<table><thead>
        <th>Дата платежа</th>
        <th>Номер</th>
        <th>Сумма</th>
        <th>Плательщик</th>
        <th>Дата заказа</th>
        <th>Номер в 1С</th>
        <th>Сумма заказа</th>
        </thead><tbody>
        ";
    foreach($payments_list as $row){
        echo "<tr>
            <td>".$row['payed']."</td>
            <td>".$row['number']."</td>
            <td>".$row['paysum']."</td>
            <td>".$row['name']."</td>
            <td>".$row['created']."</td>
            <td>".$row['1c_num']."</td>
            <td>".$row['reqsum']."</td>
        </tr>";

    };
    echo"</body></table>";
}