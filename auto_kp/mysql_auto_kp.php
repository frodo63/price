<?php
include_once 'pdo_auto_kp_connect.php';

echo"
<h1>Конструктор КП</h1>
<div class='custom_greeting'>
<h2>Приветственное слово:</h2>
    <textarea rows='10' cols='45' name='text'></textarea>
</div>

<div class='mail_body_parts' style='background-color: #F0F0F0; width: 15%;'>
    <b><h2>Тело КП:</h2></b>
    <div>
        <b><h3>Гидравлика</h3></b>
        <label for='hydraulics_bechem'>BECHEM</label><input id='hydraulics_bechem' type='checkbox'><br>
        <label for='hydraulics_total'>TOTAL</label><input id='hydraulics_total' type='checkbox'><br>
    </div>
    
    <div>
        <b><h3>СОЖи</h3></b>
        <label for='soges_bechem'>BECHEM</label><input id='soges_bechem' type='checkbox'><br>
    </div>
    
    <div>
        <b><h3>Пищевка</h3></b>
        <label for='food_bechem'>BECHEM</label><input id='food_bechem' type='checkbox'><br>
        <label for='food_total'>TOTAL</label><input id='food_total' type='checkbox'><br>
        <label for='food_rocol'>ROCOL</label><input id='food_rocol' type='checkbox'><br>
        <label for='food_matrix'>MATRIX</label><input id='food_matrix' type='checkbox'><br>
    </div>
</div>

<br>

<div class='mail_tail_parts' style='background-color: #F0F0F0; width: 20%'>
    <b><h2>Подписи:</h2></b>
    <label for='tail_dima'>Дима</label><input id='tail_dima' type='radio' name='tail'><br>
    <label for='tail_marina'>Марина</label><input id='tail_marina' type='radio' name='tail'><br>
    <label for='tail_sergey'>Сергей</label><input id='tail_sergey' type='radio' name='tail'><br>
    <label for='tail_timur'>Тимур</label><input id='tail_timur' type='radio' name='tail'><br>
    
</div>
<br>
<input type='button' value='СФОРМИРОВАТЬ' class='mail_compose'>
<script src='jquery.js'></script>
<script src='jquery-ui.js'></script>
<script src='auto_kp.js'></script>";