<?php
require 'database_connection.php';

function getImagePath(){
    $uploadDir = 'images/';
    $targetFile = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;

        if (file_exists($filePath)) {
            $targetFile = $filePath;
        } else {
            $targetFile = $uploadDir . uniqid() . "_" . $fileName;
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        }
    }
    return $targetFile;
}

try {
    $action = $_GET['action'] ?? '';

    switch ($action) {
        case 'addStudent':
        case 'addStaff':
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $details = $_POST['details'];
            $email = $_POST['email'];
            $privilege = $_POST['privilege'];
            $imagePath = getImagePath();
            $category = $action === 'addStudent' ? 'student' : 'staff';

            if ($firstName && $lastName && $details && $imagePath) {
                $stmt = $pdo->prepare("INSERT INTO team (image_path, first_name, last_name, details, category, privilege, email) VALUES (:imagePath, :firstName, :lastName, :details, :category, :privilege, :email)");
                $stmt->execute([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'imagePath' => $imagePath,
                    'category' => $category,
                    'details' => $details,
                    'privilege' => $privilege,
                    'email' => $email
                ]);
                header("Location: ../dashboard_team.php?message=Successfully added $category&status=successful");
            } else {
                header("Location: ../dashboard_team.php?message=Missing fields in form&status=unsuccessful");
            }
            break;

        case 'fetchStudents':
        case 'fetchStaff':
            $category = $action === 'fetchStudents' ? 'student' : 'staff';
            $stmt = $pdo->prepare("SELECT id, first_name, last_name, image_path, details, privilege, email FROM team WHERE category = :category");
            $stmt->execute(['category' => $category]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($data);
            break;

        case 'editStudent':
        case 'editStaff':
            $id = $_POST['id'] ?? '';
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $details = $_POST['details'] ?? '';
            $email = $_POST['email'] ?? '';
            $privilege = $_POST['privilege'] ?? '';
            $image_path = getImagePath();

            if ($image_path) {
                $stmt = $pdo->prepare("UPDATE team SET first_name = :firstName, last_name = :lastName, details = :details, image_path = :image_path, privilege = :privilege, email = :email WHERE id = :id");
                $stmt->execute([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'details' => $details,
                    'image_path' => $image_path,
                    'privilege' => $privilege,
                    'email' => $email,
                    'id' => $id
                ]);
            } else {
                $stmt = $pdo->prepare("UPDATE team SET first_name = :firstName, last_name = :lastName, details = :details, privilege = :privilege, email = :email WHERE id = :id");
                $stmt->execute([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'details' => $details,
                    'privilege' => $privilege,
                    'email' => $email,
                    'id' => $id
                ]);
            }
            header("Location: ../dashboard_team.php?message=Successfully updated&status=successful");
            break;

        case 'delete':
            $id = $_POST['id'] ?? 0;

            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM team WHERE id = :id");
                $stmt->execute(['id' => $id]);
                header("Location: ../dashboard_team.php?message=Deleted successfully&status=successful");
            } else {
                header("Location: ../dashboard_team.php?message=Invalid ID&status=unsuccessful");
            }
            break;

        default:
            header("Location: ../dashboard_team.php?message=Invalid action&status=unsuccessful");
            break;
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: ../dashboard_team.php?message=Error: " . urlencode($e->getMessage()) . "&status=unsuccessful");
}
?>
