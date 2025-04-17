<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $myusername = $_POST["username"];
    $email = $_POST["email"];
    $pswd = $_POST["password"];

     // Hash the password (for security)
    $hashed_password = password_hash($pswd, PASSWORD_DEFAULT);

    
try{
    require_once "databaseconnection.php";
    $query = "INSERT INTO users (username,pswd,email) VALUES (?,?,?);";
    $statement = $pdo->prepare($query);
    $statement->execute([$myusername, $hashed_password, $email]);
    $pdo = null;
    $statement = null;

    header("Location: index.php");
    die();
}
catch(PDOException $e){
    echo "Error occured: " . $e->getMessage();
    
    
}

}else{
    header("Location: index.html");
}

