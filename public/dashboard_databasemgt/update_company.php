<?php
include 'database_connection.php';
try{
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $field = $_POST['field'] ?? '';
    $value = $_POST['value'] ?? '';

    // Allowed fields
    $allowedFields = ['name', 'email', 'overview', 'history', 'location', 'telephone'];

    if (in_array($field, $allowedFields)) {
        $stmt = $pdo->prepare("UPDATE about SET $field = :value WHERE id = 1");
        $stmt->execute(['value' => $value]);
        header("Location: ../dashboard_about.php?success=1");
        exit();
    } else {
        die("Invalid field.");
    }
} else {
    die("Invalid request.");
}

}
catch(PDOException $e){
   header("Location: ../dashboard_about.php?success=0"); 
}