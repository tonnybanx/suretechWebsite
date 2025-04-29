<?php
require 'database_connection.php';

function getImagePath() {
    $uploadDir = 'images/';
    $targetFile = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['image']['name']);
        $targetFile = $uploadDir . uniqid() . "_" . $fileName;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            header("Location: ../dashboard_research.php?message=Failed to upload image&status=error");
            exit;
        }
    }

    return $targetFile;
}

try {
    $action = $_GET['action'] ?? '';

    switch ($action) {

        case 'add_areas':
            $title = $_POST['areaTitle'] ?? '';
            $description = $_POST['projectDescription'] ?? '';
            $category = 'areas';
            $imagePath = getImagePath();

            if ($title && $imagePath) {
                $stmt = $pdo->prepare("INSERT INTO projects (title, image_path, category) VALUES (:title, :image, :category)");
                $stmt->execute([
                    'title' => $title,
                    'image' => $imagePath,
                    'category' => $category
                ]);
                header("Location: ../dashboard_research.php?message=Content uploaded successfully&status=success");
            } else {
                header("Location: ../dashboard_research.php?message=Missing title or image&status=error");
            }
            exit;

        case 'fetch_areas':
            $category = 'areas';
            try {
                $stmt = $pdo->prepare("SELECT id, title, image_path FROM projects WHERE category = :category");
                $stmt->execute(['category' => $category]);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($data);
            } catch (PDOException $e) {
                echo json_encode(["error" => "Failed to fetch data: " . $e->getMessage()]);
            }
            break;

        case 'update_areas':
            $title = $_POST['areaTitle'] ?? '';
            $id = $_POST['id'] ?? '';
            $imagePath = getImagePath();

            if ($id && $title && $imagePath) {
                $stmt = $pdo->prepare("UPDATE projects SET image_path = :image_path, title = :title WHERE id = :id");
                $stmt->execute([
                    'title' => $title,
                    'image_path' => $imagePath,
                    'id' => $id
                ]);
                header("Location: ../dashboard_research.php?message=Area updated successfully&status=success");
            } else {
                header("Location: ../dashboard_research.php?message=Invalid update input&status=error");
            }
            exit;

        case 'delete_area':
            $id = $_POST['id'] ?? 0;

            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
                $stmt->execute(['id' => $id]);
                header("Location: ../dashboard_research.php?message=Area deleted successfully&status=success");
            } else {
                header("Location: ../dashboard_research.php?message=Invalid delete input&status=error");
            }
            exit;

        default:
            header("Location: ../dashboard_research.php?message=Unknown action&status=error");
            exit;
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: ../dashboard_research.php?message=Database error&status=error");
    exit;
}
?>
