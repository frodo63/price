<?php
echo"
<head>
        <link rel='stylesheet' href='js/jquery_ui/jquery-ui.css'>
        <link rel='stylesheet' href='css/jquery-ui.structure.min.css'>
        <link rel='stylesheet' href='css/styles.css'>
        <script src='js/jquery.js'></script>
</head>";

echo "<div id='pricingwindow' positionid='-' pricingid='-' preditposid='-' byerid='-'>
    <form id='price'><div class='sres'></div>
        <label for='trade'>Товар</label><input trade_id = 'blank' tare='-' autocomplete='off' type='text' name='trade' id='trade' placeholder='Введите товар' size='70'/><div class='sres'></div>
        <label for='seller'>Поставщик:</label><input seller_id = 'blank' autocomplete='off' type='text' name='seller' id='seller' placeholder='Введите поставщика' size='70'/><div class='sres'></div><br />
        <label for='zakup'>ЗАКУП ЗА 1 ШТ:</label> <input type='number' name='zak' id='zak' min='1' step='1'/> руб.<br />
        <label for='kol'>Кол-во:</label> <input type='number' name='kol' id='kol'  min='1'/><br /><br />
        <label for='tzrknam'>Довезти 1шт ДО НАС:</label><input id='button_history_tzrknam' type='button' value='i'><input type='number' name='tzrknam' id='tzrknam'  min='0' step='1'/> руб. &nbsp&nbsp&nbspС обналом:&nbsp<p id='obtzrknam'></p> руб.<br />
        <label for='tzrkpok'>Довезти 1шт ДО <span id='byer_name'></span>:</label><input id='button_history_tzrkpok' type='button' value='i'><input type='number' name='tzrkpok' id='tzrkpok'  min='0' step='1'/> руб. &nbsp&nbsp&nbspС обналом:&nbsp<p id='obtzrkpok'></p> руб.<br /><br />
        <label for='tzr'>ТЗР на ШТУКЕ:</label> <span id='tzr'></span> руб.<br /><br />
        <div id='fcount'>
            <label for='wtime'>ОТСРОЧКА:</label> <input type='number' size='2' name='wtime' id='wtime'  min='0' step='0.03'/> мес. <p id='wtimeday'></p> дней.&nbsp(От поставщика + От покупателя)&nbsp<span id='wtr'></span>.руб<br />           
            <label for='op'>НАШ ПРОЦЕНТ:</label> <input type='number' size='4' name='op' id='op'  min='1' step='0.01'/>% / <p id='opr'></p> руб.<br />
            <label for='tp'>ЕНОТ:</label> <input type='number' size='2' name='tp' id='tp'  min='0' step='0.01'/>% / <p id='tpr'></p> руб.(<p id='clearp'></p>&nbspот цены) НА РУКИ : <p id='firstoh'></p> руб.(<p id='clearpnar'></p>&nbspот цены) <br/>
            <label for='firstobp'>ОБНАЛ:</label> <input type='number' size='2' name='firstobp' id='firstobp'  min='0' step='0.1'/>% / <p id='firstobpr'></p> руб.<br />
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
        <input type='number' name='price' id='pr' value='0' min='0' step='0.001'/>
        <input id='button_history' hist_byer='' hist_trade='' type='button' value='i'>
        <input name='fixate' id='fixate' type='button' value='Закрепить'/>
        </div>
        <div id='rent'><h2>Рентабельность:</h2><h1>0</h1></div>        
        <div class='history'></div>
        <div class='history_knam'></div>
        <div class='history_kpok'></div>
        <div id='cases'></div>
    </form>
        <input type='button' value='__' class='minimizepricing'>                
        <input type='button' value='X' class='closepricing'>                
        <script src='js/price_mysql.js'></script>     
</div>
<div id='editmsg'></div>
<input id='thesearch' type='text' placeholder='Начните вводить наименование поставщика, покупателя, товара или название заявки'category='' theID=''>
<div id='sres'></div>
<br>
<div id='reads'>                                                                                                               
      <ul>
        <li id='tab_requests'><a href='#requests'>Заявки</a></li>
        <li id='tab_byers'><a href='#byers'>Покупатели</a></li>
        <li id='tab_sellers'><a href='#sellers'>Поставщики</a></li>
        <li id='tab_trades'><a href='#trades'>Товары</a></li>
        <li id='tab_giveaways'><a href='#givaways'>Р-1</a></li>
        <li id='tab_vidachi'><a href='#vidachi'>Выдачи</a></li>
        <li id='tab_totals'><a href='#totals'>Долги</a></li>
        <li id='tab_search'><a href='#search'>Результаты поиска</a></li>
      </ul>
  
      <div id='requests'>
          <input type='button' class='show_list' value='ЗАКАЗЫ⏎'><br><br>
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
      <input type='button' class='show_list' value='ПОКУПАТЕЛИ⏎'><br><br>
      <input type='button' class='addnew' value='+'> Добавить покупателя
              <div class='creates add_ramk'>
          <br>
                  <input type='text' placeholder='Введите наименование Покупателя' size='70'>
                  <input type='button' tc='1' name='byers' value='Добавить'>
          <br>
          <br>
              </div>
          <div class='byers_list'>
          </div>
      </div>      
      <div id='sellers'>
      <input type='button' class='show_list' value='ПОСТАВЩИКИ⏎'><br><br>
      <input type='button' class='addnew' value='+'> Добавить поставщика
          <div class='creates add_ramk'>
          <br>
              <input type='text' placeholder='Введите наименование Поставщика' size='70'>
              <input type='button' tc='2' name='sellers' value='Добавить'>  
          <br>
          <br>
          </div>
          <div class='sellers_list'>
          </div>
      </div>
      <div id='trades'>
      <input type='button' class='show_list' value='НОМЕНКЛАТУРА⏎'><br><br>
      <input type='button' class='addnew' value='+'> Добавить номенклатуру
          <div class ='creates add_ramk'>
          <br>
              <input type='text' placeholder='Введите наименование Товара' size='70'>
              <input type='button' tc='3' name='trades' value='Добавить'>
          <br>
          <br>
          </div>
          <div class='trades_list'>
          </div>
          
      </div>";
echo"      
      <div id='givaways'> 
      <input type='button' class='show_list' value='РАСЧЕТЫ⏎'><br><br>    
      <!--Добавить Платежку -->  
              <div id='add_payment'>
                  <span>Вводим платежку</span>
                  <br>
                  <label for='1'><span>Дата платежа:</span></label><input id='add_payment_date' name='1' type='date' size='20'><br>
                  <label for='2'><span>Номер п/п</span></label><input id='add_payment_1c_num' name='2' type='text' size='20'><br>
                  <label for='3'><span>Сумма, руб.</span></label><input id='add_payment_sum' name='3' type='text' size='20'><br>
                  <span class='ready_comment'></span><br>
                  <input id='button_add_payment' type='button' name='add_payment' requestid='-' paymentid='-' value='Сохранить платежку'>
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
                  
                  <input id='button_add_giveaway' type='button' name='add_giveaway' requestid='-' giveawayid='-' value='Сохранить выдачу'>
                  <input class='close_add_g' type='button' value='X'>
              </div>
      
          <div class='givaways_list'>          
          </div>      
      </div>
      <div id='vidachi'>
      <input type='button' class='show_list' value='ВЫДАЧИ⏎'><br><br>
          <div class='vidachi_list'></div>      
      </div>
      <div id='totals'>
      <input type='button' class='show_list' value='ДОЛГИ⏎'><br><br>
          <div class='totals_list'></div>
      </div>
      <div id='search'>
          <div class='search_list'></div>
      </div>
</div>
              <div id='edit_1c_num'>
                  <span>Изменить номер заказа в 1С</span>
                  <br>
                  <label for='1'><span>Введите новый номер:</span></label><input id='add_1c_num' name='1' type='text' size='20'><label for='1cnum'>ИП</label><input id='1cnum' type='checkbox'><br>
                  <input id='button_edit_1c_num' type='button' name='edit_1c_num' requestid='' value='Изменить номер'><br><br>
                  
                  <span>Изменить дату заказа</span>
                  <br>
                  <label for='2'><span>Дата:</span></label><input id='add_created' name='2' size='20'><br>
                  <input id='button_edit_created' type='button' name='edit_created' requestid='' value='Изменить дату'>
                  
                  <span class='ready_comment'></span><br>
                  <input class='close_edit_1c_num' type='button' value='X'>
              </div> 


              <div id='edit_options'>
                  
                  <label for='1'><span>Наценка:</span></label>&nbsp<b><span id='req_op_op'></span></b><br><input id='edit_op' type='number' name='1' type='text' size='5' min='0' step='0.05'>,%<br>
                  <input cc='1' id='button_edit_op' type='button' name='edit_op' requestid='' value='Задать наценку'><br><br>
                                    
                  <label for='2'><span>Енот:</span></label>&nbsp<b><span id='req_op_tp'></span></b><br><input id='edit_tp' type='number' name='2' size='5' min='0' step='0.05'>,%<br>
                  <input cc='2' id='button_edit_tp' type='button' name='edit_tp' requestid='' value='Задать Енот'><br><br>
                                    
                  <label for='3'><span>Обнал:</span></label>&nbsp<b><span id='req_op_firstobp'></span></b><br><input id='edit_firstobp' type='number' name='3' size='5' min='0' step='0.1'>,%<br>
                  <input cc='3' id='button_edit_firstobp' type='button' name='edit_firstobp' requestid='' value='Задать Обнал'><br><br>
                                    
                  <label for='4'><span>Отсрочка:</span></label>&nbsp<b><span id='req_op_wt'></span></b><br><input type='number' id='edit_wt' name='4' size='5' min='0' step='0.03'>мес.<span class='req_op_wt_days'></span>дней.<br>
                  <input cc='4' id='button_edit_wt' type='button' name='edit_wt' requestid='' value='Задать Отсрочку'><br><br>
                  
                  <span class='ready_comment'></span><br>                  
                  <input class='close_edit_options' type='button' value='X'>
                  
              </div>
              
              <div id='edit_options_pos'>
              <h3></h3>
                  <label for='add_queen'>Считать отдельно:</label><input id='add_queen' type='checkbox' name='queen'><br>
    
                      <label for='1'><span>Наценка:</span></label>&nbsp<b><span id='pos_op_op'></span></b><br><input id='edit_op_pos' type='number' name='1' type='text' size='5' min='0' step='0.05' disabled>,%<br>
                      <input cc='1' id='button_edit_op_pos' type='button' name='edit_op_pos' positionid='' value='Задать наценку' disabled><br><br>
                                        
                      <label for='2'><span>Енот:</span></label>&nbsp<b><span id='pos_op_tp'></span></b><br><input id='edit_tp_pos' type='number' name='2' size='5' min='0' step='0.05'disabled >,%<br>
                      <input cc='2' id='button_edit_tp_pos' type='button' name='edit_tp_pos' positionid='' value='Задать Енот' disabled><br><br>
                                        
                      <label for='3'><span>Обнал:</span></label>&nbsp<b><span id='pos_op_firstobp'></span></b><br><input id='edit_firstobp_pos' type='number' name='3' size='5' min='0' step='0.1' disabled>,%<br>
                      <input cc='3' id='button_edit_firstobp_pos' type='button' name='edit_firstobp_pos' positionid='' value='Задать Обнал' disabled><br><br>
                                        
                      <label for='4'><span>Отсрочка:</span></label>&nbsp<b><span id='pos_op_wt'></span></b><br><input type='number' id='edit_wt_pos' name='4' size='5' min='0' step='0.03' disabled>мес.<span class='req_op_wt_days'></span>дней.<br>
                      <input cc='4' id='button_edit_wt_pos' type='button' name='edit_wt_pos' positionid='' value='Задать Отсрочку' disabled><br><br>

                  <span class='ready_comment'></span><br>                  
                  <input class='close_edit_options_pos' type='button' value='X'>
              </div> 
              
              <div id='edit_options_trade'>
              <br>
              <span>Наименование:</span> <span id='trade_options_name'></span><br><br>

                  <input id='edit_trade_name' type='text' name='1' type='text' size='55'>
                  <br>
                  <input cc='1' id='button_edit_trade_name' disabled type='button' nameid='' value='Изменить наименование'>
                                         
              
              <br><br><span>Тара:</span> <span id='trade_options_tare'></span><br><br>
              
                  <select id='edit_trade_tare' name='select_tare' size='1'>
                      <option value='штука'>штука (по умолчанию)</option>
                      <option value='банка'>банка (до 2кг)</option>
                      <option value='канистра'>канистра (20-30л)</option>
                      <option value='бочка'>бочка(200л)</option>
                  </select>
                      
                  <input cc='2' id='button_edit_trade_tare' disabled type='button' tradeid='' value='Задать тип тары'>
                                                          
                  <input class='close_edit_options_trade' type='button' value='X'>
                  
              <br><br><span class='ready_comment'></span>    
              </div> 

<input type='button' value='▲' id='go_up'>";

echo"
<script src='js/jquery.js'></script>
<script src='js/jquery_ui/jquery-ui.js'></script>
<script src='js/mysql_scripts.js'></script>
<script src='js/mysql_edc.js'></script>
<script src='js/mysql_searching.js'></script>
<script src='js/mysql_history.js'></script>
<script src='js/mysql_thunderclap.js'></script>

";