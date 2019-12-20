<?php
include_once 'pdo_auto_kp_connect.php';

if(isset($_POST['mail_array']) && isset($_POST['with_prices']) && isset($_POST['with_pics'])){

    //Убрать потом
    //$result.=print_r($_POST['mail_array']);

    $result="";
    $signature="";
    $mail_array = array();
    $result.="<p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>Здравствуйте!</p>";
    $result.="<table style='width: 100%;'><tr>";

    $with_pics = $_POST['with_pics'];

    $pic_first = "<img src=\"data:image/png;base64,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
EeIJQrfJiSqVVEogvwQEo6ykBjGRkCdPVt550ulknkWYQxAcupk0WQXYsJNd8BJIBN/BIMuxbM3E
Rl+cGIx6lGWUEihUAllBKDjkdUAPxawdtCy1hkcJQ2kWttIALlbog5OUYR5Nt5qphR9lppweIQhe
JZUSGDYSyApcmjubEQZzVSoApBqKmtVj/UEQWF3JVU7r70TQSdMxgJaaaQlaCKGk4SWBLDO/g0zf
VgCSwZKAg0/ShyVoaXINdh0oslByMUGtUXN3CkHfV6PJIDw/SXJTMA8tp6RSAsNOAlkGh7ve9W0N
Nlm3uf3BAT8cyRVHt02M6unpGdHX11cZMWJEZeXKlWply/ofOArWnsev+5PV4gXCkDfcK4+rgQRo
/xH0g9E//OEPd3rmmWdec88996z15JNP9m244YaVbbfdduXmm29+/e9///ubzjvvvOdJt0a38UDA
5cDahpDVpCyie4Q6qZnMJNR2t3/oQx/a8brrrtv96aefHsUAjw7glsoVKOgA8np0xowZF0eZfO97
31v/gQceeP8dd9zxxOjRo0OdKsuXL+951ate9cznP//5X0bTNzs/+eST1/3b3/726ueff94JoKZh
2VHplE9+85vf/PMWW2zhCmSVjj/++D3/8Y9/7DZq1ChNy1rZ/bdTD/CKyqMuD7d61lprreWHHHLI
71772tcq11Qi3XrIw83FUV6paUPkyJEjK1OmTKkccMABPSeeeOLz66yzzoPhXtbj97///b1p1+1J
Xyt3xYoVPS960YuWvfCFL7z0ne98p1tMMtOFF1446qabbnrV/Pnzt128eHFwLYyibjdR1q1RRm9/
+9sPveWWW8bw3LWyo/dbPV+6dGllm222GTNu3LgfXXLJJU1B5tFHH+193/ve99YHH3xw/0WLFu01
b9680eTXRVKxWalbtRr0h5Vbb731KPrjdZtsssnFxx577E/33Xffue9+97t7zjzzzEz1/9znPrcD
/HeHvxNmNI+uixmUdRW8amOuWnCDn29/+9sfvPHGG5fRt2opnHgB27WOO+64v++0007X124UfDKQ
qbgp5Zkm+oAFVyHBzrLc5qATviZABx+D44008vEA18jQmIncOSPkg7AvI1sdcF111VVr3XXXXZ+d
NWvWJjZGIAZUZcGCBQ6kzMDFzLnLbbfd9l0G0tRoveW76aabXk2HvTzw93jDDTcccc0113xQUCiC
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
TkSuQmCC\" alt=\"img\" />";

    $result.=($with_pics == 1)? "<td>".$pic_first."</td>" : "<td style='width: 30%'><b style='font-size: 20px'>ООО \"Лубритэк\" </b></td>";

    $result.="<td style='width: 70%'>- официальный дилер смазочных материалов
        <b><span style='font-size: 22px; font-family: Arial;font-style: italic; font-weight: 900'> BECHEM </span></b>
        в Самарской области.<br></span><span>Мы поставляем продукцию широкого спектра на промышленные предприятия, в частности: промышленные масла, смазки, технические жидкости.</span>
    </td>
</tr></table>

<br><br>
<table style='width:100%'><tr><td style='text-align: right'>

    <span><i>\"Умеренная ценовая политика,</i></span><br>
    <span><i>беспрекословное выполнение договорных обязательств,</i></span><br>
    <span><i>наличие пополняемого тёплого склада,</i></span><br>
    <span><i>стабильные сроки поставки</i></span><br>
    <span><i>делают работу с нами комфортной.\"</i></span><br>
    <br>
    <span><i>- С.В. Улитов.</i></span>
</td>
</tr></table>

<p id='preferred_trade_group' style='font-size: 16px'></p>

<div id='custom_trades_table'></div>";

    try{
        //Сортируем массив
        foreach($_POST['mail_array'] as $res) {
            $pos = strpos($res, '_');
            $table = substr($res, 0, $pos);
            $brand_name = substr($res, $pos+1);

            if(is_array($mail_array)){
                $mail_array[$table][]=$brand_name;
            }else{
                $mail_array[$table] = array();
                $mail_array[$table][]=$brand_name;
            }
        }

        //Убрать потом
        //$result.=print_r($mail_array);

        $big_kp_array=array(
            "1" => array(
                "header" => "Масла гидравлические",
                "columns" => array('Наименование','Применение','Описание','Вязкость'),
                "table" => "general_oils_hydraulic"
            ),
            "2" => array(
                "header" => "Масла моторные",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_oils_motor"
            ),
            "3" => array(
                "header" => "Масла редукторные",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_oils_reductor"
            ),
            "4" => array(
                "header" => "Масла компрессорные",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_oils_compressor"
            ),
            "5" => array(
                "header" => "Масла трансмиссионные",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_oils_transmission"
            ),
            "6" => array(
                "header" => "Масла для направляющих",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_oils_guideline"
            ),
            "7" => array(
                "header" => "Масла для цепей",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_oils_chain"
            ),
            "8" => array(
                "header" => "Смазки универсальные",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_greases_universal"
            ),
            "9" => array(
                "header" => "Смазки для высоких температур",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_greases_hightemp"
            ),
            "10" => array(
                "header" => "Смазки для низких температур и высоких скоростей",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_greases_lowtemp"
            ),
            "11" => array(
                "header" => "Смазки устойчивые к воздействию сред",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_greases_highsustain"
            ),
            "12" => array(
                "header" => "Смазки силиконовые",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_greases_silicone"
            ),
            "13" => array(
                "header" => "Смазки для цепей",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_greases_chain"
            ),
            "14" => array(
                "header" => "Сборочные и монтажные смазки/пасты",
                "columns" => array('Наименование','Применение','Описание','Спецификации'),
                "table" => "general_greases_composition"
            ),
            "15" => array(
                "header" => "СОЖ",
                "columns" => array('Наименование','Описание','Операции','Металлы','Концентрация'),
                "table" => "metalworking_soges"
            ),
            "16" => array(
                "header" => "Жидкости для СОЖ",
                "columns" => array('Наименование','Применение','Описание'),
                "table" => "metalworking_specliqs"
            ),
            "17" => array(
                "header" => "Масла с пищевым допуском H1, Halal, Kosher",
                "columns" => array('Наименование','Применение','Описание','Рабочая температура'),
                "table" => "food_oils"
            ),
            "18" => array(
                "header" => "Смазки с пищевым допуском H1, Halal, Kosher",
                "columns" => array('Наименование','Применение','Описание','Рабочая температура'),
                "table" => "food_greases"
            ),
            "19" => array(
                "header" => "Очистители/растворители с пищевым допуском H1, Halal, Kosher",
                "columns" => array('Наименование','Применение','Описание'),
                "table" => "food_specliqs"
            ),
            "20" => array(
                "table" => "tails"
            ),
            "21" => array(
                "header" => "Смазочные материалы",
                "table" => "express_kp",
                "columns" => array('Производитель','Наименование'),
            ),

        );
        if($_POST['with_prices'] == 1){
            $result .="<p>Цены указаны с НДС (20%)</p>";
        }


        foreach($mail_array as $key=>$val) {

            foreach ($big_kp_array as $bkp_key => $bkp_value){
                if ($key == $bkp_key){

                    if(isset($bkp_value['header'])){
                        $result.="<p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>".$bkp_value['header']."</p>";
                    }


                    $columns = (!empty($bkp_value['columns'])) ? $bkp_value['columns'] : "";
                    //Если есть заявленная переменная - добавляем в массив колонок ячейку с фасовкой/ценой
                    if($_POST['with_prices'] == 1){
                        $columns[]="Фасовка/Цена";
                    }
                    $table=$bkp_value['table'];
                }
            }

            //РИСУЕМ ШАПКУ
            if(isset($columns) && $table != 'tails' && $table != 'express_kp'){
                $result.="<table style='border-collapse: collapse'><thead><tr>";
                foreach ($columns as $column){
                    $result.="<th style='border: 1px solid black'>".$column."</th>";
                }
                $result.="</tr></thead><tbody>";
                unset($columns);
            }

            $brand_table = ($table == "tails" || $table == "express_kp") ? "name" : "brand";
            $query=$pdo->prepare("SELECT * FROM $table WHERE $brand_table = ?");

            foreach ($val as $brand){

                $query->execute(array($brand));
                $query_fetched = $query->fetchAll(PDO::FETCH_ASSOC);

                if ($table == 'hydraulics'
                    || $table == 'metalworking_soges'
                    || $table == 'metalworking_specliqs'
                    || $table == 'food_greases'
                    || $table == 'food_oils'
                    || $table == 'food_specliqs'
                ){
                    $result.="<tr><td style='font-size: 20px; border: 1px solid black; text-align: center' colspan='6'>".$brand."</td></tr>";
                }

                foreach($query_fetched as $kp_entry){
                    if($table == "general_oils_hydraulic"){
                        $result.="<tr>
                        <td style='font-weight: bold; width: 15%; border: 1px solid black'>".$kp_entry['name']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['application']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['description']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['viscosity']."</td>";
                    }if($table == "metalworking_specliqs"){
                        $result.="<tr>
                        <td style='font-weight: bold; width: 15%; border: 1px solid black'>".$kp_entry['name']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['application']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['description']."</td>
                        <td style='width: 8%; border: 1px solid black'>".$kp_entry['package_price']."</td>";
                    }
                    if($table == "metalworking_soges"){
                        $result.="
                        <tr>
                        <td style='font-weight: bold; width: 15%; border: 1px solid black'>".$kp_entry['name']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['description']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['operations']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['metal_types']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['concentration']."</td>";
                    }
                    if($table == "food_greases" || $table == "food_oils"){
                        $result.="<tr>
                        <td style='font-weight: bold; width: 15%; border: 1px solid black'>".$kp_entry['name']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['application']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['description']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['working_temp']."</td>";
                    }
                    if($table == "food_specliqs"){
                        $result.="<tr>
                        <td style='font-weight: bold; width: 15%; border: 1px solid black'>".$kp_entry['name']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['application']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['description']."</td>";
                    }


                    if($_POST['with_prices'] == 1){
                        if(isset($kp_entry['packing_price'])){
                            $result.="<td style='width: 8%; border: 1px solid black'>".$kp_entry['packing_price']."</td></tr>";
                        }
                    }else{
                        $result.="</tr>";
                    };

                    if($table == "express_kp"){
                        $result.="
                        <tr>
                        <p style='font-weight: bold'>".$kp_entry['header']."</p>".$kp_entry['html'];
                    }
                    if($table == "tails"){
                        $signature.="<p style='font-size: 20px'>Компания \"Лубритэк\" предлагает взаимовыгодное сотрудничество на договорной основе для достижения наилучших результатов вашей работы.</p>";

                        $signature.="<br><br>".$kp_entry['html'];
                    }
                }
            }
            if ($table != 'tails'){
                $result.="</tbody></table>";
            }
        }


    }catch( PDOException $Exception ) {
        $pdo->rollback();
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }



    $result.="<p>Вообще, наш ассортимент весьма обширен, вот некоторые из групп товаров:</p>
<ul style='list-style: disc; font-size: 20px;'>
 <li>Индустриальные масла, смазки и СОЖ для станков и механизмов</li>
 <li>Универсальные и специальные масла и смазки для обрабатывающих отраслей</li>
 <li>Масла гидравлические, редукторные и циркуляционные</li>
 <li>Масла для грузового транспорта, сельхозтехники, строительной, дорожной, карьерной и обогатительной спецтехники</li>
 <li>Масла для трансмиссий и ГУР, антифризы, тормозные жидкости</li>
 <li>Смазочные материалы для перерабатывающих отраслей сельского хозяйства и пищевой промыщленности.</li>
 <li>Компрессорные, турбинные, трансформаторные и др. энергетические масла</li>
 <li>Смазки для агрессивных сред, экстремальных погодных условий и шоковых нагрузок</li>
 <li>Высоко и низко - температурные масла и смазки</li>
 <li>Масла-теплоносители, масла для цепей, тросов, смесителей, конвейеров</li>
 <li>Очистители, растворители , восстановители поверхности, герметики, клеи.</li>
</ul>
<p>Деятельность нашей компании в первую очередь направлена на обеспечение бесперебойной работы потребителей, на техническую поддержку, консультации  по смазочным материалам, герметикам и промышленным клеям, что гарантируется грамотным персоналом, имеющим опыт работы в производстве и прошедшим обучение в дистрибьюторских центрах производителей.
</p>";

    $result.=$signature;

    print $result;

};