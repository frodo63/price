<?php
include_once 'pdo_auto_kp_connect.php';

echo"
<script src='jquery.js'></script>
<script src='jquery-ui.js'></script>
<script src='auto_kp.js'></script>


<h1>Конструктор КП</h1>
<div class='custom_greeting' style='width: 40%'>
<h2>HTML Письма:</h2>
    <textarea id='html_copy' rows='10' cols='45' name='text'></textarea>
    <br>
    <span id='info_span' style='color: green'></span>
    <br>
    <input type='button' value='СКОПИРОВАТЬ' id='mail_copy' style='font-size: 30px'>
</div>

<div class='mail_body_parts' style='background-color: #F0F0F0; font-size: 20px; width: 40%'>
    <b><h2>Тело КП:</h2></b>
    
    <div>
        <span>Снабжение </span><input type='text' id='preferred_trade_group_input' size='30' style='font-size: 20px;text-align: center'>
        
        <select id='firm_type' style='font-size: 20px'>
          <option>предприятий</option>
          <option>производств</option>
        </select>
        
        <span>- одно из ключевых направлений нашей деятельности.</span>
    </div>
    
    <div>
        <b><h3>Гидравлика</h3></b>
        <label for='1_Bechem'>Bechem</label><input id='1_Bechem' type='checkbox'><br>
        <label for='1_Total'>Total</label><input id='1_Total' type='checkbox'><br>
        <label for='1_Shell'>Shell</label><input id='1_Shell' type='checkbox'><br>
    </div>
    
    <div>
        <b><h3>СОЖи</h3></b>
        <label for='2_Bechem'>Bechem</label><input id='2_Bechem' type='checkbox'><br>
    </div>
    
    <div>
        <b><h3>Пищевка</h3></b>
        <label for='3_Bechem'>Bechem</label><input id='3_Bechem' type='checkbox'><br>
        <label for='3_Total'>Total</label><input id='3_Total' type='checkbox'><br>
        <label for='3_Rocol'>Rocol</label><input id='3_Rocol' type='checkbox'><br>
        <label for='3_Matrix'>MATRIX</label><input id='3_Matrix' type='checkbox'><br>
    </div>
</div>

<br>

<div class='mail_tail_parts' style='background-color: #F0F0F0; width: 20%; font-size: 20px'>
    <b><h2>Подписи:</h2></b>
    <label for='9_dima'>Дима</label><input id='9_dima' type='radio' name='9'><br>
    <label for='9_marina'>Марина</label><input id='9_marina' type='radio' name='9'><br>
    <label for='9_sergey'>Сергей</label><input id='9_sergey' type='radio' name='9'><br>
    <label for='9_timur'>Тимур</label><input id='9_timur' type='radio' name='9'><br>
    
</div>
<br>
<input type='button' value='СФОРМИРОВАТЬ' class='mail_compose' style='font-size: 30px'>

<div id='html_result' style='width: 55%; position: absolute; top: 0; right: 0;'></div>

";