<?php
/*Синхронизация

Синхронизируем справочники.
Справочники - Покупатели, Поставщики, Товары. Какие тут данные могут измениться?
Товар могут создать - тогда такого уид не будет и мы его создаем.
Товар могут удалить - тогда мы не удаляем из базы, а сохраняем для истории и ставим флаг "удален из 1с". Но там возможно будет создан новый же...
Может, товары с флагом "Удален из 1с" просто не участвуют в выдаче?




Синхронизируем заказы.
есть весия данных вд, она записывается в базу и является первичным идентификатором, что изменений не было в 1с.

Идентифицировать заказы надо по уид.
Для начала к существующим в базе заказам надо добавить уиды, это отдельный разовый скрипт,
чтобы можно было работать со старой базой. На случай, если заказ создавался вручную, можно
сохранить такую функцию присоединения заказа к заказу в 1с. запускать при начале скрипта
синхронизации.
Проверить по покупателю и дате. если не совпадает - вывести форму для ручного соотнесения
внести дату и покупателя и создать заказ с введенными данными.

1)если в базе уид есть, а в массиве1с нет - то заказ был типа удалён, это бывает редко и
наверное надо не удалять из базы, оставить для истории, но поставить флаг "из 1с удален".

2)если в базе уид такого нет, то значит надо создать заказ, берем номер, уид, покупателя,
создаём заявку, берем таблицу товаров и первый товар выносим в название заявки. добавляем
" и пр.", если товаров больше 1.
На каждый товар создаем позицию, и в каждой позиции добавляем расценку, заносим информацию.
Надо зафиксировать цену и количество и при обращении к расценке вывести сообщение типа
"привести к цене такой-то".
Обойти ограничение скрипта в отсутстви поставщика, хотя там ограничений скриптовых нет,
могут быть лишь констреинты в базе майскул, в таблице pricings, типа невозможности создать
расценку без поставщика.

3)если и в базе есть, и в 1с есть, и вд совпадает, то ничего не делаем.

*/



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
                echo"<span>НомерЗаказа</span>
                     <span>Дата</span>
                     <span>КодПокупателя</span>
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

                foreach ($file_array as $row){
                    echo"<pre>";
                    print_r($row);
                    echo"</pre>";
                }
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
                echo"<ul>";
                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    echo"<li>$temp_array[1]<input type='text' class='sync_byer'><div class='sres'></div><input type='button' class='sync_to_base' value='Соотнести' table innerid uid=$temp_array[3] dataver=$temp_array[2]></li>";
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
                echo"<input type='button' value='Пройти по массиву' id = 'sync_sellers_list'>";

                //Выводим божеский вид
                echo"<ul>";
                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);
                    echo"<li>$temp_array[1]<input type='text' class='sync_seller'><div class='sres'></div><input type='button' class='sync_to_base' value='Соотнести' table innerid uid=$temp_array[3] dataver=$temp_array[2]></li>";
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
                echo"<input type='button' value='Пройти по массиву' id = 'sync_trades_list'>";

                $gotuid = $pdo->prepare("SELECT trades_uid FROM trades WHERE trades_uid = ?");

                //Выводим божеский вид
                echo"<ul>";
                foreach ($file_array as $row){
                    $temp_array = explode(';',$row);

                    //Проверка на наличие такого uid  в базе
                    $gotuid->execute(array($temp_array[4]));
                    $gotsome = $gotuid->fetchAll();
                    //Если такой uid есть - ничего не делаем
                    if(count($gotsome)>0){
                        echo"Уже в базе";
                    }else{
                        //Выводим возможность соотнести и записать в базу
                        echo"<li>$temp_array[1]<input type='text' class='sync_trade'><div class='sres'></div><input type='button' class='sync_to_base' value='Соотнести' table innerid uid=$temp_array[4] dataver=$temp_array[3]></li>";
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

if (isset($_POST['innerid']) && isset($_POST['uid']) && isset($_POST['dataver'])){
    try {
        $innerid = $_POST['innerid'];
        $uid = $_POST['uid'];
        $dataver = $_POST['dataver'];



    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
}