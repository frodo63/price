<?php
include_once 'pdo_connect.php';

if(
    isset($_POST["trade"]) &&
    isset($_POST["seller"]) &&
    isset($_POST["zak"]) &&
    isset($_POST["kol"]) &&
    isset($_POST["tzr"]) &&
    isset($_POST["tzrknam"]) &&
    isset($_POST["tzrkpok"]) &&
    isset($_POST["op"]) &&
    isset($_POST["tp"]) &&
    isset($_POST["firstobp"]) &&
    isset($_POST["wtime"]) &&
    isset($_POST["obp"]) &&
    isset($_POST["price"]) &&
    isset($_POST["firstoh"]) &&
    isset($_POST["rent"]) &&
    isset($_POST["tpr"]) &&
    isset($_POST["opr"]) &&
    isset($_POST["fixed"]) &&
    isset($_POST["firstobpr"]) &&
    isset($_POST["clearp"]) &&
    isset($_POST["wtr"]) &&
    isset($_POST["wtimeday"]) &&
    isset($_POST["positionid"])
)
{
    $positionid = (int)($_POST["positionid"]);
    $trade = (int)($_POST["trade"]);
    $seller = (int)($_POST["seller"]);
    $zak = round($_POST["zak"],2);
    $kol = (int)($_POST["kol"]);
    $tzr = round($_POST["tzr"],2);
    $tzrknam = round($_POST["tzrknam"],2);
    $tzrkpok = round($_POST["tzrkpok"],2);
    $wtime = round(($_POST["wtime"]), 2);
    $fixed = (int)($_POST["fixed"]);
    $op = round(($_POST["op"]), 2);
    $tp = round(($_POST["tp"]), 2);
    $opr = round(($_POST["opr"]), 2);
    $tpr = round(($_POST["tpr"]), 2);
    $firstobp = round(($_POST["firstobp"]), 2);
    $firstoh = round($_POST["firstoh"],2);
    $firstobpr = round($_POST["firstobpr"],2);
    $clearp = round($_POST["clearp"], 2);
    $wtr = round($_POST["wtr"], 2);
    $wtimeday = round($_POST["wtimeday"], 0);
    $obp = round(($_POST["obp"]), 2);
    $price = round($_POST["price"],3);
    $rent = round(($_POST["rent"]), 2);

    try{
        $sql = "INSERT INTO pricings(
        positionid,tradeid,sellerid,zak,kol,tzr,tzrknam,tzrkpok,wtime,fixed,op,tp,opr,tpr,firstobp,firstobpr,firstoh,clearp,obp,price,rent,wtr,wtimeday)
        VALUES(:positionid,:trade,:seller,:zak,:kol,:tzr,:tzrknam,:tzrkpok,:wtime,:fixed,:op,:tp,:opr,:tpr,:firstobp,:firstobpr,:firstoh,:clearp,:obp,:price,:rent,:wtr,:wtimeday)";
        $statement = $database->prepare($sql);
        $statement->bindValue(':positionid', $positionid);
        $statement->bindValue(':trade', $trade);
        $statement->bindValue(':seller', $seller);
        $statement->bindValue(':zak', $zak);
        $statement->bindValue(':kol', $kol);
        $statement->bindValue(':tzr', $tzr);
        $statement->bindValue(':tzrknam', $tzrknam);
        $statement->bindValue(':tzrkpok', $tzrkpok);
        $statement->bindValue(':wtime', $wtime);
        $statement->bindValue(':fixed', $fixed);
        $statement->bindValue(':op', $op);
        $statement->bindValue(':tp', $tp);
        $statement->bindValue(':opr', $opr);
        $statement->bindValue(':tpr', $tpr);
        $statement->bindValue(':firstobp', $firstobp);
        $statement->bindValue(':firstoh', $firstoh);
        $statement->bindValue(':firstobpr', $firstobpr);
        $statement->bindValue(':clearp', $clearp);
        $statement->bindValue(':obp', $obp);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':rent', $rent);
        $statement->bindValue(':wtr', $wtr);
        $statement->bindValue(':wtimeday', $wtimeday);
        $database->beginTransaction();
        $statement->execute();
        $database->commit();

       echo "<p>Расценка добавлена</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};


////EDITING
if(

    isset($_POST["trade"]) &&
    isset($_POST["seller"]) &&
    isset($_POST["zak"]) &&
    isset($_POST["kol"]) &&
    isset($_POST["tzr"]) &&
    isset($_POST["tzrknam"]) &&
    isset($_POST["tzrkpok"]) &&
    isset($_POST["op"]) &&
    isset($_POST["tp"]) &&
    isset($_POST["firstobp"]) &&
    isset($_POST["wtime"]) &&
    isset($_POST["obp"]) &&
    isset($_POST["price"]) &&
    isset($_POST["firstoh"]) &&
    isset($_POST["rent"]) &&
    isset($_POST["tpr"]) &&
    isset($_POST["opr"]) &&
    isset($_POST["fixed"]) &&
    isset($_POST["firstobpr"]) &&
    isset($_POST["clearp"]) &&
    isset($_POST["wtr"]) &&
    isset($_POST["wtimeday"]) &&
    isset($_POST["pricingid"])
)
{
    $pricingid = (int)($_POST["pricingid"]);
    $trade = (int)($_POST["trade"]);
    $seller = (int)($_POST["seller"]);
    $zak = round($_POST["zak"],2);
    $kol = (int)($_POST["kol"]);
    $tzr = round($_POST["tzr"],2);
    $tzrknam = round($_POST["tzrknam"],2);
    $tzrkpok = round($_POST["tzrkpok"],2);
    $wtime = round(($_POST["wtime"]), 2);
    $fixed = (int)($_POST["fixed"]);
    $op = round(($_POST["op"]), 2);
    $tp = round(($_POST["tp"]), 2);
    $opr = round(($_POST["opr"]), 2);
    $tpr = round(($_POST["tpr"]), 2);
    $firstobp = round(($_POST["firstobp"]), 2);
    $firstoh = round($_POST["firstoh"],2);
    $firstobpr = round($_POST["firstobpr"],2);
    $clearp = round($_POST["clearp"], 2);
    $obp = round(($_POST["obp"]), 2);
    /*$oh = round($_POST["oh"],2);*/
    $price = round($_POST["price"],3);
    $rent = round($_POST["rent"], 2);
    $wtr = round($_POST["wtr"], 2);
    $wtimeday = round($_POST["wtimeday"], 0);

    try{

        $sql = "UPDATE pricings SET
        tradeid = :trade,
        sellerid = :seller,
        zak = :zak,
        kol = :kol,
        tzr = :tzr,
        tzrknam = :tzrknam,
        tzrkpok = :tzrkpok,
        wtime = :wtime,
        fixed = :fixed,
        op = :op,
        tp = :tp,
        opr = :opr,
        tpr = :tpr,
        firstobp = :firstobp,
        firstobpr = :firstobpr,
        firstoh = :firstoh,        
        clearp = :clearp,
        obp = :obp,
        price = :price,
        rent = :rent,
        wtr = :wtr,
        wtimeday = :wtimeday WHERE pricingid = :pricingid";
        $statement = $database->prepare($sql);

        $statement->bindValue(':pricingid', $pricingid);
        $statement->bindValue(':trade', $trade);
        $statement->bindValue(':seller', $seller);
        $statement->bindValue(':zak', $zak);
        $statement->bindValue(':kol', $kol);
        $statement->bindValue(':tzr', $tzr);
        $statement->bindValue(':tzrknam', $tzrknam);
        $statement->bindValue(':tzrkpok', $tzrkpok);
        $statement->bindValue(':wtime', $wtime);
        $statement->bindValue(':fixed', $fixed);
        $statement->bindValue(':op', $op);
        $statement->bindValue(':tp', $tp);
        $statement->bindValue(':opr', $opr);
        $statement->bindValue(':tpr', $tpr);
        $statement->bindValue(':firstobp', $firstobp);
        $statement->bindValue(':firstoh', $firstoh);
        $statement->bindValue(':firstobpr', $firstobpr);
        $statement->bindValue(':clearp', $clearp);
        $statement->bindValue(':obp', $obp);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':rent', $rent);
        $statement->bindValue(':wtr', $wtr);
        $statement->bindValue(':wtimeday', $wtimeday);
        $database->beginTransaction();
        $statement->execute();
        $database->commit();

        echo "<p>Расценка " . $pricingid . " обновлена</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};


/*РЕДАКТИРОВАНИЕ НОМЕРА ЗАКАЗА В 1С*/
if(
    isset($_POST["reqid"]) && isset($_POST["new_1c_num"])
)
{
    $reqid = ($_POST["reqid"]);
    $new_1c_num = ($_POST["new_1c_num"]);

    try{

        $sql = "UPDATE requests SET 1c_num = :new_1c_num WHERE requests_id = :reqid";
        $statement = $pdo->prepare($sql);

        $statement->bindValue(':reqid', $reqid);
        $statement->bindValue(':new_1c_num', $new_1c_num);

        $pdo->beginTransaction();
        $statement->execute();
        $pdo->commit();

        echo "<p>Номер заказа в 1С обновлен</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/


/*РЕДАКТИРОВАНИЕ Даты заявки*/

if(
    isset($_POST["reqid"]) && isset($_POST["newdate"])
)
{
    $reqid = ($_POST["reqid"]);
    $newdate = ($_POST["newdate"]);

    try{

        $sql = "UPDATE requests SET created = :created WHERE requests_id = :reqid";
        $statement = $pdo->prepare($sql);

        $statement->bindValue(':reqid', $reqid);
        $statement->bindValue(':created', $newdate);

        $pdo->beginTransaction();
        $statement->execute();
        $pdo->commit();

        echo "<p>Дата заявки обновлена</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

/*РЕДАКТИРОВАНИЕ ОПЦИЙ ЗАЯВКИ*/
if(

    isset($_POST["reqid"]) && isset($_POST["c_c"]) && isset($_POST["the_input"])
)
{
    $reqid = ($_POST["reqid"]);
    $c_c = ($_POST["c_c"]);
    $the_input = ($_POST["the_input"]);

    try{

        switch($c_c)
        {
            case 1:
                $column = 'ov_op';
                $c_text = 'Наценка';
                break;
            case 2:
                $column = 'ov_tp';
                $c_text = 'Енот';
                break;
            case 3:
                $column = 'ov_firstobp';
                $c_text = 'Обнал';
                break;
            case 4:
                $column = 'ov_wt';
                $c_text = 'Отсрочка';
                break;
        }

        $sql = "UPDATE `requests` SET $column = ? WHERE requests_id = ?";
        $statement = $database->prepare($sql);

        $database->beginTransaction();
        $statement->execute(array($the_input,$reqid));
        $database->commit();

        echo "<p>Опция ".$c_text." в заявке ".$reqid." обновлена. ".$the_input."</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

/*РЕДАКТИРОВАНИЕ ОПЦИЙ ЗАЯВКИ*/
if(

    isset($_POST["posid"]) && isset($_POST["c_c"]) && isset($_POST["the_input"]) && isset($_POST["queen"])
)
{
    $posid = ($_POST["posid"]);
    $c_c = ($_POST["c_c"]);
    $the_input = ($_POST["the_input"]);
    $queen = ($_POST["queen"]);

    try{

        switch($c_c)
        {
            case 1:
                $column = 'ov_op';
                $c_text = 'Наценка';
                break;
            case 2:
                $column = 'ov_tp';
                $c_text = 'Енот';
                break;
            case 3:
                $column = 'ov_firstobp';
                $c_text = 'Обнал';
                break;
            case 4:
                $column = 'ov_wt';
                $c_text = 'Отсрочка';
                break;
        }

        $sql = "UPDATE `req_positions` SET $column = ?, `queen` = ? WHERE req_positionid = ?";
        $statement = $database->prepare($sql);

        $database->beginTransaction();
        $statement->execute(array($the_input,$queen,$posid));
        $database->commit();

        echo "<p>Опция ".$c_text." в позиции ".$posid." обновлена. ".$the_input."</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

/*Редактирование статуса "Спрятан в Р-1 Изменение на 1*/
if(
    isset($_POST["r1_hide_reqid"])
)
{
    $reqid = ($_POST["r1_hide_reqid"]);

    try{
        $sql = "UPDATE `requests` SET r1_hidden = 1 WHERE requests_id = ?";
        $statement = $database->prepare($sql);

        $database->beginTransaction();
        $statement->execute(array($reqid));
        $database->commit();

        echo "<p>Заявка ".$reqid." убрана из выдачи Р-1.</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

/*Редактирование статуса "Спрятан в Р-1 Изменение на 0*/
if(
isset($_POST["r1_show_reqid"])
)
{
    $reqid = ($_POST["r1_show_reqid"]);

    try{
        $sql = "UPDATE `requests` SET r1_hidden = 0 WHERE requests_id = ?";
        $statement = $database->prepare($sql);

        $database->beginTransaction();
        $statement->execute(array($reqid));
        $database->commit();

        echo "<p>Заявка ".$reqid." возвращена в выдачу Р-1.</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

/////Редактирование ПЛАТЕЖКИ/////////////////////////////////////////////////
if(isset($_POST['reqid']) && isset($_POST['payment_date']) && isset($_POST['num']) && isset($_POST['sum']) && isset($_POST['pay_id'])){

    $reqid = $_POST['reqid'];
    $payment_date = $_POST['payment_date'];
    $num = $_POST['num'];
    $sum = $_POST['sum'];
    $pay_id = $_POST['pay_id'];

    /**//////////////////////////////////////////////////////////////

    try{

        $sql = "UPDATE payments SET payed = :payed,number = :number,sum = :sum WHERE requestid = :requestid AND payments_id = :payments_id";
        $statement = $database->prepare($sql);

        $statement->bindValue(':payed', $payment_date);
        $statement->bindValue(':number', $num);
        $statement->bindValue(':sum', $sum);
        $statement->bindValue(':requestid', $reqid);
        $statement->bindValue(':payments_id', $pay_id);

        $database->beginTransaction();
        $statement->execute();
        $database->commit();

        echo "<p>Номер заказа в 1С обновлен</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Обновлена платежка  на сумму $sum в заявкe $reqid.";

};
//////////////////////////////////////////////////////////////////////
///
/// //Редактирование ВЫДАЧИ///////////////////////////////////////////////////
if(isset($_POST['giveaway_date']) && isset($_POST['comment']) && isset($_POST['sum']) && isset($_POST['give_id']) && isset($_POST['give_year'])){

    $giveaway_date = $_POST['giveaway_date'];
    $comment = $_POST['comment'];
    $sum = $_POST['sum'];
    $give_id = $_POST['give_id'];
    $give_year = $_POST['give_year'];

    /**//////////////////////////////////////////////////////////////

    try{

        $statement = $database->prepare("UPDATE giveaways 
SET 
`given_away`=:given_away,
`comment`=:comment,
`giveaway_sum`=:giveaway_sum,
`year_given`=:year_given 
WHERE 
giveaways_id=:giveaways_id");

        $statement->bindValue(':given_away', $giveaway_date);
        $statement->bindValue(':comment', $comment);
        $statement->bindValue(':giveaway_sum', $sum);
        $statement->bindValue(':year_given', $give_year);
        $statement->bindValue(':giveaways_id', $give_id);

        $database->beginTransaction();
        $statement->execute();
        $database->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Обновлена выдача на сумму $sum .";

};
//////////////////////////////////////////////////////////////////////

/*РЕДАКТИРОВАНИЕ ТИПА ТАРЫ ТОВАРА*/
if(
    isset($_POST["newtare"]) && isset($_POST["tradeid"])
)
{
    $tradeid = ($_POST["tradeid"]);
    $newtare = ($_POST["newtare"]);

    try{

        $sql = "UPDATE trades SET tare = :newtare WHERE trades_id = :tradeid";
        $statement = $pdo->prepare($sql);

        $statement->bindValue(':newtare', $newtare);
        $statement->bindValue(':tradeid', $tradeid);

        $pdo->beginTransaction();
        $statement->execute();
        $pdo->commit();

        echo "<p>Номер тип тары обновлен</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};
/**/

/*РЕДАКТИРОВАНИЕ ОПЦИЙ ПОКУПАТЕЛЯ*/
if(isset($_POST['newdata_byer']) && isset($_POST['byerid']) && isset($_POST['column'])){
    $newdata_byer = $_POST['newdata_byer'];
    $byerid = $_POST['byerid'];
    $column = $_POST['column'];

    switch ($column){
        case 'ov_tp':
            $statement=$database->prepare("UPDATE byers SET `ov_tp` = ? WHERE `byers_id` = ?");
            break;
        case 'ov_firstobp':
            $statement=$database->prepare("UPDATE byers SET `ov_firstobp` = ? WHERE `byers_id` = ?");
            break;
        case 'ov_wt':
            $statement=$database->prepare("UPDATE byers SET `ov_wt` = ? WHERE `byers_id` = ?");
            break;
        case 'comment':
            $statement=$database->prepare("UPDATE byers SET `comment` = ? WHERE `byers_id` = ?");
            break;

    }

    try{
        $database->beginTransaction();
        $statement->execute(array($newdata_byer,$byerid));
        $database->commit();

        echo "Все получилось! Поле ".$column." заданного покупателя изменено.";

    }catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $database->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }


}
/**/