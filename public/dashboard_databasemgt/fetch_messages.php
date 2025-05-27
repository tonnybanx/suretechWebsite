<?php
include 'database_connection.php';

try {
    $stmt = $pdo->query("SELECT id, email, message, DATE_FORMAT(date, '%Y-%m-%d') as date FROM messages ORDER BY date DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'messages' => $messages]);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>