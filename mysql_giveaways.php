<?php
include_once 'pdo_connect.php';

//Функция сравнения времени
function date_sort($a, $b) {
    return $a - $b;
}

/*СПИСОК ЗАЯВОК В РАМКАХ ОДНОГО ПОКУПАТЕЛЯ///////////////////////////////////////////////////////*/
if (isset($_POST['the_byer']) && isset($_POST['year'])){

    try {
        $the_year = $_POST['year'];
        $from = $the_year."-01-01";
        $to = $the_year."-12-31";

        //Приводим к читаемому виду
        $to_norm = substr($to,8,2).'-'.substr($to,5,2).'-'.substr($to,0,4);
        $from_norm = substr($from,8,2).'-'.substr($from,5,2).'-'.substr($from,0,4);
        //Определилилсь с $from и $to

        $the_byer = $_POST['the_byer'];
        //Нужно из $the_byer получить $the_byer_ip и положить оба значения в [4] массива $dbs_array
        $getbyersidip = $pdo->prepare("SELECT prices_ip.byers.byers_id as byersid_ip FROM prices.byers LEFT JOIN prices_ip.byers ON prices.byers.ip_uid = prices_ip.byers.byers_uid WHERE prices.byers.byers_id = ?");
        $getbyersidip->execute(array($the_byer));
        $getbyersidip_fetched = $getbyersidip->fetch(PDO::FETCH_ASSOC);
        $dbs_array[0][4] = $the_byer;
        $dbs_array[1][4] = $getbyersidip_fetched['byersid_ip'];

        echo "<input byer ='".$the_byer."'  class='count_rent_whole_byer' type='button' value='Пересчитать рентабельность во всех заявках'><br>";
        echo "<input byer ='".$the_byer."' class='refresh_r1_byer single' type='button' value='ПЕРЕСЧИТАТЬ'>";
        echo "<br><br><input class='refresh_r1_byer' ga_byer ='".$the_byer."'  type='button' value='2018'><input class='refresh_r1_byer' ga_byer ='".$the_byer."'  type='button' value='2019'><br><br>";
        echo "<br><span class='ga_requests_period'><b>Заявки за ".$the_year." год:</b></span><br><br>";
        echo "<table><thead><tr><th>Дата</th><th>Номер заказа в 1С</th><th></th><th>База</th><th>Накладная</th><th>Сумма заявки</th><th>Начислено</th><th>Статус заявки</th></tr></thead><tbody>";

    }catch( PDOException $e ) {$pdo->rollback();print "Error!: " . $e->getMessage() . "<br/>" . (int)$e->getCode( );}

    /*ПЕРЕМЕННЫЕ ИТОГОВЫЕ*/
    /*НА КАЖДОГО ПОКУПАТЕЛЯ У НАС 3 ПЕРЕМЕННЫЕ*/
    $total_sum=0;//Сумма заказа строку приводим к числу
    $total_count = 0;//Начислено
    $total_pay = 0;//Оплачено

    foreach ($dbs_array as $database){
        try {
            //17.07.19//////////////////////////////////////////////////////////////////////////////////////////////////
            //Главное в Р-1 это платежки,  последние платежки в каждой из заявок. Если Заявка 2018 года, в ней была платежки в 2018 году,
            //но последняя платежка в ней - 2019 года - то заявка расчитывается в 2019 году.

            //Нужно получить список последних платежек.
            //Получить список заявок, в которм есть платежки, прошедшие в этом году
            $reqlist=$database[0]->prepare("
SELECT DISTINCT 1c_num, payed, created, requests_id, req_sum,r.requests_uid requests_uid,executes_id
FROM requests r
                          INNER JOIN payments p ON r.requests_id = p.requestid
                          LEFT JOIN executes e ON r.requests_uid = e.requests_uid
WHERE (r.byersid=?)
  AND (payed BETWEEN ? AND ?)
  AND (r.r1_hidden = 0)
  AND r.requests_uid IS NOT NULL
  AND executes_id IS NOT NULL
GROUP BY requests_id ORDER BY created ASC");
            //Получить последние



            //17.07.19//////////////////////////////////////////////////////////////////////////////////////////////////

            /*$reqlist = $database[0]->prepare("SELECT DISTINCT 1c_num, payed, created, requests_id, req_sum,requests.requests_uid as requests_uid,executes_id
FROM requests
  LEFT JOIN executes ON requests.requests_uid = executes.requests_uid
  LEFT JOIN payments ON payments.requestid = requests.requests_id
WHERE (requests.byersid = ?)
      AND (payments.payments_id IN(SELECT payments_id FROM (SELECT MAX(payed),payments_id FROM payments WHERE payed BETWEEN ? AND ? GROUP BY requestid)) )
            AND (requests.r1_hidden = 0)
            AND requests.requests_uid IS NOT NULL
            AND executes_id IS NOT NULL
GROUP BY 1c_num");*/

            //Запросы строго по каждой заявке
            //Накладные - для визуального отображения
            $req_executals = $database[0]->prepare("SELECT * FROM executes WHERE requests_uid = ?");
            //Платежки - для статуса заказа
            $req_payments = $database[0]->prepare("SELECT requests_id,payments_id,number,payed,sum,req_sum FROM requests LEFT JOIN payments ON requests.requests_id=payments.requestid WHERE requests_id = ? ORDER BY payed");
            //Начисления - для таблички
            $req_countings = $database[0]->prepare("SELECT requestid,req_positionid,winnerid,oh,firstoh,kol FROM req_positions LEFT JOIN pricings on winnerid=pricings.pricingid WHERE requestid=?");

            $database[0]->beginTransaction();
            $reqlist->execute(array($database[4],$from,$to));
            $requests_fetched = $reqlist->fetchAll(PDO::FETCH_ASSOC);
            $database[0]->commit();

            $result="";



            foreach ($requests_fetched as $row){
                /*Выполняем запросы*/
                $database[0]->beginTransaction();

                $req_executals->execute(array($row['requests_uid']));
                $req_executals_fetched = $req_executals->fetchAll(PDO::FETCH_ASSOC);
                $req_countings->execute(array($row['requests_id']));
                $req_countings_fetched = $req_countings->fetchAll(PDO::FETCH_ASSOC);
                $req_payments->execute(array($row['requests_id']));
                $req_payments_fetched = $req_payments->fetchAll(PDO::FETCH_ASSOC);

                $database[0]->commit();

                $result .="<tr database='".$database[1]."' ga_request='".$row['requests_id']."'>";
                /*Делаем дату читаемой*/
                $phpdate = strtotime( $row['created'] );
                $mysqldate = date( 'd.m.y', $phpdate );
                $result.="<td>".$mysqldate."</td>";
                $result.="<td>".$row['1c_num']."</td>";
                $result.="<td><input class='collapse_ga_request' ga_request='".$row['requests_id']."' type='button' value='♢' byerid = '".$database[4]."' database='".$database[1]."'><div class='ga_contents' ga_request='". $row['requests_id'] ."'><div class='ga_options'></div><div class='ga_c_payments'></div><div class='ga_c_positions'></div></div></td>";
                $result.="<td>".$database[3]."</td>";
                $result.="<td>";
                //Вывести номер и дату накладной реализации
                if(count($req_executals_fetched) > 0){
                    foreach($req_executals_fetched as $exe){

                        /*Заголовок дата////////////////////////////////////////////////////////////////////////////////////////////////*/
                        $phpdate = strtotime( $exe['executed'] );
                        $mysqldate = date( 'd.m.y', $phpdate );
                        /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

                        $result .="<span style='color: green'>".$exe['execute_1c_num']." - ".$exe['sum']." от ".$mysqldate."</span><br>";
                        unset($mysqldate);
                    }
                };
                $result.="</td>";
                /*ПЕРЕМЕННЫЕ НА СТАТУС ЗАКАЗА*/
                /*НА КАЖДЫЙ ЗАКАЗ У НА 3 ПЕРЕМЕННЫЕ*/
                $req_sum=round($row['req_sum'],2);//Сумма заказа строку приводим к числу
                $req_pay = 0;//Оплачено
                $req_count = 0;//Начислено

                /*Расчет общего количества оплат*/
                foreach ($req_payments_fetched as $rp){$req_pay+=round($rp['sum'],2);}
                $total_pay += $req_pay;

                /*Подготовка переходных переменных*/
                $req_pay_ostatok = round($req_sum, 2) - round($req_pay, 2);//Остаток к оплате

                //Расчет общего количества начислений
                foreach ($req_countings_fetched as $rc){
                    if (round($rc['oh'],2) == 0) {
                        $onhands = round($rc['firstoh'],2);
                    } else {
                        $onhands = round($rc['oh'],2);
                    };
                    $req_count+=round($onhands,2) * round($rc['kol'],2);
                }
                unset($rc);

                //Выводим сумму заявки
                $result.="<td class='sum_req_r1'>".round($row['req_sum'],2)."</td>";
                $total_sum += round($row['req_sum'],2);


                //Начисления к выдаче берутся только если по заказ полностью оплачен
                if ($req_pay_ostatok <= 0){
                    //Выводим сумму начислений по заявке и зачисляем начисление в общую суму начислений
                    $result.="<td class='count_req_r1 green_letters'>".round($req_count,2)."</td>";
                    $total_count += round($req_count,2);
                }else{
                    //Выводим сумму начислений по заявке и НЕ зачисляем начисление в общую суму начислений
                    $result.="<td class='count_req_r1 red_letters'>".round($req_count,2)."</td>";
                }

                /*УСЛОВИЯ ПО СТАТУСУ ЗАКАЗА*/
                if ($req_pay_ostatok == 0 && round($req_sum,2) !=0 && round($req_pay,2) !=0 && round($req_count,2) == 0){
                    $result .="<td>
                               <div class='green'>
                                   <span>Оплата 100% Начислений не было</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'>
                                       
                               </div>
                           </td>";
                }elseif($req_pay_ostatok == 0 && round($req_sum,2) !=0 && round($req_pay,2) !=0 && round($req_count,2) > 0){
                    $result .="<td>
                               <div class='lightgreen'>
                                   <span>Оплата 100% Начислено: ".round($req_count,2)."</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'>                                       
                               </div>
                           </td>";
                }elseif (round($req_sum,2) == 0){
                    $result .="<td>
                               <div class='red'>
                                   <span>Назначьте победителя</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'>                                       
                               </div>
                           </td>";
                }elseif (round($req_sum,2) > 0 && round($req_pay,2) == 0){
                    $result .="<td>
                               <div class='lightblue'>
                                   <span>Оплат не поступало</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'>
                               </div>
                           </td>";
                }elseif(round($req_sum,2) > 0 && $req_pay_ostatok > 0){
                    $result .="<td>
                               <div class='yellow'>
                                   <span>Оплата < 100% К оплате :".$req_pay_ostatok."</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'>                                       
                               </div>
                           </td>";
                }elseif(round($req_sum,2) > 0 && $req_pay_ostatok < 0){
                    $result .="<td>
                               <div class='pink'>
                                   <span>Оплата > 100% Переплата :".$req_pay_ostatok.". К выдаче: ".round($req_count,2)."</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'>                                       
                               </div>
                           </td>";
                }

                unset($req_countings_fetched);
                unset($req_payments_fetched);
            }
            print $result;
            unset ($result);
            echo "</tr>";


        }catch( PDOException $Exception ) {$database[0]->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}
    }
    echo "</tbody></table>";
    echo "<br>";

    $total_give = 0;//Отдано


    echo "<br><br><span><b>Выдачи за ".$the_year." год:</b></span><br><br>";
    echo "<table class='ga_give_list'><thead><th>Дата выдачи</th><th>Год привязки</th><th>Сумма выдачи</th><th>Комментарий</th><th>Опции</th></thead><tbody>";

    foreach ($dbs_array as $database){
        //Запросы общие
        //Выбираем все выдачи указанному покупателю, попадающие по дате и году выдачи
        $year_giveaways = $database[0]->prepare("SELECT given_away,giveaways_id,giveaway_sum,comment,year_given FROM giveaways WHERE (byersid = ?) AND (year_given = ?) ORDER BY given_away");

        try {
            /*Расчет общего количества выдач*/

            $database[0]->beginTransaction();

            echo "<input type='button' database = '".$database[1]."' byersid='".$database[4]."' value='+Выдача в базу ".$database[3]."' class='add_giveaway'>";

            $year_giveaways->execute(array($database[4],$the_year));
            $year_giveaways_fetched = $year_giveaways->fetchAll(PDO::FETCH_ASSOC);
            $database[0]->commit();

            $req_give = 0;//Отдано в текущей базе (ЛТК или ИП)
            foreach ($year_giveaways_fetched as $rg){
                $req_give+=round($rg['giveaway_sum'],2);
            }
            $total_give += $req_give;//Отдано всего (в обеих базах)

            //Рисуем список выдач
            if(count($year_giveaways_fetched)>0){echo "<tr><td>из базы ".$database[3]."</td><td></td><td></td><td></td><td></td></tr>";}

            foreach ($year_giveaways_fetched as $give){
                echo "<tr giveaways_id='".$give['giveaways_id']."'>";
                $phpdate = strtotime( $give['given_away'] );
                $mysqldate = date( 'd.m.y', $phpdate );

                echo "<td>".$mysqldate."</td>";
                echo "<td>".$give['year_given']."</td>";
                echo "<td>".$give['giveaway_sum']."</td>";
                echo "<td>".$give['comment']."</td>";
                echo "<td><input type='button' value='E' byersid='".$database[4]."' database='".$database[1]."' class='editgiveaway' g_id='".$give['giveaways_id']."'>
            <input class='delgiveaway' database='".$database[1]."' type='button' value='X' give_id='".$give['giveaways_id']."'></td>";
                echo "</tr>";
            }
        }catch( PDOException $e ) {$database[0]->rollback();print "Error!: " . $e->getMessage() . "<br/>" . (int)$e->getCode( );}
    }
    echo "</tbody></table>";

    //Выводим СУММУ ДОЛГА и СУММУ ВЫДАННОГО
    //ВСЕГО НАЧИСЛЕНО:
    echo "<br><br><br><br>";
    echo "<h2>СУММА ВСЕХ ЗАКАЗОВ: ".number_format($total_sum, 2, ',', ' ')."</h2>";
    echo "<h2>ОПЛАЧЕНО: ".number_format($total_pay, 2, ',', ' ')."</h2>";
    echo "<br>";
    echo "<h2>НУЖНО ВЫДАТЬ: ".number_format($total_count, 2, ',', ' ')."</h2>";
    echo "<h2>ВЫДАНО: ".number_format($total_give, 2, ',', ' ')."</h2>";
    echo "<br>";
    $total_togive = round($total_count-$total_give, 2);
    echo "<h2>ОСТАЛОСЬ ВЫДАТЬ: ".number_format($total_togive, 2, ',', ' ')."</h2>";

};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*СПИСОК ПЛАТЕЖЕЙ И НАЧИСЛЕНИЙ В РАМКАХ ОДНОЙ ЗАЯВКИ///////////////////////////////////////////////////////*/
if (isset($_POST['the_request'])){
    try {
        $the_request = $_POST['the_request'];
        $onhands;

        $get_req_info = $database->prepare("SELECT created,req_sum,1c_num FROM `requests` WHERE requests_id=?");
        $get_payments = $database->prepare("SELECT payed,payments_id,number,sum,requestid FROM `payments` WHERE requestid=?");
        $get_positions = $database->prepare("SELECT pos_name, name, tare, kol, oh, firstoh, pricingid, req_positionid as position FROM (SELECT * FROM (SELECT trades_id,tare,name FROM trades LEFT JOIN allnames ON trades_nameid=nameid) AS a LEFT JOIN pricings ON a.trades_id=tradeid) AS b left join req_positions on b.pricingid=req_positions.winnerid WHERE req_positions.requestid=?");
        //Запросы для расценки
        $get_seller_name = $database->prepare("SELECT name, sellers_id FROM allnames LEFT JOIN sellers ON allnames.nameid = sellers.sellers_nameid LEFT JOIN pricings ON sellers_id=sellerid WHERE pricingid=?");

        $database->beginTransaction();
        $get_req_info->execute(array($the_request));
        $get_payments->execute(array($the_request));
        $get_positions->execute(array($the_request));
        $database->commit();

        if($get_payments->rowCount() == 0) {$result1 .= "<h3>Платежи</h3><span>Ничего еще не оплачено.</span>";
        }else {
            $result1="<h2>Платежи</h2><table><thead><tr><th>Дата</th><th>Номер п/п</th><th>Сумма платежки</th><th></th></tr></thead><tbody>";
            foreach ($get_payments as $row) {

                $phpdate = strtotime( $row['payed'] );
                $mysqldate = date( 'd.m.y', $phpdate );

                $result1 .= "<tr><td>" . $mysqldate . "</td><td>" . $row['number'] . "</td><td>" . $row['sum'] . "</td><td><input class='editpayment' database='".$db_text."' type='button' value='E' pay_id='".$row['payments_id']."' req_id='".$row['requestid']."'><input class='delpayment' database='".$db_text."' type='button' value='X' pay_id='".$row['payments_id']."' req_id='".$row['requestid']."'></td></tr>";
            };
            $result1 .= "</tbody></table>";
        };

        if($get_positions->rowCount() == 0) {$result2 .= "<h3>Начисления</h3><span>Ничего не начислено.</span> <input type='button' value='Перейти к заявке'>";
        }else {
            $result2="<h2>Начисления</h2><table><thead><tr><th>Товар</th><th>Кол-во</th><th>Начислено, на шт</th><th>Сумма к выдаче</th></tr></thead><tbody>";
            foreach ($get_positions as $row) {

                if (round($row['oh'],2) == 0) {
                    $onhands = round($row['firstoh'],2);
                } else {
                    $onhands = round($row['oh'],2);
                };

                //Имя Поставщика
                $get_seller_name->execute(array($row['pricingid']));
                $get_seller_name_fetched = $get_seller_name->fetch(PDO::FETCH_ASSOC);

                $result2 .= "<tr pricingid = ".$row['pricingid']." sellerid = '".$get_seller_name_fetched['sellers_id']."'><td><span>".$row['pos_name']."</span><br><br><span class='ga_trade' tare='".$row['tare']."'>" . $row['name'] . "</span> от <span class='ga_seller'>".$get_seller_name_fetched['name']."</span><input value='↑ E ↑' type='button' class='editpricing' position='".$row['position']."' pricing = '".$row['pricingid']."'></td><td>" . $row['kol'] . "</td><td>" . $onhands . "</td><td>" . round($row['kol'],2) * round($onhands,2) . "</td></tr>";
            };
            $result2 .= "</tbody></table>";
        };

        foreach($get_req_info as $row){
            $phpdate = strtotime( $row['created'] );
            $mysqldate = date( 'd.m.y', $phpdate );
            $result4 ="<h2 class='req_header'>Заказ от <span class='date'>".$mysqldate."</span> на сумму ".round($row['req_sum'],2).". Номер в 1С: <span class='1c_num'>".$row['1c_num']."</span><h2/>";
        }

        print(json_encode(array('data1'=>$result1,'data2'=>$result2,'data4'=>$result4)));

    }catch(PDOException $e) {$database->rollback();print "Error!: ".$e->getMessage()."<br/>".(int)$e->getCode( );}

};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////