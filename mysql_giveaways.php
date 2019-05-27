<?php
include_once 'pdo_connect.php';

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

        //Определилилсь с $from и $to

        $the_byer = $_POST['the_byer'];
        $reqlist = $pdo->prepare("SELECT created,requests_id,1c_num,name,req_sum FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid WHERE (requests.byersid = ? AND requests.created BETWEEN ? AND ? AND requests.r1_hidden = 0) ORDER BY created");
        if(isset($_POST['from']) && isset($_POST['to'])){
            $from = $_POST['from'];
            $to = $_POST['to'];

            $from_norm = substr($from,8,2).'-'.substr($from,5,2).'-'.substr($from,0,4);
            $to_norm = substr($to,8,2).'-'.substr($to,5,2).'-'.substr($to,0,4);
        }
        $req_payments = $pdo->prepare("SELECT requests_id,payments_id,number,payed,sum,req_sum FROM requests LEFT JOIN payments ON requests.requests_id=payments.requestid WHERE requests_id = ? ORDER BY payed");
        $req_giveaways = $pdo->prepare("SELECT requests_id,given_away,giveaways_id,giveaway_sum, comment FROM requests LEFT JOIN giveaways ON requests.requests_id=giveaways.requestid WHERE requests_id=? ORDER BY given_away");
        $req_countings = $pdo->prepare("SELECT requestid,req_positionid,winnerid,oh,firstoh,kol FROM req_positions LEFT JOIN pricings on winnerid=pricings.pricingid WHERE requestid=?");

        $pdo->beginTransaction();
        $reqlist->execute(array($the_byer,$from,$to));
        $pdo->commit();

        $result="<div class='ga_requests_date_range'><input class='from' size='10' placeholder='От'><input class='to' size='10' placeholder='До'>
<input class='filter_date' type='button' value='Отобразить'></div>";
        $result.="<span>Заявки за период c <b>".$from_norm."</b> по <b>".$to_norm."</b></span>.<br><br>";

        $result.="<table><thead><tr><th>Дата</th><th>Номер заказа в 1С</th><th></th><th>Сумма заявки</th><th>Начислено</th><th>Статус заявки</th></tr></thead><tbody>";

        /*ПЕРЕМЕННЫЕ ИТОГОВЫЕ*/
        /*НА КАЖДОГО ПОКУПАТЕЛЯ У НАС 4 ПЕРЕМЕННЫЕ*/
        $total_sum=0;//Сумма заказа строку приводим к числу
        $total_count = 0;//Начислено
        $total_pay = 0;//Оплачено
        $total_give = 0;//Отдано

        foreach ($reqlist as $row){

            /*Выполняем запросы*/
            $pdo->beginTransaction();
            $req_countings->execute(array($row['requests_id']));
            $req_payments->execute(array($row['requests_id']));
            $req_giveaways->execute(array($row['requests_id']));
            $pdo->commit();

            $result.="<tr ga_request='". $row['requests_id'] ."'>";
            /*Делаем дату читаемой*/
            $phpdate = strtotime( $row['created'] );
            $mysqldate = date( 'd.m.y', $phpdate );
            $result.="<td>".$mysqldate."</td>";
            $result.="<td>".$row['1c_num']."</td>";
            $result.="<td><input class='collapse_ga_request' ga_request='". $row['requests_id'] ."' type='button' value='♢'><span>".$row['name']."</span>
<div class='ga_contents' ga_request='". $row['requests_id'] ."'><div class='ga_options'></div><div class='ga_c_payments'></div><div class='ga_c_positions'></div><div class='ga_c_giveaways'></div></div></td>";

            /*ПЕРЕМЕННЫЕ НА СТАТУС ЗАКАЗА*/
            /*НА КАЖДЫЙ ЗАКАЗ У НА 4 ПЕРЕМЕННЫЕ*/
            $req_sum=round($row['req_sum'],2);//Сумма заказа строку приводим к числу
            $req_count = 0;//Начислено
            $req_pay = 0;//Оплачено
            $req_give = 0;//Отдано

            /*Расчет общего количества начислений*/
            foreach ($req_countings as $rc){
                if (round($rc['oh'],2) == 0) {
                    $onhands = round($rc['firstoh'],2);
                } else {
                    $onhands = round($rc['oh'],2);
                };
                $req_count+=round($onhands,2) * round($rc['kol'],2);
            }
            /**/

            //Выводим сумму заявки
            $result.="<td>".round($row['req_sum'],2)."</td>";
            $total_sum += round($row['req_sum'],2);

            //Выводим сумму начислений по заявке
            $result.="<td>".round($req_count,2)."</td>";
            $total_count += round($req_count,2);


            /*Расчет общего количества оплат*/
            foreach ($req_payments as $rp){
                $req_pay+=round($rp['sum'],2);
            }
            $total_pay += $req_pay;
            /**/
            /*Расчет общего количества выдач*/
            foreach ($req_giveaways as $rg){
                $req_give+=round($rg['giveaway_sum'],2);
            }
            $total_give += $req_give;
            /**/

            /*Подготовка переходных переменных*/
            $req_pay_ostatok = round($req_sum, 2) - round($req_pay, 2);//Остаток к оплате
            $req_give_ostatok = round($req_count,2) - round($req_give,2);//Долг по выдачам

            /**/

            /*УСЛОВИЯ ПО СТАТУСУ ЗАКАЗА*/
            if(round($req_sum,2) == round($req_pay,2) && round($req_sum,2) !=0 && round($req_pay,2) != 0 && $req_give_ostatok == 0 && $req_give != 0){
                $result .="<td>
                               <div class='green'>
                                   <span>Оплата 100% Выдача 100%</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."'byerid='".$the_byer."'>
                                       
                               </div>
                           </td>";
            }elseif (round($req_sum,2) == round($req_pay,2) && round($req_sum,2) !=0 && round($req_pay,2) != 0 && $req_give_ostatok == 0 && $req_give == 0){
                $result .="<td>
                               <div class='green'>
                                   <span>Оплата 100% Начислений не было</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."'byerid='".$the_byer."'>
                                       
                               </div>
                           </td>";
            }elseif(round($req_sum,2) == round($req_pay,2) && round($req_sum,2) !=0 && round($req_pay,2) !=0){
                $result .="<td>
                               <div class='lightgreen'>
                                   <span>Оплата 100% К выдаче: ".$req_give_ostatok."</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."'byerid='".$the_byer."'>                                       
                               </div>
                           </td>";
            }elseif (round($req_sum,2) == 0){
                $result .="<td>
                               <div class='red'>
                                   <span>Назначьте победителя</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."'byerid='".$the_byer."'>                                       
                               </div>
                           </td>";
            }elseif (round($req_pay,2) == 0){
                $result .="<td>
                               <div class='lightblue'>
                                   <span>Оплат не поступало</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."'byerid='".$the_byer."'>
                               </div>
                           </td>";
            }else{
                $result .="<td>
                               <div class='yellow'>
                                   <span>Оплата < 100% К оплате :".$req_pay_ostatok."</span>
                                   <input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."'byerid='".$the_byer."'>                                       
                               </div>
                           </td>";
                }
        };
        $result.="</tr></tbody></table>";

        //Выводим СУММУ ДОЛГА и СУММУ ВЫДАННОГО
        //ВСЕГО НАЧИСЛЕНО:
        echo "<br><br><br><br>";
        echo "<h2>ОБЩАЯ СУММА ЗАКАЗОВ: ".$total_sum."</h2>";
        echo "<h2>ВСЕГО ОПЛАЧЕНО: ".$total_pay."</h2>";
        echo "<h2>ВСЕГО НАЧИСЛЕНО: ".$total_count."</h2>";
        echo "<h2>ВСЕГО ВЫДАНО: ".$total_give."</h2>";
        $total_togive = round($total_count-$total_give, 2);
        echo "<h2>ОСТАЛОСЬ ВЫДАТЬ: ".$total_togive."</h2>";

        print $result;

        echo "<table><thead><th>Дата выдачи</th><th>Сумма выдачи</th><th>Комментарий</th></thead><tbody>";

        //Рисуем список выдач
        foreach ($req_giveaways as $give){
            echo "<tr>";

            $phpdate = strtotime( $give['given_away'] );
            $mysqldate = date( 'd.m.y', $phpdate );

            echo "<td giveaways_id='".$give['requests_id']."'>".$mysqldate."</td>";
            echo "<td>".$give['giveaway_sum']."</td>";
            echo "<td>".$give['comment']."</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";


        //Кнопка добавить выдачу
        echo "<input type='button' value='+Выдача' class='add_giveaway'>";

    }catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }

};

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*СПИСОК ПЛАТЕЖЕЙ, НАЧИСЛЕНИЙ И ВЫДАЧ В РАМКАХ ОДНОЙ ЗАЯВКИ///////////////////////////////////////////////////////*/

if (isset($_POST['the_request'])){
    try {
        $the_request = $_POST['the_request'];
        $onhands;

        $get_req_info = $pdo->prepare("SELECT created,req_sum,1c_num FROM `requests` WHERE requests_id=?");
        $get_payments = $pdo->prepare("SELECT payed,payments_id,number,sum,requestid FROM `payments` WHERE requestid=?");
        $get_positions = $pdo->prepare("SELECT name, kol, oh, firstoh, pricingid FROM (SELECT * FROM (SELECT trades_id,name FROM trades LEFT JOIN allnames ON trades_nameid=nameid) AS a LEFT JOIN pricings ON a.trades_id=tradeid) AS b left join req_positions on b.pricingid=req_positions.winnerid WHERE req_positions.requestid=?");
        $get_giveaways = $pdo->prepare("SELECT giveaways_id,requestid,given_away,comment,giveaway_sum FROM `giveaways` WHERE requestid=?");

        //Запросы для расценки
        $get_seller_name = $pdo->prepare("SELECT name, sellers_id FROM allnames LEFT JOIN sellers ON allnames.nameid = sellers.sellers_nameid LEFT JOIN pricings ON sellers_id=sellerid WHERE pricingid=?");

        $pdo->beginTransaction();
        $get_req_info->execute(array($the_request));
        $get_payments->execute(array($the_request));
        $get_positions->execute(array($the_request));
        $get_giveaways->execute(array($the_request));
        $pdo->commit();

        $result1="<input class='add_payment' requestid='".$the_request."' type='button' value='+платеж'><br>";
        if($get_payments->rowCount() == 0) {$result1 .= "<h3>Платежи</h3><span>Ничего еще не оплачено.</span>";
        }else {
            $result1.="<h2>Платежи</h2><table><thead><tr><th>Дата</th><th>Номер п/п</th><th>Сумма платежки</th><th></th></tr></thead><tbody>";
            foreach ($get_payments as $row) {

                $phpdate = strtotime( $row['payed'] );
                $mysqldate = date( 'd.m.y', $phpdate );

                $result1 .= "<tr><td>" . $mysqldate . "</td><td>" . $row['number'] . "</td><td>" . $row['sum'] . "</td><td><input class='delpayment' type='button' value='X' pay_id='".$row['payments_id']."' req_id='".$row['requestid']."'><input class='editpayment' type='button' value='E' pay_id='".$row['payments_id']."' req_id='".$row['requestid']."'></td></tr>";
            };
            $result1 .= "</tbody></table>";
        };

        $result2="<input type='button' value='Перейти к заявке'>";
        if($get_positions->rowCount() == 0) {$result2 .= "<h3>Начисления</h3><span>Ничего не начислено.</span> <input type='button' value='Перейти к заявке'>";
        }else {
            $result2.="<h2>Начисления</h2><table><thead><tr><th>Товар</th><th>Кол-во</th><th>Начислено, на шт</th><th>Сумма к выдаче</th></tr></thead><tbody>";
            foreach ($get_positions as $row) {

                if (round($row['oh'],2) == 0) {
                    $onhands = round($row['firstoh'],2);
                } else {
                    $onhands = round($row['oh'],2);
                };

                //Имя Поставщика
                $get_seller_name->execute(array($row['pricingid']));
                $get_seller_name_fetched = $get_seller_name->fetch(PDO::FETCH_ASSOC);

                $result2 .= "<tr pricingid = ".$row['pricingid']." sellerid = '".$get_seller_name_fetched['sellers_id']."'><td><span class='ga_trade'>" . $row['name'] . " от </span><span class='ga_seller'>".$get_seller_name_fetched['name']."</span><input value='↑ расценка ↑' type='button' class='editpricing' pricing = '".$row['pricingid']."'></td><td>" . $row['kol'] . "</td><td>" . $onhands . "</td><td>" . round($row['kol'],2) * round($onhands,2) . "</td></tr>";
            };
            $result2 .= "</tbody></table>";
        };

        $result3="<input class='add_giveaway' requestid='".$the_request."' type='button' value='+выдача'><br>";
        if($get_giveaways->rowCount() == 0) {$result3 .= "<h3>Выдачи</h3><span>Ничего еще не выдано.</span>";
        }else {
            $result3.="<h2>Выдачи</h2><table><thead><tr><th>Дата</th><th>Комментарий</th><th>Сумма</th><th></th></tr></thead><tbody>";
            foreach ($get_giveaways as $row) {

                $phpdate = strtotime( $row['given_away'] );
                $mysqldate = date( 'd.m.y', $phpdate );

                $result3 .= "<tr><td>" . $mysqldate . "</td><td>" . $row['comment'] . "</td><td>" . $row['giveaway_sum'] . "</td><td><input class='delgiveaway' type='button' value='X' give_id='".$row['giveaways_id']."' req_id='".$row['requestid']."'><input class='editgiveaway' type='button' value='E' give_id='".$row['giveaways_id']."' req_id='".$row['requestid']."'></td></tr>";
            };
            $result3 .= "</tbody></table>";
        };

        $result4="<input type='button' class='edit_1c_num' requestid='".$the_request."' value='Номер в 1C и Дата'><br>";
        foreach($get_req_info as $row){
            $phpdate = strtotime( $row['created'] );
            $mysqldate = date( 'd.m.y', $phpdate );
            $result4 .="<h2 class='req_header_".$the_request."'>Заказ от <span class='date'>".$mysqldate."</span> на сумму ".round($row['req_sum'],2).". Номер в 1С: <span class='1c_num'>".$row['1c_num']."</span> <h2/><br>";
        }


        print(json_encode(array('data1'=>$result1,'data2'=>$result2,'data3'=>$result3,'data4'=>$result4)));

    }catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }

};

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////