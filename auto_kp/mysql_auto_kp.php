<?php
include_once 'pdo_auto_kp_connect.php';

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
<script src='jquery.js'></script>
<script src='jquery-ui.js'></script>
<script src='auto_kp.js'></script>";