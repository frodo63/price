<?php
include_once 'pdo_connect.php';

if(isset($_POST['table']) && isset($_POST['thename'])){

    $table = $_POST['table'];
    $thename = $_POST['thename'];

    /**//////////////////////////////////////////////////////////////
    $statement = $pdo->prepare("INSERT INTO `allnames`(`name`) VALUES(?)");

    try {
        $pdo->beginTransaction();
        $statement->execute(array($thename));
        $theID = $pdo->lastInsertId();
        $thecolumn = $table . '_nameid';
        $statement = $pdo->prepare("INSERT INTO `$table`(`$thecolumn`) VALUES(?)");

        $statement->execute(array($theID));
        $pdo->commit();

    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Добавлена запись $thename в таблицу $table.";

};

//ДОБАВЛЕНИЕ заявки ///////////////////////////////////////////////////
if(isset($_POST['byer']) && isset($_POST['thename'])){

    $byer = $_POST['byer'];
    $thename = $_POST['thename'];

    /**//////////////////////////////////////////////////////////////
    $statement = $pdo->prepare("INSERT INTO `allnames`(`name`) VALUES(?)");
    $stmt = $pdo->prepare("INSERT INTO `requests`(`requests_nameid`,`byersid`) VALUES(?, ?)");

    try {
        $pdo->beginTransaction();
        $statement->execute(array($thename));
        $theID = $pdo->lastInsertId();
        $stmt->execute(array($theID, $byer));
        $pdo->commit();

    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Добавлена Заявка  " . $thename . " .";

};
/////////////////////////////////////////////////////////////////////

///ДОБАВЛЕНИЕ ПОЗИЦИИ////////////////////////////////////////////////
if(isset($_POST['reqid']) && isset($_POST['posname'])){

    $reqid = $_POST['reqid'];
    $posname = $_POST['posname'];

    /**//////////////////////////////////////////////////////////////

    try {
        $pdo->beginTransaction();
        $statement = $pdo->prepare("INSERT INTO `req_positions`(`pos_name`,`requestid`) VALUES(?,?)");

        $statement->bindParam(1, $posname);
        $statement->bindParam(2, $reqid);

        $statement->execute();
        $pdo->commit();

    } catch(PDOExecption $e) {
        $pdo->rollback();
        print "Error!: " . $e->getMessage() . "</br>";
    }
    /**//////////////////////////////////////////////////////////////

    echo "Получилось! Добавлена запись $posname в заявку $reqid.";

};
//////////////////////////////////////////////////////////////////////

//ДОБАВЛЕНИЕ ПЛАТЕЖКИ/////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////


//ДОБАВЛЕНИЕ ВЫДАЧИ///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
