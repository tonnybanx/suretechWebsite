<?php
include 'database_connection.php';
try{
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    if ($action === 'unsubscribe' && $id) {
        $stmt = $pdo->prepare("DELETE FROM subscribers WHERE id = ?");
        $stmt->execute([$id]);
    }
}

}
catch(PDOException $e){
 header('Location: ../dashboard_engagements.php?error=An error occurred');   
}
header('Location: ../dashboard_engagements.php');
exit;
