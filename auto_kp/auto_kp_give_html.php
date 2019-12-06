<?php
include_once 'pdo_auto_kp_connect.php';

if(isset($_POST['mail_array'])){
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
        $result.=print_r($mail_array);

        foreach($mail_array as $key=>$val) {

            switch($key)
            {
                case 1:
                    $result.="<p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>Масла гидравлические</p>";
                    $columns = array('Наименование','Применение','Описание','Вязкость','Фасовка/Цена');
                    break;
                case 2:
                    $result.="<p style='background-color: #FBBA00; font-weight: bold; text-align: center; color:#17460F; font-size:140%'>СОЖ для металлообработки</p>";
                    $columns = array('Наименование','Описание','Операции','Металлы','Концентрация','Фасовка/Цена');
                    break;
                case 9:
                    $result.="";
                    break;
            }

            //РИСУЕМ ШАПКУ
            if(isset($columns)){
                $result.="<table style='border-collapse: collapse'><thead><tr>";
                foreach ($columns as $column){
                    $result.="<th style='border: 1px solid black'>".$column."</th>";
                }
                $result.="</tr></thead><tbody>";
                unset($columns);
            }

            //Переменные для единого запроса
            switch($key)
            {
                case 1:
                    $table = 'hydraulics';
                    break;
                case 2:
                    $table = 'soges';
                    break;
                case 9:
                    $table = 'tails';
                    break;
            }

            $brand_table = ($table == "tails") ? "name" : "brand";
            $query=$pdo->prepare("SELECT * FROM $table WHERE $brand_table = ?");

            foreach ($val as $brand){

                $query->execute(array($brand));
                $query_fetched = $query->fetchAll(PDO::FETCH_ASSOC);

                if ($table == 'hydraulics' || $table == 'soges'){
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
                    if($table == "soges"){
                        $result.="
                        <tr>
                        <td style='font-weight: bold; width: 15%'>".$kp_entry['name']."</td>
                        <td>".$kp_entry['description']."</td>
                        <td>".$kp_entry['operations']."</td>
                        <td>".$kp_entry['metal_types']."</td>
                        <td>".$kp_entry['concentration']."</td>
                        <td style='width: 8%'>".$kp_entry['package_price']."</td>
                        </tr>";
                    }
                    if($table == "tails"){
                        $result.="<p style='font-size: 20px'>Компания \"Лубритэк\" предлагает взаимовыгодное сотрудничество на договорной основе для достижения наилучших результатов вашей работы.</p>";

                        $result.="<br><br>".$kp_entry['html'];
                    }
                }
            }
            if ($table == 'hydraulics' || $table == 'soges'){
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