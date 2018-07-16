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

        } catch(PDOExecption $e) {
                $pdo->rollback();
                print "Error!: " . $e->getMessage() . "</br>";
        }
};
/*//УДАЛЕНИЕ ВСЯКОГО РАЗНОГО ИЗ ТАБЛИЦ*/




/*УДАЛЕНИЕ ЗАЯВКИ*/
if(isset($_POST['delrequestid']) && isset($_POST['delnameid']))
{
        $delrequestid  = $_POST['delrequestid'];
        $delnameid  = $_POST['delnameid'];
        deleterequest($pdo, $delrequestid, $delnameid);
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

        } catch(PDOExecption $e) {
                $pdo->rollback();
                print "Error!: " . $e->getMessage() . "</br>";
        }

};
/*////УДАЛЕНИЕ ЗАЯВКИ*/



/*УДАЛЕНИЕ ПОЗИЦИИ*/
if(isset($_POST['delpositionid']))
{
        $delpositionid  = $_POST['delpositionid'];
        deleteposition($pdo, $delpositionid);
};
function deleteposition($pdo,$delpositionid)
{
        $statement = $pdo->prepare("DELETE FROM `req_positions` WHERE `req_positionid` = ?");
        try{
        $pdo->beginTransaction();
        $statement->execute(array($delpositionid));
        $pdo->commit();
        } catch(PDOExecption $e) {
                $pdo->rollback();
                print "Error!: " . $e->getMessage() . "</br>";
        }
};
/*////УДАЛЕНИЕ ПОЗИЦИИ*/


/*УДАЛЕНИЕ РАСЦЕНКИ*/
if(isset($_POST['delpricingid']))
{
        $delpricingid  = $_POST['delpricingid'];
        deletepricing($pdo, $delpricingid);
};
function deletepricing($pdo,$delpricingid)
{
        $statement = $pdo->prepare("DELETE FROM `pricings` WHERE `pricingid` = ?");
        try{
                $pdo->beginTransaction();
                $statement->execute(array($delpricingid));
                $pdo->commit();
        } catch(PDOExecption $e) {
                $pdo->rollback();
                print "Error!: " . $e->getMessage() . "</br>";
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
    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
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
    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }
};

/*///УДАЛЕНИЕ ВЫДАЧИ*/