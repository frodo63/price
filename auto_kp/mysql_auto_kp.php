<?php
include_once 'pdo_auto_kp_connect.php';

echo"
<link rel='stylesheet' type='text/css' href='jquery_ui/jquery-ui.css'>
<link rel='stylesheet' type='text/css' href='jquery_ui/jquery-ui.structure.css'>
<link rel='stylesheet' type='text/css' href='jquery_ui/jquery-ui.theme.css'>
<script src='jquery_ui/external/jquery/jquery.js'></script>
<script src='jquery_ui/jquery-ui.js'></script>
<script src='auto_kp.js'></script>
";

echo"
<h1>Конструктор КП</h1>

<b><h1>ШАПКА КП:</h1></b>
    <input type='checkbox' id='with_pics'><label for='with_pics' style='font-size: 25px'>С картинками</label><br>
    <input type='checkbox' id='with_dealership'><label for='with_dealership' style='font-size: 25px'>Дилерство</label><br>
    <input type='checkbox' id='with_thoughts'><label for='with_thoughts' style='font-size: 25px'>Умные мысли</label><br>
    <input type='checkbox' id='with_preferred_firm'><label for='with_preferred_firm' style='font-size: 25px'>Тип предприятия клиента</label><br>
    <div id='preferred' style='display:none; width: 40%'>
        <span style='font-size:20px;'>Снабжение </span><input type='text' id='preferred_trade_group_input' size='30' value='промышленных' style='font-size: 20px;text-align: center'>        
        <select id='firm_type' style='font-size: 20px'>
          <option>предприятий</option>
          <option>производств</option>
        </select>
        
        <span style='font-size:20px;'>- одно из ключевых направлений нашей деятельности.</span><br>
    </div>
    <input type='checkbox' id='with_custom_text'><label for='with_custom_text' style='font-size: 25px'>Свой текст (будет обернут в параграф)</label><br><textarea id='the_custom_text' style='margin: 0px; width: 40%; height: 150px; display: none'></textarea><br>
    <input type='checkbox' id='with_whole_product_list'><label for='with_whole_product_list' style='font-size: 25px'>Общий список продукции</label><br>
    <input type='checkbox' id='with_closing'><label for='with_closing' style='font-size: 25px'>Заключение</label><br>
    <b><h1>Тело КП:</h1></b>
    <input type='checkbox' id='with_prices'><label for='with_prices' style='font-size: 25px'>С ЦЕНАМИ</label><br>

<div class='mail_body_parts' style='background-color: #F0F0F0; font-size: 18px; width: 40%'>    
    <div>
    
  <div id='accordion'>
      <h3 style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:100%'>Краткий список смазочных материалов</h3>
       <div>
        <div>
            <input id='21_' class='select_group' type='checkbox'><b><label for='21_' style='margin-bottom: 0'>Общий список</label></b><br><br>
            
            <label for=''>Масла</label><br><br>
            
            <input id='21_ekp_oil_hydraulic' type='checkbox'><label for='21_ekp_oil_hydraulic'>Гидравлика</label><br>
            <input id='21_ekp_oil_reductor' type='checkbox'><label for='21_ekp_oil_reductor'>Редукторы</label><br>
            <input id='21_ekp_oil_compressor' type='checkbox'><label for='21_ekp_oil_compressor'>Компрессоры</label><br>
            <input id='21_ekp_oil_transmission' type='checkbox'><label for='21_ekp_oil_transmission'>Трансмиссия</label><br>
            <input id='21_ekp_oil_diesel' type='checkbox'><label for='21_ekp_oil_diesel'>Дизельные двигатели</label><br>
            <input id='21_ekp_oil_guideline' type='checkbox'><label for='21_ekp_oil_guideline'>Направляющие</label><br>
            <input id='21_ekp_oil_chain' type='checkbox'><label for='21_ekp_oil_chain'>Цепи</label><br><br>
            
            <label for=''>Смазки</label><br><br>
            
            <input id='21_ekp_gr_universal' type='checkbox'><label for='21_ekp_gr_universal'>Смазки Универсальные</label><br>
            <input id='21_ekp_gr_vniinp' type='checkbox'><label for='21_ekp_gr_vniinp'>СМАЗКИ ВНИИНП</label><br>
            <input id='21_ekp_gr_highsustain' type='checkbox'><label for='21_ekp_gr_highsustain'>Смазки,устойчивые к воздействию сред</label><br>
            <input id='21_ekp_gr_lowtemp' type='checkbox'><label for='21_ekp_gr_lowtemp'>Смазки для низких температур</label><br>
            <input id='21_ekp_gr_hightemp' type='checkbox'><label for='21_ekp_gr_hightemp'>Смазки для высоких температур</label><br>
            <input id='21_ekp_gr_food' type='checkbox'><label for='21_ekp_gr_food'>Смазки для пищевой промышленности</label><br>
            <input id='21_ekp_gr_gear' type='checkbox'><label for='21_ekp_gr_gear'>Трансмиссионные смазочные материалы</label><br>
            <input id='21_ekp_gr_silicone' type='checkbox'><label for='21_ekp_gr_silicone'>Силиконовые смазочные материалы</label><br>
            <input id='21_ekp_gr_electrocontact' type='checkbox'><label for='21_ekp_gr_electrocontact'>Смазки для электроконтактов</label><br>
            <input id='21_ekp_gr_chain' type='checkbox'><label for='21_ekp_gr_chain'>Смазочные материалы для цепей</label><br>
            <input id='21_ekp_gr_composition' type='checkbox'><label for='21_ekp_gr_composition'>Резьбовые и монтажные смазки</label><br>
            <input id='21_ekp_gr_rope' type='checkbox'><label for='21_ekp_gr_rope'>Канатные смазки</label><br>
            <input id='21_ekp_gr_guideline' type='checkbox'><label for='21_ekp_gr_guideline'>Смазки для направляющих</label><br>
            <input id='21_ekp_gr_support' type='checkbox'><label for='21_ekp_gr_support'>Смазки для суппортов</label><br>
            <input id='21_ekp_gr_polymer' type='checkbox'><label for='21_ekp_gr_polymer'>Смазки полимерных материалов</label><br>            
            <input id='21_ekp_gr_opengear' type='checkbox'><label for='21_ekp_gr_opengear'>Смазки для открытых передач</label><br><br>
            
            <label for=''>Спецжидкости</label><br><br>
            
            <input id='21_ekp_sl_sog' type='checkbox'><label for='21_ekp_sl_sog'>СОЖ для металлообработки</label><br>
            <input id='21_ekp_sl_cleaner' type='checkbox'><label for='21_ekp_sl_cleaner'>Очистители</label><br>
            <input id='21_ekp_sl_dissolver' type='checkbox'><label for='21_ekp_sl_dissolver'>Растворители</label><br>
            <input id='21_ekp_sl_tosols' type='checkbox'><label for='21_ekp_sl_tosols'>Тосолы, антифризы</label><br>
            <input id='21_ekp_sl_heattransfer' type='checkbox'><label for='21_ekp_sl_heattransfer'>Теплоносители</label><br>
            <input id='21_ekp_sl_brakes' type='checkbox'><label for='21_ekp_sl_brakes'>Жидкости для тормозной системы</label><br>
        </div>        
      </div>";
echo"
      
      <h3 style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:100%'>Масла</h3>
      <div>
        <div>
            <input id='1_' class='select_group' type='checkbox'><b><label for='1_' style='margin-bottom: 0'>Гидравлика</label></b><br>
            <input id='1_Bechem' type='checkbox'><label for='1_Bechem'>Bechem</label><br>
            <input id='1_Total' type='checkbox'><label for='1_Total'>Total</label><br>
            <input id='1_Shell' type='checkbox'><label for='1_Shell'>Shell</label><br>
        </div>
        <div>
            <br><input id='2_' class='select_group' type='checkbox'><b><label for='2_' style='margin-bottom: 0'>Моторка</label></b><br>
            <input id='2_Lukoil' type='checkbox'><label for='2_Lukoil'>Лукойл</label><br>
            <input id='2_Rosneft' type='checkbox'><label for='2_Rosneft'>Роснефть</label><br>
            <input id='2_Shell' type='checkbox'><label for='2_Shell'>Shell</label><br>
        </div>
        <div>
            <br><input id='3_' class='select_group' type='checkbox'><b><label for='3_' style='margin-bottom: 0'>Редуктор</label></b><br>
            <input id='3_Bechem' type='checkbox'><label for='3_Bechem'>Bechem</label><br>
            <input id='3_Mobil' type='checkbox'><label for='3_Mobil'>Mobil</label><br>
            <input id='3_Shell' type='checkbox'><label for='3_Shell'>Shell</label><br>
            <input id='3_Total' type='checkbox'><label for='3_Total'>Total</label><br>
            <input id='3_Agip' type='checkbox'><label for='3_Agip'>Agip</label><br>
        </div>
        <div>
            <br><input id='4_' class='select_group' type='checkbox'><b><label for='4_' style='margin-bottom: 0'>Компрессор</label></b><br>
            <input id='4_Bechem' type='checkbox'><label for='4_Bechem'>Bechem</label><br>
            <input id='4_Mobil' type='checkbox'><label for='4_Mobil'>Mobil</label><br>
            <input id='4_Shell' type='checkbox'><label for='4_Shell'>Shell</label><br>
            <input id='4_Total' type='checkbox'><label for='4_Total'>Total</label><br>
        </div>
        <div>
            <br><input id='5_' class='select_group' type='checkbox'><b><label for='5_' style='margin-bottom: 0'>Трансмиссия</label></b><br>
            <input id='5_Mobil' type='checkbox'><label for='5_Mobil'>Mobil</label><br>
            <input id='5_Shell' type='checkbox'><label for='5_Shell'>Shell</label><br>
            <input id='5_Total' type='checkbox'><label for='5_Total'>Total</label><br>
            <input id='5_Agip' type='checkbox'><label for='5_Agip'>Agip</label><br>
        </div>
        <div>
            <br><input id='6_' class='select_group' type='checkbox'><b><label for='6_' style='margin-bottom: 0'>Направляющие</label></b><br>
            <input id='6_Mobil' type='checkbox'><label for='6_Mobil'>Mobil</label><br>
            <input id='6_Agip' type='checkbox'><label for='6_Agip'>Agip</label><br>
        </div>
        <div>
           <br><input id='7_' class='select_group' type='checkbox'><b><label for='7_' style='margin-bottom: 0'>Цепи</label></b><br>
            <input id='7_Mobil' type='checkbox'><label for='7_Mobil'>Mobil</label><br>
            <input id='7_Agip' type='checkbox'><label for='7_Agip'>Agip</label><br>
        </div>
      </div>
  
      <h3 style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:100%'>Смазки</h3>
      <div>
        <div>
            <input id='8_' class='select_group' type='checkbox'><b><label for='8_' style='margin-bottom: 0'>Универсальные</label></b><br>
            <input id='8_Bechem' type='checkbox'><label for='8_Bechem'>Bechem</label><br>
        </div>
        <div>
            <br><input id='9_' class='select_group' type='checkbox'><b><label for='9_' style='margin-bottom: 0'>Для высоких температур</label></b><br>
            <input id='9_Lukoil' type='checkbox'><label for='9_Lukoil'>Лукойл</label><br>
            <input id='9_Bechem' type='checkbox'><label for='9_Bechem'>Bechem</label><br>
        </div>
        <div>
            <br><input id='10_' class='select_group' type='checkbox'><b><label for='10_' style='margin-bottom: 0'>Для низких температур и высоких скоростей</label></b><br>
            <input id='10_Bechem' type='checkbox'><label for='10_Bechem'>Bechem</label><br>
        </div>
        <div>
            <br><input id='11_' class='select_group' type='checkbox'><b><label for='11_' style='margin-bottom: 0'>Устойчивые к воздействию сред</label></b><br>
            <input id='11_Bechem' type='checkbox'><label for='11_Bechem'>Bechem</label><br>
        </div>
        <div>
            <br><input id='12_' class='select_group' type='checkbox'><b><label for='12_' style='margin-bottom: 0'>Силиконовые</label></b><br>
            <input id='12_Mobil' type='checkbox'><label for='12_Mobil'>Mobil</label><br>
            <input id='12_Bechem' type='checkbox'><label for='12_Bechem'>Bechem</label><br>
        </div>
        <div>
            <br><input id='13_' class='select_group' type='checkbox'><b><label for='13_' style='margin-bottom: 0'>Для цепей</label></b><br>
            <input id='13_Mobil' type='checkbox'><label for='13_Mobil'>Mobil</label><br>
            <input id='13_Bechem' type='checkbox'><label for='13_Bechem'>Bechem</label><br>
        </div>
        <div>
            <br><input id='14_' class='select_group' type='checkbox'><b><label for='14_' style='margin-bottom: 0'>Сборочные и монтажные смазки/пасты</label></b><br>
            <input id='14_Bechem' type='checkbox'><label for='14_Bechem'>Bechem</label><br>
        </div>
      </div>
  
      <h3 style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:100%'>Металлообработка</h3>
      <div>       
        <div>
            <b><input id='15_' class='select_group' type='checkbox'><label for='15_' style='margin-bottom: 0'>СОЖ</label></b><br>
            <input id='15_Bechem' type='checkbox'><label for='15_Bechem'>Bechem</label><br>
        </div>
        <div>
            <br><input id='16_' class='select_group' type='checkbox'><b><label for='16_' style='margin-bottom: 0'>Жидкости для СОЖ</label></b><br>
            <input id='16_Bechem' type='checkbox'><label for='16_Bechem'>Bechem</label><br>
            <input id='16_Troy' type='checkbox'><label for='16_Troy'>Troy</label><br>
        </div>
      </div>
  
      <h3 style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:100%'>Пищевка</h3>
      <div>
          <div>
              <input id='17_' class='select_group' type='checkbox'><b><label for='17_' style='margin-bottom: 0'>Масла</label></b><br>
              <input id='17_Bechem' type='checkbox'><label for='17_Bechem'>Bechem</label><br>
              <input id='17_Total' type='checkbox'><label for='17_Total'>Total</label><br>
              <input id='17_Rocol' type='checkbox'><label for='17_Rocol'>Rocol</label><br>
              <input id='17_Matrix' type='checkbox'><label for='17_Matrix'>MATRIX</label><br>
          </div>
          <div>
              <br><input id='18_' class='select_group' type='checkbox'><b><label for='18_' style='margin-bottom: 0'>Смазки</label></b><br>
              <input id='18_Bechem' type='checkbox'><label for='18_Bechem'>Bechem</label><br>
              <input id='18_Total' type='checkbox'><label for='18_Total'>Total</label><br>
              <input id='18_Rocol' type='checkbox'><label for='18_Rocol'>Rocol</label><br>
              <input id='18_Matrix' type='checkbox'><label for='18_Matrix'>MATRIX</label><br>
          </div>
          <div>
              <br><input id='19_' class='select_group' type='checkbox'><b><label for='19_' style='margin-bottom: 0'>Очистители/растворители</label></b><br>
              <input id='19_Bechem' type='checkbox'><label for='19_Bechem'>Bechem</label><br>
              <input id='19_Total' type='checkbox'><label for='19_Total'>Total</label><br>
              <input id='19_Rocol' type='checkbox'><label for='19_Rocol'>Rocol</label><br>
              <input id='19_Matrix' type='checkbox'><label for='19_Matrix'>MATRIX</label><br>
          </div>
      </div>
      <h3 style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:100%'>Ввести отдельный продукт</h3>
      <div style='position: relative' id='custom_trades'>
      
      <input type='button' style='position: absolute; top: 5px; right: 5px' id='add_custom_trade' value='+'>      
          
      </div>
  </div>";


echo"

<br>

<div class='mail_tail_parts' style='background-color: #F0F0F0; width: 40%; font-size: 18px'>
    <b><h2>Подписи:</h2></b>
    <label for='20_dima'>Дима</label><input id='20_dima' type='radio' name='9'><br>
    <label for='20_marina'>Марина</label><input id='20_marina' type='radio' name='9'><br>
    <label for='20_sergey'>Сергей</label><input id='20_sergey' type='radio' name='9'><br>
    <label for='20_timur'>Тимур</label><input id='20_timur' type='radio' name='9'><br>
    <br><br>
    <input type='button' value='СФОРМИРОВАТЬ' class='mail_compose' style='font-size: 30px'>    
</div>
<br>

<div class='custom_greeting' style='width: 40%'>
<h2>HTML Письма:</h2>
    <textarea id='html_copy' rows='12' cols='90' name='text'></textarea>
    <br>
    <span id='info_span' style='color: green'></span>
    <br>
    <input type='button' value='СКОПИРОВАТЬ' id='mail_copy' style='font-size: 30px'>
    <br><br>
    <input type='button' value='УБРАТЬ ВСЕ ГАЛОЧКИ' id='deselect_all' style='font-size: 15px'>    
</div>

<div id='html_result' style='width: 55%; position: absolute; top: 0; right: 0;'></div>
";