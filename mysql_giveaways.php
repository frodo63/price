<?php
include_once 'pdo_connect.php';

//Функция сравнения времени
function date_sort($a, $b) {
    return $a - $b;
}

/*СПИСОК ЗАЯВОК В РАМКАХ ОДНОГО ПОКУПАТЕЛЯ///////////////////////////////////////////////////////*/
if (isset($_POST['the_byer'])){
    try {
//Проверяем общую опцию даты
        $ga_period = $pdo->prepare("SELECT * FROM `options` WHERE options_id = 'general'");
        $ga_period->execute();
        $ga_period_fetched = $ga_period->fetch(PDO::FETCH_ASSOC);
        $ga_period_current = $ga_period_fetched['ga_period'];

        switch ($ga_period_current){
            case 'year':
                $from = date("Y")."-01-01";
                break;
            case 'quarter':
                //Найти начало квартала
                $month = date("n");
                $n = 12-$month;
                //Первый кватал
                if($n <= 11 && $n > 8){$from = date("Y")."-01-01";}
                //Второй квартал
                if($n <= 8 && $n > 5){$from = date("Y")."-04-01";}
                //Третий квартал
                if($n <= 5 && $n > 2){$from = date("Y")."-07-01";}
                //Четвертый квартал
                if($n < 3){$from = date("Y")."-10-01";}
                break;
            case 'month':
                $from = date("Y-m")."-01";
                break;
        }
        $to = date("Y-m-d");
        //Приводим к читаемому виду
        $to_norm = substr($to,8,2).'-'.substr($to,5,2).'-'.substr($to,0,4);
        $from_norm = substr($from,8,2).'-'.substr($from,5,2).'-'.substr($from,0,4);
        //С другой стороны, даты могут быть прямо определены вручную
        if(isset($_POST['from']) && isset($_POST['to'])){
            $from = $_POST['from'];
            $to = $_POST['to'];

            $from_norm = substr($from,8,2).'-'.substr($from,5,2).'-'.substr($from,0,4);
            $to_norm = substr($to,8,2).'-'.substr($to,5,2).'-'.substr($to,0,4);
        }
        //Определилилсь с $from и $to

        $the_byer = $_POST['the_byer'];
        //Нужно из $the_byer получить $the_byer_ip и положить оба значения в [4] массива $dbs_array
        $getbyersidip = $pdo->prepare("SELECT prices_ip.byers.byers_id as byersid_ip FROM prices.byers LEFT JOIN prices_ip.byers ON prices.byers.ip_uid = prices_ip.byers.byers_uid WHERE prices.byers.byers_id = ?");
        $getbyersidip->execute(array($the_byer));
        $getbyersidip_fetched = $getbyersidip->fetch(PDO::FETCH_ASSOC);
        $dbs_array[0][4] = $the_byer;
        $dbs_array[1][4] = $getbyersidip_fetched['byersid_ip'];

        //datepicker
        echo "<div class='ga_requests_date_range'><input class='from' size='10' placeholder='От'><input class='to' size='10' placeholder='До'><input class='filter_date' type='button' value='Отобразить'></div>";
        echo "<br><span class='ga_requests_period'>Заявки за период c <b>".$from_norm."</b> по <b>".$to_norm."</b></span>";
        echo "<table><thead><tr><th>Дата</th><th>Номер заказа в 1С</th><th></th><th>База</th><th>Накладная</th><th>Сумма заявки</th><th>Начислено</th><th>Статус заявки</th></tr></thead><tbody>";

    }catch( PDOException $e ) {$pdo->rollback();print "Error!: " . $e->getMessage() . "<br/>" . (int)$e->getCode( );}

    /*ПЕРЕМЕННЫЕ ИТОГОВЫЕ*/
    /*НА КАЖДОГО ПОКУПАТЕЛЯ У НАС 3 ПЕРЕМЕННЫЕ*/
    $total_sum=0;//Сумма заказа строку приводим к числу
    $total_count = 0;//Начислено
    $total_pay = 0;//Оплачено

    foreach ($dbs_array as $database){
        try {
            //Главный запрос
            //Выбираем все заявки из базы, попадающие по дате создания заказа, не убранные из Р-1 и по которым были накладные
            $reqlist = $database[0]->prepare("SELECT DISTINCT 1c_num, created, requests_id, req_sum,requests.requests_uid as requests_uid,executes_id FROM requests LEFT JOIN executes ON requests.requests_uid=executes.requests_uid WHERE (requests.byersid = ?) AND (requests.created BETWEEN ? AND ?) AND (requests.r1_hidden = 0) AND requests.requests_uid IS NOT NULL AND executes_id IS NOT NULL GROUP BY 1c_num");
            //$reqlist = $database[0]->prepare("SELECT created,requests_id,1c_num,name,req_sum,requests_uid FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid WHERE (requests.byersid = ? AND requests.created BETWEEN ? AND ? AND requests.r1_hidden = 0) ORDER BY created");

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
                        $result .="<span style='color: green'>".$exe['execute_1c_num']." от ".$exe['executed']."</span><br>";
                    }
                };
                $result.="</td>";
                /*ПЕРЕМЕННЫЕ НА СТАТУС ЗАКАЗА*/
                /*НА КАЖДЫЙ ЗАКАЗ У НА 3 ПЕРЕМЕННЫЕ*/
                $req_sum=round($row['req_sum'],2);//Сумма заказа строку приводим к числу
                $req_pay = 0;//Оплачено
                $req_count = 0;//Начислено

                /*Расчет общего количества оплат*/
                foreach ($req_payments_fetched as $rp){
                    $req_pay+=round($rp['sum'],2);
                }
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
                $result.="<td>".round($row['req_sum'],2)."</td>";
                $total_sum += round($row['req_sum'],2);

                //Выводим сумму начислений по заявке
                $result.="<td>".round($req_count,2)."</td>";
                //Начисления к выдаче берутся лишь в том случае, если заказ оплачен. То есть, $req_pay_ostatok <=0
                if ($req_pay_ostatok <= 0){
                    $total_count += round($req_count,2);
                }

                /*УСЛОВИЯ ПО СТАТУСУ ЗАКАЗА*/
                if ($req_pay_ostatok == 0 && round($req_sum,2) !=0 && round($req_pay,2) !=0 && round($req_count,2) == 0){
                    $result .="<td>
                               <div class='green'>
                                   <span>Оплата 100% Начислений не было</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."'byerid='".$database[4]."'>
                                       
                               </div>
                           </td>";
                }elseif($req_pay_ostatok == 0 && round($req_sum,2) !=0 && round($req_pay,2) !=0 && round($req_count,2) > 0){
                    $result .="<td>
                               <div class='lightgreen'>
                                   <span>Оплата 100% Начислено: ".round($req_count,2)."</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."'byerid='".$database[4]."'>                                       
                               </div>
                           </td>";
                }elseif (round($req_sum,2) == 0){
                    $result .="<td>
                               <div class='red'>
                                   <span>Назначьте победителя</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."'byerid='".$database[4]."'>                                       
                               </div>
                           </td>";
                }elseif (round($req_sum,2) > 0 && round($req_pay,2) == 0){
                    $result .="<td>
                               <div class='lightblue'>
                                   <span>Оплат не поступало</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."'byerid='".$database[4]."'>
                               </div>
                           </td>";
                }elseif(round($req_sum,2) > 0 && $req_pay_ostatok > 0){
                    $result .="<td>
                               <div class='yellow'>
                                   <span>Оплата < 100% К оплате :".$req_pay_ostatok."</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."'byerid='".$database[4]."'>                                       
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
    $req_give = 0;//Отдано

    foreach ($dbs_array as $database){
        //Запросы общие
        //Выбираем все выдачи указанному покупателю, попадающие по дате выдачи
        $req_giveaways = $database[0]->prepare("SELECT given_away,giveaways_id,giveaway_sum,comment FROM giveaways WHERE (byersid = ?) AND (given_away BETWEEN ? AND ?) ORDER BY given_away");
        //Выбираем все платежки от указанного покупателя, попадающие по дате платежа
        $req_all_payments = $database[0]->prepare("SELECT payed FROM payments LEFT JOIN requests ON payments.requestid = requests.requests_id WHERE byersid = ? AND payed BETWEEN ? AND ? ORDER BY payed ASC");

        try {
            /*Расчет общего количества выдач*/


            $database[0]->beginTransaction();
            //$given_away_from - это дата первой в списке платежки
            //$given_away_to - это дата следующей, не вошедшей в список платежки (а если ее нет - то дата последней платежки + 2 недели)

            //Добыть дату следующей платежки:
            $req_all_payments->execute(array($database[4],$from,$to));
            $req_all_payments_fetched = $req_all_payments->fetchAll(PDO::FETCH_ASSOC);

            $next_payment = $database[0]->prepare("SELECT payed FROM payments LEFT JOIN requests ON payments.requestid = requests.requests_id WHERE byersid = 46 AND payed > ? ORDER BY payed ASC");
            $last_payment = end($req_all_payments_fetched);
            $next_payment->execute(array($last_payment['payed']));
            $next_payment_fetched = $next_payment->fetchAll(PDO::FETCH_ASSOC);
            if(!$next_payment_fetched[0]['payed'] || strtotime($next_payment_fetched[0]['payed']) < strtotime(date('Y-m-d'))){
                $next_payment_fetched[0]['payed'] = date('Y-m-d');
            }

            $giveaways_start_date = $req_all_payments_fetched[0]['payed'];
            $giveaways_end_date = $next_payment_fetched[0]['payed'];

            if(!$giveaways_start_date || $giveaways_start_date == ''){
                $giveaways_start_date = $from;
            }

            if(!$giveaways_end_date || $giveaways_end_date == ''){
                $giveaways_end_date = $to;
            }

            echo "<br><br><span>Выдачи за период с ".$giveaways_start_date." по ".$giveaways_end_date."</span><br>";
            echo "<input type='button' database = '".$database[1]."' byersid='".$database[4]."' value='+Выдача в базу ".$database[3]."' class='add_giveaway'>";
            echo "<table><thead><th>Дата выдачи</th><th>Сумма выдачи</th><th>Комментарий</th><th>Опции</th></thead><tbody>";

            $req_giveaways->execute(array($database[4],$giveaways_start_date,$giveaways_end_date));
            $giveaways_fetched = $req_giveaways->fetchAll(PDO::FETCH_ASSOC);
            $database[0]->commit();

            unset($req_all_payments_fetched);

            foreach ($giveaways_fetched as $rg){
                $req_give+=round($rg['giveaway_sum'],2);
            }
            $total_give += $req_give;

            //Рисуем список выдач
            foreach ($giveaways_fetched as $give){
                echo "<tr><td></td><td>из базы ".$database[3]."</td><td></td><td></td></tr>";
                echo "<tr giveaways_id='".$give['giveaways_id']."'>";
                $phpdate = strtotime( $give['given_away'] );
                $mysqldate = date( 'd.m.y', $phpdate );

                echo "<td>".$mysqldate."</td>";
                echo "<td>".$give['giveaway_sum']."</td>";
                echo "<td>".$give['comment']."</td>";
                echo "<td><input type='button' value='E' byersid='".$database[4]."' database='".$database[1]."' class='editgiveaway' g_id='".$give['giveaways_id']."'>
            <input class='delgiveaway' database='".$database[1]."' type='button' value='X' give_id='".$give['giveaways_id']."'></td>";
                echo "</tr>";
            }
            unset($giveaways_fetched);
            echo "</tbody></table>";

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

                $result1 .= "<tr><td>" . $mysqldate . "</td><td>" . $row['number'] . "</td><td>" . $row['sum'] . "</td><td><input class='delpayment' database='".$db_text."' type='button' value='X' pay_id='".$row['payments_id']."' req_id='".$row['requestid']."'><input class='editpayment' database='".$db_text."' type='button' value='E' pay_id='".$row['payments_id']."' req_id='".$row['requestid']."'></td></tr>";
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