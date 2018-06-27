<?php

$dsn = 'mysql:host=localhost;dbname=prices';
$username = 'root';
$password = 'root';
$options = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
);

try {
    $pdo = new PDO($dsn, $username, $password, $options);


} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}


