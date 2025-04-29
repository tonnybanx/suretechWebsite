<?php
include 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    if ($action === 'delete' && $id) {
        $stmt = $pdo->prepare("DELETE FROM partners WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action === 'edit' && $id) {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $stmt = $pdo->prepare("UPDATE partners SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$name, $email, $id]);
    }
}

header('Location: ../dashboard_engagements.php');
exit;
