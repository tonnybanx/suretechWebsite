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
            header("Location: ../dashboard_research.php?tab=" . urlencode($_POST['tab'] ?? 'areas') . "&message=Failed to upload image&status=error");
            exit;
        }
    }

    return $targetFile;
}

try {
    $action = $_GET['action'] ?? '';
    $tab = $_POST['tab'] ?? $_GET['tab'] ?? 'areas';

    switch ($action) {
        case 'add_areas':
            $title = $_POST['areaTitle'] ?? '';
            $category = 'areas';
            $imagePath = getImagePath();

            if ($title && $imagePath) {
                $stmt = $pdo->prepare("INSERT INTO projects (title, image_path, category) VALUES (:title, :image, :category)");
                $stmt->execute([
                    'title' => $title,
                    'image' => $imagePath,
                    'category' => $category
                ]);
                header("Location: ../dashboard_research.php?tab=" . urlencode($tab) . "&message=Content uploaded successfully&status=success");
            } else {
                header("Location: ../dashboard_research.php?tab=" . urlencode($tab) . "&message=Missing title or image&status=error");
            }
            exit;

        case 'update_areas':
            $title = $_POST['areaTitle'] ?? '';
            $id = $_POST['id'] ?? '';
            $imagePath = getImagePath();

            if ($id && $title) {
                // Fetch original image path
                $stmt = $pdo->prepare("SELECT image_path FROM projects WHERE id = :id");
                $stmt->execute(['id' => $id]);
                $originalImage = $stmt->fetchColumn();

                // Update database
                if ($imagePath) {
                    // Delete original image if a new one is uploaded
                    if ($originalImage && file_exists($originalImage)) {
                        unlink($originalImage);
                    }
                    $stmt = $pdo->prepare("UPDATE projects SET image_path = :image_path, title = :title WHERE id = :id");
                    $stmt->execute([
                        'title' => $title,
                        'image_path' => $imagePath,
                        'id' => $id
                    ]);
                } else {
                    $stmt = $pdo->prepare("UPDATE projects SET title = :title WHERE id = :id");
                    $stmt->execute([
                        'title' => $title,
                        'id' => $id
                    ]);
                }
                header("Location: ../dashboard_research.php?tab=" . urlencode($tab) . "&message=Area updated successfully&status=success");
            } else {
                header("Location: ../dashboard_research.php?tab=" . urlencode($tab) . "&message=Invalid update input&status=error");
            }
            exit;

        case 'delete_area':
            $id = $_POST['id'] ?? 0;

            if ($id) {
                // Fetch image path to delete
                $stmt = $pdo->prepare("SELECT image_path FROM projects WHERE id = :id");
                $stmt->execute(['id' => $id]);
                $imagePath = $stmt->fetchColumn();

                // Delete image file
                if ($imagePath && file_exists($imagePath)) {
                    unlink($imagePath);
                }

                // Delete database record
                $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
                $stmt->execute(['id' => $id]);
                header("Location: ../dashboard_research.php?tab=" . urlencode($tab) . "&message=Area deleted successfully&status=success");
            } else {
                header("Location: ../dashboard_research.php?tab=" . urlencode($tab) . "&message=Invalid delete input&status=error");
            }
            exit;

        default:
            header("Location: ../dashboard_research.php?tab=" . urlencode($tab) . "&message=Unknown action&status=error");
            exit;
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: ../dashboard_research.php?tab=" . urlencode($tab) . "&message=Database error&status=error");
    exit;
}
?>