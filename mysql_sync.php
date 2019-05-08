<?php

include_once 'pdo_connect.php';

if(isset($_POST['sync_file'])){
    $sync = $_POST['sync_file'];
    $uid_column = $sync."_uid";
    $path = 'files/sync_'.$sync.'.txt';
    $file = fopen($path,'r');

    switch ($sync){
        case "requests":
            if ($file){
                echo"<p>Файл найден</p>";
                $file_array = file($path); // Считывание файла в массив $file_array
                if (count($file_array) > 0);
                echo"<p>Файл выгружен в массив</p>";

                $gotuid = $pdo->prepare("SELECT requests_uid FROM requests WHERE requests_uid = ?");
                $getbyer_name = $pdo->prepare("SELECT name, byers_id FROM byers LEFT JOIN allnames ON byers.byers_nameid = allnames.nameid WHERE byers_uid = ?");

                //Выводим божеский вид
                echo"<ul id='sinchronize_requests'>";

                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[5],0,-2);
                    $created_trimmed = substr($temp_array[1],0,-9);
                    $created_for_mysql = substr($temp_array[1],6,-9).".".substr($temp_array[1],3,-14).".".substr($temp_array[1],0,-17);

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
                        echo"<li> Уже в базе --- Заказ № ".$temp_array[0]." от ".$created_trimmed."</li>";
                        /*ничего не выводим*/

                    }else{
                        //Выводим возможность соотнести и записать в базу
                        echo"<li><input type='text' class='sync_request'><div class='sres'></div>                                 
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid onec_id=$temp_array[0] uid=$temp_array[5] byersid=$byers_id created=$created_for_mysql>
                                 <span class='sync_add_name'>Заказ ".$byers_name." № ".$temp_array[0]." от ".$created_trimmed."</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";
                    }
                }

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

                $gotuid = $pdo->prepare("SELECT payments_uid FROM payments WHERE payments_uid = ?");
                $gotrequestid = $pdo->prepare("SELECT requests_id FROM requests WHERE requests_uid = ?");

                echo"<ul id='sinchronize_payments'>";

                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    foreach($temp_array as $row){
                        $row[4] = preg_replace('/[\xc2\xa0]+', '&nbsp;', $row[4]);
                    }

                    $gotuid->execute(array($temp_array[6]));
                    $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);

                    $gotrequestid->execute(array($temp_array[5]));
                    $gotrid = $gotrequestid->fetch(PDO::FETCH_ASSOC);
                    if( ! $gotrid){
                        $rid = 'none';
                        $status = "<span style='color: red'>Заказ не определен</span>";
                    }else{
                        $rid = $gotrid['requests_id'];
                        $status = "<span style='color: green'>Заказ найден</span>";
                    }

                    //Дата
                    $payed_trimmed = substr($temp_array[2],0,-8);
                    $payed_trimmed_for_mysql = substr($temp_array[2],6,-8).".".substr($temp_array[2],3,-13).".".substr($temp_array[2],0,-16);

                    if (is_string($gotsome['payments_uid']) && $temp_array[6] == $gotsome['payments_uid']){
                        echo"<li><span>Уже в базе № ".$temp_array[3]." от ".$payed_trimmed." на сумму ".$temp_array[4]." руб.</span>".$status."</li>";

                    }else{
                        echo"<li>
                             <input type='text' class='sync_payment'><div class='sres'></div>
                             <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[6] payed=$payed_trimmed_for_mysql number=$temp_array[3] sum=$temp_array[4] requestid=$rid>
                             <span>№ ".$temp_array[3]." от ".$payed_trimmed." на сумму ".$temp_array[4]." руб.</span>".$status."
                             <input class='sync_add_to_base' type='button' value='+'>
                         </li>";
                    }


                }
                echo"</ul>";
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

                //Выводим божеский вид
                echo"<ul id='sinchronize_byers'>";
                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[3],0,-2);

                    //Проверка на наличие такого uid  в базе
                    $gotuid->execute(array($uid_trimmed));
                    $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);

                    //Если такой uid есть - ничего не делаем
                    if(is_string($gotsome['byers_uid']) && $uid_trimmed == $gotsome['byers_uid']){
                        echo"<li> Уже в базе --- ".$temp_array[1]."</li>";
                        /*ничего не выводим*/

                    }else{
                        //Выводим возможность соотнести и записать в базу
                        echo"<li><input type='text' class='sync_byer'><div class='sres'></div>                                 
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[3]>
                                 <span class='sync_add_name'>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";
                    }
                }
                echo"</ul>";
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

                //Выводим божеский вид
                echo"<ul id='sinchronize_sellers'>";
                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[3],0,-2);

                    //Проверка на наличие такого uid  в базе
                    $gotuid->execute(array($uid_trimmed));
                    $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);

                    //Если такой uid есть - ничего не делаем
                    if(is_string($gotsome['sellers_uid']) && $uid_trimmed == $gotsome['sellers_uid']){
                        echo"<li> Уже в базе --- ".$temp_array[1]."</li>";
                        /*ничего не выводим*/

                    }else{
                        //Выводим возможность соотнести и записать в базу
                        echo"<li><input type='text' class='sync_seller'><div class='sres'></div>                                 
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[3]>
                                 <span class='sync_add_name'>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";
                    }
                }
                echo"</ul>";
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

                $gotuid = $pdo->prepare("SELECT trades_uid FROM trades WHERE trades_uid = ?");

                //Выводим божеский вид
                echo"<ul id='sinchronize_trades'>";
                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[4],0,-2);

                    //Проверка на наличие такого uid  в базе
                    $gotuid->execute(array($uid_trimmed));
                    $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);

                    //Если такой uid есть - ничего не делаем
                    if(is_string($gotsome['trades_uid']) && $uid_trimmed == $gotsome['trades_uid']){
                        echo"<li> Уже в базе --- ".$temp_array[1]."</li>";
                        /*ничего не выводим*/

                    }else{
                        //Выводим возможность соотнести и записать в базу
                        echo"<li><input type='text' class='sync_trade'><div class='sres'></div>                                 
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid  onec_id=$temp_array[0] uid=$temp_array[4]>
                                 <span class='sync_add_name'>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+'>
                             </li>";
                    }
                }
                echo"</ul>";
            }else{
                echo"<p>Файл НЕ найден</p>";
            }
            break;
    }

    $file = "files/sync_requests.txt";
    $requests_list = array();
    $temp_array = array();
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
                <option value='штука'>штука (по умолчанию)</option>
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