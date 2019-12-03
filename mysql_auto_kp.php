<?php

echo"
<div class='mail_body_parts' style='background-color: #F0F0F0; width: 20%'>
<b><span>Тело КП</span></b><br><br>
<label for='hydraulic_bechem'>Гидравлика - BECHEM</label><input name='hydraulic_bechem' type='checkbox'><br>
<label for='hydraulic_total'>Гидравлика - TOTAL</label><input name='hydraulic_total' type='checkbox'><br>
<label for='red_bechem'>Редуктор - BECHEM</label><input name='red_bechem' type='checkbox'><br>
<label for='sog_bechem'>СОЖ - BECHEM</label><input name='sog_bechem' type='checkbox'><br>
<label for='food_bechem'>Пищевка - BECHEM</label><input name='food_bechem' type='checkbox'><br>
<label for='food_total'>Пищевка - TOTAL</label><input name='food_total' type='checkbox'><br>
<label for='food_rocol'>Пищевка - ROCOL</label><input name='food_rocol' type='checkbox'><br>
<label for='food_matrix'>Пищевка - MATRIX</label><input name='food_matrix' type='checkbox'><br>
</div>

<br><br>

<div class='mail_tail_parts' style='background-color: #F0F0F0; width: 20%'>
<b><span>Подписи</span></b><br><br>
<label for='tail_dima'>Дима</label><input name='tail_dima' type='checkbox'><br>
<label for='tail_timur'>Марина</label><input name='tail_timur' type='checkbox'><br>
<label for='tail_sergey'>Сергей</label><input name='tail_sergey' type='checkbox'><br>
<label for='tail_marina'>Тимур</label><input name='tail_marina' type='checkbox'><br>

</div>
<br><br>
<input type='button' value='СФОРМИРОВАТЬ' class='mail_compose'>

";


$mail_head="<p style=\"background-color: #FBBA00; font-size:25px; font-weight: bold; text-align: center; color:#17460F\">Здравствуйте!</p>

<table style=\"width: 100%;\"><tbody><tr>
    <td><b style=\"font-size: 35px\">ООО \"Лубритэк\"</b></td>
    <td>- официальный дилер смазочных материалов
        <b><span style=\"font-size: 22px; font-family: Arial;font-style: italic; font-weight: 900\"> BECHEM </span></b>
        в Самарской области.<br>
    </td>
</tr></tbody></table>

<p>Деятельность нашей компании в первую очередь направлена на обеспечение бесперебойной работы потребителей, на техническую поддержку, консультации  по смазочным материалам, герметикам и промышленным клеям, что гарантируется грамотным персоналом, имеющим опыт работы в производстве и прошедшим обучение в дистрибьюторских центрах производителей.
</p>

<br><br>
<table style=\"width:100%\"><tbody><tr><td style=\"text-align: right\">

    <span><i>\"Умеренная ценовая политика,</i></span><br>
    <span><i>беспрекословное выполнение договорных обязательств,</i></span><br>
    <span><i>наличие пополняемого тёплого склада,</i></span><br>
    <span><i>стабильные сроки поставки</i></span><br>
    <span><i>делают работу с нами комфортной.\"</i></span><br>
    <br>
    <span><i>- С.В. Улитов.</i></span>

</td>
</tr></tbody></table>";
$mail_greeting="";
$mail_body="";
$mail_tail="";

$themail = "";
$themail .= $mail_head;
$themail .= $mail_greeting;
$themail .= $mail_body;
$themail .= $mail_tail;

print $themail;