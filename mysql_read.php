<?php
include_once 'pdo_connect.php';


/*ЧТЕНИЕ ВСЕГО ПОЛНЫМИ ТАБЛИЦАМИ*/
if(isset($_POST['table'])){
    $table = $_POST['table'];
    $tablenid = $table . '_nameid';

    if ($table == 'givaways') {
        try {

            $statement = $pdo->prepare("SELECT byers.byers_id AS b_id,byers.byers_nameid AS b_nid,allnames.name AS b_name FROM `byers` LEFT JOIN `allnames` ON byers.byers_nameid=allnames.nameid");
            $statement->execute();
            $result = "<div class='byer_req_list'>";

            foreach ($statement as $row) {
                $result .= "<div byerid =" . $row['b_id'] . ">
                                <input type='button' name =" . $row['b_nid'] . " byersid =" . $row['b_id'] . " value='W' class='collapse'>
                                <span class='name'>" . $row['b_name'] . "</span>
                            </div>";
            }
            $result .= "</div>";
            print $result;
        } catch (PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }
        /**//////////////////////////////////////////////////////////////ЧТЕНИЕ СПИСКА ЗАЯВОК
    } else if ($table == 'requests') {
        try {

            $statement = $pdo->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.name AS req_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name
                                        FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        ORDER BY `b`.`name` ASC");
            $statement->execute();
            $result = "<table><thead><tr><th>Дата</th><th>№ Заказа</th><th>Покупатель</th><th>Название заявки</th><th>Рент</th><th>Сумма</th><th></th></tr></thead>";
            foreach ($statement as $row) {$result .= "<tr requestid =" . $row['req_id'] . ">
            <td class='req_date'><span>" . $row['req_date'] . "</span></td>
            <td class='req_id'><span>" . $row['req_id'] . "</span></td>
            <td byerid=" . $row['b_id'] . " name=" . $row['b_nameid'] . "><span>". $row['b_name'] ."</span></td>
            <td category='requests' name =" . $row['req_nameid'] . "><input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='W' class='collapse'>Наименование заказа: <span class='name'> \"" . $row['req_name'] . "\" </span>
            
            <div id=" . $row['req_nameid'] . " class='contents'> 
            <div class='rentcount'></div>           
            <div class='positions'></div>
            
            <input type='button' class='add_pos' value='+позиция'>
            <div class='add-pos-inputs'>
            <input type='text' class='trade' name='new_req_name' placeholder='Название позиции' size='50'>
            <div class='sres'></div>
            <input type='button' name =" . $row['req_id'] . " value='Добавить' class='addpos'>
            </div>
            
            </td>
                <td class = 'rent_whole'>".number_format($row['rent'], 2, '.', ' ')."</td>
                <td class = 'sum_whole'>" .number_format($row['sum'], 2, '.', ' '). "</td>
            <td class = 'req_buttons'><input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='R' class='edit'>
         <input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='X' class='delete'></td></tr>";
            }
            $result .= "</table><!--<script src='js/mysql_edc.js'></script>-->";
            print $result;


        } catch (PDOExecption $e) {
            $pdo->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    } else if(($table == 'byers')) {
    /**//////////////////////////////////////////////////////////////ЧТЕНИЕ ПОКУПАТЕЛИ/ПОСТАВЩИКИ/ТОВАРЫ
        try {

            $statement = $pdo->prepare("SELECT name, nameid, clearp, obnal, wtime  FROM $table  LEFT JOIN `allnames` ON allnames.nameid=$table.$tablenid GROUP BY name");
            $statement->execute();
            $result = "<table><thead><tr><th>Покупатель</th><th>%</th><th>Обн</th><th>Отсрочка</th><th>Опции</th></tr></thead>";
            foreach ($statement as $row)
            {
                $result .= "<tr><td category='" . $table . "' name =" . $row['nameid'] . ">";
                $result .= "<span class='name' name =" . $row['nameid'] . ">" . $row['name'] . "</span></td>
                                <td class='clearp'><span contenteditable='false'>" . $row['clearp'] . "<span/></td>
                                <td class='obnal'><span contenteditable='false'>" . $row['obnal'] . "<span/></td>
                                <td class='wtime'><span contenteditable='false'>" . $row['wtime'] . "<span/></td>
                <td class = 'item_buttons'>
         <input type='button' name =" . $row['nameid'] . " value='R' class='edit'>
         <input type='button' name =" . $row['nameid'] . " value='X' class='delete'></td></tr>";
            }
            $result.="</table><!--<script src='js/mysql_edc.js'></script>-->";

            print $result;



        } catch(PDOExecption $e) {
            $pdo->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
        /**//////////////////////////////////////////////////////////////
    }else {
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



        } catch(PDOExecption $e) {
            $pdo->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
        /**//////////////////////////////////////////////////////////////
    };
    /**//////////////////////////////////////////////////////////////
};

/*СОДЕРЖИМОЕ ЗАЯВКИ - СПИСОК ПОЗИЦИЙ///////////////////////////////////////////////////////////////////////////////////////////////////*/
if (isset($_POST['requestid'])){
    $req_id=$_POST['requestid'];
try{
    $nowinners = $pdo->prepare("SELECT `pos_name`, `req_positionid`, `winnerid` FROM `req_positions` WHERE `requestid`=?");
    $winners = $pdo->prepare("SELECT `requestid`, `req_positionid`, `pos_name`, `name`, `rent`, `price`, `kol`   FROM
								(SELECT `rent`, `price`,`kol`, `pricingid`, `name` FROM 
																		(
																			(SELECT `rent`, `price`, `kol`, `pricingid`, `sellerid` FROM `pricings`) AS a
																				LEFT JOIN 
																			(SELECT a.`sellers_id`, b.`name` FROM(
																													(SELECT * FROM `sellers`) AS a 
																														LEFT JOIN
																													(SELECT * FROM `allnames`) AS b ON a.`sellers_nameid`=b.`nameid`
																												)
																			) AS b ON a.`sellerid` = b.`sellers_id`
																		)
								) AS a
									LEFT JOIN
								(SELECT * FROM `req_positions`) AS b ON a.`pricingid` = b.`winnerid` WHERE `req_positionid`=?");
    $nowinners->execute(array($req_id));
    $result = "<br><br><input type='button' requestid='" . $req_id . "' class = 'check_rent' value='Посчитать рентабельность'><br><br><table><thead><th>№</th><th>Название позиции</th><th>Сумма</th><th>Поб</th><th>Рент</th><th>Опции</th></thead>";
    $rownumber = 1;
    foreach ($nowinners as $row)
    {
        /*echo('<pre>');
        echo (print_r($row));
        echo('</pre>');*/
        if ($row['winnerid']!=0){//Если это виннер
            $winners->execute(array($row['req_positionid']));
            foreach ($winners as $row)
                {
                    $result .= "<tr position =".$row['req_positionid'].">
                    <td> ".$rownumber.".</td>
                    <td category='positions'>
                        <input type='button' request=".$req_id." position =".$row['req_positionid']." value='V' class='collapsepos'>
                        <span class='name'>" . $row['pos_name'] . "</span>
                        <div class='pricings'>
                        </div>
                    </td>
                    <td class='pr'>".intval($row['price'])*intval($row['kol'])."</td><!--Сумма-->
                    <td class='winname'>".$row['name']."</td>
                    <td class='rent'>".number_format($row['rent'], 2, '.', ' ')."</td>
                    <td class = 'pos_buttons'>
                        <input type='button' position =" . $row['req_positionid'] . " value='R' class='edit'>
                        <input type='button' position =" . $row['req_positionid'] . " value='X' class='posdelete'>
                    </td></tr>";
                    ++$rownumber;
                };

        }else{

            $result .= "<tr position =".$row['req_positionid']."><td> ".$rownumber.".</td>
            <td category='positions'>
                <input type='button' position =".$row['req_positionid']." value='V' class='collapsepos'>
                <span class='name'>" . $row['pos_name'] . "</span>
                <div class='pricings'>
                </div>
                </td>
    
    
                <td>
                <input type='button' position =" . $row['req_positionid'] . " value='R' class='edit'>
                <input type='button' position =" . $row['req_positionid'] . " value='X' class='posdelete'>
                </td></tr>";
            ++$rownumber;
        };
    }
    $result.="</table>";


    echo $result;

} catch (PDOExecption $e) {
    $pdo->rollback();
    print "Error!: " . $e->getMessage() . "</br>";
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
                                            d.trades_id AS trades_id
                                             FROM (SELECT * FROM (SELECT `pricingid`, `firstoh`, `rop`, `oh`, `tradeid`, `sellerid`, `zak`, `kol`, `fixed`, `tzr`, `opr`, `tpr`,
        `clearp`, `price`, `rent`, `winner` FROM `pricings` WHERE `positionid`=?) AS a LEFT JOIN (SELECT `name`, `sellers_id`, `sellers_nameid` FROM `allnames` LEFT JOIN `sellers` ON `allnames`.`nameid`=`sellers`.`sellers_nameid`) AS b ON a.sellerid=b.sellers_id) as c LEFT JOIN (SELECT `name`, `trades_id`, `trades_nameid` FROM `allnames` LEFT JOIN `trades` ON `allnames`.`nameid`=`trades`.`trades_nameid`) AS d ON c.tradeid=d.trades_id");
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
                <td class=pr-trade-name>" . $row['trade_name'] . "</td>                
                <td>" . number_format($row['zak'], 2, '.', ' ') . "</td>
                <td>" . $row['kol'] . "</td>
                <!--УБРАНО Сумма закупа для экономии места 14.06.17<td>--><!--</td>-->
                <td>" . number_format($row['tzr']*$row['kol'], 0, '.', ' ') . "</td>
                <td>" . $nam . "</td>
                <!--УБРАНО ИМ для экономии места 22.06.17<td></td>-->
                <td>" . number_format($row['clearp'], 2, '.', ' ') . "</td>
                <td>" . number_format($row['price'], 2, '.', ' ') . "</td>
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

    } catch (PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }

};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*ЧТЕНИЕ РАСЦЕНКИ*//////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['pricingid'])){
    $pricing_id=$_POST['pricingid'];
    try{
        $pdo->beginTransaction();
        $statement = $pdo->prepare("SELECT * FROM `pricings` WHERE `pricingid`=?");
        $statement->execute(array($pricing_id));
        $result = $statement->fetch();
        echo json_encode($result);/*Перевели массив расценки в формат JSON*/
    } catch (PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }

};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*Чтение по запросу из ВЕЛИКОЙ СТРОКИ ПОИСКА ВСЕГО*/
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
                                        a.name AS req_name,
                                        a.req_rent AS rent,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum
                                        FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        WHERE a.byersid = ? ORDER BY `b`.`byers_id` ASC");
            $pdo->beginTransaction();
            $statement->execute(array($theid));
            $pdo->commit();

            $count = $statement->rowCount();
            if($count==0){
                echo ('<p>Заявок, в которых бы фигурировал этот покупатель, не обнаружено.</p>');
            }else{

                $result = "<table><thead><tr><th>Дата</th><th>№ Заказа</th><th>Покупатель</th><th>Название заявки</th><th>Рент</th><th>Сумма</th><th></th></tr></thead>";
                foreach ($statement as $row) {$result .= "<tr requestid =" . $row['req_id'] . ">
            <td class='req_date'><span>" . $row['req_date'] . "</span></td>
            <td class='req_id'><span>" . $row['req_id'] . "</span></td>
            <td byerid=" . $row['b_id'] . " name=" . $row['b_nameid'] . "><span>". $row['b_name'] ."</span></td>
            <td category='requests' name =" . $row['req_nameid'] . "><input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='W' class='collapse'>Наименование заказа: <span class='name'> \"" . $row['req_name'] . "\" </span>
            
            <div id=" . $row['req_nameid'] . " class='contents'> 
            <div class='rentcount'></div>           
            <div class='positions'></div>
            
            <input type='button' class='add_pos' value='+позиция'>
            <div class='add-pos-inputs'>
            <input type='text' class='trade' name='new_req_name' placeholder='Название позиции' size='50'>
            <div class='sres'></div>
            <input type='button' name =" . $row['req_id'] . " value='Добавить' class='addpos'>
            </div>
            
            </td>
                <td class = 'rent_whole'>".number_format($row['rent'], 2, '.', ' ')."</td>
                <td class = 'sum_whole'>" .number_format($row['sum'], 2, '.', ' '). "</td>
            <td class = 'req_buttons'><input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='R' class='edit'>
         <input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='X' class='delete'></td></tr>";
                }
                $result .= "</table><!--<script src='js/mysql_edc.js'></script>-->";
                print $result;
            };

        } catch (PDOExecption $e) {
            $pdo->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    };
    /*Список заявок по названию заявки*/
    if($category == 'request'){
        try {

            $statement = $pdo->prepare("SELECT 
                                        a.created AS req_date,
                                        a.requests_id AS req_id,
                                        a.requests_nameid AS req_nameid,
                                        a.name AS req_name,
                                        a.req_rent AS rent,
                                        a.req_sum AS sum,
                                        b.byers_id AS b_id,
                                        b.byers_nameid AS b_nameid,
                                        b.name AS b_name
                                        FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                        WHERE a.requests_id = ? ORDER BY `b`.`byers_id` ASC");
            $pdo->beginTransaction();
            $statement->execute(array($theid));
            $pdo->commit();

            $result = "<table><thead><tr><th>Дата</th><th>№ Заказа</th><th>Покупатель</th><th>Название заявки</th><th>Рент</th><th>Сумма</th><th></th></tr></thead>";
            foreach ($statement as $row) {$result .= "<tr requestid =" . $row['req_id'] . ">
            <td class='req_date'><span>" . $row['req_date'] . "</span></td>
            <td class='req_id'><span>" . $row['req_id'] . "</span></td>
            <td byerid=" . $row['b_id'] . " name=" . $row['b_nameid'] . "><span>". $row['b_name'] ."</span></td>
            <td category='requests' name =" . $row['req_nameid'] . "><input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='W' class='collapse'>Наименование заказа: <span class='name'> \"" . $row['req_name'] . "\" </span>
            
            <div id=" . $row['req_nameid'] . " class='contents'> 
            <div class='rentcount'></div>           
            <div class='positions'></div>
            
            <input type='button' class='add_pos' value='+позиция'>
            <div class='add-pos-inputs'>
            <input type='text' class='trade' name='new_req_name' placeholder='Название позиции' size='50'>
            <div class='sres'></div>
            <input type='button' name =" . $row['req_id'] . " value='Добавить' class='addpos'>
            </div>
            
            </td>
                <td class = 'rent_whole'>".number_format($row['rent'], 2, '.', ' ')."</td>
                <td class = 'sum_whole'>" .number_format($row['sum'], 2, '.', ' '). "</td>
            <td class = 'req_buttons'><input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='R' class='edit'>
         <input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='X' class='delete'></td></tr>";
            }
            $result .= "</table><!--<script src='js/mysql_edc.js'></script>-->";
            print $result;


        } catch (PDOExecption $e) {
            $pdo->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
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
                echo $ids;
                /*Строка из значений передается напрямую в запрос, только после того, как переменная готова*/
                $readids = $pdo->prepare("SELECT 
                                            a.created AS req_date,
                                            a.requests_id AS req_id,
                                            a.requests_nameid AS req_nameid,
                                            a.name AS req_name,
                                            a.req_rent AS rent,
                                            a.req_sum AS sum,
                                            b.byers_id AS b_id,
                                            b.byers_nameid AS b_nameid,
                                            b.name AS b_name
                                            FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                            WHERE `a`.`requests_id` IN (".$ids.") ORDER BY a.requests_id ASC");
                $readids->execute();
                $pdo->commit();
                $result = "<table><thead><tr><th>Дата</th><th>№ Заказа</th><th>Покупатель</th><th>Название заявки</th><th>Рент</th><th>Сумма</th><th></th></tr></thead>";
                foreach ($readids as $row) {

                    $result .= "<tr requestid =" . $row['req_id'] . ">
            <td class='req_date'><span>" . $row['req_date'] . "</span></td>
            <td class='req_id'><span>" . $row['req_id'] . "</span></td>
            <td byerid=" . $row['b_id'] . " name=" . $row['b_nameid'] . "><span>". $row['b_name'] ."</span></td>
            <td category='requests' name =" . $row['req_nameid'] . "><input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='W' class='collapse'>Наименование заказа: <span class='name'> \"" . $row['req_name'] . "\" </span>
            
            <div id=" . $row['req_nameid'] . " class='contents'> 
            <div class='rentcount'></div>           
            <div class='positions'></div>
            
            <input type='button' class='add_pos' value='+позиция'>
            <div class='add-pos-inputs'>
            <input type='text' class='trade' name='new_req_name' placeholder='Название позиции' size='50'>
            <div class='sres'></div>
            <input type='button' name =" . $row['req_id'] . " value='Добавить' class='addpos'>
            </div>
            
            </td>
                <td class = 'rent_whole'>".number_format($row['rent'], 2, '.', ' ')."</td>
                <td class = 'sum_whole'>" .number_format($row['sum'], 2, '.', ' '). "</td>
            <td class = 'req_buttons'><input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='R' class='edit'>
         <input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='X' class='delete'></td></tr>";
                }
                $result .= "</table><!--<script src='js/mysql_edc.js'></script>-->";
                print $result;
            };
        } catch (PDOExecption $e) {
            $pdo->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
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
                /*Айдишники из массива в троку с сепаратором запятая*/
                $ids = implode(",", array_unique($ids));
                /*echo $ids;*/
                /*Строка из значений передается напрямую в запрос, только после того, как переменная готова*/
                $readids = $pdo->prepare("SELECT 
                                            a.requests_id AS req_id,
                                            a.created AS req_date,
                                            a.requests_nameid AS req_nameid,
                                            a.name AS req_name,
                                            a.req_rent AS rent,
                                            a.req_sum AS sum,
                                            b.byers_id AS b_id,
                                            b.byers_nameid AS b_nameid,
                                            b.name AS b_name
                                            FROM (SELECT * FROM requests LEFT JOIN allnames ON requests.requests_nameid=allnames.nameid)AS a LEFT JOIN (SELECT * FROM byers LEFT JOIN allnames ON byers.byers_nameid=allnames.nameid) AS b ON b.byers_id=a.byersid  
                                            WHERE a.requests_id IN (" . $ids . ") ORDER BY `b`.`byers_id` ASC");
                $readids->execute();
                $pdo->commit();
                $result = "<table><thead><tr><th>Дата</th><th>№ Заказа</th><th>Покупатель</th><th>Название заявки</th><th>Рент</th><th>Сумма</th><th></th></tr></thead>";
                foreach ($readids as $row) {

                    $result .= "<tr requestid =" . $row['req_id'] . ">
            <td class='req_date'><span>" . $row['req_date'] . "</span></td>
            <td class='req_id'><span>" . $row['req_id'] . "</span></td>
            <td byerid=" . $row['b_id'] . " name=" . $row['b_nameid'] . "><span>". $row['b_name'] ."</span></td>
            <td category='requests' name =" . $row['req_nameid'] . "><input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='W' class='collapse'>Наименование заказа: <span class='name'> \"" . $row['req_name'] . "\" </span>
            
            <div id=" . $row['req_nameid'] . " class='contents'> 
            <div class='rentcount'></div>           
            <div class='positions'></div>
            
            <input type='button' class='add_pos' value='+позиция'>
            <div class='add-pos-inputs'>
            <input type='text' class='trade' name='new_req_name' placeholder='Название позиции' size='50'>
            <div class='sres'></div>
            <input type='button' name =" . $row['req_id'] . " value='Добавить' class='addpos'>
            </div>
            
            </td>
                <td class = 'rent_whole'>".number_format($row['rent'], 2, '.', ' ')."</td>
                <td class = 'sum_whole'>" .number_format($row['sum'], 2, '.', ' '). "</td>
            <td class = 'req_buttons'><input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='R' class='edit'>
         <input type='button' name =" . $row['req_nameid'] . " requestid =" . $row['req_id'] . " value='X' class='delete'></td></tr>";
                }
                $result .= "</table><!--<script src='js/mysql_edc.js'></script>-->";
                print $result;
            };
        } catch (PDOExecption $e) {
            $pdo->rollback();
            print "Error!: " . $e->getMessage() . "</br>";
        }
    };



}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/