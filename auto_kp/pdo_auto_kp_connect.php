<?php

$dsn = 'mysql:host=localhost;dbname=auto_kp';
$username = 'root';
$password = 'tr776bBe';
$options = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
);

try {

    $pdo = new PDO($dsn, $username, $password, $options);

} catch (PDOException $Exception) {
    print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    die();
}



