<?php

$dsn = 'mysql:host=localhost;dbname=prices';
$dsnip = 'mysql:host=localhost;dbname=prices_ip';
$username = 'root';
$password = 'root';
$options = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
);

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdoip = new PDO($dsnip, $username, $password, $options);

    if(isset($_POST['db'])){
        if($_POST['db'] == "ltk"){$database = $pdo; $db_text = 'ltk';}
        if($_POST['db'] == "ip"){$database = $pdoip; $db_text = 'ip';}
    }

} catch (PDOException $Exception) {
    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    die();
}



