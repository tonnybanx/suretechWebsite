<?php
$dbc = "mysql:host=localhost;dbname=suretech_database";
$username = "root";
$pwd = "";

try{
    $pdo = new PDO($dbc, $username, $pwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e){
    echo "connection failed: ". $e->getMessage();
}