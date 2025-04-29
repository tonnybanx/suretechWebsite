<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=suretech_database", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Select ID and password to use both
        $stmt = $pdo->prepare("SELECT id, password FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['admin'] = true;
            $_SESSION['admin_id'] = $user['id'];

            header("Location: dashboard_home.php");
            exit;
        } else {
            header("Location: login.php?message=Invalid username or password!&status=error");
            exit;
        }
    } catch (PDOException $e) {
        header("Location: login.php?message=An error occurred!&status=error");
        exit;
    }
}
?>
