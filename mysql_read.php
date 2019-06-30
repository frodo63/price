<?php
include_once 'pdo_connect.php';

/*Форматирование числа и округление до 2 знаков*/
function number_f($num)
{
    return number_format(round($num, 2), 2, '.', ' ');
}


/*ЧТЕНИЕ ВСЕГО ПОЛНЫМИ И НЕ СОВСЕМ ПОЛНЫМИ ТАБЛИЦАМИ*/
if(isset($_POST['table'])){
    $table = $_POST['table'];
    $tablenid = $table . '_nameid';
    $dbs_array=array(array($pdo,'ltk'),array($pdoip,'ip'));

    if ($table == 'requests') {
        //Блок рисовки результатов поиска из ВПСПВ
        if (isset($_POST['category']) && isset($_POST['theid'])){
            $category = $_POST['category'];
            $theid = $_POST['theid'];
            /*Список заявок по покупателю*/
            if($category == 'byer'){
                try {
                    $statement = $pdo->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum 
                                        FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        WHERE a.byersid = ? ORDER BY req_date DESC");
                    //////////////////////////////////////////////////////////////////////////
                    $pdo->beginTransaction();
                    $statement->execute(array($theid));
                    $pdo->commit();

                    $count = $statement->rowCount();
                    if($count==0){
                        echo ('<p>Заявок в базе Лубритэк, в которых бы фигурировал этот покупатель, не обнаружено.</p>');
                    }else{
                        //Тут исполнение
                    }
                } catch( PDOException $Exception ) {
                    // Note The Typecast To An Integer!
                    $pdo->rollback();
                    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
                }
            };
            /*Список заявок по названию заявки*/
            if($category == 'request'){
                try {
                    $statement = $pdo->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum
                                        FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        WHERE a.requests_id = ? ORDER BY req_date DESC");
                    $pdo->beginTransaction();
                    $statement->execute(array($theid));
                    $pdo->commit();
                } catch( PDOException $Exception ) {
                    // Note The Typecast To An Integer!
                    $pdo->rollback();
                    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
                }
            };
            /*Список заявок по Поставщику*/
            if($category == 'seller'){
                try {
                    $getids=$pdo->prepare("SELECT b.`requestid` AS reqid FROM 
            ((SELECT `sellerid`,`positionid` FROM `pricings`) AS a INNER JOIN (SELECT `req_positionid`, `requestid` FROM `req_positions`) AS b 
            ON a.`positionid`= b.`req_positionid`) 
            WHERE a.`sellerid` = ?");
                    $pdo->beginTransaction();
                    $getids->execute(array($theid));
                    /*Создаем пустой массив, кидаем все результаты в массив ids*/
                    $ids=array();
                    foreach ($getids as $row){
                        $ids[] = $row['reqid'];
                    };
                    /*Если заявок нет, список пустой - то выводим текcт об этом*/
                    if (count($ids) == 0){
                        echo ('<p>Заявок, в позициях которых были бы расценки, в которых бы фигурировал этот поставщик, не обнаружено.</p>');
                    }else{
                        /*Айдишники из массива в строку с сепаратором запятая*/
                        $ids=implode(",", array_unique($ids));
                        /*Строка из значений передается напрямую в запрос, только после того, как переменная готова*/
                        $statement = $pdo->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name
                                            FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                            WHERE `a`.`requests_id` IN (".$ids.") ORDER BY req_date DESC");
                        $statement->execute();
                        $pdo->commit();

                    };
                } catch( PDOException $Exception ) {
                    // Note The Typecast To An Integer!
                    $pdo->rollback();
                    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
                }

            };
            /*Список заявок по товару*/
            if($category == 'trade'){
                try {
                    $getids=$pdo->prepare("SELECT b.`requestid` AS reqid FROM 
            ((SELECT `tradeid`,`positionid` FROM `pricings`) AS a INNER JOIN (SELECT `req_positionid`, `requestid` FROM `req_positions`) AS b 
            ON a.`positionid`= b.`req_positionid`) 
            WHERE a.`tradeid` = ?");
                    $pdo->beginTransaction();
                    $getids->execute(array($theid));
                    /*Создаем пустой массив, кидаем все результаты в массив ids*/
                    $ids = array();
                    foreach ($getids as $row) {
                        $ids[] = $row['reqid'];
                    };
                    /*Если заявок нет, список пустой - то выводим тект об этом*/
                    if (count($ids) == 0){
                        echo ('<p>Заявок, в позициях которых были бы расценки, в которых бы фигурировал этот товар, не обнаружено.</p>');
                    }else {
                        /*Айдишники из массива в cтроку с сепаратором запятая*/
                        $ids = implode(",", array_unique($ids));
                        /*echo $ids;*/
                        /*Строка из значений передается напрямую в запрос, только после того, как переменная готова*/
                        $statement = $pdo->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name
                                            FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                            WHERE a.requests_id IN (" . $ids . ") ORDER BY req_date DESC");
                        $statement->execute();
                        $pdo->commit();

                    };
                } catch( PDOException $Exception ) {
                    // Note The Typecast To An Integer!
                    $pdo->rollback();
                    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
                }
            };
        }/*Временной интервал*/else if(isset($_POST['from']) && isset($_POST['to'])) {
            $from = $_POST['from'];
            $to = $_POST['to'];
            $filterbyer = $_POST['filterbyer'];

            if($filterbyer == 'none'){
                try {

                    $statement = $pdo->prepare("SELECT                                       
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name
                                        FROM (SELECT * FROM (SELECT * FROM requests WHERE `created` BETWEEN ? AND ?) AS x LEFT JOIN allnames ON x.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        ORDER BY req_date DESC");

                    $pdo->beginTransaction();
                    $statement->execute(array($from,$to));
                    $pdo->commit();

                }catch( PDOException $Exception ) {
                    // Note The Typecast To An Integer!
                    $pdo->rollback();
                    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
                }
            }else{
                try {

                    $statement = $pdo->prepare("SELECT                                       
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name
                                        FROM (SELECT * FROM 
                                              
                                              (SELECT * FROM requests) AS x LEFT JOIN allnames ON x.requests_nameid=allnames.nameid)AS a 
                                              
                                              LEFT JOIN 
                                              
                                              (SELECT * FROM byers AS t LEFT JOIN allnames ON t.byers_nameid=allnames.nameid) AS b 
                                              
                                              ON b.byers_id=a.byersid WHERE (a.created BETWEEN ? AND ?) AND (`b`.`byers_id` = ?) ORDER BY req_date DESC");

                    $pdo->beginTransaction();
                    $statement->execute(array($from,$to,$filterbyer));
                    $pdo->commit();

                }catch( PDOException $Exception ) {
                    // Note The Typecast To An Integer!
                    $pdo->rollback();
                    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
                }
            }

        }/*Общий список заявок*/else{
            $result = "";
            foreach ($dbs_array as $database){
                try {
                    $statement = $database[0]->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.requests_uid AS req_uid,
                                        a.name AS req_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum,
                                        a.1c_num AS 1c_num,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name
                                        FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        ORDER BY req_date DESC");
                    $statement->execute();
                } catch( PDOException $Exception ) {
                    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
                }
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $result .= "<table><thead><tr><th>Дата</th><th>№ в 1С</th><th>Покупатель</th><th>Название заявки</th><th>Рент</th><th>Сумма</th><th></th></tr></thead>";
                //Рисуем заявки из базы ltk
                foreach ($statement as $row) {

                    $get_executals = $database[0]->prepare("SELECT * FROM executes WHERE requests_uid = ?");
                    $get_executals->execute(array($row['req_uid']));
                    $get_executals_fetched = $get_executals->fetchAll(PDO::FETCH_ASSOC);

                    /*Заголовок заказа////////////////////////////////////////////////////////////////////////////////////////////////*/
                    $phpdate = strtotime( $row['req_date'] );
                    $mysqldate = date( 'd.m.y', $phpdate );
                    /*////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/

                    $result .= "<tr database = '".$database[1]."' requestid =" . $row['req_id'] . " byerid =".$row['b_id'].">
            <td class='req_date'><span>" . $mysqldate . "</span></td>
            <td class='1c_num'><span>" . $row['1c_num'] . "</span></td>
            <td byerid=" . $row['b_id'] . " name=" . $row['b_nameid'] . "><span>". $row['b_name'] ."</span></td>
            <td category='requests' name =".$row['req_nameid'].">";

                    $result .="<input type='button' requestid =".$row['req_id']." value=♢ class='collapse' name =".$row['req_nameid'].">";

                    if(count($get_executals_fetched) > 0){
                        foreach($get_executals_fetched as $exe){
                            $result .="<span style='color: green'>Накладная № ".$exe['execute_1c_num']." от ".$exe['executed']."</span><br>";
                        }
                    }

                    $result .="<span class='name'>&nbsp ".$row['req_name']."</span>";


                    $result .="<div class='contents' id=".$row['req_nameid'].">
                <h3 class='req_header_".$row['req_id']."'>Заказ от <span class='date'>".$mysqldate."</span> на сумму <span class='reqsumma'>".number_format($row['sum'],2,'.',' ')."&nbsp</span><br> Номер в 1С: <span class='1c_num'>".$row['1c_num']."</span> <h3/><br>
                <input type='button' class='edit_options' value='Опции' requestid='".$row['req_id']."'>
                <input type='button' class='edit_1c_num' value='Номер в 1С и дата' requestid='".$row['req_id']."'>  
                <input type='button' value='Вернуть в Р-1' class='r1_show' requestid='".$row['req_id']."'>              
                <input type='button' class='add_pos' value='+позиция'>
                <div class='add-pos-inputs'>
                <input type='text' class='trade' name='new_req_name' placeholder='Название позиции' size='50'>
                <div class='sres'></div>
                <input type='button' name =" . $row['req_id'] . " value='Добавить' class='addpos' database='ltk'>
            </div>
            
            <div class='positions'></div>
            <div class='rentcount'></div>            
            </td>
                <td class = 'rent_whole'>".round($row['rent'], 2)."</td>
                <td class = 'sum_whole'>" .number_format(round($row['sum'], 2), 2, '.', ' '). "</td>
            <td class = 'req_buttons'><input type='button' requestid =" . $row['req_id'] . " value='R' class='edit' name =".$row['req_nameid'].">
         <input type='button' requestid =" . $row['req_id'] . " value='X' class='reqdelete' name =".$row['req_nameid']."></td></tr>";
                }
            }
        }


        $result .= "</table>";
        print $result;
        unset($result);
    }
    else if ($table == 'givaways') {
        try {

            /*ОПЦИИ ДАТЫ*/
            /*Смотрим, какой период сейчас выставлен по умолчанию*/
            $ga_period = $pdo->prepare("SELECT * FROM `options` WHERE options_id = 'general'");
            $ga_period->execute();
            $ga_period_fetched = $ga_period->fetch(PDO::FETCH_ASSOC);
            $ga_period_current = $ga_period_fetched['ga_period'];
            $ga_periods = array(
                array("year",'С начала года'),
                array("quarter",'С начала квартала'),
                array("month",'С начала месяца')
            );
            //ТЕКУЩУЮ ОПЦИЮ ВЫДЕЛИТЬ ЗЕЛЕНЫМ ЦВЕТОМ
            foreach($ga_periods as $gap){
                if($gap[0] == $ga_period_current){
                    echo "<input type='button' class='date_option green' period='".$gap[0]."' value='".$gap[1]."'>";

                }else{
                    echo "<input type='button' class='date_option' period='".$gap[0]."' value='".$gap[1]."'>";
                }
            };
            /*ОПЦИИ ДАТЫ*/

            //Сейчс скрипт берет всех покупателей из базы
            $statement = $pdo->prepare("SELECT byers.byers_id AS b_id,byers.byers_nameid AS b_nid,allnames.name AS b_name FROM `byers` LEFT JOIN `allnames` ON byers.byers_nameid=allnames.nameid ORDER BY b_name");
            $gotrequests = $pdo->prepare("SELECT requests_id FROM requests WHERE (requests.byersid = ? AND requests.r1_hidden = 0)");
            $statement->execute();
            $result = "<ul class='byer_req_list'>";

            foreach ($statement as $row) {
                $ga_bid = $row['b_id'];
                //Проверка ан наличие заявок
                $gotsome = array();
                $gotrequests->execute(array($ga_bid));
                $gotsome = $gotrequests->fetchall(PDO::FETCH_ASSOC);
                if(count($gotsome)>0){

                    $result .= "<li byerid =" . $row['b_id'] . "><input type='button' name =" . $row['b_nid'] . " ga_byer =" . $row['b_id'] . " value='♢' class='collapse_ga_byer w'>
                                <span class='name'>" . $row['b_name'] . "</span>
                                <div class='ga_byer_requests' ga_byer ='" . $row['b_id'] . "'></div>
                            </li>";
                }
            }
            $result .= "</ul>";
            print $result;


        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
        /**//////////////////////////////////////////////////////////////ЧТЕНИЕ СПИСКА ЗАЯВОК
    }
    else if ($table == 'vidachi') {
        if(isset($_POST['order'])){
            $order = ($_POST['order']);
            switch ($order) {
                case 1:
                  $sql="
                  SELECT
                  given_away,`name`,`1c_num`,giveaway_sum,created,req_sum,g.`comment`,giveaways_id
                  FROM giveaways g 
                  LEFT JOIN requests r on g.requestid = r.requests_id
                  INNER JOIN byers b on r.byersid=b.byers_id
                  LEFT JOIN  allnames a on b.byers_nameid = a.nameid
                  ORDER BY given_away DESC";
                  break;
                case 2:
                  $sql="
                  SELECT
                  given_away,`name`,`1c_num`,giveaway_sum,created,req_sum,g.`comment`,giveaways_id
                  FROM giveaways g 
                  LEFT JOIN requests r on g.requestid = r.requests_id
                  INNER JOIN byers b on r.byersid=b.byers_id
                  LEFT JOIN  allnames a on b.byers_nameid = a.nameid
                  ORDER BY name DESC";
                  break;
                case 3:
                  $sql="
                  SELECT
                  given_away,`name`,`1c_num`,giveaway_sum,created,req_sum,g.`comment`,giveaways_id
                  FROM giveaways g 
                  LEFT JOIN requests r on g.requestid = r.requests_id
                  INNER JOIN byers b on r.byersid=b.byers_id
                  LEFT JOIN  allnames a on b.byers_nameid = a.nameid
                  ORDER BY created DESC";
                  break;
                case 4:
                  $sql="
                  SELECT
                  given_away,`name`,`1c_num`,giveaway_sum,created,req_sum,g.`comment`,giveaways_id
                  FROM giveaways g 
                  LEFT JOIN requests r on g.requestid = r.requests_id
                  INNER JOIN byers b on r.byersid=b.byers_id
                  LEFT JOIN  allnames a on b.byers_nameid = a.nameid
                  ORDER BY 1c_num DESC";
                  break;
            }
        }else{
            $sql="
                  SELECT
                  given_away,`name`,`1c_num`,giveaway_sum,created,req_sum,g.`comment`,giveaways_id
                  FROM giveaways g 
                  LEFT JOIN requests r on g.requestid = r.requests_id
                  INNER JOIN byers b on r.byersid=b.byers_id
                  LEFT JOIN  allnames a on b.byers_nameid = a.nameid
                  ";
        }

        try {
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $result = "
                <table><thead>
                <th id='vidachi_order_given_away'>Дата выдачи</th>
                <th>Сумма выдачи</th>
                <th id='vidachi_order_name'>Плательщик</th>
                <th id='vidachi_order_created'>Дата заказа</th>
                <th id='vidachi_order_1c_number'>Номер в 1С</th>
                <th>Коммент</th>
                <th>Сумма заказа</th>
                </thead><tbody>";

            foreach ($statement as $row) {
                $phpdate = strtotime( $row['given_away'] );
                $given_away= date( 'd.m.y', $phpdate );

                $phpdate = strtotime( $row['created'] );
                $created = date( 'd.m.y', $phpdate );



                $result .= "<tr g_id='".$row['giveaways_id']."'>
                                <td>$given_away</td>
                                <td>".$row['giveaway_sum']."</td>
                                <td>".$row['name']."</td>
                                <td>$created</td>
                                <td>".$row['1c_num']."</td>
                                <td>".$row['req_sum']."</td>
                                <td>".$row['comment']."</td>
                            </tr>";          }
            $result .= "</tbody></table>";
            print $result;
        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
        /**//////////////////////////////////////////////////////////////ЧТЕНИЕ СПИСКА ЗАЯВОК
    }
    else if ($table == 'payments') {
        if(isset($_POST['order'])){
            $order = ($_POST['order']);
            switch ($order) {
                case 1:
                    $sql="
                        SELECT
                         payed,number,sum,name,created,`1c_num`,req_sum 
                         FROM requests 
                         INNER JOIN payments ON requests.requests_id = payments.requestid 
                         LEFT JOIN byers ON byersid=byers_id 
                         LEFT JOIN allnames ON byers.byers_nameid = allnames.nameid 
                         ORDER BY payed DESC";
                    break;
                case 2:
                    $sql="
                        SELECT
                         payed,number,sum,name,created,`1c_num`,req_sum 
                         FROM requests 
                         INNER JOIN payments ON requests.requests_id = payments.requestid 
                         LEFT JOIN byers ON byersid=byers_id 
                         LEFT JOIN allnames ON byers.byers_nameid = allnames.nameid 
                         ORDER BY name DESC";
                    break;
                case 3:
                    $sql="
                        SELECT
                         payed,number,sum,name,created,`1c_num`,req_sum 
                         FROM requests 
                         INNER JOIN payments ON requests.requests_id = payments.requestid 
                         LEFT JOIN byers ON byersid=byers_id 
                         LEFT JOIN allnames ON byers.byers_nameid = allnames.nameid 
                         ORDER BY created DESC";
                    break;
                case 4:
                    $sql="
                        SELECT
                         payed,number,sum,name,created,`1c_num`,req_sum 
                         FROM requests 
                         LEFT JOIN payments ON requests.requests_id = payments.requestid 
                         LEFT JOIN byers ON byersid=byers_id 
                         LEFT JOIN allnames ON byers.byers_nameid = allnames.nameid 
                         ORDER BY 1c_num DESC";
                    break;
            }
        }else{
            $sql="
                SELECT
                payed,number,sum,name,created,`1c_num`,req_sum 
                FROM requests 
                INNER JOIN payments ON requests.requests_id = payments.requestid 
                LEFT JOIN byers ON byersid=byers_id 
                LEFT JOIN allnames ON byers.byers_nameid = allnames.nameid 
                ORDER BY payed DESC";
        }

        try {
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $result = "
                <table><thead>
                <th id='payments_order_payed'>Дата платежа</th>
                <th>Номер платежа</th>
                <th>Сумма платежа</th>
                <th id='payments_order_name'>Плательщик</th>
                <th id='payments_order_created'>Дата заказа</th>
                <th id='payments_order_1c_number'>Номер в 1С</th>
                <th>Сумма заказа</th>
                </thead><tbody>";

            foreach ($statement as $row) {
                $phpdate = strtotime( $row['payed'] );
                $payed= date( 'd.m.y', $phpdate );

                $phpdate = strtotime( $row['created'] );
                $created = date( 'd.m.y', $phpdate );



                $result .= "<tr>
                                <td>$payed</td>
                                <td>".$row['number']."</td>
                                <td>".$row['sum']."</td>
                                <td>".$row['name']."</td>
                                <td>$created</td>
                                <td>".$row['1c_num']."</td>
                                <td>".$row['req_sum']."</td>
                            </tr>";          }
            $result .= "</tbody></table>";
            print $result;
        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
        /**//////////////////////////////////////////////////////////////ЧТЕНИЕ СПИСКА ЗАЯВОК
    }
    else if(($table == 'byers')) {
        /**//////////////////////////////////////////////////////////////ЧТЕНИЕ ПОКУПАТЕЛИ
        try {

            $statement = $pdo->prepare("SELECT name, byers_id, nameid, ov_tp, ov_firstobp, ov_wt, comment, onec_id, ip_uid  FROM $table  LEFT JOIN `allnames` ON allnames.nameid=$table.$tablenid GROUP BY name");
            $statement->execute();
            $result = "<table><thead><tr><th>Покупатель</th><th>%</th><th>Обн</th><th>Отсрочка</th><th>Коммент</th><th>Номер в 1С</th><th>Соотнесение</th><th>Опции</th></tr></thead>";
            foreach ($statement as $row)
            {
                $result .= "<tr><td category='" . $table . "' name =" . $row['nameid'] . ">";
                $result .= "<span class='name' byerid=" . $row['byers_id'] . " name =" . $row['nameid'] . ">" . $row['name'] . "</span></td>
                                <td class='ov_tp'><span>" . $row['ov_tp'] . "<span/></td>
                                <td class='ov_firstobp'><span>" . $row['ov_firstobp'] . "<span/></td>
                                <td class='ov_wt'><span>" . $row['ov_wt'] . "<span/></td>
                                <td class='comment'><span>" . $row['comment'] . "<span/></td>";
                $result .= "<td class='onec_id'><span>" . $row['onec_id'] . "<span/></td>
                <td class='synced'><span>" . $row['ip_uid'] . "<span/></td>
                <td class = 'item_buttons'>
         <input type='button' name =" . $row['nameid'] . " value='R' class='edit'>
         <input type='button' name =" . $row['nameid'] . " value='X' class='delete'></td></tr>";
            }
            $result.="</table>";

            print $result;



        } catch(PDOExeption $e) {
            $pdo->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
        /**//////////////////////////////////////////////////////////////
    }
    else if ($table == 'totals') {
        try {
            //Totals 1 уровень рисуем
            //Выборка: Заказы, НЕскрытые в Р-1, отсортированные по наименованию покупателя, дать цифры для расчета оплаченности заказа
            $get_byers = $pdo->prepare("SELECT byers_id, name FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid");
            $get_req_sums = $pdo->prepare("SELECT requests_id,req_sum FROM requests WHERE r1_hidden=0 AND byersid=?");
            $get_req_paysum = $pdo->prepare("SELECT sum(sum) AS paysum,requestid FROM payments WHERE requestid=?");
            $get_req_countsum = $pdo->prepare("SELECT created,requests_id,req_sum,1c_num,req_positionid,winnerid,SUM(kol * firstoh) AS countsum FROM (SELECT created,requests_id,req_sum,1c_num,req_positionid,
                                                       winnerid FROM requests LEFT JOIN req_positions ON requests_id=requestid) AS a 
                                                       LEFT JOIN (SELECT pricingid,kol,firstoh FROM pricings) AS b 
                                                       ON a.winnerid=b.pricingid WHERE requests_id=?");
            $get_req_givesum = $pdo->prepare("SELECT SUM(giveaway_sum) as giveaway_sum FROM giveaways WHERE requestid=?");
            $get_giveaways_by_req = $pdo->prepare("SELECT given_away,giveaway_sum,requestid,comment FROM giveaways WHERE requestid=?");
            //Выборка: Дата последней платежки
            $lastpayment = $pdo->prepare("SELECT MAX(payed) AS lpayed,number FROM `payments` WHERE requestid IN (SELECT requests_id FROM requests WHERE r1_hidden=0 AND byersid=?)");
            $lastgiveaway = $pdo->prepare("SELECT MAX(given_away) AS lgiven,giveaway_sum FROM `giveaways` WHERE requestid IN (SELECT requests_id FROM requests WHERE r1_hidden=0 AND byersid=?)");
            //TODO:Последняя платежка и последняя выдача, если они фигурируют в отчете по долгам должны обязательно
            //TODO: относиться к входящим в Отчет заказам. На просот последняя платежка, а последняя платежка от этого покупателя по заказам, которые фигурируют в отчете.
            //TODO: Там дальше есть массив действующих айдишников. Чуть переработать 2 запроса, чтобы брались не всей заявки, а только из того массива

            $result = "<table class='byer_req_list_totals'><thead><tr><th>Наименование</th><th>Сумма долга</th><th>Оплата</th><th>Выдача</th></tr></thead><tbody>";


            //Переменные
            $byers_list = array();

            $get_byers->execute();
            $byers_list = $get_byers->fetchAll(PDO::FETCH_ASSOC);
            foreach ($byers_list as $byer) {
                $b_id = $byer['byers_id'];
                $b_name = $byer['name'];
                //Перезаряжаем переменные
                $byers_list = array();
                $requests_list = array();
                $paysum = array();
                $givesum = array();
                $countsum = array();
                $sum_total = array();
                $payed_total = array();
                $given_total = array();
                $counted_total = array();
                $r_id_list = array();
                $g_r_g = array();
                $g_p_by_r = array();
                $s_t = 0;
                $p_t = 0;
                $c_t = 0;
                $g_t = 0;
                $r_sum = 0;
                $pay_sum = 0;
                $c_sum = 0;
                $g_sum = 0;
                $req_countgive_diff = 0;
                $req_countgive_diff_by_req = 0;
                $requests_counts_list = array();//Массив для всех заявок и данных по ним для инфы по заказу
                ////////////////////////////////////////////////////////////

                //Что-то делаем с byerid и именем

                $get_req_sums->execute(array($b_id));
                $requests_list = $get_req_sums->fetchAll(PDO::FETCH_ASSOC);
                foreach ($requests_list as $request) {//Проходимся по всем заявкам из $requests_list
                    //Перезаряжаем заказовские переменные
                    $counted_r = array();
                    $given_r = array();

                    $r_id = $request['requests_id'];//ID заказа
                    $r_sum = round($request['req_sum'], 2);//Сумма заказа

                    //Расчет платежей
                    $get_req_paysum->execute(array($r_id));
                    $paysum = $get_req_paysum->fetch(PDO::FETCH_ASSOC);
                    $pay_sum = round($paysum['paysum'], 2);//Сумма денег по всем платежкам этого заказа

                    ////////////////////////////////////////////////////////////////////////////////////////////////////
                    //Посчитать сумму начисленных
                    $get_req_countsum->execute(array($r_id));
                    $countsum = $get_req_countsum->fetch(PDO::FETCH_ASSOC);
                    $c_sum = round($countsum['countsum'], 2);//Сумма начисленных по одному заказу
                    //Посчитать сумму выданного
                    $get_req_givesum->execute(array($r_id));//РАсчет делается для каждой заявки
                    $givesum = $get_req_givesum->fetch(PDO::FETCH_ASSOC);
                    $g_sum = round($givesum['giveaway_sum'], 2);//Сумма выданных по одному заказу

                    ////////////////////////////////////////////////////////////////////////////////////////////////////
                    //Если заказ не оплачен, он в Доолгах не отображается, а его сумма и сумма платежей не идут в общий расчет
                    $debt = $c_sum - $g_sum;//Долг по одному заказу
                    if ($r_sum > 0 && $pay_sum > 0 && $r_sum == $pay_sum && $c_sum > 0 && $g_sum >= 0 && $debt > 0) {
                        //Если напротив - то сумма и платежи идут в общую сумму по заказу для расчета ОПЛАЧЕННОСТИ
                        $sum_total[] = $r_sum;//Сумма всех заказов этого покупателя
                        $payed_total[] = $pay_sum;//Сумма денег по всем платежкам этого покупателя
                        $counted_total[] = $c_sum;//Сумма начислений по всем заказам этого покупателя
                        $given_total[] = $g_sum;//Сумма начислений по всем заказам этого покупателя
                        $r_id_list[] = $r_id;//А ID - в список ID заказов, отображаемых дальше
                    }
                }
                //Создаем красивый массив для рисования
                $requests_paints_list = array();
                $giveaways_paints_list = array();
                foreach ($r_id_list as $row) {
                    $temp_array = array();
                    $get_req_countsum->execute(array($row));
                    $temp_array = $get_req_countsum->fetch(PDO::FETCH_ASSOC);
                    $requests_paints_list[] = $temp_array;
                }
                //Прошлись по всем заказам покупателя, собрали данные и сравниваем
                //Если сумма заказов равна сумме платежей и не равна нулю, рисуем
                //TODO: ЗАКАЗ ДОЛЖЕН ПОЯВЛЯТЬСЯ В Р-2 ТОЛЬКО ЕСЛИ ЕСТЬ ЕЩЕ НАЧИСЛЕНИЯ, ТО ЕСТЬ СУММА НАЧИСЛЕНИЙ НЕ РАВНА НУЛЮ
                $s_t = round(array_sum($sum_total), 2);//СУмма заказов
                $p_t = round(array_sum($payed_total), 2);//СУмма платежек
                $c_t = round(array_sum($counted_total), 2);//Сумма начислений
                $g_t = round(array_sum($given_total), 2);//Сумма выдач
                //Посчитать сумму долга
                $req_countgive_diff = $c_t - $g_t;//Долг
                if (//Если:
                    $s_t == $p_t &&//Сумма заказов равна сумме платежек
                    $s_t > 0 && //И при этом ни сумма заказов
                    $p_t > 0 && //Ни сумма платежек не равны нулю
                    $c_t > 0 && //Есть начисления
                    $g_t >= 0 //Сумма выдач больше или равна нулю
                )
                {//Мы рисуем выбранные заказы этого покупателя:
                    $result .= '<tr byerid =' . $byer["byers_id"] . '>';
                    $result .= '<td><input type="button" totals_byer =' . $b_id . ' value="W" class="collapse_totals_byer">';
                    $result .= '<span class="name">' . $b_name . '</span>';
                    //Рисуем список заказов, вошедших в расчет.
                    $result .= '<div class="totals_byer_requests" totals_byer =' . $b_id . '>';
                    $result .= '<table class="totals_requests_list"><thead><th>Заказ №</th><th>Дата</th><th>Сумма</th>
                                <th>Начислено</th><th>Выдано</th><th>Долг</th></thead><tbody>';
                    //Рисование
                    foreach ($requests_paints_list as $r_list) {//По каждой заявке рисуем строку (нужно requestid, 1c_num, показать сумму начислений и сумму долга по каждой заявке)
                        $result .= '<tr><td requestid="' . $r_list['requests_id'] . '">' . $r_list['1c_num'] . '</td>
                                        <td>' . date( 'd.m.y', strtotime( $r_list['created'] ) ) . '</td><td>' . number_f($r_list['req_sum']) . '</td>
                                        <td>' . number_f($r_list['countsum']) . '</td>';
                        //Выводим выдачи
                        $get_req_givesum->execute(array($r_list['requests_id']));
                        $g_r_g = $get_req_givesum->fetch(PDO::FETCH_ASSOC);
                        $get_giveaways_by_req->execute(array($r_list['requests_id']));
                        $g_p_by_r = $get_giveaways_by_req->fetchAll(PDO::FETCH_ASSOC);

                        $result .= '<td><span>' . number_f($g_r_g['giveaway_sum']) . '</span><input type="button" value="W" class="collapse_totals_g_list"><div class="totals_g_list"><table>';
                        foreach ($g_p_by_r as $g_list) {
                            $result .= '<tr>
                                           <td>' . date( 'd.m.y', strtotime( $g_list['given_away'] ) ) . '</td>
                                           <td>' . $g_list['comment'] . '</td>
                                           <td>' . number_f($g_list['giveaway_sum']) . '</td>
                                       </tr>';
                        };
                        $result .= '</table></div></td>';
                        $req_countgive_diff_by_req = number_format(round($r_list['countsum'], 2) - round($g_r_g['giveaway_sum'],2), 2, '.', ' ');
                        $result .= '<td>' . $req_countgive_diff_by_req . '</td></tr>';//Разница между начисленным и выданным
                    };
                    $result .= '</tbody></table></td>';

                    $result .= '</td>';
                    $result .= '<td>' . number_f($req_countgive_diff) . '</td>';//
                    //Получить дату и номер последней платежки
                    $lastpayment->execute(array($b_id));
                    $lpayment = $lastpayment->fetch(PDO::FETCH_ASSOC);
                    $lpay_number = $lpayment['number'];
                    $lpayed = date( 'd.m.y', strtotime( $lpayment['lpayed'] ) );
                    $result .= '<td>№ ' . $lpay_number . ' от ' . $lpayed . '</td>';
                    //Получить дату и сумму последней выдачи
                    $lastgiveaway->execute(array($b_id));
                    $lgiveaway = $lastgiveaway->fetch(PDO::FETCH_ASSOC);
                    $lpayed = date( 'd.m.y', strtotime( $lgiveaway['lgiven'] ) );
                    $lpayed_sum = $lgiveaway['giveaway_sum'];
                    if ($lpayed_sum > 0) {
                        $result .= '<td>' . $lpayed . ' - ' . $lpayed_sum . ' р.</td></tr>';
                    } else {
                        $result .= '<td>НЕ было выдач</td></tr>';
                    }
                };
            };
            $result .= "</tbody></table>";
            print $result;
        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
        /**//////////////////////////////////////////////////////////////ЧТЕНИЕ СПИСКА ЗАЯВОК
    }
    else if ($table == 'trades'){
        try {

            $statement = $pdo->prepare("SELECT `trades_id`,`nameid`,`name`,`tare`,`onec_id`,`ip_uid` FROM `trades` LEFT JOIN `allnames` ON allnames.nameid=`trades`.`trades_nameid`");
            $statement->execute();
            $result = "<table><thead><tr><th>Наименование</th><th>Тип тары</th><th>Номер в 1С</th><th>Соотнесение</th><th></th></tr></thead>";
            foreach ($statement as $row)
            {
                $result .= "<tr><td category='trades' name =" . $row['nameid'] . ">";
                $result .= "<span class='trade_name' tradeid=" . $row['trades_id'] . " name =" . $row['nameid'] . ">" . $row['name'] . "</span></td>
                                <td class='trade_tare' tradeid=" . $row['trades_id'] . "><span>" . $row['tare'] . "<span/></td>";

                if($row['onec_id']){
                    $result .= "<td class='trade_onec_id'><span>" . $row['onec_id'] . "<span/></td>";
                }else{$result .= "<td class='trade_onec_id'><span style='color: grey'>Болванка<span/></td>";}

                $result .= "<td class='trade_synched'><span>" . $row['ip_uid'] . "<span/></td>
                <td class = 'item_buttons'>
         <input type='button' name =" . $row['nameid'] . " tradeid =" . $row['trades_id'] . " value='E' class='edit_options_trade'>
         <input type='button' name =" . $row['nameid'] . " value='X' class='delete'></td></tr>";
            }
            $result.="</table>";

            print $result;



        } catch(PDOExeption $e) {
            $pdo->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    }
    else {
        /**//////////////////////////////////////////////////////////////ЧТЕНИЕ ПОКУПАТЕЛИ/ПОСТАВЩИКИ/ТОВАРЫ
        try {

            $statement = $pdo->prepare("SELECT name, nameid  FROM $table  LEFT JOIN `allnames` ON allnames.nameid=$table.$tablenid GROUP BY name");
            $statement->execute();
            $result = "<table>";
            foreach ($statement as $row)
            {
                $result .= "<tr><td category='" . $table . "' name =" . $row['nameid'] . ">";
                $result .= "<span class='name' name =" . $row['nameid'] . ">" . $row['name'] . "</span></td>                
                <td class = 'item_buttons'>
         <input type='button' name =" . $row['nameid'] . " value='R' class='edit'>
         <input type='button' name =" . $row['nameid'] . " value='X' class='delete'></td></tr>";
            }
            $result.="</table><!--<script src='js/mysql_edc.js'></script>-->";

            print $result;



        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
        /**//////////////////////////////////////////////////////////////
    };
};
/*///////////////////////////////////////////////////*/

/*СОДЕРЖИМОЕ ЗАЯВКИ - СПИСОК ПОЗИЦИЙ///////////////////////////////////////////////////////////////////////////////////////////////////*/
if (isset($_POST['requestid'])){
    $req_id=$_POST['requestid'];
    try{
        $nowinners = $pdo->prepare("SELECT `pos_name`, `req_positionid`, `line_num`, `winnerid` FROM `req_positions` WHERE `requestid`=?");
        $winners = $pdo->prepare("SELECT `requestid`, `req_positionid`, `line_num`, `pos_name`, `name`, `rent`, `price`, `kol` FROM (SELECT * FROM ((SELECT * FROM `pricings`) AS a LEFT JOIN (SELECT `sellers_id`, `name` FROM(sellers LEFT JOIN allnames ON sellers.sellers_nameid=allnames.nameid)) AS b ON a.`sellerid` = b.`sellers_id`)) AS a LEFT JOIN req_positions ON a.`pricingid` = req_positions.winnerid WHERE `req_positionid`=?");
        $nowinners->execute(array($req_id));
        $nowinners_fetched = $nowinners->fetchAll(PDO::FETCH_ASSOC);
        $result .= "<br><table><thead><th>№</th><th>Название позиции</th><th>Цена</th><th>Сумма</th><th>Поб</th><th>Рент</th><th>Опции</th></thead><tbody>";
        foreach ($nowinners_fetched as $row)
        {
            if ($row['winnerid']!=0){//Если в позиции назначен победитель
                $winners->execute(array($row['req_positionid']));
                $winners_fetched = $winners->fetchAll(PDO::FETCH_ASSOC);
                foreach ($winners_fetched as $win)
                {
                    $price = number_format(round($win['price'],2),'2','.', ' ');
                    $pr = round($win['price'],2)*round($win['kol'],2);
                    $pr=number_format($pr,'2','.',' ');

                    $result .= "<tr position =".$win['req_positionid'].">";
                    $result .= "<td> ".$win['line_num'].".</td>";
                    $result .= "<td category='positions'>";
                    $result .= "<input type='button' request=".$req_id." position =".$win['req_positionid']." value=♢ class='collapsepos'>";
                    $result .= "<span class='name'>" . $win['pos_name'] . "</span>";
                    $result .= "<div class='pricings'>";
                    $result .= "</div>";
                    $result .= "</td>";
                    $result .= "<td class='pr'>".$price."</td>";
                    $result .= "<td class='pr'>".$pr."</td><!--Сумма-->";
                    $result .= "<td class='winname'>".$win['name']."</td>";
                    $result .= "<td class='rent'>".round($win['rent'], 2)."</td>";
                    $result .= "<td class = 'pos_buttons'>";
                    $result .= "<input type='button' position =" . $win['req_positionid'] . " value='R' class='edit'>";
                    $result .= "<input type='button' position =" . $win['req_positionid'] . " value='X' class='posdelete'>";
                    $result .= "<input type='button' req_op_id='".$req_id."' pos_op_id=". $win['req_positionid'] ." value='...' class='edit_options_pos'>";
                    $result .= "</td></tr>";

                };
            }else{
                $result .= "<tr position =".$row['req_positionid']."><td> ".$row['line_num'].".</td>
            <td category='positions'>
                <input type='button' position =".$row['req_positionid']." value=♢ class='collapsepos'>
                <span class='name'>" . $row['pos_name'] . "</span>
                <div class='pricings'>
                </div>
                </td>  
                <td>
                <input type='button' position =" . $row['req_positionid'] . " value='R' class='edit'>
                <input type='button' position =" . $row['req_positionid'] . " value='X' class='posdelete'>
                <input type='button' req_op_id='".$req_id."' pos_op_id=". $row['req_positionid'] ." value='...' class='edit_options_pos'>
                </td></tr>";

            };
        }
        $result.="</tbody></table>";
        $result.= "<input type='button' requestid='" . $req_id . "' class = 'check_rent' value='Рассчитать сумму и рентабельность сделки'>";



        echo $result;

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

};

/*СОДЕРЖИМОЕ ПОЗИЦИИ - СПИСОК РАСЦЕНОК/////////////////////////////////////////////////////////////////////////////////////////////*/
if (isset($_POST['positionid'])){
    $pos_id=$_POST['positionid'];

    try{
        $statement = $pdo->prepare("SELECT  c.pricingid AS pricingid,
                                            c.firstoh AS firstoh,
                                            c.rop AS rop,
                                            c.oh AS oh,
                                            c.tradeid AS tradeid,
                                            c.zak AS zak,
                                            c.kol AS kol,
                                            c.fixed AS fixed,
                                            c.tzr AS tzr,
                                            c.opr AS opr,
                                            c.tpr AS tpr,
                                            c.clearp AS clearp,
                                            c.price AS price,
                                            c.rent AS rent,
                                            c.winner AS winner,
                                            c.sellerid AS sellerid,
                                            c.sellers_id AS sellers_id,
                                            c.name AS seller_name,
                                            d.name AS trade_name,
                                            d.tare AS trade_tare,
                                            d.trades_id AS trades_id
                                             FROM (SELECT * FROM (SELECT `pricingid`, `firstoh`, `rop`, `oh`, `tradeid`, `sellerid`, `zak`, `kol`, `fixed`, `tzr`, `opr`, `tpr`,
        `clearp`, `price`, `rent`, `winner` FROM `pricings` WHERE `positionid`=?) AS a LEFT JOIN (SELECT `name`, `sellers_id`, `sellers_nameid` FROM `allnames` LEFT JOIN `sellers` ON `allnames`.`nameid`=`sellers`.`sellers_nameid`) AS b ON a.sellerid=b.sellers_id) as c LEFT JOIN (SELECT `name`, `tare`, `trades_id`, `trades_nameid` FROM `allnames` LEFT JOIN `trades` ON `allnames`.`nameid`=`trades`.`trades_nameid`) AS d ON c.tradeid=d.trades_id");
        $statement->execute(array($pos_id));
        if($statement->rowCount() == 0) {$result = "Здесь еще нет расценок.<input class ='addpricing' positionid='".$pos_id."' value='Расценить новое?' type ='button'><script src='js/mysql_edc.js'></script>";
        } else{

            /*ДЕЛАЕМ ТАБЛИЦУ!!!*/

            $result = "<table class='pricing-list'><thead><tr>
                    <th>Продавец</th>    
                    <th>Товар</th>                    
                    <th>Закуп</th>
                    <th>Кол-во</th>
                    <!--<th>Сумма закупа</th>-->
                    <th>Σ ТЗР</th>
                    <th>Нам</th>
                    <!--<th>Им</th>-->
                    <th>Чист%</th>                    
                    <th>Цена</th>                    
                    <th>Рент</th>
                    <th>Опции</th>
                    </tr></thead>";
            foreach ($statement as $row) {
                switch ($row['fixed']) {
                    case '0':
                        $nam = number_format($row['opr'] * $row['kol'], 0, '.', ' ');
                        $im = number_format($row['firstoh'] * $row['kol'], 0, '.', ' ');
                        break;
                    case '1':
                        $nam = number_format($row['rop'] * $row['kol'], 0, '.', ' ');
                        $im = number_format($row['oh'] * $row['kol'], 0, '.', ' ');
                        break;
                };

                if($row['winner'] == 1){
                    $result .= "<tr class=\"win\" pricingid =". $row['pricingid'] .">";
                }else{
                    $result .= "<tr pricingid =". $row['pricingid'] .">";
                };
                $result .="<td class=pr-seller-name>" . $row['seller_name'] . "</td>
                <td class='pr-trade-name' tare='" . $row['trade_tare'] . "'>" . $row['trade_name'] . "</td>                
                <td>" . number_format($row['zak'], 2, '.', ' ') . "</td>
                <td>" . $row['kol'] . "</td>
                <!--УБРАНО Сумма закупа для экономии места 14.06.17<td>--><!--</td>-->
                <td>" . number_format($row['tzr']*$row['kol'], 0, '.', ' ') . "</td>
                <td>" . $nam . "</td>
                <!--УБРАНО ИМ для экономии места 22.06.17<td></td>-->
                <td>" . round($row['clearp'], 2) . "</td>
                <td>" . round($row['price'], 2) . "</td>
                <td class='pr-rent'>" . number_format($row['rent'], 2, '.', ' ') . "</td>
                <td>
                <div class='del-ren-pricing'>
                <input type='button' pricing =" . $row['pricingid'] . " value='E' class='editpricing'>
                <input type='button' pricing =" . $row['pricingid'] . " value='X' class='delpricing'>";
                if($row['winner'] == 1){
                    $result.="<input type='button' pricing =" . $row['pricingid'] . " value='П' class='winner'>";
                }else{$result.="<input type='button' pricing =" . $row['pricingid'] . " value='*' class='winner'>";}



                $result.="</div></td></tr>";
            }
            $result.="<!--<script src='js/mysql_edc.js'></script>--></tbody></table><input class ='addpricing' positionid='".$pos_id."' value='Расценить новое?' type ='button'>";
        };

        echo $result;

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*ЧТЕНИЕ РАСЦЕНКИ*//////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['pricingid'])){
    $pricing_id=$_POST['pricingid'];
    try{
        $pdo->beginTransaction();
        $statement = $pdo->prepare("SELECT * FROM `pricings` as a  LEFT JOIN (SELECT created, req_positionid, 1c_num as num FROM req_positions LEFT JOIN requests ON req_positions.requestid = requests.requests_id) AS b on a.positionid=b.req_positionid WHERE `pricingid`=?");
        $statement->execute(array($pricing_id));
        $result = $statement->fetch();

        $phpdate = strtotime( $result['created'] );
        $result['created'] = date( 'd.m.y', $phpdate );

        echo json_encode($result);/*Перевели массив расценки в формат JSON*/
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//ЧТЕНИЕ ДАТЫ ЗАЯВКИ
if ( isset($_POST['chng_number']) ){
    try{
        $id_number = $_POST['chng_number'];

        $statement=$pdo->prepare("SELECT created FROM requests WHERE requests_id = ?");

        $pdo->beginTransaction();
        $statement->execute(array($id_number));
        $pdo->commit();

        $result = $statement->fetch();

        $phpdate = strtotime( $result['created'] );
        $result = date( 'd.m.y', $phpdate );

        print $result;

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

//ЧТЕНИЕ 1С Номера ЗАЯВКИ
if ( isset($_POST['chng_number_1c']) ){
    try{
        $id_number = $_POST['chng_number_1c'];

        $statement=$pdo->prepare("SELECT 1c_num FROM requests WHERE requests_id = ?");

        $pdo->beginTransaction();
        $statement->execute(array($id_number));
        $pdo->commit();

        $result = $statement->fetch();
        $new1c_num = $result['1c_num'];

        print $new1c_num;

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

//Чтение ОПЦИЙ ЗАЯВКИ ПО ОДНОЙ
if ( isset($_POST['c_c']) &&  isset($_POST['reqid'])){
    try{
        $reqid = ($_POST["reqid"]);
        $c_c = ($_POST["c_c"]);

        switch($c_c)
        {
            case 1:
                $column = 'ov_op';
                break;
            case 2:
                $column = 'ov_tp';
                break;
            case 3:
                $column = 'ov_firstobp';
                break;
            case 4:
                $column = 'ov_wt';
                break;
        }

        $statement=$pdo->prepare("SELECT $column FROM `requests` WHERE requests_id = ?");

        $pdo->beginTransaction();
        $statement->execute(array($reqid));
        $pdo->commit();

        $result = $statement->fetch();

        print $result[$column];

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

//Чтение ОПЦИЙ ПОЗИЦИИ ПО ОДНОЙ
if ( isset($_POST['pos_c_c']) &&  isset($_POST['posid'])){
    try{
        $posid = ($_POST["posid"]);
        $c_c = ($_POST["pos_c_c"]);

        switch($c_c)
        {
            case 1:
                $column = 'ov_op';
                break;
            case 2:
                $column = 'ov_tp';
                break;
            case 3:
                $column = 'ov_firstobp';
                break;
            case 4:
                $column = 'ov_wt';
                break;
        }

        $statement=$pdo->prepare("SELECT $column FROM `req_positions` WHERE req_positionid = ?");

        $pdo->beginTransaction();
        $statement->execute(array($posid));
        $pdo->commit();

        $result = $statement->fetch();

        print $result[$column];

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

//ЧТЕНИЕ ПЛАТЕЖКИ
if(isset($_POST['pay_reqid']) && isset($_POST['pay_id'])){
    $paymentid = $_POST['pay_id'];
    $requestid = $_POST['pay_reqid'];
    try{
        $pdo->beginTransaction();
        $statement = $pdo->prepare("SELECT * FROM `payments` WHERE payments_id=? AND requestid=?");
        $statement->execute(array($paymentid,$requestid));
        $pdo->commit();
        $result = $statement->fetch();
        echo json_encode($result);/*Перевели массив расценки в формат JSON*/
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
}
/**/

//ЧТЕНИЕ ВЫДАЧИ
if(isset($_POST['byersid']) && isset($_POST['give_id'])){
    $giveawayid = $_POST['give_id'];
    $byersid = $_POST['byersid'];

    try{
        $pdo->beginTransaction();
        $statement = $pdo->prepare("SELECT * FROM `giveaways` WHERE giveaways_id=? AND byersid=?");
        $statement->execute(array($giveawayid,$byersid));
        $pdo->commit();
        $result = $statement->fetch();
        echo json_encode($result);/*Перевели массив расценки в формат JSON*/
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

}
/**/
