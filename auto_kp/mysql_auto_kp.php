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

<div class='mail_body_parts' style='background-color: #F0F0F0; font-size: 18px; width: 40%'>
    <b><h1>Тело КП:</h1></b>
    
    <div>
        <span>Снабжение </span><input type='text' id='preferred_trade_group_input' size='30' value='промышленных' style='font-size: 20px;text-align: center'>
        
        <select id='firm_type' style='font-size: 20px'>
          <option>предприятий</option>
          <option>производств</option>
        </select>
        
        <span>- одно из ключевых направлений нашей деятельности.</span>
    </div>
    
    <div>
<p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>Масла</p>
        <div>
        <b><label for='1_' style='margin-bottom: 0'>Гидравлика</label><input id='1_' class='select_group' type='checkbox'></b><br>
        <label for='1_Bechem'>Bechem</label><input id='1_Bechem' type='checkbox'><br>
        <label for='1_Total'>Total</label><input id='1_Total' type='checkbox'><br>
        <label for='1_Shell'>Shell</label><input id='1_Shell' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='2_' style='margin-bottom: 0'>Моторка</label><input id='2_' class='select_group' type='checkbox'></b><br>
        <label for='2_Lukoil'>Лукойл</label><input id='2_Lukoil' type='checkbox'><br>
        <label for='2_Rosneft'>Роснефть</label><input id='2_Rosneft' type='checkbox'><br>
        <label for='2_Shell'>Shell</label><input id='2_Shell' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='3_' style='margin-bottom: 0'>Редуктор</label><input id='3_' class='select_group' type='checkbox'></b><br>
        <label for='3_Bechem'>Bechem</label><input id='3_Bechem' type='checkbox'><br>
        <label for='3_Mobil'>Mobil</label><input id='3_Mobil' type='checkbox'><br>
        <label for='3_Shell'>Shell</label><input id='3_Shell' type='checkbox'><br>
        <label for='3_Total'>Total</label><input id='3_Total' type='checkbox'><br>
        <label for='3_Agip'>Agip</label><input id='3_Agip' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='4_' style='margin-bottom: 0'>Компрессор</label><input id='4_' class='select_group' type='checkbox'></b><br>
        <label for='4_Bechem'>Bechem</label><input id='4_Bechem' type='checkbox'><br>
        <label for='4_Mobil'>Mobil</label><input id='4_Mobil' type='checkbox'><br>
        <label for='4_Shell'>Shell</label><input id='4_Shell' type='checkbox'><br>
        <label for='4_Total'>Total</label><input id='4_Total' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='5_' style='margin-bottom: 0'>Трансмиссия</label><input id='5_' class='select_group' type='checkbox'></b><br>
        <label for='5_Mobil'>Mobil</label><input id='5_Mobil' type='checkbox'><br>
        <label for='5_Shell'>Shell</label><input id='5_Shell' type='checkbox'><br>
        <label for='5_Total'>Total</label><input id='5_Total' type='checkbox'><br>
        <label for='5_Agip'>Agip</label><input id='5_Agip' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='6_' style='margin-bottom: 0'>Направляющие</label><input id='6_' class='select_group' type='checkbox'></b><br>
        <label for='6_Mobil'>Mobil</label><input id='6_Mobil' type='checkbox'><br>
        <label for='6_Agip'>Agip</label><input id='6_Agip' type='checkbox'><br>
        </div>
        <div>
       <br><b><label for='7_' style='margin-bottom: 0'>Цепи</label><input id='7_' class='select_group' type='checkbox'></b><br>
        <label for='7_Mobil'>Mobil</label><input id='7_Mobil' type='checkbox'><br>
        <label for='7_Agip'>Agip</label><input id='7_Agip' type='checkbox'><br>
        </div>
    </div>
    
    <p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>Смазки</p>
        <div>
        <b><label for='8_' style='margin-bottom: 0'>Универсальные</label><input id='8_' class='select_group' type='checkbox'></b><br>
        <label for='8_Bechem'>Bechem</label><input id='8_Bechem' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='9_' style='margin-bottom: 0'>Для высоких температур</label><input id='9_' class='select_group' type='checkbox'></b><br>
        <label for='9_Lukoil'>Лукойл</label><input id='9_Lukoil' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='10_' style='margin-bottom: 0'>Для низких температур и высоких скоростей</label><input id='10_' class='select_group' type='checkbox'></b><br>
        <label for='10_Bechem'>Bechem</label><input id='10_Bechem' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='11_' style='margin-bottom: 0'>Устойчивые к воздействию сред</label><input id='11_' class='select_group' type='checkbox'></b><br>
        <label for='11_Bechem'>Bechem</label><input id='11_Bechem' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='12_' style='margin-bottom: 0'>Силиконовые</label><input id='12_' class='select_group' type='checkbox'></b><br>
        <label for='12_Mobil'>Mobil</label><input id='12_Mobil' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='13_' style='margin-bottom: 0'>Для цепей</label><input id='13_' class='select_group' type='checkbox'></b><br>
        <label for='13_Mobil'>Mobil</label><input id='13_Mobil' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='14_' style='margin-bottom: 0'>Сборочные и монтажные смазки/пасты</label><input id='14_' class='select_group' type='checkbox'></b><br>
        <label for='14_Bechem'>Bechem</label><input id='14_Bechem' type='checkbox'><br>
        </div>    
    <div>
        <p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>Металлобработка</p>
        <div>
        <b><label for='15_' style='margin-bottom: 0'>СОЖ</label><input id='15_' class='select_group' type='checkbox'></b><br>
        <label for='15_Bechem'>Bechem</label><input id='15_Bechem' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='16_' style='margin-bottom: 0'>Жидкости для СОЖ</label><input id='16_' class='select_group' type='checkbox'></b><br>
        <label for='16_Bechem'>Bechem</label><input id='16_Bechem' type='checkbox'><br>
        </div>
    </div>
    
    <div>
        <p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>Пищевка</p>
        <div>
        <b><label for='17_' style='margin-bottom: 0'>Масла</label><input id='17_' class='select_group' type='checkbox'></b><br>
        <label for='17_Bechem'>Bechem</label><input id='17_Bechem' type='checkbox'><br>
        <label for='17_Total'>Total</label><input id='17_Total' type='checkbox'><br>
        <label for='17_Rocol'>Rocol</label><input id='17_Rocol' type='checkbox'><br>
        <label for='17_Matrix'>MATRIX</label><input id='17_Matrix' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='18_' style='margin-bottom: 0'>Смазки</label><input id='18_' class='select_group' type='checkbox'></b><br>
        <label for='18_Bechem'>Bechem</label><input id='18_Bechem' type='checkbox'><br>
        <label for='18_Total'>Total</label><input id='18_Total' type='checkbox'><br>
        <label for='18_Rocol'>Rocol</label><input id='18_Rocol' type='checkbox'><br>
        <label for='18_Matrix'>MATRIX</label><input id='18_Matrix' type='checkbox'><br>
        </div>
        <div>
        <br><b><label for='19_' style='margin-bottom: 0'>Очистители/растворители</label><input id='19_' class='select_group' type='checkbox'></b><br>
        <label for='19_Bechem'>Bechem</label><input id='19_Bechem' type='checkbox'><br>
        <label for='19_Total'>Total</label><input id='19_Total' type='checkbox'><br>
        <label for='19_Rocol'>Rocol</label><input id='19_Rocol' type='checkbox'><br>
        <label for='19_Matrix'>MATRIX</label><input id='19_Matrix' type='checkbox'><br>
        </div>
    </div>
</div>
    
    
    
</div>

<br>

<div class='mail_tail_parts' style='background-color: #F0F0F0; width: 40%; font-size: 18px'>
    <b><h2>Подписи:</h2></b>
    <label for='20_dima'>Дима</label><input id='20_dima' type='radio' name='9'><br>
    <label for='20_marina'>Марина</label><input id='20_marina' type='radio' name='9'><br>
    <label for='20_sergey'>Сергей</label><input id='20_sergey' type='radio' name='9'><br>
    <label for='20_timur'>Тимур</label><input id='20_timur' type='radio' name='9'><br>
    
</div>
<br>
<input type='button' value='СФОРМИРОВАТЬ' class='mail_compose' style='font-size: 20px'>
<label for='with_prices' style='font-size: 20px'>С ЦЕНАМИ</label><input type='checkbox' id='with_prices'><br>


<div id='html_result' style='width: 55%; position: absolute; top: 0; right: 0;'></div>

";