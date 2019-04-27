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
                $getbyer_name = $pdo->prepare("SELECT name FROM byers LEFT JOIN allnames ON byers.byers_nameid = allnames.nameid WHERE byers_uid = ?");

                //Выводим божеский вид
                echo"<ul id='sinchronize_requests'>";

                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    $uid_trimmed = substr($temp_array[5],0,-2);
                    $created_trimmed = substr($temp_array[1],0,-9);

                    try{

                        //Проверка на наличие такого uid  в базе
                        $gotuid->execute(array($uid_trimmed));
                        $getbyer_name->execute(array($temp_array[4]));
                        $gotsome = $gotuid->fetch(PDO::FETCH_ASSOC);
                        $gotname = $getbyer_name->fetch(PDO::FETCH_ASSOC);


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
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' innerid onec_id=$temp_array[0] uid=$temp_array[5]>
                                 <span class='sync_add_name'>Заказ ".$gotname['name']." № ".$temp_array[0]." от ".$created_trimmed."</span><input class='sync_add_to_base' type='button' value='+'>
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

                /*foreach ($file_array as $row){

                    //Кидаем данные во временный массив
                    $temp_array = explode(';',$row);
                    //Что-то делаем с каждым вэлью из временного массива:

                    //Номер в 1С. надо отрезать нули в начале
                    $temp_array[0] = ltrim($temp_array[0],'0');

                    //Дата. Надо отрезать время в конце:
                    $temp_array[1] = substr($temp_array[1], 0, 10);

                    //Айдишник покупателя. отрезаем в начале нолики
                    $temp_array[2] = ltrim($temp_array[2],'0');

                    //Создаем запись для информирования
                    $temp_array[3] = "Будет создан заказ. Номер в 1С: ".$temp_array[0]." Дата: ".$temp_array[1]." Покупатель: ".$temp_array[2];

                    //Заносим результат
                    $requests_list[] = $temp_array;
                }*/
                //Выводим божеский вид

                echo"<ul id='sinchronize_payments'>";
                echo"<span>onec_id Платежа</span><span>ВерсияДанных</span><span>ДатаПлатежа</span><span>НомерПлатежки</span><span>onec_id Плательщика</span><span>СуммаПлатежа</span><span>УИД Заказа</span>";
                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    echo"<li>
                             $temp_array[0]$temp_array[1]$temp_array[2]$temp_array[3]$temp_array[4]$temp_array[5]$temp_array[6]
                             <input class='sync_add_to_base' type='button' value='+'>
                         </li>";
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
                    <input type='text' placeholder='Выберите Покупателя' size='20' id ='byer' autocomplete='off'>
                    <div class='sres'></div>
                    <input type='text' id='req_name' placeholder='Введите название для Заявки' size='40'>                
                    <input type='button' name='requests' value='Добавить заявку'>
                </div>";
            break;
        case "payments":
            echo"<div class='creates'>
                  <label><span>Дата платежа:</span></label><input id='add_payment_date' type='date' size='20'><br>
                  <label><span>Номер п/п</span></label><input id='add_payment_1c_num' type='text' size='20'><br>
                  <label><span>Сумма, руб.</span></label><input id='add_payment_sum' type='text' size='20'><br>
                  <span class='ready_comment'></span><br>
                  <input class='button_add_payment' type='button' name='payments' requestid='-' paymentid='-' value='Сохранить платежку'>
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
                $table = "requests";
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

        echo "получилось";


    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
}