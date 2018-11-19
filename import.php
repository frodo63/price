<?php
include_once 'pdo_connect.php';

$file = "files/import_test.csv";

$byers_list = array();

if (file_exists($file)){
    echo"<p>Файл найден</p>";
    $file_array = file($file); // Считывание файла в массив $file_array
    if (count($file_array) > 0);
    echo"<p>Файл выгружен в массив</p>";

    foreach ($file_array as $row){
        $byers_list[] = explode(';',$row);
    }

    foreach ($byers_list as $row){
        echo"<pre>";
        print_r($row);
        echo"/<pre>";
    }
}