<?php
include_once 'pdo_connect.php';

$table = null;
$id = null;
$col2 = null;



/*УДАЛЕНИЕ ВСЯКОГО РАЗНОГО ИЗ ТАБЛИЦ*/
if(isset($_POST['delid']) && isset($_POST['deltablenameid']) && isset($_POST['deltable']))

{
        $id = $_POST['delid'];
        $table = $_POST['deltable'];
        $tablenameid = $_POST['deltablenameid'];

        delete($pdo, $tablenameid, $id, $table);

};


function delete($pdo,$tablenameid,$id,$table){

        $deltable = $pdo->prepare("DELETE FROM `$table` WHERE `$tablenameid` = ?");
        $delname = $pdo->prepare("DELETE FROM `allnames` WHERE `nameid` = ?");

        try{
        $pdo->beginTransaction();
        $deltable->execute(array($id));
        $delname->execute(array($id));
        $pdo->commit();

        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            $pdo->rollback();
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
};
/*//УДАЛЕНИЕ ВСЯКОГО РАЗНОГО ИЗ ТАБЛИЦ*/




/*УДАЛЕНИЕ ЗАЯВКИ С НАЗВАНИЕМ*/
if(isset($_POST['delrequestid']) && isset($_POST['delnameid']))
{
        $delrequestid  = $_POST['delrequestid'];
        $delnameid  = $_POST['delnameid'];
        deleterequest($database, $delrequestid, $delnameid);
};

function deleterequest($pdo,$delrequestid,$delnameid)
{

        $deltable = $pdo->prepare("DELETE FROM `requests` WHERE `requests_id` = ?");
        $delname = $pdo->prepare("DELETE FROM `allnames` WHERE `nameid` = ?");

        try{
        $pdo->beginTransaction();
        $deltable->execute(array($delrequestid));
        $delname->execute(array($delnameid));
        $pdo->commit();

        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            $pdo->rollback();
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }

};

/*УДАЛЕНИЕ ЗАЯВКИ БЕЗ НАЗВАНИЯ*/

if(isset($_POST['delrequestid_no_nameid']))
{
    $delrequestid  = $_POST['delrequestid_no_nameid'];
    deleterequest_no_nameid($database, $delrequestid);
};

function deleterequest_no_nameid($pdo,$delrequestid)
{

    $deltable = $pdo->prepare("DELETE FROM `requests` WHERE `requests_id` = ?");

    try{
        $pdo->beginTransaction();
        $deltable->execute(array($delrequestid));
        $pdo->commit();

    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

};
/*////УДАЛЕНИЕ ЗАЯВКИ*/



/*УДАЛЕНИЕ ПОЗИЦИИ*/
if(isset($_POST['delpositionid']))
{
        $delpositionid  = $_POST['delpositionid'];
        deleteposition($database, $delpositionid);
};
function deleteposition($pdo,$delpositionid)
{
        $statement = $pdo->prepare("DELETE FROM `req_positions` WHERE `req_positionid` = ?");
        try{
        $pdo->beginTransaction();
        $statement->execute(array($delpositionid));
        $pdo->commit();
        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            $pdo->rollback();
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
};
/*////УДАЛЕНИЕ ПОЗИЦИИ*/


/*УДАЛЕНИЕ РАСЦЕНКИ*/
if(isset($_POST['delpricingid']))
{
        $delpricingid  = $_POST['delpricingid'];
        deletepricing($database, $delpricingid);
};
function deletepricing($pdo,$delpricingid)
{


    $is_winner = $pdo->prepare("SELECT winner FROM pricings WHERE pricingid = ?");
    $get_positionid = $pdo->prepare("SELECT positionid FROM pricings WHERE pricingid = ?");

    $del_winner_from_position = $pdo->prepare("UPDATE req_positions SET winnerid = 0 WHERE req_positionid = ?");


        $statement = $pdo->prepare("DELETE FROM `pricings` WHERE `pricingid` = ?");
        try{

            $is_winner->execute(array($delpricingid));
            $is_winner_fetched = $is_winner->fetch(PDO::FETCH_ASSOC);


            $pdo->beginTransaction();

            //Проверка, а не является ли расцека виннером?
            if($is_winner_fetched['winner'] == 1){
                $get_positionid->execute(array($delpricingid));
                $get_positionid_fetched = $get_positionid->fetch(PDO::FETCH_ASSOC);
                $del_winner_from_position->execute(array($get_positionid_fetched['positionid']));
            }

            $statement->execute(array($delpricingid));
            $pdo->commit();
        } catch( PDOException $Exception ) {
            // Note The Typecast To An Integer!
            $pdo->rollback();
            print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
        }
};

/*///УДАЛЕНИЕ РАСЦЕНКИ*/


/*УДАЛЕНИЕ ПЛАТЕЖКИ*/
if(isset($_POST['delpaymentid']))
{
    $delpaymentid = $_POST['delpaymentid'];
    deletepayment($pdo, $delpaymentid);
};
function deletepayment($pdo,$delpaymentid)
{
    $statement = $pdo->prepare("DELETE FROM `payments` WHERE `payments_id` = ?");
    try{
        $pdo->beginTransaction();
        $statement->execute(array($delpaymentid));
        $pdo->commit();
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};

/*///УДАЛЕНИЕ ПЛАТЕЖКИ*/

/*УДАЛЕНИЕ ВЫДАЧИ*/
if(isset($_POST['delgiveawayid']))
{
    $delgiveawayid = $_POST['delgiveawayid'];
    deletegiveaway($pdo, $delgiveawayid);
};
function deletegiveaway($pdo,$delgiveawayid)
{
    $statement = $pdo->prepare("DELETE FROM `giveaways` WHERE `giveaways_id` = ?");
    try{
        $pdo->beginTransaction();
        $statement->execute(array($delgiveawayid));
        $pdo->commit();
    } catch( PDOException $Exception ) {
        // Note The Typecast To An Integer!
        $pdo->rollback();
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }
};

/*///УДАЛЕНИЕ ВЫДАЧИ*/