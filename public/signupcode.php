<?php
$host = 'localhost';
$dbname = 'suretech_database';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['submit'])) {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $location = trim($_POST['location']);
        $details = trim($_POST['details']);

        // Check for existing username
        $checkUsername = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
        $checkUsername->execute([':username' => $username]);

        if ($checkUsername->rowCount() > 0) {
            header("Location: signup.php?error=" . urlencode("Username already exists. Please choose another."));
            exit();
        }

        // Check for existing email
        $checkEmail = $pdo->prepare("SELECT * FROM admin WHERE email = :email");
        $checkEmail->execute([':email' => $email]);

        if ($checkEmail->rowCount() > 0) {
            header("Location: signup.php?error=" . urlencode("Email already exists. Please use another email."));
            exit();
        }

        // Check if user is in team table with 'admin' privilege
        $checkTeam = $pdo->prepare("SELECT * FROM team 
            WHERE email = :email AND privilege = 'admin'");
        $checkTeam->execute([
            ':email' => $email
        ]);

        if ($checkTeam->rowCount() > 0) {
            $stmt = $pdo->prepare("INSERT INTO admin (first_name, last_name, username, email, password, location, details)
                VALUES (:first_name, :last_name, :username, :email, :password, :location, :details)");
            $stmt->execute([
                ':first_name' => $first_name,
                ':last_name' => $last_name,
                ':username' => $username,
                ':email' => $email,
                ':password' => $password,
                ':location' => $location,
                ':details' => $details
            ]);

            header("Location: login.php?signup=success");
            exit();
        } else {
            header("Location: signup.php?error=" . urlencode("Access denied. You must be an admin in the team list to register here."));
            exit();
        }
    } else {
        header("Location: signup.php?error=" . urlencode("Invalid request."));
        exit();
    }
} catch (PDOException $e) {
    header("Location: signup.php?error=" . urlencode("Database error: " . $e->getMessage()));
    exit();
}
?>
