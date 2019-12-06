<?php
include_once 'pdo_auto_kp_connect.php';

if(isset($_POST['mail_array']) && isset($_POST['with_prices'])){

    //Убрать потом
    //$result.=print_r($_POST['mail_array']);

    $result="";
    $mail_array = array();
    $result.="<p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>Здравствуйте!</p>";
    $result.="<table style='width: 100%;'><tr>
    <td style='width: 30%'><b style='font-size: 20px'>ООО \"Лубритэк\" </b></td>
    <td style='width: 70%'>- официальный дилер смазочных материалов
        <b><span style='font-size: 22px; font-family: Arial;font-style: italic; font-weight: 900'> BECHEM </span></b>
        в Самарской области.<br></span><span>Мы поставляем продукцию широкого спектра на промышленные предприятия Самарской области, в частности: промышленные масла, смазки, технические жидкости.</span>
    </td>
</tr></table>

<p id='preferred_trade_group' style='font-size: 16px'></p>

<p>Вообще, наш ассортимент весьма обширен, вот некоторые из групп товаров:</p>
<ul>
    <li>Масла и смазки с пищевым допуском на синтетической основе</li>
    <li>Уплотнительные смазки для арматур питьевой воды и других жидкостей</li><li>Высоко и низко - температурные масла и смазки для холодильных установок и печей, смесителей, конвейеров.</li>
    <li>Масла  гидравлические,  редукторные и циркуляционные</li>
    <li>Масла и смазки для цепей, масла-теплоносители</li>
    <li>Универсальные смазки и смазки для оборудования и техники</li>
    <li>Очистители,  восстановители поверхности,  герметики,  клеи.</li>
</ul>
<p>Деятельность нашей компании в первую очередь направлена на обеспечение бесперебойной работы потребителей, на техническую поддержку, консультации  по смазочным материалам, герметикам и промышленным клеям, что гарантируется грамотным персоналом, имеющим опыт работы в производстве и прошедшим обучение в дистрибьюторских центрах производителей.
</p>
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
<p>Цены указаны с НДС (20%)</p>";
    try{
        //Сортируем массив
        foreach($_POST['mail_array'] as $res) {
            $pos = strpos($res, '_');
            $table = substr($res, 0, $pos);
            $brand_name = substr($res, $pos+1);

            if(is_array($mail_array[$table])){
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
                "header" => "Масла с пищевым допуском",
                "columns" => array('Наименование','Применение','Описание','Рабочая температура'),
                "table" => "food_oils"
            ),
            "18" => array(
                "header" => "Смазки с пищевым допуском",
                "columns" => array('Наименование','Применение','Описание','Рабочая температура'),
                "table" => "food_greases"
            ),
            "19" => array(
                "header" => "Очистители/растворители с пищевым допуском",
                "columns" => array('Наименование','Применение','Описание'),
                "table" => "food_specliqs"
            ),
            "20" => array(
                "table" => "tails"
            ),

        );

        foreach($mail_array as $key=>$val) {

            foreach ($big_kp_array as $bkp_key => $bkp_value){
                if ($key == $bkp_key){
                    $result.="<p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>".$bkp_value['header']."</p>";
                    $columns = $bkp_value['columns'];
                    //Если есть заявленная переменная - добавляем в массив колонок ячейку с фасовкой/ценой
                    if($_POST['with_prices'] == 1){
                        $columns[]="Фасовка/Цена";
                    }
                    $table=$bkp_value['table'];
                }
            }

            //РИСУЕМ ШАПКУ
            if(isset($columns) && $table != 'tails'){
                $result.="<table style='border-collapse: collapse'><thead><tr>";
                foreach ($columns as $column){
                    $result.="<th style='border: 1px solid black'>".$column."</th>";
                }
                $result.="</tr></thead><tbody>";
                unset($columns);
            }

            $brand_table = ($table == "tails") ? "name" : "brand";
            $query=$pdo->prepare("SELECT * FROM $table WHERE $brand_table = ?");

            foreach ($val as $brand){

                $query->execute(array($brand));
                $query_fetched = $query->fetchAll(PDO::FETCH_ASSOC);

                if ($table == 'hydraulics' || $table == 'metalworking_soges'){
                    $result.="<tr><td style='font-size: 20px; border-bottom: 1px solid black' colspan='6'>".$brand."</td></tr>";
                }

                foreach($query_fetched as $kp_entry){
                    if($table == "hydraulics"){
                        $result.="<tr>
                        <td style='font-weight: bold; width: 15%'>".$kp_entry['name']."</td>
                        <td>".$kp_entry['application']."</td>
                        <td>".$kp_entry['description']."</td>
                        <td>".$kp_entry['viscosity']."</td>
                        <td style='width: 8%'>".$kp_entry['package_price']."</td>
                        </tr>";
                    }
                    if($table == "metalworking_soges"){
                        $result.="
                        <tr>
                        <td style='font-weight: bold; width: 15%'>".$kp_entry['name']."</td>
                        <td>".$kp_entry['description']."</td>
                        <td>".$kp_entry['operations']."</td>
                        <td>".$kp_entry['metal_types']."</td>
                        <td>".$kp_entry['concentration']."</td>";

                        if($_POST['with_prices'] == 1){
                            $result.="<td style='width: 8%'>".$kp_entry['packing_price']."</td></tr>";
                        }else{
                            $result.="</tr>";
                        };
                    }
                    if($table == "tails"){
                        $result.="<p style='font-size: 20px'>Компания \"Лубритэк\" предлагает взаимовыгодное сотрудничество на договорной основе для достижения наилучших результатов вашей работы.</p>";

                        $result.="<br><br>".$kp_entry['html'];
                    }
                }
            }
            if ($table != 'tails'){
                $result.="</tbody></table>";
            }
        }

    print $result;
    }catch( PDOException $Exception ) {
        $pdo->rollback();
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};