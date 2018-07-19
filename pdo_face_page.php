<?php
echo"
<head>
        <link rel='stylesheet' href='js/jquery_ui/jquery-ui.css'>
        <link rel='stylesheet' href='css/jquery-ui.structure.min.css'>
        <link rel='stylesheet' href='css/styles.css'>
        <script src='js/jquery.js'></script>
</head>
";

echo "
<div id='pricingwindow' positionid='-' pricingid='-'>
    <form id='price'><div class='sres'></div>
        <label for='trade'>Товар</label><input trade_id = 'blank' autocomplete='off' type='text' name='trade' id='trade' placeholder='Введите товар' size='70'/><div class='sres'></div>
        <label for='seller'>Поставщик:</label><input seller_id = 'blank' autocomplete='off' type='text' name='seller' id='seller' placeholder='Введите поставщика' size='70'/><div class='sres'></div><br />
        <label for='zakup'>ЗАКУП ЗА 1 ШТ:</label> <input type='number' name='zak' id='zak' min='1' step='1'/> руб.<br />
        <label for='kol'>Кол-во:</label> <input type='number' name='kol' id='kol'  min='1'/><br />
        <label for='tzr'>ТЗР на ШТУКЕ:</label> <input type='number' name='tzr' id='tzr'  min='0' step='1'/> руб. С обналом: <p id='obtzr'></p> руб.<br /><br />
        <div id='fcount'>
        <label for='op'>НАШ ПРОЦЕНТ:</label> <input type='number' size='2' name='op' id='op'  min='1' step='0.01'/>% / <p id='opr'></p> руб.<br />
        <label for='tp'>ЕНОТ:</label> <input type='number' size='2' name='tp' id='tp'  min='0' step='0.01'/>% / <p id='tpr'></p> руб. НА РУКИ : <p id='firstoh'></p> руб. (<p id='clearp'></p> ЧИСТЫМИ)<br/><br />
        <label for='firstobp'>ОБНАЛ:</label> <input type='number' size='2' name='firstobp' id='firstobp'  min='0' step='0.1'/>% / <p id='firstobpr'></p> руб.<br />
        <label for='wtime'>ОТСРОЧКА:</label> <input type='number' size='2' name='wtime' id='wtime'  min='0' step='0.03'/> мес. <p id='wtimeday'></p> дней.        
        </div>
        <div id='margediv'>
        <br />
        <label for='marge'>МАРЖА<br />ВСЕГО:</label> <p id='marge'></p> руб. / НА ШТУКЕ: <p id='margek'></p> руб.<br /><br />
        СООТНОШЕНИЕ<br/>
        НАШИМ:<br/><input id='rop' type='number' min='0' step='1'/><p id='realop'></p><br/>
        НЕНАШИМ:<br/><input id='rtp' type='number' min='0' step='1'/><p id='realtp'></p><br/><br/>
        <div id='obnal'>
        <label for='obp'>Обнал:</label> <input type='number' size='2' name='obp' id='obp'  min='0' step='0.1'/>%,<br/><p id='onhands'>ИТОГО НА РУКИ:</p><p id='oh'></p>
        </div><br />
        </div>
        <input type='submit' name='submit' value='Посчитать' id='go' />
        <div id='result'>
        <h2>Итоговая цена:</h2>
        <input type='number' name='price' id='pr' value='0' min='0' step='0.01'/>
        <input name='fixate' id='fixate' type='button' value='Закрепить'/>
        </div>
        <div id='rent'><h2>Рентабельность:</h2><h1>0</h1></div>
        <div id='cases'></div>
    </form>
        <input type='button' value='X' class='closepricing'>                
        <script src='js/price_mysql.js'></script>     
</div>
<div id='editmsg'></div>
<input id='thesearch' type='text' placeholder='Начните вводить наименование поставщика, покупателя, товара или название заявки'category='' theID=''>
<div id='sres'></div>
<br>
<input type='button' id='readstoggle' value='Скрыть/Показать табы'>
<div id='reads'>                                                                                                               
      <ul>
        <li id='tab_requests'><a href='#requests'>Заявки</a></li>
        <li id='tab_byers'><a href='#byers'>Покупатели</a></li>
        <li id='tab_sellers'><a href='#sellers'>Поставщики</a></li>
        <li id='tab_trades'><a href='#trades'>Товары</a></li>
        <li id='tab_giveaways'><a href='#givaways'>Расчеты по заявкам</a></li>
      </ul>
  
      <div id='requests'>
      <input type='button' class='addnew' value='+'> Добавить заявку
          <div class='creates add_ramk'>
              <br>
                    <input type='text' placeholder='Выберите Покупателя' size='20' id ='byer' autocomplete='off'>
                    <div class='sres'></div>
                    <input type='text' id='req_name' placeholder='Введите название для Заявки' size='70'>                
                    <input type='button' name='requests' value='Добавить заявку'>
              <br>
              <br>
          </div>
          <div id='requests_date_range'>
              <span>Выберите временной интервал</span><br>
              <!--<input class='from' type='date'><input class='to' type='date'>-->
              <input class='from' size='10' placeholder='От'><input class='to' size='10' placeholder='До'>

              <input class='filter_date' type='button' value='Отобразить'>
          </div>
          <div class='requests_list'>
          </div>                
      </div>     
      
      <div id='byers'>
      <input type='button' class='addnew' value='+'> Добавить покупателя
              <div class='creates add_ramk'>
          <br>
                  <input type='text' placeholder='Введите наименование Покупателя' size='70'>
                  <input type='button' name='byers' value='Добавить'>
          <br>
          <br>
              </div>
          <div class='byers_list'>
          </div>
      </div>      
      
      <div id='sellers'>
      <input type='button' class='addnew' value='+'> Добавить поставщика
          <div class='creates add_ramk'>
          <br>
              <input type='text' placeholder='Введите наименование Поставщика' size='70'>
              <input type='button' name='sellers' value='Добавить'>  
          <br>
          <br>
          </div>
          <div class='sellers_list'>
          </div>
      </div>
        
      <div id='trades'>
      <input type='button' class='addnew' value='+'> Добавить номенклатуру
          <div class ='creates add_ramk'>
          <br>
              <input type='text' placeholder='Введите наименование Товара' size='70'>
              <input type='button' name='trades' value='Добавить'>
          <br>
          <br>
          </div>
          <div class='trades_list'>
          </div>
      </div>  
      
      <div id='givaways'>      
      <!--Добавить Платежку -->  
              <div id='add_payment'>
                  <span>Вводим платежку</span>
                  <br>
                  <label for='1'><span>Дата платежа:</span></label><input id='add_payment_date' name='1' type='date' size='20'><br>
                  <label for='2'><span>Номер п/п</span></label><input id='add_payment_1c_num' name='2' type='text' size='20'><br>
                  <label for='3'><span>Комментарий</span></label><input id='add_payment_comment'name='3' type='text' size='20'><br>
                  <label for='4'><span>Сумма, руб.</span></label><input id='add_payment_sum' name='4' type='text' size='20'><br>
                  <span class='ready_comment'></span><br>
                  <input id='button_add_payment' type='button' name='add_payment' requestid='' value='Добавить платежку'>
                  <input class='close_add_p' type='button' value='X'>
              </div>
      <!--Добавить Выдачу -->
              <div id='add_giveaway'>
                  <span>Вводим выдачу</span>
                  <br>
                  <label for='1'><span>Дата выдачи:</span></label><input id='add_giveaway_date' type='date' name='1'size='1'><br>
                  <label for='2'><span>Комментарий:</span></label><input id='add_giveaway_comment' type='text' name='2' size='20'><br>
                  <label for='3'><span>Сумма, руб.:</span></label><input id='add_giveaway_sum' type='text' name='3' size='20'><br>
                  <span class='ready_comment'></span><br>
                  <input id='button_add_giveaway' type='button' name='add_giveaway' requestid='' value='Добавить выдачу'>
                  <input class='close_add_g' type='button' value='X'>
              </div>
      
          <div class='givaways_list'>
          
          </div>      
      </div>    
  
</div>
<!--Блок редактирования номера и зады заявки-->
              <div id='edit_1c_num'>
                  <span>Изменить номер заказа в 1С</span>
                  <br>
                  <label for='1'><span>Введите новый номер:</span></label><input id='add_1c_num' name='1' type='text' size='20'><br>
                  <input id='button_edit_1c_num' type='button' name='edit_1c_num' requestid='' value='Изменить номер'><br><br>
                  
                  <span>Изменить дату заказа</span>
                  <br>
                  <label for='2'><span>Дата:</span></label><input id='add_created' name='2' size='20'><br>
                  <input id='button_edit_created' type='button' name='edit_created' requestid='' value='Изменить дату'>
                  
                  <input class='close_edit_1c_num' type='button' value='X'>
              </div> 
<!---->
<input type='button' id='req_searchstoggle' value='Скрыть/Показать результаты поиска'>
<div id='search_reads'>
<div class='requests_list'>
          </div> 

</div> 
";





echo"
<script src='js/jquery.js'></script>
<script src='js/jquery_ui/jquery-ui.js'></script>
<script src='js/mysql_scripts.js'></script>
<script src='js/mysql_edc.js'></script>
<script src='js/mysql_searching.js'></script>

";