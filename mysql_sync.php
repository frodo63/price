<?php

include_once 'pdo_connect.php';

//Скриптик для добавления byersid для всех выдач
//Получить все выдачи
/*$getg_a_s = $pdo->prepare("SELECT giveaways_id, requestid FROM giveaways");
$getbyersid = $pdo->prepare("SELECT byersid FROM requests WHERE requests_id = ?");
$setgabyersid = $pdo->prepare("UPDATE giveaways SET byersid=? WHERE requestid=?");

$getg_a_s->execute();
$getgas = $getg_a_s->fetchAll(PDO::FETCH_ASSOC);

foreach($getgas as $giveaway){
    //Получить byersid
    $getbyersid->execute(array($giveaway['requestid']));
    $byersid = $getbyersid->fetch(PDO::FETCH_ASSOC);
    //Изменить byersid выдачи
    $setgabyersid->execute(array($byersid['byersid'], $giveaway['requestid']));

}*/
//////////////////////////////////////////////////////////////////

function is_array_empty($array, $check_all_elements = false)
{
    if (!is_array($array) || empty($array))
        return true;

    $elements = count($array);
    foreach ($array as $element)
    {
        if (empty($element) || (is_array($element) && is_array_empty($element, $check_all_elements)))
        {
            if ($check_all_elements)
                return true;
            else $elements--;
        }
    }
    return empty($elements);
}

if(isset($_POST['sync_file'])){
    $sync = $_POST['sync_file'];
    $uid_column = $sync."_uid";
    //$path = 'files/sync_'.$sync.'.txt';
    $path = '/samba/allaccess/1111/sync_'.$sync.'.txt';
    $file = fopen($path,'r');



    $synched = array();
    $not_synched = array();

    switch ($sync){
        case "requests":
            if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0);
                echo"<p>Файл выгружен в массив</p>";

                $gotuid = $pdo->prepare("SELECT requests_uid FROM requests WHERE requests_uid = ?");
                $getbyer_name = $pdo->prepare("SELECT name, byers_id FROM byers LEFT JOIN allnames ON byers.byers_nameid = allnames.nameid WHERE byers_uid = ?");

                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[5],0,-2);
                    $created_trimmed = substr($temp_array[1],0,10);
                    $created_for_mysql = substr($temp_array[1],6,4).".".substr($temp_array[1],3,2).".".substr($temp_array[1],0,2);

                    try{

                        //Проверка на наличие такого uid  в базе
                        $gotuid->execute(array($uid_trimmed));
                        $getbyer_name->execute(array($temp_array[4]));
                        $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);
                        $gotname = $getbyer_name->fetch(PDO::FETCH_ASSOC);

                        $byers_name = $gotname['name'];
                        $byers_id = $gotname['byers_id'];


                    } catch( PDOException $Exception ) {
                        // Note The Typecast To An Integer!
                        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
                    }


                    //Если такой uid есть - ничего не делаем
                    if(is_string($gotsome['requests_uid']) && $uid_trimmed == $gotsome['requests_uid']){
                        //echo"<li> Уже в базе --- Заказ № ".$temp_array[0]." от ".$created_trimmed."</li>";
                        $synched[]="<li> Уже в базе --- Заказ № ".$temp_array[0]." от ".$created_trimmed."</li>";

                    }else{
                        //Выводим возможность соотнести и записать в базу
                        /*echo"<li><input type='text' class='sync_request'><div class='sres'></div>
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid onec_id=$temp_array[0] uid=$temp_array[5] byersid=$byers_id created=$created_for_mysql>
                                 <span class='sync_add_name'>Заказ ".$byers_name." № ".$temp_array[0]." от ".$created_trimmed."</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";*/

                        $not_synched[]="<li><input type='text' class='sync_request'><div class='sres'></div>                                 
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid onec_id=$temp_array[0] uid=$temp_array[5] byersid=$byers_id created=$created_for_mysql>
                                 <span class='sync_add_name'>Заказ ".$byers_name." № ".$temp_array[0]." от ".$created_trimmed."</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";
                    }
                }

                //Выводим божеский вид
                echo"<ul id='sinchronize_requests'>";

                foreach($not_synched as $n_s){echo $n_s;}
                foreach($synched as $s){echo $s;}

                echo "</ul>";

                unset($synched);
                unset($not_synched);

            }else{
                echo"<p>Файл НЕ найден</p>";
            }
            break;
        case "payments":
            if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0);
                echo"<p>Файл выгружен в массив</p>";

                $getuid = $pdo->prepare("SELECT payments_uid FROM payments WHERE payments_uid = ?");
                $getrequestid = $pdo->prepare("SELECT requests_id, 1c_num, created, req_sum FROM requests WHERE requests_uid = ?");
                $getpayments = $pdo->prepare("SELECT payed, onec_id, number, sum FROM payments WHERE requestid = ?");

                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    foreach($temp_array as $row){

                        $string = htmlentities($row[4], null, 'utf-8');
                        $content = str_replace("&nbsp;", "", $string);
                        $row[4] = html_entity_decode($content);
                    }

                    //Проверяем, есть ли платежка уже
                    $getuid->execute(array($temp_array[6]));
                    $gotsome = $getuid->fetch(PDO::FETCH_ASSOC);

                    //Проверяем, найден ли заказ
                    $getrequestid->execute(array($temp_array[5]));
                    $gotrid = $getrequestid->fetch(PDO::FETCH_ASSOC);

                    //Список платежек в заказе
                    $getpayments->execute(array($gotrid['requests_id']));
                    $gotpayments = $getpayments->fetchAll(PDO::FETCH_ASSOC);

                    $phpdate = strtotime( $gotrid['created'] );
                    $created_r = date( 'd.m.y', $phpdate );

                    $pay_list = "<div style='display: none; font-weight: bold' class='show_payments_list'><br><span>Заказ № ".$gotrid['1c_num']." от ".$created_r." на сумму ".$gotrid['req_sum']."</span><ul>";
                    foreach($gotpayments as $payment){

                        $phpdate = strtotime( $payment['payed'] );
                        $created = date( 'd.m.y', $phpdate );

                        $pay_list.="<li>".$created." № в 1С ".$payment['onec_id']." номер ".$payment['number']." на сумму ".$payment['sum']."</li>";
                    };
                    $pay_list .= "</ul></div>";

                    if( ! $gotrid){
                        if($temp_array[5] == "ДокументОснование этой платежки не является заказом"){
                            $rid = 'none';
                            $status = "<span style='color: blue'>ДокументОснование этой платежки не является заказом</span>";
                        }else{
                            $rid = 'none';
                            $status = "<span style='color: red'>Заказ не определен</span>";
                        }
                    }else{
                        $rid = $gotrid['requests_id'];
                        $status = "<span style='color: green'>Заказ найден</span>";
                    }

                    //Дата
                    $payed_trimmed = substr($temp_array[2],0,-8);
                    $payed_trimmed_for_mysql = substr($temp_array[2],6,4).".".substr($temp_array[2],3,2).".".substr($temp_array[2],0,2);

                    if (is_string($gotsome['payments_uid']) && $temp_array[6] == $gotsome['payments_uid']){
                        //echo"<li><span>Уже в базе № ".$temp_array[3]." от ".$payed_trimmed." на сумму ".$temp_array[4]." руб.</span>".$status."</li>";
                        $synched[]="<li><span>Уже в базе № ".$temp_array[3]." от ".$payed_trimmed." на сумму ".$temp_array[4]." руб.</span>".$status."</li>";

                    }else{
                        /*echo"<li>
                             <input type='text' class='sync_payment'><div class='sres'></div>
                             <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[6] payed=$payed_trimmed_for_mysql number=$temp_array[3] sum=$temp_array[4] requestid=$rid>
                             <span>№ ".$temp_array[3]." от ".$payed_trimmed." на сумму ".$temp_array[4]." руб.</span>".$status."
                             <input class='sync_add_to_base' type='button' value='+'>
                         </li>";*/

                        $not_synched[]="<li>
                             <input type='text' class='sync_payment'><div class='sres'></div>
                             <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[6] payed=$payed_trimmed_for_mysql number=$temp_array[3] sum=$temp_array[4] requestid=$rid>
                             <span>№ ".$temp_array[3]." от ".$payed_trimmed." на сумму ".$temp_array[4]." руб.</span>".$status."
                             <input class='sync_add_to_base' type='button' value='+'>
                             <input class='show_hide' type='button' value='?'>".$pay_list."
                             <br>
                         </li>";
                    }
                    unset($pay_list);
                }

                echo"<ul id='sinchronize_payments'>";

                foreach($not_synched as $n_s){echo $n_s;}
                foreach($synched as $s){echo $s;}

                echo"</ul>";

                unset($synched);
                unset($not_synched);

            }else{
                echo"<p>Файл НЕ найден</p>";
            }

            break;
        case "byers":
            if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0);
                echo"<p>Файл выгружен в массив: </p>";

                $gotuid = $pdo->prepare("SELECT `byers_uid` FROM `byers` WHERE `byers_uid` = ?");


                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[3],0,-2);

                    //Проверка на наличие такого uid  в базе
                    $gotuid->execute(array($uid_trimmed));
                    $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);

                    //Если такой uid есть - ничего не делаем
                    if(is_string($gotsome['byers_uid']) && $uid_trimmed == $gotsome['byers_uid']){
                        //echo"<li> Уже в базе --- ".$temp_array[1]."</li>";
                        $synched[]="<li> Уже в базе --- ".$temp_array[1]."</li>";
                        /*ничего не выводим*/

                    }else{
                        //Выводим возможность соотнести и записать в базу
                        /*echo"<li><input type='text' class='sync_byer'><div class='sres'></div>
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[3]>
                                 <span class='sync_add_name'>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";*/

                        $not_synched[]="<li><input type='text' class='sync_byer'><div class='sres'></div>                                 
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[3]>
                                 <span class='sync_add_name'>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";
                    }
                }

                //Выводим божеский вид
                echo"<ul id='sinchronize_byers'>";

                foreach($not_synched as $n_s){echo $n_s;}
                foreach($synched as $s){echo $s;}

                echo"</ul>";

                unset($synched);
                unset($not_synched);

            }else{
                echo"<p>Файл НЕ найден</p>";
            }
            break;
        case "sellers":
            if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0);
                echo"<p>Файл выгружен в массив: </p>";

                $gotuid = $pdo->prepare("SELECT `sellers_uid` FROM `sellers` WHERE `sellers_uid` = ?");


                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[3],0,-2);

                    //Проверка на наличие такого uid  в базе
                    $gotuid->execute(array($uid_trimmed));
                    $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);

                    //Если такой uid есть - ничего не делаем
                    if(is_string($gotsome['sellers_uid']) && $uid_trimmed == $gotsome['sellers_uid']){
                        //echo"<li> Уже в базе --- ".$temp_array[1]."</li>";
                        $synched[]="<li> Уже в базе --- ".$temp_array[1]."</li>";
                        /*ничего не выводим*/

                    }else{
                        //Выводим возможность соотнести и записать в базу
                        /*echo"<li><input type='text' class='sync_seller'><div class='sres'></div>
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[3]>
                                 <span class='sync_add_name'>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";*/

                        $not_synched[]="<li><input type='text' class='sync_seller'><div class='sres'></div>                                 
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[3]>
                                 <span class='sync_add_name'>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";
                    }
                }
                //Выводим божеский вид
                echo"<ul id='sinchronize_sellers'>";

                foreach($not_synched as $n_s){echo $n_s;}
                foreach($synched as $s){echo $s;}

                echo"</ul>";

                unset($synched);
                unset($not_synched);

            }else{
                echo"<p>Файл НЕ найден</p>";
            }
            break;
        case "trades":
            if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0);
                echo"<p>Файл выгружен в массив: </p>";

                $gotuid = $pdo->prepare("SELECT trades_uid, tare FROM trades WHERE trades_uid = ?");


                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[4],0,-2);

                    //Проверка на наличие такого uid  в базе
                    $gotuid->execute(array($uid_trimmed));
                    $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);

                    //Если такой uid есть - ничего не делаем
                    if(is_string($gotsome['trades_uid']) && $uid_trimmed == $gotsome['trades_uid']){
                        //echo"<li> Уже в базе --- ".$temp_array[1]."</li>";
                        $synched[]="<li> Уже в базе --- ".$temp_array[1]."(".$gotsome['tare'].") Ед. Изм.: ".$temp_array[2]." </li>";
                        /*ничего не выводим*/

                    }else{
                        //Выводим возможность соотнести и записать в базу
                        /*echo"<li><input type='text' class='sync_trade'><div class='sres'></div>
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[4]>
                                 <span class='sync_add_name'>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";*/

                        $not_synched[]="<li><input type='text' class='sync_trade'><div class='sres'></div>                                 
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[4]>
                                 <span class='sync_add_name'>$temp_array[1] в $temp_array[2]</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";
                    }
                }
                //Выводим божеский вид
                echo"<ul id='sinchronize_trades'>";

                foreach($not_synched as $n_s){echo $n_s;}
                foreach($synched as $s){echo $s;}

                echo"</ul>";

                unset($synched);
                unset($not_synched);
            }else{
                echo"<p>Файл НЕ найден</p>";
            }
            break;
        case "positions":
            if ($file){

                $req_positions = array();

                $gettradename = $pdo->prepare("SELECT name, trades_id FROM trades LEFT JOIN allnames a on trades.trades_nameid = a.nameid WHERE trades_uid = ?");
                $gettradename_tradeid = $pdo->prepare("SELECT name FROM trades LEFT JOIN allnames a on trades.trades_nameid = a.nameid WHERE trades_id = ?");
                $getreqnum = $pdo->prepare("SELECT 1c_num, name, created, requests_id FROM requests LEFT JOIN byers ON requests.byersid = byers_id LEFT JOIN allnames on byers_nameid = allnames.nameid WHERE requests_uid = ?");
                $getpositions = $pdo->prepare("SELECT pos_name, line_num, req_positionid FROM req_positions LEFT JOIN requests ON requestid = requests_id WHERE requests_uid = ? ORDER BY line_num ASC");
                $getpricings = $pdo->prepare("SELECT pricingid, tradeid, price, sellerid FROM pricings WHERE positionid = ?");
                $getsellername = $pdo->prepare("SELECT name FROM pricings LEFT JOIN sellers on sellerid=sellers_id LEFT JOIN allnames a on sellers.sellers_nameid = a.nameid WHERE pricingid = ?");
                $chk_pos=$pdo->prepare("SELECT line_num FROM req_positions WHERE (`requestid` = ? AND `line_num` = ?)");

                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0);
                echo"<p>Файл выгружен в массив: </p>";

                //echo"<input type='button' class='add1s' value='Добавить единички в базу'>";

                //Строку в массив
                foreach ($file_array as $k => $v){

                    /*ФУНКЦИЯ ДЛЯ УДАЛЕНИЯ &NBSP КОТОРАЯ РАБОТАЕТ!!!*/
                    $string = htmlentities($v, null, 'utf-8');
                    $content = str_replace("&nbsp;", "", $string);
                    $v = html_entity_decode($content);

                    $t_a = explode(';',$v);
                    $file_array_trimmed[$k]=[$t_a];
                }

                //Массив для дубрилующих элементво массива. Сюда удут стекаться ключи и он будет ограничивать проход по массиву
                $a2del = array();
                //Всякое с массивом
                foreach($file_array_trimmed as $k2 => $v2){
                    foreach ($file_array_trimmed as $k2del => $v2del){
                        if($k2 !== $k2del && !in_array($k2, $a2del)){
                            if ($v2[0][1] == $v2del[0][1]){
                                //Тут действие замены
                                $file_array_trimmed[$k2][] = $v2del[0];

                                //Копим ключи дублирующих элементов массива
                                $a2del[]=$k2del;
                            }
                        }
                    }
                }
                //Удаляем дублирующие элементы массива
                foreach ($a2del as $a2del){
                    unset($file_array_trimmed[$a2del]);
                }

                //Выводим божеский вид
                echo"<ul id='sinchronize_positions'>";

                //echo "<pre>";
                //print_r($file_array_trimmed);
                //echo "</pre>";

                //Рисование из массива
                foreach ($file_array_trimmed as $k=>$v){
                    $getreqnum->execute(array($v[0][1]));
                    $gotreqnum = $getreqnum->fetch(PDO::FETCH_ASSOC);

                    echo "<li rid='" . $gotreqnum['requests_id'] . "'><ul>";
                    $phpdate = strtotime( $gotreqnum['created'] );
                    $created = date( 'd.m.y', $phpdate );

                    $getpositions->execute(array($v[0][1]));
                    $gotpositions = $getpositions->fetchAll(PDO::FETCH_ASSOC);

                    echo "<span><strong>Заказ № " . $gotreqnum['1c_num'] . "</strong> от " . $created . " для ".$gotreqnum['name']."</span>";

                    foreach ($file_array_trimmed[$k] as $inner_v){
                        $gettradename->execute(array($inner_v[6]));
                        $gottradename = $gettradename->fetch(PDO::FETCH_ASSOC);

                        echo "<li><span>" . $inner_v[2] . ". </span><span class='pn'>" . $gottradename['name'] . " в количестве  " . $inner_v[4] . $inner_v[3] . " по цене " . $inner_v[7] . " руб. на сумму " . $inner_v[8] . " руб.</span>";

                        $chk_pos->execute(array($gotreqnum['requests_id'], $inner_v[2]));
                        $checked = $chk_pos->fetch(PDO::FETCH_ASSOC);
                        if(!$checked['line_num']){
                            echo "<input class='sync_add_to_base' price = '" . $inner_v[7] . "' kol = '" . $inner_v[4] . "' tradeid = '" . $gottradename['trades_id'] . "' type='button' value='+' linenum = '" . $inner_v[2] . "' requests_id='" . $gotreqnum['requests_id'] . "'>";
                        };

                        echo "</li>";
                    }

                    //Тут проверка: Если в данной заявке ЕСТЬ позиции, мы их рисуем, "А в базе уже есть". Другого варианта не предусмотрено.
                    if(!is_array_empty($gotpositions)){
                        echo "<li style='color: green'><br><span>А в базе уже есть: </span></li>";
                        foreach ($gotpositions as $pos){
                            $getpricings->execute(array($pos['req_positionid']));
                            $pricings = $getpricings->fetchAll(PDO::FETCH_ASSOC);

                            echo "<li style='color: green'>".$pos['line_num'] . ". " . $pos['pos_name'] . "</li>";

                            //В зависимости от переменной $pricings выводим либо раценки, которые найдены в базе, либо плюсик для ввода расценки.
                            if(!is_array_empty($pricings)){
                                //Выводим расценки
                                echo "<ul>";
                                foreach($pricings as $pricing){
                                    $gettradename_tradeid->execute(array($pricing['tradeid']));
                                    $gottradename_tradeid = $gettradename_tradeid->fetch(PDO::FETCH_ASSOC);

                                    $getsellername->execute(array($pricing['pricingid']));
                                    $gotsellername = $getsellername->fetch(PDO::FETCH_ASSOC);

                                    echo "<li>Расценка № " . $pricing['pricingid']." ".$gottradename_tradeid['name']." по цене ".$pricing['price'] . " руб. от " . $gotsellername['name'] . "</li>";
                                }
                                echo"</ul>";
                            }else{
                                //И в кнопке должны быть все переменные для добавления расценки
                                //Расценки нет, и все данные для добаления расценки надо взять откудато. Из позиции больше не от куда.

                                $pos_lnum = $pos['line_num']-1;
                                $pos_trade_uid = $v[$pos_lnum][6];
                                $gettradename->execute(array($pos_trade_uid));
                                $gottradename=$gettradename->fetch(PDO::FETCH_ASSOC);
                                echo "<input type='button' requestid = '" . $gotreqnum['requests_id'] . "' req_positionid = '" . $pos['req_positionid'] . "' price = '" . $v[$pos_lnum][7] . "' kol = '" . $v[$pos_lnum][4] . "' tradeid = '" . $gottradename['trades_id'] . "'  class='sync_addpricing' value='+Превратить позицию в расценку'>";

                            }

                        }
                    };
                    echo "<br><br><br></ul></li>";
                }
                echo"</ul>";
            }else{
                echo"<p>Файл НЕ найден</p>";
            }
            break;
    }

    //$file = "files/sync_requests.txt";
    //$requests_list = array();
    //$temp_array = array();
}

/*Код для формы добавления разного*/
if(isset($_POST['sync_html'])){
    $sync = $_POST['sync_html'];

    switch ($sync){
        case "requests":
            echo"<div class='creates'>
                    <label for='src'>Дата заказа:</label><span class='sync_req_created' name='src'></span><br>                
                    <label for='sru'>Уникальный идентификатор:</label><span class='sync_req_uid' name='sru'></span><br>                
                    <label for='srb'>Код Покупателя:</label><span class='sync_req_byers_id' name='srb'></span><br>                
                    <label for='srn'>Номер в 1С:</label><span class='sync_req_onec_id' name='srn'></span><br>                
                    <input type='button' name='requests' created bid uid onec_id value='Добавить заявку' disabled>
                </div>";
            break;
        case "positions":
            echo"<div>              
                    <label for='spr'>Код Заказа:</label><span class='sync_pos_requestid' name='spr'></span><br>                
                    <label for='spn'>Имя позиции:</label><span class='sync_pos_pos_name' name='spn'></span><br>                
                    <label for='spl'>Номер строки:</label><span class='sync_pos_line_num' name='spl'></span><br>                
                    <label for='spp'>Цена:</label><span class='sync_pos_price' name='spp'></span><br>                
                    <label for='spk'>Количество:</label><span class='sync_pos_kol' name='spk'></span><br>                
                    <label for='spt'>Товар:</label><span class='sync_pos_tradeid' name='spt'></span><br>                
                    <input class='addpos' type='button' price kol tradeid linenum name='positions' requestid posname value='Добавить позицию' disabled>
                </div>";
            break;
        case "payments":
            echo"<div class='creates'>
                    <label for='spp'>Дата платежа:</label><span class='sync_pay_payed' name='spp'></span><br>                
                    <label for='spnum'>№ п/п:</label><span class='sync_pay_num' name='spnum'></span><br>                           
                    <label for='srn'>Номер в 1С:</label><span class='sync_pay_onec_id' name='spn'></span><br>   
                    <label for='spu'>Уникальный идентификатор:</label><span class='sync_pay_uid' name='spu'></span><br>             
                    <label for='sps'>Сумма:</label><span class='sync_pay_sum' name='sps'></span><br>             
                    <label for='sprid'>Внутренный код заказа:</label><span class='sync_pay_rid' name='sprid'></span><br>
                    <span class='ready_comment'></span><br>             
                    <input type='button' name='payments' payed number sum uid onec_id requestid value='Добавить платежку' disabled>
              </div>";
            break;
        case "byers":
            echo"<div class='creates add_ramk'>
                <input class='add_byer_name' type='text' placeholder='Введите наименование Покупателя' size='40'>
                <br><span class='ready_comment'></span><br>  
                <input type='button' tc='1' name='byers' value='Добавить' uid onec_id disabled>
                </div>";
            break;
        case "sellers":
            echo"<div class='creates'>
                <input class='add_seller_name' type='text' placeholder='Введите наименование Поставщика' size='40'>
                <br><span class='ready_comment'></span><br>  
                <input type='button' tc='2' name='sellers' value='Добавить' uid onec_id disabled>
                </div>";
            break;
        case "trades":
            echo"<div class ='creates'>
                <br><input class='add_trade_name' type='text' placeholder='Введите наименование Товара' size='40'>
                <br><span>Тара:</span><span class='trade_options_tare'></span><br>
                <select class='add_trade_tare' size='1'>
                <option value='штука'>штука (по умолчанию л/кг/тн)</option>
                <option value='банка'>банка (до 5кг)</option>
                <option value='канистра'>канистра (5-50л)</option>
                <option value='бочка'>бочка(200л)</option>
                </select><br>
                <span class='ready_comment'></span><br>
                <input  type='button' name='trades' value='Добавить' disabled uid onec_id><br><br></div>";
            break;}
}

/*Собственно соотнесение*/
if (isset($_POST['innerid']) && isset($_POST['uid']) && isset($_POST['table']) && isset($_POST['onec_id'])){
    try {
        switch ($_POST['table']) {
            case "requests":
                $statement=$pdo->prepare("UPDATE requests SET `requests_uid`=:uid, `1c_num`=:onec_id WHERE `requests_id`=:innerid");
                break;
            case "byers":
                $statement=$pdo->prepare("UPDATE byers SET `byers_uid`=:uid, `onec_id`=:onec_id WHERE `byers_id`=:innerid");
                break;
            case "sellers":
                $statement=$pdo->prepare("UPDATE sellers SET `sellers_uid`=:uid, `onec_id`=:onec_id WHERE `sellers_id`=:innerid");
                break;
            case "trades":
                $statement=$pdo->prepare("UPDATE trades SET `trades_uid`=:uid, `onec_id`=:onec_id WHERE `trades_id`=:innerid");
                break;
            case "payments":
                $statement=$pdo->prepare("UPDATE payments SET `payments_uid`=:uid, `onec_id`=:onec_id WHERE `payments_id`=:innerid");
                break;
        }

        $innerid = $_POST['innerid'];
        $uid = $_POST['uid'];
        $onec_id = $_POST['onec_id'];

        $statement->bindValue(':uid', $uid);
        $statement->bindValue(':innerid', $innerid);
        $statement->bindValue(':onec_id', $onec_id);

        $pdo->beginTransaction();
        $statement->execute();
        $pdo->commit();

        echo "Соотнесение успешно.";


    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
}

/*Обновление одной позиции после добавления позиции или расценки*/
if(isset($_POST['synched_request'])){
    try{
    $rid = $_POST['synched_request'];

    $getreqnum=$pdo->prepare("SELECT 1c_num, created, name, requests_uid FROM requests LEFT JOIN byers ON byersid=byers_id LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid WHERE requests_id=?");
    $getpositions=$pdo->prepare("SELECT pos_name, line_num, req_positionid FROM req_positions WHERE requestid=? ORDER BY line_num ASC");
    $gettradename = $pdo->prepare("SELECT name, trades_id FROM trades LEFT JOIN allnames a on trades.trades_nameid = a.nameid WHERE trades_uid = ?");
    $getpricings = $pdo->prepare("SELECT pricingid, tradeid, kol, price FROM pricings WHERE positionid = ?");
    $gettradename_tradeid = $pdo->prepare("SELECT name FROM trades LEFT JOIN allnames a on trades.trades_nameid = a.nameid WHERE trades_id = ?");
    $getsellername = $pdo->prepare("SELECT name FROM pricings LEFT JOIN sellers on sellerid=sellers_id LEFT JOIN allnames a on sellers.sellers_nameid = a.nameid WHERE pricingid = ?");
    $chk_pos=$pdo->prepare("SELECT line_num FROM req_positions WHERE (`requestid` = ? AND `line_num` = ?)");


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //Фaйл в массив
            $path = '/samba/allaccess/1111/sync_positions.txt';
            $file = fopen($path,'r');
            $file_array = file($path); // Считывание файла в массив $file_array

            //Строку в массив
            foreach ($file_array as $k => $v){

                //ФУНКЦИЯ ДЛЯ УДАЛЕНИЯ &NBSP КОТОРАЯ РАБОТАЕТ!!!
                $string = htmlentities($v, null, 'utf-8');
                $content = str_replace("&nbsp;", "", $string);
                $v = html_entity_decode($content);

                $t_a = explode(';',$v);
                $file_array_trimmed[$k]=[$t_a];
            }
            //Массив для дубрилующих элементво массива. Сюда удут стекаться ключи и он будет ограничивать проход по массиву
            $a2del = array();
            //Всякое с массивом
            foreach($file_array_trimmed as $k2 => $v2){
                foreach ($file_array_trimmed as $k2del => $v2del){
                    if($k2 !== $k2del && !in_array($k2, $a2del)){
                        if ($v2[0][1] == $v2del[0][1]){
                            //Тут действие замены
                            $file_array_trimmed[$k2][] = $v2del[0];
                            //Копим ключи дублирующих элементов массива
                            $a2del[]=$k2del;
                        }
                    }
                }
            }
            //Удаляем дублирующие элементы массива
            foreach ($a2del as $a2del){
                unset($file_array_trimmed[$a2del]);
            }


        //Рисование из массива


        $getreqnum->execute(array($rid));
        $gotreqnum=$getreqnum->fetch(PDO::FETCH_ASSOC);

        foreach ($file_array_trimmed as $k=>$v){
            if($v[0][1] == $gotreqnum['requests_uid']){

                $thehtml = "<ul>";

                $phpdate = strtotime( $gotreqnum['created'] );
                $created = date( 'd.m.y', $phpdate );

                //Рисуем первую строку
                $thehtml .= "<span><strong>Заказ № " . $gotreqnum['1c_num'] . "</strong> от " . $created . " для ".$gotreqnum['name']."</span>";

                //Рисуем позиции
                foreach ($file_array_trimmed[$k] as $inner_v){
                    $gettradename->execute(array($inner_v[6]));
                    $gottradename = $gettradename->fetch(PDO::FETCH_ASSOC);

                    $thehtml .= "<li><span>" . $inner_v[2] . ". </span><span class='pn'>" . $gottradename['name'] . " в количестве  " . $inner_v[4] . $inner_v[3] . " по цене " . $inner_v[7] . " руб. на сумму " . $inner_v[8] . " руб.</span>";

                    $chk_pos->execute(array($rid, $inner_v[2]));
                    $checked = $chk_pos->fetch(PDO::FETCH_ASSOC);
                    if(!$checked['line_num']){
                        $thehtml .= "<input class='sync_add_to_base' price = '" . $inner_v[7] . "' kol = '" . $inner_v[4] . "' tradeid = '" . $gottradename['trades_id'] . "' type='button' value='+' linenum = '" . $inner_v[2] . "' requests_id='" . $rid . "'>";
                    };

                    $thehtml .= "</li>";
                }

                //Тут проверка: Если в данной заявке ЕСТЬ позиции, мы рисуем, "А в базе уже есть". Другого варианта не предусмотрено.

                $getpositions->execute(array($rid));
                $gotpositions=$getpositions->fetchAll(PDO::FETCH_ASSOC);
                if(!is_array_empty($gotpositions)){
                    $thehtml .= "<li style='color: green'><br><span>А в базе уже есть: </span></li>";
                    foreach ($gotpositions as $pos){
                        $getpricings->execute(array($pos['req_positionid']));
                        $gotpricings = $getpricings->fetchAll(PDO::FETCH_ASSOC);

                        $thehtml .= "<li style='color: green'>".$pos['line_num'] . ". " . $pos['pos_name'] . "</li>";

                        //В зависимости от переменной $pricings выводим либо раценки, которые найдены в базе, либо плюсик для ввода расценки.
                        if(!is_array_empty($gotpricings)){
                            //Выводим расценки
                            $thehtml .= "<ul>";
                            foreach($gotpricings as $pricing){
                                $gettradename_tradeid->execute(array($pricing['tradeid']));
                                $gottradename_tradeid = $gettradename_tradeid->fetch(PDO::FETCH_ASSOC);

                                $getsellername->execute(array($pricing['pricingid']));
                                $gotsellername = $getsellername->fetch(PDO::FETCH_ASSOC);

                                $thehtml .= "<li>Расценка № " . $pricing['pricingid']." ".$gottradename_tradeid['name']." по цене ".$pricing['price'] . " руб. от " . $gotsellername['name'] . "</li>";
                            }
                            $thehtml .= "</ul>";
                        }else{
                            //И в кнопке должны быть все переменные для добавления расценки
                            //Расценки нет, и все данные для добаления расценки надо взять откудато. Из позиции больше не от куда.

                            $pos_lnum = $pos['line_num']-1;
                            $pos_trade_uid = $v[$pos_lnum][6];
                            $gettradename->execute(array($pos_trade_uid));
                            $gottradename=$gettradename->fetch(PDO::FETCH_ASSOC);
                            $thehtml .= "<input type='button' requestid = '" . $rid . "' req_positionid = '" . $pos['req_positionid'] . "' price = '" . $v[$pos_lnum][7] . "' kol = '" . $v[$pos_lnum][4] . "' tradeid = '" . $gottradename['trades_id'] . "'  class='sync_addpricing' value='+Превратить позицию в расценку'>";
                        }
                    }
                };
                $thehtml .= "<br><br><br></ul></li>";
            }
        }
    print $thehtml;
} catch( PDOException $Exception ) {
    // Note The Typecast To An Integer!
    $pdo->rollback();
    throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
}


}