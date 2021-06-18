<?php
include_once 'pdo_connect.php';

//Функция сравнения времени
function date_sort($a, $b) {
    return $a - $b;
}

//Еще одна функция сравоения времени для массива
function date_compare($element1, $element2) {
    $datetime1 = strtotime($element1['datetime']);
    $datetime2 = strtotime($element2['datetime']);
    return $datetime1 - $datetime2;
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
        $getbyersinfo = $pdo->prepare("SELECT b.ov_firstobp, b.ov_tp, b.ov_wt, b.comment, b.debt_2018, b.debt_2019, b.debt_2020, b.debt_2021, b.debt_2022, b.debt_2023, b.debt_total FROM prices.byers b WHERE b.byers_id = ?");
        $getpayments_allyear = $pdo->prepare("SELECT p.payed, p.number, p.sum, r.1c_num  FROM prices.payments p LEFT JOIN requests r ON p.requestid = r.requests_id WHERE p.byersid = ? AND p.payed BETWEEN ? AND ? ORDER BY payed ASC");
        $getbyersidip->execute(array($the_byer));
        $getbyersidip_fetched = $getbyersidip->fetch(PDO::FETCH_ASSOC);
        $dbs_array[0][4] = $the_byer;
        $dbs_array[1][4] = $getbyersidip_fetched['byersid_ip'];



        //ОБЩИЙ МАССИВ ДЛЯ ВЫВОДА КОЛБАСЫ С ПОДСЧЕТОМ ДОЛГА В РЕАЛЬНОМ ВРЕМЕНИ.
        //ЕСТЬ НАЧИСЛЕНИЯ И ВЫДАЧИ. ВЫДЧАИ _ ПОНЯТНО, а НАЧИСЛЕНИЯ МОГУТ БЫТЬ как НАКЛАДНЫЕ, так и ПЛАТЕЖКИ, в зависимости от того, что произошло позже.
        $debt_track = Array();
        //$debt_track = Array (
        //    Array (,
        //        "datetime" => "2019-02-22 11:29:45",
        //        "type" => "payment/execution/give",
        //        "sum" => "1000",
        //        Array(
        //              "number" => "23142",
        //              ),
        //        ),
        //    Array (,
        //        "datetime" => "2019-02-22 11:29:45",
        //        "type" => "give/take",
        //        "sum" => "1000",
        //        Array(
        //              "number" => "23142",
        //              "type" => "payment/exec"
        //              ),
        //        ),
        //// Comparison function
        //function date_compare($element1, $element2) {
        //    $datetime1 = strtotime($element1['datetime']);
        //    $datetime2 = strtotime($element2['datetime']);
        //    return $datetime1 - $datetime2;
        //}
        //
        //// Sort the array
        //usort($array, 'date_compare');
        //
        //// Print the array
        //print_r($array)
        //);

        echo "<br><br>";
        echo "<input byer ='".$the_byer."'  class='count_rent_whole_byer' type='button' value='Пересчитать рентабельность во всех заявках'><br>";
        /*echo "<input byer ='".$the_byer."' class='refresh_r1_byer single' type='button' value='ОБНОВИТЬ'>";*/
        echo "<i byer ='".$the_byer."' class='fa fa-refresh refresh_r1_byer single'></i>";
        echo "<br>
        <input class='refresh_r1_byer' ga_byer ='".$the_byer."'  type='button' value='2018'>
        <input class='refresh_r1_byer' ga_byer ='".$the_byer."'  type='button' value='2019'>
        <input class='refresh_r1_byer' ga_byer ='".$the_byer."'  type='button' value='2020'>
        <input class='refresh_r1_byer' ga_byer ='".$the_byer."'  type='button' value='2021'>
        <input class='refresh_r1_byer' ga_byer ='".$the_byer."'  type='button' value='2022'>
        <input class='refresh_r1_byer' ga_byer ='".$the_byer."'  type='button' value='2023'>
<br><br>";



        $dbs_array[0][0]->beginTransaction();
        $getbyersinfo->execute(array($the_byer));
        $dbs_array[0][0]->commit();

            $getbyersinfo_fetched = $getbyersinfo->fetch(PDO::FETCH_ASSOC);

            echo "<span>РАСЧЕТ за : " . $the_year . " год.</span>";
            echo "<span>Процент: " . $getbyersinfo_fetched['ov_tp'] . "</span>";
            echo "<span>Обнал: " . $getbyersinfo_fetched['ov_firstobp'] . "</span>";
            echo "<span>Отсрочка: " . $getbyersinfo_fetched['ov_wt'] . "</span>";
            echo "<span>Коммент: " . $getbyersinfo_fetched['comment'] . "</span><br><br>";



        //ВЫВОД ДОЛГА ПРОШЛОГО ГОДА
        switch($the_year)
        {
            case '2018':
                $last_year_debt = 0;
                break;
            case '2019':
                $last_year_debt = $getbyersinfo_fetched['debt_2018'];
                break;
            case '2020':
                $last_year_debt = $getbyersinfo_fetched['debt_2018'] + $getbyersinfo_fetched['debt_2019'];
                break;
            case '2021':
                $last_year_debt = $getbyersinfo_fetched['debt_2018'] + $getbyersinfo_fetched['debt_2019'] + $getbyersinfo_fetched['debt_2020'];
                break;
            case '2022':
                $last_year_debt = $getbyersinfo_fetched['debt_2018'] + $getbyersinfo_fetched['debt_2019'] + $getbyersinfo_fetched['debt_2020'] + $getbyersinfo_fetched['debt_2021'];
                break;
            case '2023':
                $last_year_debt = $getbyersinfo_fetched['debt_2018'] + $getbyersinfo_fetched['debt_2019'] + $getbyersinfo_fetched['debt_2020'] + $getbyersinfo_fetched['debt_2021'] + $getbyersinfo_fetched['debt_2022'];
                break;
        }
        echo "<span><b>Долг на начало года :  ".number_format($last_year_debt, 2, ',', ' ')." руб.</b></span><br><br><br><br>";
        //КОНЕЦ ВЫВОДА ДОЛГА ПРОШЛОГО ГОДА

        echo "<br><span class='ga_requests_period'><b>Заявки за ".$the_year." год:</b></span><br><br>";
        echo "<table class='ga_request_list_shrinken'><thead><tr><th>Дата</th><th>Заказ в 1С</th><th></th><th>База</th><th>Накладная</th><th>Сумма</th><th>Начислено</th><th>Статус заявки</th></tr></thead><tbody>";

    }catch( PDOException $e ) {$pdo->rollback();print "Error!: " . $e->getMessage() . "<br/>" . (int)$e->getCode( );}

    /*ПЕРЕМЕННЫЕ ИТОГОВЫЕ*/
    /*НА КАЖДОГО ПОКУПАТЕЛЯ У НАС 3 ПЕРЕМЕННЫЕ*/
    $total_sum=0;//Сумма заказа строку приводим к числу
    $total_count = 0;//Начислено
    $total_pay = 0;//Оплачено
    $total_exec = 0;//Отгружено (ДОБАВИТЬ!!!)

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
                $req_events = Array();
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
                $str=$row['1c_num']*1;
                $result.="<td>".$str."</td>";
                $result.="<td>
                        <input class='collapse_ga_request' ga_request='".$row['requests_id']."' type='button' value='♢' byerid = '".$database[4]."' database='".$database[1]."'>
                            <div class='ga_contents' ga_request='". $row['requests_id'] ."'>
                                <div class='ga_options'></div>
                                <div class='ga_c_payments'></div>
                                <div class='ga_c_executes'></div>
                                <div class='ga_c_positions'></div>
                            </div>
                        </td>";
                $result.="<td>".$database[3]."</td>";
                $result.="<td>";
                //Вывести номер и дату накладной реализации
                if(count($req_executals_fetched) > 0){
                    foreach($req_executals_fetched as $exe){

                        /*Заголовок дата////////////////////////////////////////////////////////////////////////////////////////////////*/
                        $phpdate = strtotime( $exe['executed'] );
                        $mysqldate = date( 'd.m.y', $phpdate );
                        /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

                        $str = $exe['execute_1c_num'] * 1;
                        $result .="<span style='color: green'>№ ".$str." - ".$exe['sum']." от ".$mysqldate."</span><br>";
                        unset($mysqldate);
                    }
                };
                $result.="</td>";
                /*ПЕРЕМЕННЫЕ НА СТАТУС ЗАКАЗА*/
                /*НА КАЖДЫЙ ЗАКАЗ У НА 3 ПЕРЕМЕННЫЕ*/
                $req_sum=round($row['req_sum'],2);//Сумма заказа строку приводим к числу
                $req_pay = 0;//Оплачено
                $req_count = 0;//Начислено
                $req_exec = 0;//Отгружено

                /*Расчет общего количества оплат*/
                foreach ($req_payments_fetched as $rp){
                    $req_pay+=round($rp['sum'],2);
                }
                $total_pay += $req_pay;

                /*Рачсет общего количества реализаций*/
                foreach ($req_executals_fetched as $exec){
                    $req_exec+=round($exec['sum'],2);
                }
                $total_exec += $req_exec;

                /*Подготовка переходных переменных*/
                $req_pay_ostatok = round($req_sum, 2) - round($req_pay, 2);//Остаток к оплате
                $req_exec_ostatok = round($req_sum, 2) - round($req_exec, 2);//Остаток к реализации

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
                $result.="<td class='sum_req_r1'>".number_format($row['req_sum'], 2, ',', ' ')."</td>";
                //$result.="<td class='sum_req_r1'>".round($row['req_sum'],2)."</td>";
                $total_sum += round($row['req_sum'],2);

                //Начисления к выдаче берутся только если заказ полностью оплачен и отгружен
                if (
                    $req_pay_ostatok <= 2
                    && $req_exec_ostatok <= 2
                )
                {
                    //Выводим сумму начислений по заявке и зачисляем начисление в общую суму начислений
                    $result.="<td class='count_req_r1 green_letters'>".number_format($req_count, 2, ',', ' ')."</td>";
                    $total_count += round($req_count,2);
                    //И БЕРЕМ дату последнего события: платежки или реализиции и вносим эту запись в общий массив отслеживания долга

                    foreach ($req_executals_fetched as $exec){
                        $req_events[]=[
                            "datetime" => $exec['executed'],
                            "type" => "накладная",
                            "sum" => $exec['sum'],
                            "info" => [
                                "number" => $exec['execute_1c_num'],
                            ],
                        ];
                    }
                    foreach ($req_payments_fetched as $rp){
                        $req_events[]=[
                            "datetime" => $rp['payed'],
                            "type" => "платеж",
                            "sum" => $rp['sum'],
                            "info" => [
                                "number" => $rp['number'],
                            ],
                        ];
                    }
                    //Сортируем текущие события по дате
                    usort($req_events, 'date_compare');
                    //Берем последнюю запись в массиве ( end($req_events) )
                    //И заносим в общий массив $debt_track записи обо всех событиях этой заявки дытой последнего события
                    $debt_track[] = [
                        "datetime" => end($req_events)['datetime'],
                        "type" => "Начисление",
                        "sum" => $req_count,
                        "info" => $req_events,
                        "order" => [
                            "1c_num"=>$row['1c_num'],
                            "order_sum"=>$row['req_sum'],
                            "order_date"=>$row['created'],
                            ],
                    ];


                }else{
                    //Выводим сумму начислений по заявке и НЕ зачисляем начисление в общую суму начислений
                    $result.="<td class='count_req_r1 red_letters'>".number_format($req_count, 2, ',', ' ')."</td>";
                }

                /*УСЛОВИЯ ПО СТАТУСУ ЗАКАЗА*/
                ///////////////////////////////////////////////////////
                //ВСЁ ХОРОШО
                if (//Оплата 100% Начислений не было
                    $req_pay_ostatok >= 0 && $req_pay_ostatok < 2
                    && round($req_sum,2) !=0
                    && round($req_pay,2) !=0
                    && round($req_count,2) == 0
                ){
                    $result .="<td><div class='green'><span>Оплата 100% Начислений не было</span><input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'></div></td>";
                }
                elseif(//Оплата 100% Отгрузка 100% Есть начисления
                    $req_pay_ostatok >= 0  && $req_pay_ostatok < 2
                    && $req_exec_ostatok >= 0 && $req_exec_ostatok < 2
                    && round($req_sum,2) !=0
                    && round($req_pay,2) !=0
                    && round($req_count,2) > 0
                ){
                    $result .="<td><div class='lightgreen'><span>Оплата 100% Отгрузка 100% Начислено: ".round($req_count,2)."</span><input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'></div></td>";
                }
                ///////////////////////////////////////////////////////
                //ОТСУТСВИЕ ЧЕГО-ТО
                elseif (//Назначьте победителя
                    round($req_sum,2) == 0
                ){
                    $result .="<td><div class='red'><span>Назначьте победителя</span><input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'></div></td>";
                }
                elseif (//Оплат не поступало
                    round($req_sum,2) != 0
                    && round($req_pay,2) == 0
                ){
                    $result .="<td><div class='lightblue'><span>Оплат не поступало</span><input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'></div></td>";
                }
                elseif (// Оплата 100% Отгрузок не было
                    round($req_sum,2) != 0
                    && $req_pay_ostatok >= 0 && $req_pay_ostatok < 2
                    && round($req_exec,2) == 0
                ){
                    $result .="<td><div class='peach'><span>Оплата 100% Отгрузок не было</span><input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'></div></td>";
                }
                ///////////////////////////////////////////////////////
                //НЕПОЛНОТА ЧЕГО-ТО
                elseif(//Оплата < 100% Есть начисления
                    round($req_sum,2) != 0
                    && $req_pay_ostatok >= 2
                    && round($req_count,2) != 0
                ){
                    $result .="<td><div class='yellow'><span>Недооплата :".round($req_pay_ostatok,2)."</span><input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'></div></td>";
                }
                elseif(//Оплата 100% Отгрузка < 100% Есть начисления
                    round($req_sum,2) != 0
                    && $req_pay_ostatok >= 0 && $req_pay_ostatok < 2
                    && $req_exec_ostatok >= 2
                    && round($req_count,2) != 0
                ){
                    $result .="<td><div class='darkorange'><span>Оплата 100% Недоотгрузка :".round($req_exec_ostatok,2)."</span><input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'></div></td>";
                }
                ///////////////////////////////////////////////////////
                //ИЗБЫТОК ЧЕГО-ТО
                elseif(//Оплата > 100% Переплата Отгрузка 100% Есть начисления
                    round($req_sum,2) != 0
                    && $req_pay_ostatok < 0
                    && $req_exec_ostatok >= 0 && $req_exec_ostatok < 2
                ){
                    $result .="<td><div class='pink'><span>Переплата :".round($req_pay_ostatok,2)." Отгрузка 100%. К выдаче: ".round($req_count,2)."</span><input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'></div></td>";
                }
                elseif(//Оплата 100% Отгрузка > 100% Есть начисления
                    round($req_sum,2) != 0
                    && $req_pay_ostatok >= 0 && $req_pay_ostatok < 2
                    && $req_exec_ostatok < 0
                ){
                    $result .="<td><div class='darkseagreen'><span>Оплата 100% Переотгрузка :".round($req_exec_ostatok,2)." К выдаче: ".round($req_count,2)."</span><input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'></div></td>";
                }
                elseif(//Оплата > 100% Отгрузка > 100% Есть начисления
                    round($req_sum,2) != 0
                    && $req_pay_ostatok < 0
                    && $req_exec_ostatok < 0
                ){
                    $result .="<td><div class='lightpink'><span>Переотгрузка :".round($req_exec_ostatok,2)." Переплата :".round($req_pay_ostatok,2)." К выдаче: ".round($req_count,2)."</span><input type='button' value='X' class='r1_hide' requestid='".$row['requests_id']."' byerid='".$database[4]."'></div></td>";
                }

                unset($req_countings_fetched);
                unset($req_payments_fetched);
                unset($req_executals_fetched);

                /*echo "<pre>";
                print_r($req_events);
                echo "</pre>";
                echo "<hr>";*/

                unset($req_events);
            }
            print $result;
            unset ($result);
            echo "</tr>";


        }catch( PDOException $Exception ) {$database[0]->rollback();print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );}
    }
    echo "</tbody></table>";
    echo "<br>";

    //СПИСОК ПЛАТЕЖЕК ЗА ГОД
    echo "<br><span><b>Платежки за ".$the_year." год:</b></span><br><br>";
    echo "<table><thead><tr><th>Заказ</th><th>Дата платежа</th><th></th><th>Сумма</th></tr></thead><tbody>";
    foreach ($dbs_array as $database){
        //СПИСОК ПЛАТЕЖЕК ПО ЭТОМУ ПОКУПАТЕЛЮ ЗА ГОД///////////////////////////////////////////////////////
        $database[0]->beginTransaction();
        $getpayments_allyear->execute(array($database[4],$from,$to));
        $database[0]->commit();

        $result="";

        $getpayments_allyear_fetched = $getpayments_allyear->fetchAll(PDO::FETCH_ASSOC);
        if(count($getpayments_allyear_fetched)>0){
            echo "<tr><td>из базы ".$database[3]."</td><td></td><td></td><td></td></tr>";}
        foreach ($getpayments_allyear_fetched as $pay_full_year){

            $result .="<tr database='".$database[1]."' payment_full_year_request='".$pay_full_year['1c_num']."'>";
            /*Делаем дату читаемой*/
            $str=$pay_full_year['1c_num']*1;
            $result.="<td>№ ".$str."</td>";
            $phpdate = strtotime( $pay_full_year['payed'] );
            $mysqldate = date( 'd.m.y', $phpdate );
            $result.="<td>".$mysqldate."</td>";
            $result.="<td>п/п № ".$pay_full_year['number']."</td>";
            $result.="<td>".number_format($pay_full_year['sum'], 2, ',', ' ')."</td>";
            $result.="<tr>";
        };
        $result.="</tbody></table>";
        print $result;
        ///////////////////////////////////////////////////////////////////////////////////////////////////
    }


    //СПИСОК ВЫДАЧ ЗА ГОД
    echo "<br>";
    $total_give = 0;//Отдано
    echo "<br><br><span><b>Выдачи за ".$the_year." год:</b></span><br><br>";
    echo "<table class='ga_give_list'><thead><th>Дата выдачи</th><th>Год привязки</th><th>Сумма выдачи</th><!--<th>Остаток долга</th>--><th>Комментарий</th><th>Опции</th></thead><tbody>";

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
                //И ЗАНОСИМ КАЖДУЮ ВЫДАЧУ В МАССИВ ОТСЛЕЖИВАНИЯ ДОЛГА
                $debt_track[] = [
                    "datetime" => $rg['given_away'],
                    "type" => "Выдача",
                    "sum" => $rg['giveaway_sum'],
                    "info" => [
                        "comment" => $rg['comment'],
                        ],
                ];
            }
            $total_give += $req_give;//Отдано всего (в обеих базах)

            //Рисуем список выдач
            if(count($year_giveaways_fetched)>0){echo "<tr><td>из базы ".$database[3]."</td><!--<td></td>--><td></td><td></td><td></td></tr>";}

            $current_debt = $total_count;
            foreach ($year_giveaways_fetched as $give){
                echo "<tr giveaways_id='".$give['giveaways_id']."'>";
                $phpdate = strtotime( $give['given_away'] );
                $mysqldate = date( 'd.m.y', $phpdate );

                echo "<td>".$mysqldate."</td>";
                echo "<td>".$give['year_given']."</td>";
                echo "<td>".number_format($give['giveaway_sum'], 2, ',', ' ')."</td>";
                $current_debt -= $give['giveaway_sum'];
                /*echo "<td>".number_format($current_debt, 2, ',', ' ')."</td>";*/
                echo "<td>".$give['comment']."</td>";
                echo "<td><input type='button' value='E' byersid='".$database[4]."' database='".$database[1]."' class='editgiveaway' g_id='".$give['giveaways_id']."'>
            <input class='delgiveaway' database='".$database[1]."' type='button' value='X' give_id='".$give['giveaways_id']."'></td>";
                echo "</tr>";
            }
        }catch( PDOException $e ) {$database[0]->rollback();print "Error!: " . $e->getMessage() . "<br/>" . (int)$e->getCode( );}
    }
    echo "</tbody></table>";

    //ВЫВОДИМ МАССИВ ОТСЛЕЖИВАНИЯ ДОЛГА
    //НО СНАЧАЛА СОРТИРУЕМ
    usort($debt_track, 'date_compare');
    //И ПОТОМ ВЫВОДИМ
    echo "<pre>";
    /*print_r($debt_track);*/
    echo "</pre>";
    $result_track = "";

    $current_debt = 0;
    $current_debt += $last_year_debt;
    foreach($debt_track as $d_t){
        if($d_t['type'] == "Выдача"){$result_track .="<tr style='font-weight: bold'>";
        }
        else{$result_track .="<tr style='font-weight: bold'>";
        }

        //Делаем дату читаемой
        $phpdate = strtotime( $d_t['datetime'] );
        $mysqldate = date( 'd.m.y', $phpdate );

        $result_track .="<td>".$mysqldate."</td>";
        /*$result_track .="<td>".$d_t['type']."</td>";*/

        if($d_t['type'] == "Начисление"){
            $current_debt += $d_t['sum'];
            $result_track .="<td style='color: red';>+ ".number_format($d_t['sum'], 2, ',', ' ')."</td>";

            $order = ($d_t['order']);
            $phpdate = strtotime( $order['order_date'] );
            $mysqldate = date( 'd.m.y', $phpdate );
            $result_track .="<td><table class='order_events_track'><thead><tr><th>№ ".($order['1c_num']*1)."</th><th>".$mysqldate."</th><th>".number_format($order['order_sum'], 0, '.', ' ')."</th><th><input type='button' value='?' class='toggle_event_list'></th></tr></thead>";
            $result_track .="<tbody><tr><td colspan='4'><ul class='req_events_for_take'>";
            foreach($d_t['info'] as $key=>$value){
                    $result_track .= "<li>";
                    $phpdate = strtotime( $value['datetime'] );
                    $mysqldate = date( 'd.m', $phpdate );
                    $result_track .= "<span> ".$mysqldate."</span>";
                    $result_track .= "<span>  -  </span>";
                    $result_track .= "<span>".$value['type']." </span>";
                    $result_track .= "<span>".($value['info']['number']*1)." - </span>";
                    $result_track .= "<span>".number_format($value['sum'], 0, '.', ' ')."</span>";
                    $result_track .= "</li>";
            }
            $result_track .="</ul></td></tr></tbody></table>";
        }else{
            $current_debt -= $d_t['sum'];
            $result_track .="<td style='color: darkgreen';>- ".number_format($d_t['sum'], 2, ',', ' ')."</td><td>";
            foreach($d_t['info'] as $key=>$value){
                $result_track .="<span>".$value."</span>";
            }
            $result_track .="</td>";
        }
        //Показать Долг на дату события
        $result_track .="<td>".number_format($current_debt, 2, ',', ' ')."</td>";
        $result_track .="</tr>";
    }
    unset($debt_track);
    unset($current_debt);
    echo "<h2>Таблица изменения долга</h2>";
    echo "<table class='result_track'><thead><tr><th>Дата события</th><th>Начисление/Выдача</th><th>Счёт на оплату</th><th>Долг на дату события</th></tr></thead>";
    echo "<tr style='font-weight: bold'><td>Начало года</td><td></td><td></td><td>".number_format($last_year_debt, 2, ',', ' ')."</td></tr>";
    print $result_track;
    echo "</table>";
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

    switch($the_year)
    {
        case '2018':
            $text_2018 = number_format($total_togive, 2, ',', ' ');
            $debt_finish_line = "(2018) :".$text_2018;
            $total_debt = $total_togive + $getbyersinfo_fetched['debt_2019'] + $getbyersinfo_fetched['debt_2020'] + $getbyersinfo_fetched['debt_2021'] + $getbyersinfo_fetched['debt_2022'] + $getbyersinfo_fetched['debt_2023'];
            break;
        case '2019':
            $text_2018 = number_format($getbyersinfo_fetched['debt_2018'], 2, ',', ' ');
            $text_2019 = number_format($total_togive, 2, ',', ' ');
            $debt_finish_line = "(2018 + 2019) :".$text_2018." + ".$text_2019;
            $total_debt = $getbyersinfo_fetched['debt_2018'] + $total_togive + $getbyersinfo_fetched['debt_2020'] + $getbyersinfo_fetched['debt_2021'] + $getbyersinfo_fetched['debt_2022'] + $getbyersinfo_fetched['debt_2023'];
            break;
        case '2020':
            $text_2018 = number_format($getbyersinfo_fetched['debt_2018'], 2, ',', ' ');
            $text_2019 = number_format($getbyersinfo_fetched['debt_2019'], 2, ',', ' ');
            $text_2020 = number_format($total_togive, 2, ',', ' ');
            $debt_finish_line = "(2018 + 2019 + 2020) :".$text_2018." + ".$text_2019." + ".$text_2020;
            $total_debt = $getbyersinfo_fetched['debt_2018'] + $getbyersinfo_fetched['debt_2019'] + $total_togive + $getbyersinfo_fetched['debt_2021'] + $getbyersinfo_fetched['debt_2022'] + $getbyersinfo_fetched['debt_2023'];
            break;
        case '2021':
            $text_2018 = number_format($getbyersinfo_fetched['debt_2018'], 2, ',', ' ');
            $text_2019 = number_format($getbyersinfo_fetched['debt_2019'], 2, ',', ' ');
            $text_2020 = number_format($getbyersinfo_fetched['debt_2020'], 2, ',', ' ');
            $text_2021 = number_format($total_togive, 2, ',', ' ');
            $debt_finish_line = "(2018 + 2019 + 2020 + 2021) :".$text_2018." + ".$text_2019." + ".$text_2020." + ".$text_2021;
            $total_debt = $getbyersinfo_fetched['debt_2018'] + $getbyersinfo_fetched['debt_2019'] + $getbyersinfo_fetched['debt_2020'] + $total_togive + $getbyersinfo_fetched['debt_2022'] + $getbyersinfo_fetched['debt_2023'] ;
            break;
        case '2022':
            $text_2018 = number_format($getbyersinfo_fetched['debt_2018'], 2, ',', ' ');
            $text_2019 = number_format($getbyersinfo_fetched['debt_2019'], 2, ',', ' ');
            $text_2020 = number_format($getbyersinfo_fetched['debt_2020'], 2, ',', ' ');
            $text_2021 = number_format($getbyersinfo_fetched['debt_2021'], 2, ',', ' ');
            $text_2022 = number_format($total_togive, 2, ',', ' ');
            $debt_finish_line = "(2018 + 2019 + 2020 + 2021 + 2022) :".$text_2018." + ".$text_2019." + ".$text_2020." + ".$text_2021." + ".$text_2022;
            $total_debt = $getbyersinfo_fetched['debt_2018'] + $getbyersinfo_fetched['debt_2019'] + $getbyersinfo_fetched['debt_2020'] + $getbyersinfo_fetched['debt_2021']  + $total_togive + $getbyersinfo_fetched['debt_2023'];
            break;
        case '2023':
            $text_2018 = number_format($getbyersinfo_fetched['debt_2018'], 2, ',', ' ');
            $text_2019 = number_format($getbyersinfo_fetched['debt_2019'], 2, ',', ' ');
            $text_2020 = number_format($getbyersinfo_fetched['debt_2020'], 2, ',', ' ');
            $text_2021 = number_format($getbyersinfo_fetched['debt_2021'], 2, ',', ' ');
            $text_2022 = number_format($getbyersinfo_fetched['debt_2022'], 2, ',', ' ');
            $text_2023 = number_format($total_togive, 2, ',', ' ');
            $debt_finish_line = "(2018 + 2019 + 2020 + 2021 + 2022 + 2023) :".$text_2018." + ".$text_2019." + ".$text_2020." + ".$text_2021." + ".$text_2022." + ".$text_2023;
            $total_debt = $getbyersinfo_fetched['debt_2018'] + $getbyersinfo_fetched['debt_2019'] + $getbyersinfo_fetched['debt_2020'] + $getbyersinfo_fetched['debt_2021']  + $getbyersinfo_fetched['debt_2022'] + $total_togive;
            break;
    }
    echo "<h2>ОСТАЛОСЬ ВЫДАТЬ за текущий год: ".number_format($total_togive, 2, ',', ' ') ."</h2>";
    echo "<h2>ОБЩИЙ ДОЛГ : ".$debt_finish_line." = ". number_format($total_debt, 2, ',', ' ') ."</h2>";

    //После подсчета общего долга занести результат общего долга по году в базу к данному покупателю
    switch($the_year)
    {
        case '2018':
            $debt_2018 = $total_togive;
            $debt_2019 = $getbyersinfo_fetched['debt_2019'];
            $debt_2020 = $getbyersinfo_fetched['debt_2020'];
            $debt_2021 = $getbyersinfo_fetched['debt_2021'];
            $debt_2022 = $getbyersinfo_fetched['debt_2022'];
            break;
        case '2019':
            $debt_2018 = $getbyersinfo_fetched['debt_2018'];
            $debt_2019 = $total_togive;
            $debt_2020 = $getbyersinfo_fetched['debt_2020'];
            $debt_2021 = $getbyersinfo_fetched['debt_2021'];
            $debt_2022 = $getbyersinfo_fetched['debt_2022'];
            break;
        case '2020':
            $debt_2018 = $getbyersinfo_fetched['debt_2018'];
            $debt_2019 = $getbyersinfo_fetched['debt_2019'];
            $debt_2020 = $total_togive;
            $debt_2021 = $getbyersinfo_fetched['debt_2021'];
            $debt_2022 = $getbyersinfo_fetched['debt_2022'];
            break;
        case '2021':
            $debt_2018 = $getbyersinfo_fetched['debt_2018'];
            $debt_2019 = $getbyersinfo_fetched['debt_2019'];
            $debt_2020 = $getbyersinfo_fetched['debt_2020'];
            $debt_2021 = $total_togive;
            $debt_2022 = $getbyersinfo_fetched['debt_2022'];
            break;
        case '2022':
            $debt_2018 = $getbyersinfo_fetched['debt_2018'];
            $debt_2019 = $getbyersinfo_fetched['debt_2019'];
            $debt_2020 = $getbyersinfo_fetched['debt_2020'];
            $debt_2021 = $getbyersinfo_fetched['debt_2021'];
            $debt_2022 =  $total_togive;
            break;
        case '2023':
            $debt_2018 = $getbyersinfo_fetched['debt_2018'];
            $debt_2019 = $getbyersinfo_fetched['debt_2019'];
            $debt_2020 = $getbyersinfo_fetched['debt_2020'];
            $debt_2021 = $getbyersinfo_fetched['debt_2021'];
            $debt_2022 = $getbyersinfo_fetched['debt_2022'];
            $debt_2023 =  $total_togive;
            break;
    }
    $refreshbyersdebt = $pdo->prepare("UPDATE prices.byers SET `debt_2018` = ?, `debt_2019` = ?, `debt_2020` = ?, `debt_2021` = ?, `debt_2022` = ?, `debt_total`= ?  WHERE prices.byers.byers_id = ?");
    $dbs_array[0][0]->beginTransaction();
    $refreshbyersdebt->execute(array($debt_2018,$debt_2019,$debt_2020,$debt_2021,$debt_2022,$total_debt,$the_byer));
    $dbs_array[0][0]->commit();



    //Конец занесения в базу долга по году данного покупателя

};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*СПИСОК ПЛАТЕЖЕЙ И НАЧИСЛЕНИЙ В РАМКАХ ОДНОЙ ЗАЯВКИ///////////////////////////////////////////////////////*/
if (isset($_POST['the_request'])){
    try {
        $the_request = $_POST['the_request'];
        $onhands;

        $get_req_info = $database->prepare("SELECT created,req_sum,1c_num FROM `requests` WHERE requests_id=?");
        $get_payments = $database->prepare("SELECT payed,payments_id,number,sum,requestid FROM `payments` WHERE requestid=?");
        $get_executals = $database->prepare("SELECT * FROM `executes` LEFT JOIN requests r on executes.requests_uid = r.requests_uid WHERE r.requests_id=?");
        $get_positions = $database->prepare("SELECT pos_name, name, tare, kol, oh, firstoh, pricingid, req_positionid as position FROM (SELECT * FROM (SELECT trades_id,tare,name FROM trades LEFT JOIN allnames ON trades_nameid=nameid) AS a LEFT JOIN pricings ON a.trades_id=tradeid) AS b left join req_positions on b.pricingid=req_positions.winnerid WHERE req_positions.requestid=?");
        //Запросы для расценки
        $get_seller_name = $database->prepare("SELECT name, sellers_id FROM allnames LEFT JOIN sellers ON allnames.nameid = sellers.sellers_nameid LEFT JOIN pricings ON sellers_id=sellerid WHERE pricingid=?");

        $database->beginTransaction();
        $get_req_info->execute(array($the_request));
        $get_payments->execute(array($the_request));
        $get_executals->execute(array($the_request));
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

        if($get_executals->rowCount() == 0) {$result3 .= "<h3>Реализации</h3><span>Ничего еще не отгружено.</span>";
        }else {
            $result3="<h2>Реализации</h2><table><thead><tr><th>Дата</th><th>Номер накладной</th><th>Сумма отгрузки</th><th></th></tr></thead><tbody>";
            foreach ($get_executals as $row) {

                $phpdate = strtotime( $row['executed'] );
                $mysqldate = date( 'd.m.y', $phpdate );

                $result3 .= "<tr><td>" . $mysqldate . "</td><td>" . $row['execute_1c_num'] . "</td><td>" . $row['sum'] . "</td><td><input class='editexecute' database='".$db_text."' type='button' value='E' exec_id='".$row['executes_id']."' req_id='".$row['requests_uid']."'><input class='delexecute' database='".$db_text."' type='button' value='X' exec_id='".$row['executes_id']."' req_id='".$row['requests_uid']."'></td></tr>";
            };
            $result3 .= "</tbody></table>";
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

                if ($get_seller_name_fetched){
                    $result2 .= "<tr pricingid = ".$row['pricingid']." sellerid = '".$get_seller_name_fetched['sellers_id']."'><td><span>".$row['pos_name']."</span><br><br><span class='ga_trade' tare='".$row['tare']."'>" . $row['name'] . "</span> от <span class='ga_seller'>".$get_seller_name_fetched['name']."</span><input value='↑ E ↑' type='button' class='editpricing' position='".$row['position']."' pricing = '".$row['pricingid']."'></td><td>" . $row['kol'] . "</td><td>" . $onhands . "</td><td>" . round($row['kol'],2) * round($onhands,2) . "</td></tr>";
                }else{
                    //$result2 .= "<tr pricingid = ".$row['pricingid']." sellerid = '".$get_seller_name_fetched['sellers_id']."'><td><span>".$row['pos_name']."</span><br><br><span class='ga_trade' tare='".$row['tare']."'>" . $row['name'] . "</span> от <span class='ga_seller'>".$get_seller_name_fetched['name']."</span><input value='↑ E ↑' type='button' class='editpricing' position='".$row['position']."' pricing = '".$row['pricingid']."'></td><td>" . $row['kol'] . "</td><td>" . $onhands . "</td><td>" . round($row['kol'],2) * round($onhands,2) . "</td></tr>";
                    $result2 .= "<tr pricingid = ".$row['pricingid']." sellerid = 'NONE'><td><span>".$row['pos_name']."</span><br><br><span class='ga_trade' tare='".$row['tare']."'>" . $row['name'] . "</span> от <span class='ga_seller'>ПОСТАВЩИК НЕ ОПРЕДЕЛЕН</span><input value='↑ E ↑' type='button' class='editpricing' position='".$row['position']."' pricing = '".$row['pricingid']."'></td><td>" . $row['kol'] . "</td><td>" . $onhands . "</td><td>" . round($row['kol'],2) * round($onhands,2) . "</td></tr>";
                }


            };
            $result2 .= "</tbody></table>";
        };

        foreach($get_req_info as $row){
            $phpdate = strtotime( $row['created'] );
            $mysqldate = date( 'd.m.y', $phpdate );
            $result4 ="<h2 class='req_header'>Заказ от <span class='date'>".$mysqldate."</span> на сумму ".round($row['req_sum'],2).". Номер в 1С: <span class='1c_num'>".$row['1c_num']."</span><h2/>";
        }

        print(json_encode(array('data1'=>$result1,'data2'=>$result2, 'data3'=>$result3, 'data4'=>$result4)));

    }catch(PDOException $e) {$database->rollback();print "Error!: ".$e->getMessage()."<br/>".(int)$e->getCode( );}

};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////