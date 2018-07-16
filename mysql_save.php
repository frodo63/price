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
    $positionid = ($_POST["positionid"]);
    $trade = ($_POST["trade"]);
    $seller = ($_POST["seller"]);
    $zak = ($_POST["zak"]);
    $kol = ($_POST["kol"]);
    $tzr = ($_POST["tzr"]);
    $wtime = ($_POST["wtime"]);
    $fixed = ($_POST["fixed"]);
    $op = ($_POST["op"]);
    $tp = ($_POST["tp"]);
    $opr = ($_POST["opr"]);
    $tpr = ($_POST["tpr"]);
    $firstobp = ($_POST["firstobp"]);
    $firstoh = ($_POST["firstoh"]);
    $firstobpr = ($_POST["firstobpr"]);
    $marge = ($_POST["marge"]);
    $margek = ($_POST["margek"]);
    $rop = ($_POST["rop"]);
    $realop = ($_POST["realop"]);
    $rtp = ($_POST["rtp"]);
    $realtp = ($_POST["realtp"]);
    $clearp = ($_POST["clearp"]);
    $obp = ($_POST["obp"]);
    $oh = ($_POST["oh"]);
    $price = ($_POST["price"]);
    $rent = ($_POST["rent"]);

    try{

        $sql = "INSERT INTO pricings(
        positionid, tradeid,sellerid,zak,kol,tzr,wtime,fixed,op,tp,opr,tpr,firstobp,firstobpr,firstoh,marge,margek,rop,realop,rtp,realtp,clearp,obp,oh,price,rent)
        VALUES(
        :positionid,:trade,:seller,:zak,:kol,:tzr,:wtime,:fixed,:op,:tp,:opr,:tpr,:firstobp,:firstobpr,:firstoh,:marge,:margek,:rop,:realop,:rtp,:realtp,:clearp,:obp,:oh,:price,:rent
        )";
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
    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
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
    $pricingid = ($_POST["pricingid"]);
    $trade = ($_POST["trade"]);
    $seller = ($_POST["seller"]);
    $zak = ($_POST["zak"]);
    $kol = ($_POST["kol"]);
    $tzr = ($_POST["tzr"]);
    $wtime = ($_POST["wtime"]);
    $fixed = ($_POST["fixed"]);
    $op = ($_POST["op"]);
    $tp = ($_POST["tp"]);
    $opr = ($_POST["opr"]);
    $tpr = ($_POST["tpr"]);
    $firstobp = ($_POST["firstobp"]);
    $firstoh = ($_POST["firstoh"]);
    $firstobpr = ($_POST["firstobpr"]);
    $marge = ($_POST["marge"]);
    $margek = ($_POST["margek"]);
    $rop = ($_POST["rop"]);
    $realop = ($_POST["realop"]);
    $rtp = ($_POST["rtp"]);
    $realtp = ($_POST["realtp"]);
    $clearp = ($_POST["clearp"]);
    $obp = ($_POST["obp"]);
    $oh = ($_POST["oh"]);
    $price = ($_POST["price"]);
    $rent = ($_POST["rent"]);

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
    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
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
    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }
};
/**/
