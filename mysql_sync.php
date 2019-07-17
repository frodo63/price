<?php

include_once 'pdo_connect.php';


//Скриптик для добавления byersid для всех выдач
//Получить все выдачи
/*$getg_a_s = $database->prepare("SELECT giveaways_id, requestid FROM giveaways");
$getbyersid = $database->prepare("SELECT byersid FROM requests WHERE requests_id = ?");
$setgabyersid = $database->prepare("UPDATE giveaways SET byersid=? WHERE requestid=?");

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
function in_multi_array($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_multi_array($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

if(isset($_POST['sync_file'])){
    $sync = $_POST['sync_file'];
    $path = '/samba/allaccess/1111/sync_'.$sync.'.txt';

    if (file_exists($path)) {
        echo "<br><span>В последний раз файл $sync был изменен: " . date('d.m.y H:i:s', filemtime($path))."</span>";
    }

    $file = fopen($path,'r');

    $synched = array();
    $not_synched = array();

    switch ($sync){
        case "requests":
        case "ip_requests":
            if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0);
                echo"<p>Файл выгружен в массив</p>";

                $gotuid = $database->prepare("SELECT requests_uid FROM requests WHERE requests_uid = ?");
                $getbyer_name = $database->prepare("SELECT name, byers_id FROM byers LEFT JOIN allnames ON byers.byers_nameid = allnames.nameid WHERE byers_uid = ?");

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
                        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
                    }


                    //Если такой uid есть - ничего не делаем
                    if(is_string($gotsome['requests_uid']) && $uid_trimmed == $gotsome['requests_uid']){
                        //echo"<li> Уже в базе --- Заказ № ".$temp_array[0]." от ".$created_trimmed."</li>";
                        $synched[]="<li> Уже в базе --- Заказ № ".$temp_array[0]." от ".$created_trimmed."</li>";

                    }else{
                        //Выводим возможность соотнести и записать в базу
                        /*$not_synched[]="<li><input type='text' class='sync_request'><div class='sres'></div>
                                 <input type='button' table='requests' class='sync_to_base' value='Соотнести' innerid onec_id=$temp_array[0] uid=$temp_array[5] byersid=$byers_id created=$created_for_mysql>
                                 <span class='sync_add_name'>Заказ ".$byers_name." № ".$temp_array[0]." от ".$created_trimmed."</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";*/
                        $not_synched[]="<li>
                                 <span class='sync_add_name'>Заказ ".$byers_name." № ".$temp_array[0]." от ".$created_trimmed."</span><input table='requests' innerid onec_id=$temp_array[0] uid=$temp_array[5] byersid=$byers_id created=$created_for_mysql class='sync_add_to_base' type='button' value='+'>
                             </li>";
                    }
                }

                //Выводим божеский вид
                switch ($sync) {
                    case "requests":
                        echo "<ul id='sinchronize_requests'>";
                        break;
                    case "ip_requests":
                        echo "<ul id='sinchronize_ip_requests'>";
                        break;
                }

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
        case "ip_payments":
            if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0);
                echo"<p>Файл выгружен в массив</p>";

                $getuid = $database->prepare("SELECT payments_uid FROM payments WHERE payments_uid = ?");
                $getrequestid = $database->prepare("SELECT requests_id, 1c_num, created, req_sum,name FROM requests r LEFT JOIN byers b ON r.byersid=b.byers_id LEFT JOIN allnames a on b.byers_nameid = a.nameid WHERE requests_uid = ?");
                $getpayments = $database->prepare("SELECT payed, onec_id, number, sum FROM payments WHERE requestid = ?");

                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    foreach($temp_array as $row_tr){

                        $string = htmlentities($row_tr[4], null, 'utf-8');
                        $content = str_replace("&nbsp;", "", $string);
                        $row_tr[4] = html_entity_decode($content);
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
                        $status = "<span style='color: green'>Заказ найден:</span><span>".$gotrid['name']." - ".$gotrid['1c_num']." от ".$gotrid['created']."</span>";
                    }

                    //Дата
                    $payed_trimmed = substr($temp_array[2],0,-8);
                    $payed_trimmed_for_mysql = substr($temp_array[2],6,4).".".substr($temp_array[2],3,2).".".substr($temp_array[2],0,2);

                    if (is_string($gotsome['payments_uid']) && $temp_array[6] == $gotsome['payments_uid']){
                        //echo"<li><span>Уже в базе № ".$temp_array[3]." от ".$payed_trimmed." на сумму ".$temp_array[4]." руб.</span>".$status."</li>";
                        $synched[]="<li><span>Уже в базе № ".$temp_array[3]." от ".$payed_trimmed." на сумму ".$temp_array[4]." руб.</span>".$status."</li>";

                    }else{
                        /*$not_synched[]="<li>
                             <input type='text' class='sync_payment'><div class='sres'></div>
                             <input type='button' table='payments' class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[6] payed=$payed_trimmed_for_mysql number=$temp_array[3] sum=$temp_array[4] requestid=$rid>
                             <span>№ ".$temp_array[3]." от ".$payed_trimmed." на сумму ".$temp_array[4]." руб.</span>".$status."
                             <input class='sync_add_to_base' type='button' value='+'>
                             <input class='show_hide' type='button' value='?'>".$pay_list."
                             <br>
                         </li>";*/
                        $not_synched[]="<li>
                             <span>№ ".$temp_array[3]." от ".$payed_trimmed." на сумму ".$temp_array[4]." руб.</span>".$status."
                             <input class='sync_add_to_base' type='button' value='+' table='payments' innerid  onec_id=$temp_array[0] uid=$temp_array[6] payed=$payed_trimmed_for_mysql number=$temp_array[3] sum=$temp_array[4] requestid=$rid>
                             <input class='show_hide' type='button' value='?'>".$pay_list."
                             <br>
                         </li>";
                    }
                    unset($pay_list);
                }

                //Выводим божеский вид
                switch ($sync) {
                    case "payments":
                        echo "<ul id='sinchronize_payments'>";
                        break;
                    case "ip_payments":
                        echo "<ul id='sinchronize_ip_payments'>";
                        break;
                }

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
                $gotuid = $database->prepare("SELECT `byers_uid` FROM `byers` WHERE `byers_uid` = ?");


                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[3],0,-2);

                    //Проверка на наличие такого uid  в базе
                    $gotuid->execute(array($uid_trimmed));
                    $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);

                    //Если такой uid есть - ничего не делаем
                    if(is_string($gotsome['byers_uid']) && $uid_trimmed == $gotsome['byers_uid']){
                        $synched[]="<li> Уже в базе --- ".$temp_array[1]."</li>";
                    }else{
                        //Выводим возможность соотнести и записать в базу
                        $not_synched[]="<li><input type='text' class='sync_byer'><div class='sres'></div>
                                 <span class='sync_add_name'>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+' table='byers' innerid  onec_id=$temp_array[0] uid=$temp_array[3]>
                             </li>";
                    }
                }

                //Выводим божеский вид
                echo "<ul id='sinchronize_byers'>";


                foreach($not_synched as $n_s){echo $n_s;}
                foreach($synched as $s){echo $s;}

                echo"</ul>";

                unset($synched);
                unset($not_synched);

            }else{
                echo"<p>Файл НЕ найден</p>";
            }
            break;
        case "ip_byers":
            if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0);
                echo"<p>Файл выгружен в массив: </p>";
                //Попутно проверить, а есть ли в базе ltk упоминание на этот итем из базы ip?

                $got_ip_uid = $pdo->prepare("SELECT `ip_uid` FROM `byers` WHERE `ip_uid` = ?");
                $gotuid = $pdoip->prepare("SELECT `byers_uid` FROM `byers` WHERE `byers_uid` = ?");


                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[3],0,-2);

                    //Проверка на наличие такого uid  в базе
                    $gotuid->execute(array($uid_trimmed));
                    $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);

                    $got_ip_uid->execute(array($uid_trimmed));
                    $got_ip_some = $got_ip_uid->fetch(PDO::FETCH_ASSOC);

                    //Если такой uid есть - ничего не делаем
                    if(is_string($gotsome['byers_uid']) && $uid_trimmed == $gotsome['byers_uid']){
                        $synched[]="<li> Уже в базе --- ".$temp_array[1]."</li>";
                    }else{
                        //Выводим возможность соотнести и записать в базу
                        $not_synched[]="<li><input type='text' class='sync_byer'><div class='sres'></div>                                 
                                 <span class='sync_add_name'>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+' table='byers' innerid  onec_id=$temp_array[0] uid=$temp_array[3]>
                             </li>";
                    }
                };

                //Выводим божеский вид
                echo "<ul id='sinchronize_ip_byers'>";


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

                $gotuid = $database->prepare("SELECT `sellers_uid` FROM `sellers` WHERE `sellers_uid` = ?");


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
                        $not_synched[]="<li><input type='text' class='sync_seller'><div class='sres'></div>
                                 <span class='sync_add_name'>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+' table='sellers' innerid  onec_id=$temp_array[0] uid=$temp_array[3]>
                             </li>";
                    }
                }
                //Выводим божеский вид
                switch ($sync) {
                    case "sellers":
                        echo "<ul id='sinchronize_sellers'>";
                        break;
                    case "ip_sellers":
                        echo "<ul id='sinchronize_ip_sellers'>";
                        break;
                }


                foreach($not_synched as $n_s){echo $n_s;}
                foreach($synched as $s){echo $s;}

                echo"</ul>";

                unset($synched);
                unset($not_synched);

            }else{
                echo"<p>Файл НЕ найден</p>";
            }
            break;
        case "ip_sellers":
            if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0);
                echo"<p>Файл выгружен в массив: </p>";

                $gotuid = $pdo->prepare("SELECT `ip_uid` FROM `sellers` WHERE `ip_uid` = ?");
                $gotuid = $pdoip->prepare("SELECT `sellers_uid` FROM `sellers` WHERE `sellers_uid` = ?");


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
                        $not_synched[]="<li><input type='text' class='sync_seller'><div class='sres'></div>                                 
                                 <span class='sync_add_name'>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+' table='sellers' innerid  onec_id=$temp_array[0] uid=$temp_array[3]>
                             </li>";
                    }
                }
                //Выводим божеский вид
                switch ($sync) {
                    case "sellers":
                        echo "<ul id='sinchronize_sellers'>";
                        break;
                    case "ip_sellers":
                        echo "<ul id='sinchronize_ip_sellers'>";
                        break;
                }


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

                $gotuid = $database->prepare("SELECT trades_uid, tare FROM trades WHERE trades_uid = ?");


                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[4],0,-2);

                    //Логика такая:
                    //1. Если в ltk такого uid нет -           Соотносим с ltk вручную, проверяем, есть ли такая болванка
                    //2. Если в ltk нашлась болванка -         Добавляем в болванку uid и 1c_num
                    //3. Если в ltk не нашлась болванка -      Заносим новый итем

                    //Проверка на наличие такого uid  в базе
                    $gotuid->execute(array($uid_trimmed));
                    $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);

                    //Если такой uid есть - ничего не делаем
                    if(is_string($gotsome['trades_uid']) && $uid_trimmed == $gotsome['trades_uid']){
                        $synched[]="<li> Уже в базе --- ".$temp_array[1]."(".$gotsome['tare'].") Ед. Изм.: ".$temp_array[2]." </li>";
                        //Тут можно вывести, с кем итем соотнесен

                    }else{
                        //Выводим возможность соотнести и записать в базу
                        //В результатах поиска при соотнесении будут выскакивать только болванки. Чтоб не запутаться
                        $not_synched[]="<li><input type='text' class='sync_trade'><div class='sres'></div>
                                 <span class='sync_add_name'>$temp_array[1] в $temp_array[2]</span><input class='sync_add_to_base' type='button' value='+' table='trades' innerid  onec_id=$temp_array[0] uid=$temp_array[4]>
                             </li>";
                    }
                }
                //Выводим божеский вид
                switch ($sync) {
                    case "trades":
                        echo "<ul id='sinchronize_trades'>";
                        break;
                    case "ip_trades":
                        echo "<ul id='sinchronize_ip_trades'>";
                        break;
                }

                foreach($not_synched as $n_s){echo $n_s;}
                foreach($synched as $s){echo $s;}

                echo"</ul>";

                unset($synched);
                unset($not_synched);
            }else{
                echo"<p>Файл НЕ найден</p>";
            }
            break;
        case "ip_trades":
            if ($file){
                //Логика такая:
                //1. Если в ip такого uid нет -                    Заносим в ip
                //2. Если в ip такой uid есть -                    Проверяем, есть ли в ltk такой ip_uid
                //3. Если в ltk такого ip_uid нет -                Соотносим с ltk вручную
                //4. Если с ltk соотнести не удалось -             Заносим в ltk болванку(итем без uid и 1c_num) и добавляем в нее наш ip_uid

                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0);
                echo"<p>Файл выгружен в массив: </p>";

                $gotuid = $pdoip->prepare("SELECT trades_uid, tare FROM trades WHERE trades_uid = ?");
                $got_sync = $pdo->prepare("SELECT trades_id, trades_uid, tare FROM trades WHERE ip_uid = ?");
                $get_name = $pdo->prepare("SELECT name FROM trades LEFT JOIN allnames ON trades.trades_nameid = allnames.nameid WHERE trades_id = ?");


                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[4],0,-2);

                    //Проверка на наличие такого uid  в базе
                    $gotuid->execute(array($uid_trimmed));
                    $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);

                    //Если такой uid есть - ничего не делаем
                    if(is_string($gotsome['trades_uid']) && $uid_trimmed == $gotsome['trades_uid']){
                        //Дополнительно надо проверить, а есть ли такой uid в ip_uid?
                        $got_sync->execute(array($uid_trimmed));
                        $got_sync_fetched = $got_sync->fetch(PDO::FETCH_ASSOC);
                        if(is_string($got_sync_fetched['trades_id']) && is_string($got_sync_fetched['tare'])){
                            //получаем имя соотнесённого товара
                            $get_name->execute(array($got_sync_fetched['trades_id']));
                            $get_name_fetched = $get_name->fetch(PDO::FETCH_ASSOC);
                            $synched[]="<li>".$temp_array[1]."(".$gotsome['tare'].") Ед. Изм.: ".$temp_array[2]." <span style='color: green'>СООТНЕСЕН С </span>".$get_name_fetched['name']."</li>";
                        }else{
                            $synched[]="<li><input type='text' class='sync_trade'><div class='sres'></div>".$temp_array[1]."(".$gotsome['tare'].") Ед. Изм.: ".$temp_array[2]."<span style='color: red'> НЕ СООТНЕСЕН</span></li>";
                        }




                    }else{
                        //Выводим возможность соотнести и записать в базу
                        /*$not_synched[]="<li><input type='text' class='sync_trade'><div class='sres'></div>
                                 <input type='button' table='trades' class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[4]>
                                 <span class='sync_add_name'>$temp_array[1] в $temp_array[2]</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";*/
                        $not_synched[]="<li><input type='text' class='sync_trade'><div class='sres'></div>                                 
                                 <span class='sync_add_name'>$temp_array[1] в $temp_array[2]</span><input class='sync_add_to_base' type='button' value='+' table='trades' innerid  onec_id=$temp_array[0] uid=$temp_array[4]>
                             </li>";
                    }
                }
                //Выводим божеский вид
                switch ($sync) {
                    case "trades":
                        echo "<ul id='sinchronize_trades'>";
                        break;
                    case "ip_trades":
                        echo "<ul id='sinchronize_ip_trades'>";
                        break;
                }

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
        case "ip_positions":
            if ($file){

                $req_positions = array();

                $gettradename = $database->prepare("SELECT name, trades_id FROM trades LEFT JOIN allnames a on trades.trades_nameid = a.nameid WHERE trades_uid = ?");
                $gettradename_tradeid = $database->prepare("SELECT name FROM trades LEFT JOIN allnames a on trades.trades_nameid = a.nameid WHERE trades_id = ?");
                $getreqnum = $database->prepare("SELECT 1c_num, name, created, requests_id FROM requests LEFT JOIN byers ON requests.byersid = byers_id LEFT JOIN allnames on byers_nameid = allnames.nameid WHERE requests_uid = ?");
                $getpositions = $database->prepare("SELECT pos_name, line_num, req_positionid FROM req_positions LEFT JOIN requests ON requestid = requests_id WHERE requests_uid = ? ORDER BY line_num ASC");
                $getpricings = $database->prepare("SELECT pricingid, tradeid, price, sellerid FROM pricings WHERE positionid = ?");
                $getsellername = $database->prepare("SELECT name FROM pricings LEFT JOIN sellers on sellerid=sellers_id LEFT JOIN allnames a on sellers.sellers_nameid = a.nameid WHERE pricingid = ?");
                $chk_pos=$database->prepare("SELECT line_num FROM req_positions WHERE (`requestid` = ? AND `line_num` = ?)");

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

                //Массив для дубрилующих элементво массива. Сюда будут стекаться ключи и он будет ограничивать проход по массиву
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
                switch ($sync) {
                    case "positions":
                        echo "<ul id='sinchronize_positions'>";
                        break;
                    case "ip_positions":
                        echo "<ul id='sinchronize_ip_positions'>";
                        break;
                }

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
                                echo "<input database='".$_POST['db']."' type='button' requestid = '" . $gotreqnum['requests_id'] . "' req_positionid = '" . $pos['req_positionid'] . "' price = '" . $v[$pos_lnum][7] . "' kol = '" . $v[$pos_lnum][4] . "' tradeid = '" . $gottradename['trades_id'] . "'  class='sync_addpricing' value='+Превратить позицию в расценку'>";
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
        case "purchases":
        case "ip_purchases":
            try{
                if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0){
                    echo"<p>Файл выгружен в массив</p>";

                    /*Мехаинзм такой: Если закупка в 1С изменилась - она меняется в базе*/

                    $check_purchase = $database->prepare("SELECT purchases_uid FROM purchases WHERE purchases_uid = ? AND line_num = ?");
                    $insert_purchase = $database->prepare("INSERT INTO purchases (
                                                        purchases_uid,
                                                        seller_uid,
                                                        incdoc_date,
                                                        incdoc_num,                                                        
                                                        line_num,
                                                        trade_uid,
                                                        kol,
                                                        price,
                                                        sum
    ) VALUES(?,?,?,?,?,?,?,?,?)");
                    $update_purchase = $database->prepare("UPDATE purchases SET 
                                                                              seller_uid=?,
                                                                              incdoc_date=?,
                                                                              incdoc_num=?,                                                                              
                                                                              trade_uid=?,
                                                                              kol=?,
                                                                              price=?,
                                                                              sum=? WHERE (purchases_uid=? AND line_num=?)");

                    foreach ($file_array as $row){
                        $temp_array = explode(';',$row);
                        //echo "<pre>";
                        //print_r($temp_array);
                        //echo "</pre>";

                        /*
                         * $temp_array[0] - uid реализации
                         * $temp_array[1] - uid поставщика
                         * $temp_array[2] - ДатаВходящегоДокумента
                         * $temp_array[3] - №ВходящегоДокумента
                         * $temp_array[4] - Номер строки
                         * $temp_array[5] - uid товара
                         * $temp_array[6] - количество
                         * $temp_array[7] - цена
                         * $temp_array[8] - сумма
                         */

                        /*Проверяем, есть ли в системе такая закупка, если нет - то заносим в базу. Если есть - ничего не делаем
                         * */
                        $database->beginTransaction();
                        $check_purchase->execute(array($temp_array[0], $temp_array[4]));
                        $check_purchase_fetched = $check_purchase->fetch(PDO::FETCH_ASSOC);

                        //echo "<pre>";
                        //print_r($check_purchase_fetched);
                        //echo "</pre>";

                        $good_date = substr($temp_array[2],6,4 )."-".substr($temp_array[2],3,2)."-".substr($temp_array[2],0,2);

                        if(count($check_purchase_fetched['purchases_uid']) > 0){
                            $update_purchase->execute(array($temp_array[1],$good_date,$temp_array[3],$temp_array[5],$temp_array[6],$temp_array[7],$temp_array[8],$temp_array[0],$temp_array[4]));
                        }else{
                            $insert_purchase->execute(array($temp_array[0],$temp_array[1],$good_date,$temp_array[3],$temp_array[4],$temp_array[5],$temp_array[6],$temp_array[7],$temp_array[8]));
                        }
                        $database->commit();
                    }
                    echo"Закупки пройдены.";
                };
            }else{
                echo"<p>Файл НЕ найден</p>";
            };
            }catch( PDOException $e ) {$database->rollback();print "Error!: " . $e->getMessage() . "<br/>" . (int)$e->getCode( );}
                break;
        case "transports":
        case "ip_transports":
            if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0){
                    echo"<p>Файл выгружен в массив</p>";

                    /*switch($sync){
                        case "transports":
                            $database = $pdo;
                            break;
                        case "ip_transports":
                            $database = $pdoip;
                            break;
                    }*/

                    $check_transport = $database->prepare("SELECT purchases_uid FROM transports WHERE purchases_uid = ?");
                    $insert_transport = $database->prepare("INSERT INTO transports (purchases_uid,seller_uid,incdoc_date,incdoc_num,sum,comment) VALUES(?,?,?,?,?,?)");

                    foreach ($file_array as $row){
                        $temp_array = explode(';',$row);
                        /*
                         * $temp_array[0] - uid заказа поставщику
                         * $temp_array[1] - uid поставщика
                         * $temp_array[2] - ДатаВходящегоДокумента
                         * $temp_array[3] - №ВходящегоДокумента
                         * $temp_array[4] - сумма
                         * $temp_array[5] - сумма
                         */

                        /*Проверяем, есть ли в системе такая закупка, если нет - то заносим в базу. Если есть - ничего не делаем
                         * */
                        $check_transport->execute(array($temp_array[0]));
                        $check_transport_fetched = $check_transport->fetch(PDO::FETCH_ASSOC);
                        if(!$check_transport_fetched['purchases_uid']){

                            //uid заказа поставщику
                            $temp_array[0];
                            //uid поставщика
                            $temp_array[1];
                            //ДатаВходящегоДокумента
                            $temp_array[2] = substr($temp_array[2],6,4 )."-".substr($temp_array[2],3,2)."-".substr($temp_array[2],0,2);
                            //№ВходящегоДокумента
                            $temp_array[3];
                            //сумма
                            $temp_array[4];
                            //Комментарий
                            $temp_array[5];

                            $insert_transport->execute(array($temp_array[0],$temp_array[1],$temp_array[2],$temp_array[3],$temp_array[4],$temp_array[5]));
                        }
                    }
                    echo"Транспортные пройдены.";
                };
            }else{
                echo"<p>Файл НЕ найден</p>";
            };
            break;
        case "executes":
        case "ip_executes":
            if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0){
                    echo"<p>Файл выгружен в массив</p>";

                    /*switch($sync){
                        case "executes":
                            $database = $pdo;
                            break;
                        case "ip_executes":
                            $database = $pdoip;
                            break;
                    }*/

                    $check_executes = $database->prepare("SELECT executes_uid FROM executes WHERE executes_uid = ?");
                    $insert_execute = $database->prepare("INSERT INTO executes (executes_uid,requests_uid,executed,execute_1c_num) VALUES(?,?,?,?)");

                    foreach ($file_array as $row){
                        $temp_array = explode(';',$row);

                        /*
                         * $temp_array[0] - uid реализации
                         * $temp_array[1] - uid заказа
                         * $temp_array[2] - Номер реализации
                         * $temp_array[3] - Дата реализации
                         */

                        /*Проверяем, есть ли в системе такая реализация, если нет - то заносим в базу. Если есть - ничего не делаем
                         * */
                        $check_executes->execute(array($temp_array[0]));
                        $check_executes_fetched = $check_executes->fetch(PDO::FETCH_ASSOC);
                        if(!$check_executes_fetched['executes_uid']){
                            $temp_array[0];//uid реализации
                            $temp_array[1];//uid заказа
                            $temp_array[2];//Номер реализации
                            $temp_array[3] = substr($temp_array[3],6,4 )."-".substr($temp_array[3],3,2)."-".substr($temp_array[3],0,2);//Дата реализации
                            $insert_execute->execute(array($temp_array[0], $temp_array[1],$temp_array[3], $temp_array[2]));
                        }
                    }
                    echo"Реализации пройдены.";
                };
            }else{
                echo"<p>Файл НЕ найден</p>";
            };
            break;
    }
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
                    <input type='button' name='requests' database='ltk' created bid uid onec_id value='Добавить заявку' disabled>
                </div>";
            break;
        case "ip_requests":
            echo"<div class='creates'>
                    <label for='src'>Дата заказа:</label><span class='sync_req_created' name='src'></span><br>                
                    <label for='sru'>Уникальный идентификатор:</label><span class='sync_req_uid' name='sru'></span><br>                
                    <label for='srb'>Код Покупателя:</label><span class='sync_req_byers_id' name='srb'></span><br>                
                    <label for='srn'>Номер в 1С:</label><span class='sync_req_onec_id' name='srn'></span><br>                
                    <input type='button' name='requests' database='ip' created bid uid onec_id value='Добавить заявку' disabled>
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
                    <input class='addpos' type='button' database='ltk' price kol tradeid linenum name='positions' requestid posname value='Добавить позицию' disabled>
                </div>";
            break;
        case "ip_positions":
            echo"<div>              
                    <label for='spr'>Код Заказа:</label><span class='sync_pos_requestid' name='spr'></span><br>                
                    <label for='spn'>Имя позиции:</label><span class='sync_pos_pos_name' name='spn'></span><br>                
                    <label for='spl'>Номер строки:</label><span class='sync_pos_line_num' name='spl'></span><br>                
                    <label for='spp'>Цена:</label><span class='sync_pos_price' name='spp'></span><br>                
                    <label for='spk'>Количество:</label><span class='sync_pos_kol' name='spk'></span><br>                
                    <label for='spt'>Товар:</label><span class='sync_pos_tradeid' name='spt'></span><br>                
                    <input class='addpos' type='button' database='ip' price kol tradeid linenum name='positions' requestid posname value='Добавить позицию' disabled>
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
                    <input type='button' name='payments' database='ltk' payed number sum uid onec_id requestid value='Добавить платежку' disabled>
              </div>";
            break;
        case "ip_payments":
            echo"<div class='creates'>
                    <label for='spp'>Дата платежа:</label><span class='sync_pay_payed' name='spp'></span><br>                
                    <label for='spnum'>№ п/п:</label><span class='sync_pay_num' name='spnum'></span><br>                           
                    <label for='srn'>Номер в 1С:</label><span class='sync_pay_onec_id' name='spn'></span><br>   
                    <label for='spu'>Уникальный идентификатор:</label><span class='sync_pay_uid' name='spu'></span><br>             
                    <label for='sps'>Сумма:</label><span class='sync_pay_sum' name='sps'></span><br>             
                    <label for='sprid'>Внутренный код заказа:</label><span class='sync_pay_rid' name='sprid'></span><br>
                    <span class='ready_comment'></span><br>             
                    <input type='button' name='payments' database='ip' payed number sum uid onec_id requestid value='Добавить платежку' disabled>
              </div>";
            break;
        case "byers":
            echo"<div class='creates add_ramk'>
                <input class='add_byer_name' type='text' placeholder='Введите наименование Покупателя' size='40'>
                <br><span class='ready_comment'></span><br>  
                <input type='button' database='ltk' tc='1' name='byers' value='Добавить' uid onec_id disabled>
                </div>";
            break;
        case "ip_byers":
            echo"<div class='creates add_ramk'>
                <input class='add_byer_name' type='text' placeholder='Введите наименование Покупателя' size='40'>
                <br><span class='ready_comment'></span><br>  
                <input type='button' database='ip' tc='1' name='byers' value='Добавить' uid innerid onec_id disabled>
                </div>";
            break;
        case "sellers":
            echo"<div class='creates'>
                <input class='add_seller_name' type='text' placeholder='Введите наименование Поставщика' size='40'>
                <br><span class='ready_comment'></span><br>  
                <input type='button' database='ltk' tc='2' name='sellers' value='Добавить' uid onec_id disabled>
                </div>";
            break;
        case "ip_sellers":
            echo"<div class='creates'>
                <input class='add_seller_name' type='text' placeholder='Введите наименование Поставщика' size='40'>
                <br><span class='ready_comment'></span><br>  
                <input type='button' database='ip' tc='2' name='sellers' value='Добавить' uid innerid onec_id disabled>
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
                <input  type='button' database='ltk' tc='3' name='trades' value='Добавить' disabled uid onec_id><br><br></div>";
            break;
        case "ip_trades":
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
                <input  type='button' database='ip' tc='3' name='trades' value='Добавить' disabled innerid uid onec_id><br><br></div>";
            break;
        case "purchases":
        case "ip_purchases":
            echo"<div class ='creates'>                                   
                </div>";
            break;
        case "transports":
        case "ip_transports":
            echo"<div class ='creates'>                                   
                </div>";
            break;
        case "executes":
        case "ip_executes":
            echo"<div class ='creates'>                                   
                </div>";
            break;
    }
}

/*Собственно соотнесение*/
/*Собственно соотнесение по последним изменениям у нас будет проходить только при добавлении нового в базу ip.
То есть вообще не так часто. Кнопка соотнести вообще не нужна. Временно все комментим*/
/*if (isset($_POST['innerid']) && isset($_POST['uid']) && isset($_POST['table']) && isset($_POST['onec_id'])){
    try {
        switch ($_POST['table']) {
            case "requests":
                $statement=$database->prepare("UPDATE requests SET `requests_uid`=:uid, `1c_num`=:onec_id WHERE `requests_id`=:innerid");
                break;
            case "byers":
                $statement=$database->prepare("UPDATE byers SET `byers_uid`=:uid, `onec_id`=:onec_id WHERE `byers_id`=:innerid");
                break;
            case "sellers":
                $statement=$database->prepare("UPDATE sellers SET `sellers_uid`=:uid, `onec_id`=:onec_id WHERE `sellers_id`=:innerid");
                break;
            case "trades":
                $statement=$database->prepare("UPDATE trades SET `trades_uid`=:uid, `onec_id`=:onec_id WHERE `trades_id`=:innerid");
                break;
            case "payments":
                $statement=$database->prepare("UPDATE payments SET `payments_uid`=:uid, `onec_id`=:onec_id WHERE `payments_id`=:innerid");
                break;
        }

        $innerid = $_POST['innerid'];
        $uid = $_POST['uid'];
        $onec_id = $_POST['onec_id'];

        $statement->bindValue(':uid', $uid);
        $statement->bindValue(':innerid', $innerid);
        $statement->bindValue(':onec_id', $onec_id);

        $database->beginTransaction();
        $statement->execute();
        $database->commit();

        echo "Соотнесение успешно.";


    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}*/

/*Обновление одной позиции после добавления позиции или расценки*/
if(isset($_POST['synched_request'])){
    try{
    $rid = $_POST['synched_request'];

    $getreqnum=$database->prepare("SELECT 1c_num, created, name, requests_uid FROM requests LEFT JOIN byers ON byersid=byers_id LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid WHERE requests_id=?");
    $getpositions=$database->prepare("SELECT pos_name, line_num, req_positionid FROM req_positions WHERE requestid=? ORDER BY line_num ASC");
    $gettradename = $database->prepare("SELECT name, trades_id FROM trades LEFT JOIN allnames a on trades.trades_nameid = a.nameid WHERE trades_uid = ?");
    $getpricings = $database->prepare("SELECT pricingid, tradeid, kol, price FROM pricings WHERE positionid = ?");
    $gettradename_tradeid = $database->prepare("SELECT name FROM trades LEFT JOIN allnames a on trades.trades_nameid = a.nameid WHERE trades_id = ?");
    $getsellername = $database->prepare("SELECT name FROM pricings LEFT JOIN sellers on sellerid=sellers_id LEFT JOIN allnames a on sellers.sellers_nameid = a.nameid WHERE pricingid = ?");
    $chk_pos=$database->prepare("SELECT line_num FROM req_positions WHERE (`requestid` = ? AND `line_num` = ?)");


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //Фaйл в массив
            switch($_POST['db']){
                case 'ip':
                    $path = '/samba/allaccess/1111/sync_ip_positions.txt';
                    break;
                case 'ltk':
                    $path = '/samba/allaccess/1111/sync_positions.txt';
                    break;
            }
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
                            $thehtml .= "<input database='".$_POST['db']."' type='button' requestid = '" . $rid . "' req_positionid = '" . $pos['req_positionid'] . "' price = '" . $v[$pos_lnum][7] . "' kol = '" . $v[$pos_lnum][4] . "' tradeid = '" . $gottradename['trades_id'] . "'  class='sync_addpricing' value='+Превратить позицию в расценку'>";
                        }
                    }
                };
                $thehtml .= "<br><br><br></ul></li>";
            }
        }
    print $thehtml;
} catch( PDOException $Exception ) {
    // Note The Typecast To An Integer!
    $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
}
}

//Добавление поступления в позицию и позиции в поступление
if (isset($_POST['attach_pur_date']) && isset($_POST['attach_pur_id']) && isset($_POST['position_to_attach'])){

    $theposition = $_POST['position_to_attach'];
    $pur_id = $_POST['attach_pur_id'];
    $pur_date = $_POST['attach_pur_date'];

    $attach_purchase = $database->prepare("UPDATE req_positions SET purchase_id = :purchase_id, purchased = :purchased WHERE req_positionid = :req_positionid");
    $attach_position = $database->prepare("UPDATE purchases SET positionid = :positionid WHERE purchases_id = :purchases_id");

    try{

        $attach_purchase->bindValue(':purchase_id', $pur_id);
        $attach_purchase->bindValue(':purchased', $pur_date);
        $attach_purchase->bindValue(':req_positionid', $theposition);

        $attach_position->bindValue(':positionid', $theposition);
        $attach_position->bindValue(':purchases_id', $pur_id);

        $database->beginTransaction();
        $attach_purchase->execute();
        $attach_position->execute();
        $database->commit();

        echo "Добавлено к позиции ".$theposition." поступление ".$pur_id." от ".$pur_date;
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}