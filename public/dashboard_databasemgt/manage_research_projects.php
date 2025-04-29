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
        $filePath = $uploadDir . $fileName;

        if (file_exists($filePath)) {
            $targetFile = $filePath;
        } else {
            $targetFile = $uploadDir . uniqid() . "_" . $fileName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                header("Location: ../dashboard_research.php?message=Failed to upload image&status=error");
                exit;
            }
        }
    }

    return $targetFile;
}

try {
    $action = $_GET['action'] ?? '';

    switch ($action) {

        case 'add_project':
            $title = $_POST['areaTitle'] ?? '';
            $description = $_POST['projectDescription'] ?? '';
            $imagePath = getImagePath();
            $category = 'projects';

            if ($title && $imagePath) {
                $stmt = $pdo->prepare("INSERT INTO projects (title, image_path, category, description) VALUES (:title, :image, :category, :description)");
                $stmt->execute([
                    'title' => $title,
                    'image' => $imagePath,
                    'category' => $category,
                    'description' => $description
                ]);
                header("Location: ../dashboard_research.php?message=Added successfully&status=successful");
            } else {
                header("Location: ../dashboard_research.php?message=Missing title or image&status=error");
            }
            exit;

        case 'fetch_projects':
            try {
                $stmt = $pdo->prepare("SELECT id, title, image_path, description FROM projects WHERE category = :category");
                $stmt->execute(['category' => 'projects']);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($data);
            } catch (PDOException $e) {
                echo json_encode(["error" => "Failed to fetch data: " . $e->getMessage()]);
            }
            break;

        case 'update_project':
            $title = $_POST['areaTitle'] ?? '';
            $description = $_POST['projectDescription'] ?? '';
            $id = $_POST['id'] ?? '';
            $imagePath = getImagePath();

            if ($id && $title) {
                if ($imagePath) {
                    $stmt = $pdo->prepare("UPDATE projects SET image_path = :image_path, title = :title, description = :description WHERE id = :id");
                    $stmt->execute([
                        'title' => $title,
                        'description' => $description,
                        'image_path' => $imagePath,
                        'id' => $id
                    ]);
                } else {
                    $stmt = $pdo->prepare("UPDATE projects SET title = :title, description = :description WHERE id = :id");
                    $stmt->execute([
                        'title' => $title,
                        'description' => $description,
                        'id' => $id
                    ]);
                }
                header("Location: ../dashboard_research.php?message=Updated successfully&status=successful");
            } else {
                header("Location: ../dashboard_research.php?message=Invalid update input&status=error");
            }
            exit;

        case 'delete_project':
            $id = $_POST['id'] ?? 0;
            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
                $stmt->execute(['id' => $id]);
                header("Location: ../dashboard_research.php?message=Deleted successfully&status=successful");
            } else {
                header("Location: ../dashboard_research.php?message=Invalid delete ID&status=error");
            }
            exit;

        default:
            header("Location: ../dashboard_research.php?message=Unknown action requested&status=error");
            exit;
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: ../dashboard_research.php?message=An error occurred&status=unsuccessful");
    exit;
}
?>
