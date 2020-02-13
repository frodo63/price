<?php
include_once 'pdo_auto_kp_connect.php';
include_once 'megapics.php';

if(isset($_POST['mail_array'])
    && isset($_POST['with_prices'])
    && isset($_POST['with_pics'])
    && isset($_POST['with_dealership'])
    && isset($_POST['with_thoughts'])
    && isset($_POST['with_preferred_firm'])
    && isset($_POST['with_custom_text'])
    && isset($_POST['with_whole_product_list'])
    && isset($_POST['with_closing'])
){
    try{
    $result="";
    $signature="";
    $mail_array = array();
    $ekp_pre_result="<table>";
    $ekp_pre_result_index = 2;


    //Сортируем массив
    if(count($_POST['mail_array']) > 0){
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
    }


    $with_pics = $_POST['with_pics'];
    $with_dealership = $_POST['with_dealership'];
    $with_thoughts = $_POST['with_thoughts'];
    $with_preferred_firm = $_POST['with_preferred_firm'];
    $preferred_group = $_POST['preferred_group'];
    $firm_type = $_POST['firm_type'];
    $with_custom_text = $_POST['with_custom_text'];
    $custom_text = $_POST['custom_text'];
    $with_whole_product_list = $_POST['with_whole_product_list'];
    $with_closing = $_POST['with_closing'];

    $result.="<p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>Здравствуйте!</p>";
    $result.=($with_dealership == 1)? "<table style='width: 100%;'><tr>".(($with_pics == 1)? "<td>".$pic_first."</td>" : "<td style='width: 30%'><b style='font-size: 20px'>ООО \"Лубритэк\" </b></td>")."<td style='width: 70%'>- официальный дилер смазочных материалов
        <b><span style='font-size: 22px; font-family: Arial;font-style: italic; font-weight: 900'> BECHEM </span></b>
        в Самарской области.<br></span><span>Мы поставляем продукцию широкого спектра на промышленные предприятия, в частности: промышленные масла, смазки, технические жидкости.</span>
    </td></tr></table><br><br>" : "<tr><td style='width: 100%'></td></tr></table>";

    $result.=($with_thoughts == 1)? "
<table style='width:100%'><tr><td style='text-align: right'>
    <span><i>\"Умеренная ценовая политика,</i></span><br>
    <span><i>беспрекословное выполнение договорных обязательств,</i></span><br>
    <span><i>наличие пополняемого тёплого склада,</i></span><br>
    <span><i>стабильные сроки поставки</i></span><br>
    <span><i>делают работу с нами комфортной.\"</i></span><br>
    <br>
    <span><i>- С.В. Улитов.</i></span></td></tr></table>" : "";

    $result.=($with_preferred_firm == 1)? "Снабжение " .$preferred_group." ".$firm_type. " - одно из ключевых направлений нашей деятельности." : "";

    $result.=($with_custom_text == 1)? "<table id='custom_text' style='font-size: 22px; background-color: #F0F0F0'><tr><td>".$custom_text."</td></tr></table>" : "";

    $result.="<p id='preferred_trade_group' style='font-size: 20px'></p>
<div id='custom_trades_table'></div>";

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
                "columns" => array('Наименование','Применение','Описание','Рабочий диапазон температур'),
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
                "header" => "Предлагаем к поставке смазочные материалы:",
                "table" => "express_kp",
                "columns" => array('Производитель','Наименование'),
            ),

        );
        if($_POST['with_prices'] == 1){
            $result .="<p>Цены указаны с НДС (20%)</p>";
        }

        //Если массив с товарами из базы пустой - рисуем просто пустое место
        if(count($mail_array)==0){
            $result .="<p>НЕ ВЫБРАНО НИЧЕГО</p>";
        }else{

            foreach($mail_array as $key=>$val) {
                foreach ($big_kp_array as $bkp_key => $bkp_value){
                    if ($key == $bkp_key){

                        if(isset($bkp_value['header'])){
                            $result.="<p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>".$bkp_value['header']."</p>";
                        }

                        //$columns = array();
                        $columns = (!empty($bkp_value['columns'])) ? $bkp_value['columns'] : "";
                        //Если есть заявленная переменная - добавляем в массив колонок ячейку с фасовкой/ценой
                        if($_POST['with_prices'] == 1){
                            $columns[]='Фасовка/Цена';
                        }
                        $table=$bkp_value['table'];
                    }
                }
                //РИСУЕМ ШАПКУ ТАБЛИЦЫ
                if(isset($columns) && $table != 'tails' && $table != 'express_kp'){
                    $result.="<table style='border-collapse: collapse'><thead><tr>";
                    foreach ($columns as $column){
                        $result.="<th class='table_header' style='border: 1px solid black'>".$column."</th>";
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
                        || $table == 'general_greases_silicone'
                    ){
                        $result.="<tr><td style='font-size: 20px; border: 1px solid black; text-align: center' colspan='6'>".$brand."</td></tr>";
                    }

                    foreach($query_fetched as $index=>$kp_entry){
                        if($table == "general_oils_hydraulic"){
                            $result.="<tr>
                        <td style='font-weight: bold; width: 15%; border: 1px solid black'>".$kp_entry['name']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['application']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['description']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['viscosity']."</td>";
                        }
                        if($table == "metalworking_specliqs"){
                            $result.="<tr>
                        <td style='font-weight: bold; width: 15%; border: 1px solid black'>".$kp_entry['name']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['application']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['description']."</td>
                        <td style='width: 8%; border: 1px solid black'>".$kp_entry['package_price']."</td>";
                        }
                        if($table == "metalworking_soges"){
                            $result.="<tr>
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
                        if($table == "general_greases_silicone"){
                            $result.="<tr>
                        <td style='font-weight: bold; width: 15%; border: 1px solid black'>".$kp_entry['name']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['application']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['description']."</td>
                        <td style='border: 1px solid black'>".$kp_entry['working_temp']."</td>";
                        }
                        if($_POST['with_prices'] == 1){
                            if(isset($kp_entry['packing_price'])){
                                $result.="<td style='width: 8%; border: 1px solid black'>".$kp_entry['packing_price']."</td></tr>";
                            }
                        }else{
                            $result.="</tr>";
                        };
                        if($table == "express_kp"){
                            //Собрать табличку сначла тут, засунуть в $result в самом конце
                            //открываемся таК:
                            //$ekp_pre_result.="<table>";

                            if ($ekp_pre_result_index % 2 == 0) {
                                //2,4,6,8,10
                                $ekp_pre_result.="<tr><td style='vertical-align: baseline'>";
                                $ekp_pre_result.="<span style='font-weight: bold'>".$kp_entry['header']."</span><br>".$kp_entry['html'];
                                $ekp_pre_result.="</td>";
                            }else{
                                //3,5,7,9,11
                                $ekp_pre_result.="<td style='vertical-align: baseline'>";
                                $ekp_pre_result.="<span style='font-weight: bold'>".$kp_entry['header']."</span><br>".$kp_entry['html'];
                                $ekp_pre_result.="</td></tr>";
                            }


                            //Тут логика такая: Если это первый или нечетный итем - мы рисуем <tr> и ставим какой-то знак, что это был первый или нечетный элемент
                            //Если это второй или четный элемент - ставим тоже об этом знак


                            $ekp_pre_result_index++;
                            //закрываемся таК:
                            //$ekp_pre_result.="</table>";

                        }

                        if($table == "tails"){
                            $signature.="<br><br>".$kp_entry['html'];
                        }
                    }
                }
                if ($table != 'tails'){
                    $result.="</tbody></table>";
                }
            }
        }

        //Если были Индексы с 21_ekp, рисуем закрытие таблицы или если надо, закрытие ряда
        if($ekp_pre_result_index>2){
            if ($ekp_pre_result_index % 2 == 0) {
                $ekp_pre_result.="</table>";//Если индекс четный
            }else{
                $ekp_pre_result.="</tr></table>";//Если индекс нечетный
            }
            $result.=$ekp_pre_result;
        }


        $result.=($with_whole_product_list == 1)? "<p>Наш ассортимент весьма обширен, вот некоторые из групп товаров:</p>
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
</p>" : "";
        $result.=($with_closing == 1)? "<p style='font-size: 20px'>Компания \"Лубритэк\" предлагает взаимовыгодное сотрудничество на договорной основе для достижения наилучших результатов вашей работы.</p>": "";

        if($signature!=""){
            $result.=$signature;
        }

        print $result;

    }catch( PDOException $Exception ) {
        $pdo->rollback();
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};