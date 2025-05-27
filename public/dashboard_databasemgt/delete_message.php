<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'database_connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

// Check if ID is provided
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Invalid message ID']);
    exit;
}

$messageId = (int)$_POST['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$messageId]);
    
    if ($stmt->rowCount() > 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Message not found']);
    }
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>