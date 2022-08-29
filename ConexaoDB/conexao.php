<?php

$servername = "localhost";
$myDB = "promocao";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$myDB; charset=utf8", $username, $password,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>