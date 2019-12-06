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
    <b><h1>Тело КП:</h1></b>
    
    <div>
        <span>Снабжение </span><input type='text' id='preferred_trade_group_input' size='30' style='font-size: 20px;text-align: center'>
        
        <select id='firm_type' style='font-size: 20px'>
          <option>предприятий</option>
          <option>производств</option>
        </select>
        
        <span>- одно из ключевых направлений нашей деятельности.</span>
    </div>
    
    <div>
<p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>Масла</p>
        <b><h3>Гидравлика</h3></b>
        <label for='1_Bechem'>Bechem</label><input id='1_Bechem' type='checkbox'><br>
        <label for='1_Total'>Total</label><input id='1_Total' type='checkbox'><br>
        <label for='1_Shell'>Shell</label><input id='1_Shell' type='checkbox'><br>
        <b><h3>Моторка</h3></b>
        <label for='2_Bechem'>Лукойл</label><input id='2_Lukoil' type='checkbox'><br>
        <label for='2_Rosneft'>Роснефть</label><input id='2_Rosneft' type='checkbox'><br>
        <label for='2_Shell'>Shell</label><input id='2_Shell' type='checkbox'><br>
        <b><h3>Редуктор</h3></b>
        <label for='3_Bechem'>Bechem</label><input id='3_Bechem' type='checkbox'><br>
        <label for='3_Mobil'>Mobil</label><input id='3_Mobil' type='checkbox'><br>
        <label for='3_Shell'>Shell</label><input id='3_Shell' type='checkbox'><br>
        <label for='3_Total'>Total</label><input id='3_Total' type='checkbox'><br>
        <label for='3_Agip'>Agip</label><input id='3_Agip' type='checkbox'><br>
        <b><h3>Компрессор</h3></b>
        <label for='4_Bechem'>Bechem</label><input id='4_Bechem' type='checkbox'><br>
        <label for='4_Mobil'>Mobil</label><input id='4_Mobil' type='checkbox'><br>
        <label for='4_Shell'>Shell</label><input id='4_Shell' type='checkbox'><br>
        <label for='4_Total'>Total</label><input id='4_Total' type='checkbox'><br>
        <b><h3>Трансмиссия</h3></b>
        <label for='5_Mobil'>Mobil</label><input id='5_Mobil' type='checkbox'><br>
        <label for='5_Shell'>Shell</label><input id='5_Shell' type='checkbox'><br>
        <label for='5_Total'>Total</label><input id='5_Total' type='checkbox'><br>
        <label for='5_Agip'>Agip</label><input id='5_Agip' type='checkbox'><br>
        <b><h3>Направляющие</h3></b>
        <label for='6_Mobil'>Mobil</label><input id='6_Mobil' type='checkbox'><br>
        <label for='6_Agip'>Agip</label><input id='6_Agip' type='checkbox'><br>
        <b><h3>Цепи</h3></b>
        <label for='7_Mobil'>Mobil</label><input id='7_Mobil' type='checkbox'><br>
        <label for='7_Agip'>Agip</label><input id='7_Agip' type='checkbox'><br>
    </div>
    
    <div>
        <p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>Металлобработка</p>
        <b><h3>СОЖ</h3></b>
        <label for='8_Bechem'>Bechem</label><input id='8_Bechem' type='checkbox'><br>
        <b><h3>Жидкости для СОЖ</h3></b>
        <label for='9_Bechem'>Bechem</label><input id='9_Bechem' type='checkbox'><br>
    </div>
    
    <div>
        <p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>Пищевка</p>
        <b><h3>Масла</h3></b>
        <label for='10_Bechem'>Bechem</label><input id='10_Bechem' type='checkbox'><br>
        <label for='10_Total'>Total</label><input id='10_Total' type='checkbox'><br>
        <label for='10_Rocol'>Rocol</label><input id='10_Rocol' type='checkbox'><br>
        <label for='10_Matrix'>MATRIX</label><input id='10_Matrix' type='checkbox'><br>
        <b><h3>Смазки</h3></b>
        <label for='11_Bechem'>Bechem</label><input id='11_Bechem' type='checkbox'><br>
        <label for='11_Total'>Total</label><input id='11_Total' type='checkbox'><br>
        <label for='11_Rocol'>Rocol</label><input id='11_Rocol' type='checkbox'><br>
        <label for='11_Matrix'>MATRIX</label><input id='11_Matrix' type='checkbox'><br>
        <b><h3>Очистители/растворители</h3></b>
        <label for='12_Bechem'>Bechem</label><input id='12_Bechem' type='checkbox'><br>
        <label for='12_Total'>Total</label><input id='12_Total' type='checkbox'><br>
        <label for='12_Rocol'>Rocol</label><input id='12_Rocol' type='checkbox'><br>
        <label for='12_Matrix'>MATRIX</label><input id='12_Matrix' type='checkbox'><br>
    </div>
    
    <p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>Смазки</p>
        <b><h3>Универсальные</h3></b>
        <label for='13_Bechem'>Bechem</label><input id='13_Bechem' type='checkbox'><br>
        <b><h3>Для высоких температур</h3></b>
        <label for='14_Bechem'>Лукойл</label><input id='14_Lukoil' type='checkbox'><br>
        <b><h3>Для низких температур и высоких скоростей</h3></b>
        <label for='15_Bechem'>Bechem</label><input id='15_Bechem' type='checkbox'><br>
        <b><h3>Устойчивые к воздействию сред</h3></b>
        <label for='16_Bechem'>Bechem</label><input id='16_Bechem' type='checkbox'><br>
        <b><h3>Силиконовые</h3></b>
        <label for='17_Mobil'>Mobil</label><input id='17_Mobil' type='checkbox'><br>
        <b><h3>Для цепей</h3></b>
        <label for='18_Mobil'>Mobil</label><input id='18_Mobil' type='checkbox'><br>
        <b><h3>Сборочные и монтажные смазки/пасты</h3></b>
        <label for='19_Mobil'>Bechem</label><input id='19_Bechem' type='checkbox'><br>
    </div>
    
</div>

<br>

<div class='mail_tail_parts' style='background-color: #F0F0F0; width: 20%; font-size: 20px'>
    <b><h2>Подписи:</h2></b>
    <label for='20_dima'>Дима</label><input id='20_dima' type='radio' name='9'><br>
    <label for='20_marina'>Марина</label><input id='20_marina' type='radio' name='9'><br>
    <label for='20_sergey'>Сергей</label><input id='20_sergey' type='radio' name='9'><br>
    <label for='20_timur'>Тимур</label><input id='20_timur' type='radio' name='9'><br>
    
</div>
<br>
<input type='button' value='СФОРМИРОВАТЬ' class='mail_compose' style='font-size: 30px'>

<div id='html_result' style='width: 55%; position: absolute; top: 0; right: 0;'></div>

";