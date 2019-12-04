<?php
include_once 'pdo_auto_kp_connect.php';

echo"
<h1>Конструктор КП</h1>
<div class='custom_greeting'>
<h2>Скопировать HTML:</h2>
    <textarea id='html_copy' rows='10' cols='45' name='text'></textarea>
</div>

<div class='mail_body_parts' style='background-color: #F0F0F0; width: 15%;'>
    <b><h2>Тело КП:</h2></b>
    <div>
        <b><h3>Гидравлика</h3></b>
        <label for='1_bechem'>BECHEM</label><input id='1_bechem' type='checkbox'><br>
        <label for='1_total'>TOTAL</label><input id='1_total' type='checkbox'><br>
        <label for='1_shell'>SHELL</label><input id='1_shell' type='checkbox'><br>
    </div>
    
    <div>
        <b><h3>СОЖи</h3></b>
        <label for='2_bechem'>BECHEM</label><input id='2_bechem' type='checkbox'><br>
    </div>
    
    <div>
        <b><h3>Пищевка</h3></b>
        <label for='3_bechem'>BECHEM</label><input id='3_bechem' type='checkbox'><br>
        <label for='3_total'>TOTAL</label><input id='3_total' type='checkbox'><br>
        <label for='3_rocol'>ROCOL</label><input id='3_rocol' type='checkbox'><br>
        <label for='3_matrix'>MATRIX</label><input id='3_matrix' type='checkbox'><br>
    </div>
</div>

<br>

<div class='mail_tail_parts' style='background-color: #F0F0F0; width: 20%'>
    <b><h2>Подписи:</h2></b>
    <label for='9_dima'>Дима</label><input id='9_dima' type='radio' name='9'><br>
    <label for='9_marina'>Марина</label><input id='9_marina' type='radio' name='9'><br>
    <label for='9_sergey'>Сергей</label><input id='9_sergey' type='radio' name='9'><br>
    <label for='9_timur'>Тимур</label><input id='9_timur' type='radio' name='9'><br>
    
</div>
<br>
<input type='button' value='СФОРМИРОВАТЬ' class='mail_compose'>

<div id='html_result'></div>

<script src='jquery.js'></script>
<script src='jquery-ui.js'></script>
<script src='auto_kp.js'></script>";