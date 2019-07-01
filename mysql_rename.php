<?php
include_once 'pdo_connect.php';

/*ПЕРЕИМЕНОВАНИЕ ЗАЯВОК, ПОКУПАТЕЛЕЙ, ПОСТАВЩИКОВ, ТОВАРОВ*/
function OutNewRename($pdo, $newname, $nameid, $table){

    if($table == 'positions'){
        try{
            $pdo->beginTransaction();
            /*ВОТ КАК НАДО ДЕЛАТЬ АПЕДЙТ В БАЗЕ*/
            $rename=$pdo->prepare("UPDATE `req_positions` SET `pos_name` = :newname WHERE `req_positions`.`req_positionid` = :nameid");
            $rename->execute(array(':newname' => $newname, ':nameid' => $nameid));

            $pdo->commit();
            echo "<p>Наименование позиции изменено</p>";
        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            $pdo->rollback();
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }

    }else{
        try{
            $pdo->beginTransaction();
            /*ВОТ КАК НАДО ДЕЛАТЬ АПЕДЙТ В БАЗЕ*/
            $rename=$pdo->prepare("UPDATE `allnames` SET `allnames`.`name` = :newname WHERE `allnames`.`nameid` = :nameid");
            $rename->execute(array(':newname' => $newname, ':nameid' => $nameid));

            $pdo->commit();
            echo "<p>Наименование изменено</p>";
        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            $pdo->rollback();
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
    };
};

if(isset($_POST['newname']) && isset($_POST['nameid']) && isset($_POST['table']))
{
    $newname = $_POST['newname'];
    $nameid = $_POST['nameid'];
    $table = $_POST['table'];

    OutNewRename($database, $newname, $nameid, $table);
};



/*ПЕРЕИМЕНВАНИЕ ПОЗИЦИИИ _ ОТДЕЛЬНЫЙ СКРИПТ, ТАК КАК ИМЯ ПОЗИЦИИ НЕ СОХРАНЯЕТСМЯ В ОЛЛНЕЙМАСАХ*/