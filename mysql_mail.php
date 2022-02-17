<?php

// Подключаем библиотеку PHPMailer
include_once 'PHPMailer/src/Exception.php';
include_once 'PHPMailer/src/PHPMailer.php';
include_once 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    //$path = '{imap.yandex.ru:993/imap/ssl}[Yandex]/Sent';
    $path = '{imap.yandex.ru:993/imap/ssl}Sent';

    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);

    print('<br> вот уже вот вот');

    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);

    print('<br> получилось?');

    return $result;
}

function send_request_my_mail($subject,$request, $adresats){

    //Отправляем по списку трём адресам
    foreach ($adresats as $adresat){
        try {

            // Авторизация
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->Host         = 'smtp.yandex.ru';
            $mail->SMTPAuth     = true;
            $mail->Username     = 'lubritek@yandex.ru';
            $mail->Password     = 'ketir_bul071114';
            $mail->SMTPSecure   = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port         = 587;
            $mail->CharSet = 'UTF-8';
            $mail->From = 'lubritek@yandex.ru';
            $mail->FromName = 'DmitryBaevRobot';

            // Контент
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $string_to_send = 'Здравствуйте, ' .  $adresat[1] . '! <br> Прошу рассмотреть возможность поставки продукта: <br>';
            foreach ($request as $req){
                $string_to_send .= $req[0] . ' - ' . $req[1] . ' ' . $req[2] . '<br>';
            }
            $string_to_send .= 'Прошу указать наличие / срок и цену.';
            $mail->Body = $string_to_send;

            $mail->addAddress($adresat[0]);

            // Отправка
            if(!$mail->send()) {
                echo 'Сообщение не может быть отправлено.';
                echo 'Ошибка: ' . $mail->ErrorInfo;
                exit;
            }
            else{
                echo 'Сообщение на адрес ' . $adresat[0] . ' отправлено. <br>';
                if (save_mail($mail)) {
                    echo "Message saved!";
                }
            }

        } catch (Exception $e) {}
    }
}

$zayavka[0] = array('ИТД 460', '1200', 'л');
$zayavka[1] = array('Shell Corena S2 V 460', '500', 'тюбиков');
$zayavka[2] = array('Мобилгир 600 экспи 100', '120', 'кг');

$adresats = array(
    ['frodo63@mail.ru', 'Дмитрий'],
    ['baevamu@yandex.ru', 'Марина'],
    ['ktkzombie@gmail.com', 'Joe']
);

send_request_my_mail("ПЕРВАЯ МАССОВАЯ ОТПРАВКА скриптом",$zayavka, $adresats);

/*
$imap = imap_open("{imap.yandex.ru:993/imap/ssl}INBOX", "lubritek@yandex.ru", "ketir_bul071114");
$mails_id = imap_search($imap, 'UNSEEN');

foreach ($mails_id as $num) {
    // Заголовок письма
    $header = imap_header($imap, $num);
    echo "<br> ЗАГОЛОВКИ: <br>";
    echo "<pre>";
    var_dump($header);
    var_dump(mb_convert_encoding($header, 'UTF-8', 'UTF7-IMAP'));

    // Тело письма
    $body = imap_body($imap, $num);
    echo "<br> ТЕЛА : <br>";
    var_dump($body);
    var_dump(mb_convert_encoding($body, 'UTF-8', 'UTF7-IMAP'));
    echo "</pre>";
}

imap_close($imap);*/


