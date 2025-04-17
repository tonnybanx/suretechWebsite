<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=webdev", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $stmt = $pdo->prepare("SELECT pswd FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['pswd'])) {
             header("Location: main_dashboard.php");
            
        } else {
           header("Location: login.php?message=Invalid username or password!&status=error"); 
        }
    } catch (PDOException $e) {
    
    }
}
