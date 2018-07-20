<?php
include_once 'pdo_connect.php';

if(
    isset($_POST["trade"]) &&
    isset($_POST["seller"]) &&
    isset($_POST["zak"]) &&
    isset($_POST["kol"]) &&
    isset($_POST["tzr"]) &&
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
    isset($_POST["rop"]) &&
    isset($_POST["rtp"]) &&
    isset($_POST["realop"]) &&
    isset($_POST["realtp"]) &&
    isset($_POST["oh"]) &&
    isset($_POST["marge"]) &&
    isset($_POST["margek"]) &&
    isset($_POST["clearp"]) &&
    isset($_POST["positionid"])
)
{
    $positionid = (int)($_POST["positionid"]);
    $trade = (int)($_POST["trade"]);
    $seller = (int)($_POST["seller"]);
    $zak = (int)($_POST["zak"]);
    $kol = (int)($_POST["kol"]);
    $tzr = (int)($_POST["tzr"]);
    $wtime = round(($_POST["wtime"]), 2);
    $fixed = (int)($_POST["fixed"]);
    $op = round(($_POST["op"]), 2);
    $tp = round(($_POST["tp"]), 2);
    $opr = round(($_POST["opr"]), 2);
    $tpr = round(($_POST["tpr"]), 2);
    $firstobp = round(($_POST["firstobp"]), 2);
    $firstoh = (int)($_POST["firstoh"]);
    $firstobpr = (int)($_POST["firstobpr"]);
    $marge = round(($_POST["margek"]), 2);
    $margek = round(($_POST["margek"]), 2);
    $rop = round(($_POST["rop"]), 2);
    $realop = round(($_POST["realop"]), 2);
    $rtp = round(($_POST["rtp"]), 2);
    $realtp = round(($_POST["realtp"]), 2);
    $clearp = round($_POST["clearp"], 2);
    $obp = round(($_POST["obp"]), 2);
    $oh = (int)($_POST["oh"]);
    $price = (int)($_POST["price"]);
    $rent = round(($_POST["rent"]), 2);

    try{
        $sql = "INSERT INTO pricings(
        positionid,tradeid,sellerid,zak,kol,tzr,wtime,fixed,op,tp,opr,tpr,firstobp,firstobpr,firstoh,marge,margek,rop,realop,rtp,realtp,clearp,obp,oh,price,rent)
        VALUES(:positionid,:trade,:seller,:zak,:kol,:tzr,:wtime,:fixed,:op,:tp,:opr,:tpr,:firstobp,:firstobpr,:firstoh,:marge,:margek,:rop,:realop,:rtp,:realtp,:clearp,:obp,:oh,:price,:rent)";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':positionid', $positionid);
        $statement->bindValue(':trade', $trade);
        $statement->bindValue(':seller', $seller);
        $statement->bindValue(':zak', $zak);
        $statement->bindValue(':kol', $kol);
        $statement->bindValue(':tzr', $tzr);
        $statement->bindValue(':wtime', $wtime);
        $statement->bindValue(':fixed', $fixed);
        $statement->bindValue(':op', $op);
        $statement->bindValue(':tp', $tp);
        $statement->bindValue(':opr', $opr);
        $statement->bindValue(':tpr', $tpr);
        $statement->bindValue(':firstobp', $firstobp);
        $statement->bindValue(':firstoh', $firstoh);
        $statement->bindValue(':firstobpr', $firstobpr);
        $statement->bindValue(':marge', $marge);
        $statement->bindValue(':margek', $margek);
        $statement->bindValue(':rop', $rop);
        $statement->bindValue(':realop', $realop);
        $statement->bindValue(':rtp', $rtp);
        $statement->bindValue(':realtp', $realtp);
        $statement->bindValue(':clearp', $clearp);
        $statement->bindValue(':obp', $obp);
        $statement->bindValue(':oh', $oh);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':rent', $rent);
        $pdo->beginTransaction();
        $statement->execute();
        $pdo->commit();

       echo "<p>Расценка добавлена</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
};


////EDITING
if(

    isset($_POST["trade"]) &&
    isset($_POST["seller"]) &&
    isset($_POST["zak"]) &&
    isset($_POST["kol"]) &&
    isset($_POST["tzr"]) &&
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
    isset($_POST["rop"]) &&
    isset($_POST["rtp"]) &&
    isset($_POST["realop"]) &&
    isset($_POST["realtp"]) &&
    isset($_POST["oh"]) &&
    isset($_POST["marge"]) &&
    isset($_POST["margek"]) &&
    isset($_POST["clearp"]) &&
    isset($_POST["pricingid"])
)
{
    $pricingid = (int)($_POST["pricingid"]);
    $trade = (int)($_POST["trade"]);
    $seller = (int)($_POST["seller"]);
    $zak = (int)($_POST["zak"]);
    $kol = (int)($_POST["kol"]);
    $tzr = (int)($_POST["tzr"]);
    $wtime = round(($_POST["wtime"]), 2);
    $fixed = (int)($_POST["fixed"]);
    $op = round(($_POST["op"]), 2);
    $tp = round(($_POST["tp"]), 2);
    $opr = round(($_POST["opr"]), 2);
    $tpr = round(($_POST["tpr"]), 2);
    $firstobp = round(($_POST["firstobp"]), 2);
    $firstoh = (int)($_POST["firstoh"]);
    $firstobpr = (int)($_POST["firstobpr"]);
    $marge = round(($_POST["margek"]), 2);
    $margek = round(($_POST["margek"]), 2);
    $rop = round(($_POST["rop"]), 2);
    $realop = round(($_POST["realop"]), 2);
    $rtp = round(($_POST["rtp"]), 2);
    $realtp = round(($_POST["realtp"]), 2);
    $clearp = round($_POST["clearp"], 2);
    $obp = round(($_POST["obp"]), 2);
    $oh = (int)($_POST["oh"]);
    $price = (int)($_POST["price"]);
    $rent = round(($_POST["rent"]), 2);

    try{

        $sql = "UPDATE pricings SET
        tradeid = :trade,
        sellerid = :seller,
        zak = :zak,
        kol = :kol,
        tzr = :tzr,
        wtime = :wtime,
        fixed = :fixed,
        op = :op,
        tp = :tp,
        opr = :opr,
        tpr = :tpr,
        firstobp = :firstobp,
        firstobpr = :firstobpr,
        firstoh = :firstoh,
        marge = :marge,
        margek = :margek,
        rop = :rop,
        realop = :realop,
        rtp = :rtp,
        realtp = :realtp,
        clearp = :clearp,
        obp = :obp,
        oh = :oh,
        price = :price,
        rent = :rent WHERE pricingid = :pricingid";
        $statement = $pdo->prepare($sql);

        $statement->bindValue(':pricingid', $pricingid);
        $statement->bindValue(':trade', $trade);
        $statement->bindValue(':seller', $seller);
        $statement->bindValue(':zak', $zak);
        $statement->bindValue(':kol', $kol);
        $statement->bindValue(':tzr', $tzr);
        $statement->bindValue(':wtime', $wtime);
        $statement->bindValue(':fixed', $fixed);
        $statement->bindValue(':op', $op);
        $statement->bindValue(':tp', $tp);
        $statement->bindValue(':opr', $opr);
        $statement->bindValue(':tpr', $tpr);
        $statement->bindValue(':firstobp', $firstobp);
        $statement->bindValue(':firstoh', $firstoh);
        $statement->bindValue(':firstobpr', $firstobpr);
        $statement->bindValue(':marge', $marge);
        $statement->bindValue(':margek', $margek);
        $statement->bindValue(':rop', $rop);
        $statement->bindValue(':realop', $realop);
        $statement->bindValue(':rtp', $rtp);
        $statement->bindValue(':realtp', $realtp);
        $statement->bindValue(':clearp', $clearp);
        $statement->bindValue(':obp', $obp);
        $statement->bindValue(':oh', $oh);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':rent', $rent);
        $pdo->beginTransaction();
        $statement->execute();
        $pdo->commit();

        echo "<p>Расценка " . $pricingid . " обновлена</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
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
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
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
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
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
        $statement = $pdo->prepare($sql);

       $pdo->beginTransaction();
        $statement->execute(array($the_input,$reqid));
        $pdo->commit();

        echo "<p>Опция ".$c_text." в заявке ".$reqid." обновлена. ".$the_input."</p>";
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        throw new MyDatabaseException( $Exception->getMessage( ) , (int)$Exception->getCode( ) );
    }
};
/**/