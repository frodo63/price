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
                echo"<span>НомерЗаказа</span><span>Дата</span><span>КодПокупателя</span>
                     <span>УИДЗаказа</span>";
                foreach ($file_array as $row){
                    echo"<pre>";
                    print_r($row);
                    echo"</pre>";
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
                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    echo"<li>
                             $row;
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
                echo"<input type='button' value='Пройти по массиву' id = 'sync_byers_list'>";


                //Выводим божеский вид
                echo"<ul id='sinchronize_byers'>";
                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    echo"<li>$temp_array[1]<input type='text' class='sync_byer'><div class='sres'></div><input type='button' class='sync_to_base' value='Соотнести' table innerid uid=$temp_array[3] dataver=$temp_array[2]>
                    <input class='sync_add_to_base' type='button' value='+'></li>";
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

                //Выводим божеский вид
                echo"<ul id='sinchronize_sellers'>";
                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    echo"<li><input type='text' class='sync_seller'><div class='sres'></div>
                             <span>$temp_array[1]</span><input type='button' class='sync_to_base' value='Соотнести' table innerid uid=$temp_array[3] dataver=$temp_array[2]>
                             <input class='sync_add_to_base' type='button' value='+'>
                         </li>";
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
                                 <input type='button' table=$sync class='sync_to_base' value='Соотнести' table innerid uid=$temp_array[4] dataver=$temp_array[3]>
                                 <span>$temp_array[1]</span><input class='sync_add_to_base' type='button' value='+'>
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
if(isset($_POST['sync_html'])){
    $sync = $_POST['sync_html'];

    switch ($sync){
        case "requests":
            echo"";
            break;
        case "payments":
            echo"";
            break;
        case "byers":
            echo"<div class='creates add_ramk'><br>
                <input type='text' placeholder='Введите наименование Покупателя' size='40'>
                <input type='button' tc='1' name='byers' value='Добавить'>
                <br>
                <br>
                </div>";
            break;
        case "sellers":
            echo"<div class='creates'>
                <br>
                <input type='text' placeholder='Введите наименование Поставщика' size='40'>
                <input type='button' tc='2' name='sellers' value='Добавить'>
                <br>
                <br>
                </div>";
            break;
        case "trades":
            echo"<div class ='creates'>
                <br><input class='add_trade_name' type='text' placeholder='Введите наименование Товара' size='70'>
                <br><span>Тара:</span><span class='trade_options_tare'></span><br>
                <select id='add_trade_tare' size='1'>
                <option value='штука'>штука (по умолчанию)</option>
                <option value='банка'>банка (до 5кг)</option>
                <option value='канистра'>канистра (5-50л)</option>
                <option value='бочка'>бочка(200л)</option>
                </select><br>
                <span class='ready_comment'></span><br>
                <input  type='button' name='trades' value='Добавить' disabled><br><br></div>";
            break;}
}


/*Собственно соотнесение*/
if (isset($_POST['innerid']) && isset($_POST['uid']) && isset($_POST['table'])){
    try {

        switch ($_POST['table']) {
            case "requests":
                $table = "requests";
                break;
            case "byers":
                $table = "byers";
                break;
            case "sellers":
                $table = "sellers";
                break;
            case "trades":
                $statement=$pdo->prepare("UPDATE trades SET `trades_uid`=:uid WHERE `trades_id`=:innerid");
                break;
        }



        $innerid = $_POST['innerid'];
        $uid = $_POST['uid'];


        $statement->bindValue(':uid', $uid);
        $statement->bindValue(':innerid', $innerid);


        $pdo->beginTransaction();
        $statement->execute();
        $pdo->commit();

        echo "получилось";


    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
}