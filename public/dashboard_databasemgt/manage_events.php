<?php
require 'database_connection.php';

function getImagePath($pdo, $id = null) {
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
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Image uploaded successfully
            } else {
                $targetFile = '';
            }
        }
    }

    return $targetFile;
}

function deleteOldImage($pdo, $id) {
    $stmt = $pdo->prepare("SELECT image_path FROM events WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($event && $event['image_path'] && file_exists($event['image_path'])) {
        unlink($event['image_path']);
    }
}

try {
    $action = $_GET['action'] ?? '';
    $tab = $_POST['tab'] ?? $_GET['tab'] ?? 'hackathrons'; // Preserve tab
    $validTabs = ['hackathrons', 'conferences', 'news'];
    if (!in_array($tab, $validTabs)) {
        $tab = 'hackathrons';
    }

    switch ($action) {
        case 'addEvent':
            $title = $_POST['title'] ?? '';
            $date = $_POST['date'] ?? '';
            $details = $_POST['details'] ?? '';
            $location = $_POST['location'] ?? '';
            $category = $_POST['category'] ?? '';
            $imagePath = getImagePath($pdo);

            // Convert date to TIMESTAMP if valid
            $timestamp = $date && strtotime($date) ? date('Y-m-d H:i:s', strtotime($date)) : null;

            if ($title && $imagePath && $timestamp && $location && $details && $category) {
                $stmt = $pdo->prepare("INSERT INTO events (image_path, title, date, location, category, details) VALUES (:imagePath, :title, :date, :location, :category, :details)");
                $stmt->execute([
                    'imagePath' => $imagePath,
                    'title' => $title,
                    'date' => $timestamp,
                    'location' => $location,
                    'category' => $category,
                    'details' => $details
                ]);
                header("Location: ../dashboard_events.php?tab=$tab&message=Added successfully&status=successful");
            } else {
                header("Location: ../dashboard_events.php?tab=$tab&message=Failed to add event&status=unsuccessful");
            }
            break;

        case 'addNews':
            $title = $_POST['title'] ?? '';
            $details = $_POST['details'] ?? '';
            $imagePath = getImagePath($pdo);
            $category = 'news';

            if ($title && $imagePath && $category && $details) {
                $stmt = $pdo->prepare("INSERT INTO events (image_path, title, category, details) VALUES (:imagePath, :title, :category, :details)");
                $stmt->execute([
                    'imagePath' => $imagePath,
                    'title' => $title,
                    'category' => $category,
                    'details' => $details
                ]);
                header("Location: ../dashboard_events.php?tab=$tab&message=Added successfully&status=successful");
            } else {
                header("Location: ../dashboard_events.php?tab=$tab&message=Failed to add news&status=unsuccessful");
            }
            break;

        case 'editEvent':
            $id = $_POST['id'] ?? '';
            $title = $_POST['title'] ?? '';
            $location = $_POST['location'] ?? '';
            $details = $_POST['details'] ?? '';
            $date = $_POST['date'] ?? '';
            $imagePath = getImagePath($pdo, $id);

            // Convert date to TIMESTAMP if valid
            $timestamp = $date && strtotime($date) ? date('Y-m-d H:i:s', strtotime($date)) : null;

            if ($id && $title && $details) {
                if ($imagePath) {
                    // Delete old image before updating
                    deleteOldImage($pdo, $id);
                    $stmt = $pdo->prepare("UPDATE events SET title = :title, location = :location, details = :details, image_path = :image_path, date = :date WHERE id = :id");
                    $stmt->execute([
                        'title' => $title,
                        'location' => $location,
                        'details' => $details,
                        'image_path' => $imagePath,
                        'date' => $timestamp,
                        'id' => $id
                    ]);
                } else {
                    $stmt = $pdo->prepare("UPDATE events SET title = :title, location = :location, details = :details, date = :date WHERE id = :id");
                    $stmt->execute([
                        'title' => $title,
                        'location' => $location,
                        'details' => $details,
                        'date' => $timestamp,
                        'id' => $id
                    ]);
                }
                header("Location: ../dashboard_events.php?tab=$tab&message=Update successful&status=successful");
            } else {
                header("Location: ../dashboard_events.php?tab=$tab&message=Failed to update event&status=unsuccessful");
            }
            break;

        case 'editNews':
            $id = $_POST['id'] ?? '';
            $title = $_POST['title'] ?? '';
            $details = $_POST['details'] ?? '';
            $imagePath = getImagePath($pdo, $id);

            if ($id && $title && $details) {
                if ($imagePath) {
                    // Delete old image before updating
                    deleteOldImage($pdo, $id);
                    $stmt = $pdo->prepare("UPDATE events SET title = :title, details = :details, image_path = :image_path WHERE id = :id");
                    $stmt->execute([
                        'title' => $title,
                        'details' => $details,
                        'image_path' => $imagePath,
                        'id' => $id
                    ]);
                } else {
                    $stmt = $pdo->prepare("UPDATE events SET title = :title, details = :details WHERE id = :id");
                    $stmt->execute([
                        'title' => $title,
                        'details' => $details,
                        'id' => $id
                    ]);
                }
                header("Location: ../dashboard_events.php?tab=$tab&message=Update successful&status=successful");
            } else {
                header("Location: ../dashboard_events.php?tab=$tab&message=Failed to update news&status=unsuccessful");
            }
            break;

        case 'deleteEvent':
            $id = $_POST['id'] ?? 0;

            if ($id) {
                // Delete image before deleting record
                deleteOldImage($pdo, $id);
                $stmt = $pdo->prepare("DELETE FROM events WHERE id = :id");
                $stmt->execute(['id' => $id]);
                header("Location: ../dashboard_events.php?tab=$tab&message=Deleted successfully&status=successful");
            } else {
                header("Location: ../dashboard_events.php?tab=$tab&message=Failed to delete event&status=unsuccessful");
            }
            break;

        default:
            header("Location: ../dashboard_events.php?tab=$tab&message=Invalid action&status=unsuccessful");
            break;
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: ../dashboard_events.php?tab=$tab&message=An error occurred: " . urlencode($e->getMessage()) . "&status=unsuccessful");
}
?>