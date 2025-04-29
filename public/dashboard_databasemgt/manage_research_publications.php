<?php
require 'database_connection.php';

try {
    $action = $_GET['action'] ?? '';

    switch ($action) {
        // Add publication
        case 'add_publication':
            $title = $_POST['title'] ?? '';
            $description = $_POST['content'] ?? '';
            $link = $_POST['link'] ?? '';
            $author = $_POST['author'] ?? '';
            $date = $_POST['date'] ?? '';

            try {
                if ($title && $description && $link && $author && $date) {
                    $stmt = $pdo->prepare("INSERT INTO publications (title, link, description, author, publisher_date) VALUES (:title, :link, :description, :author, :date)");
                    $stmt->execute([
                        'title' => $title,
                        'link' => $link,
                        'description' => $description,
                        'author' => $author,
                        'date' => $date
                    ]);
                    header("Location: ../dashboard_research.php?status=success&message=Publication added successfully");
                    exit;
                } else {
                    header("Location: ../dashboard_research.php?status=error&message=Missing required fields");
                    exit;
                }
            } catch (PDOException $e) {
                header("Location: ../dashboard_research.php?status=error&message=" . urlencode("Error occurred: " . $e->getMessage()));
                exit;
            }
            break;

        // Fetch publications
        case 'fetch_publications':
            try {
                $stmt = $pdo->prepare("SELECT id, title, description, author, link, publisher_date FROM publications");
                $stmt->execute();
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($data);
            } catch (PDOException $e) {
                echo json_encode(["error" => "Failed to fetch data: " . $e->getMessage()]);
            }
            break;

        // Update publication
        case 'update_publication':
            $id = $_POST['id'] ?? '';
            $title = $_POST['title'] ?? '';
            $description = $_POST['content'] ?? '';
            $link = $_POST['link'] ?? '';
            $author = $_POST['author'] ?? '';
            $date = $_POST['date'] ?? '';

            if ($id && $title && $description && $link && $author && $date) {
                $stmt = $pdo->prepare("UPDATE publications SET description = :description, title = :title, link = :link, author = :author, publisher_date = :date WHERE id = :id");
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'id' => $id,
                    'link' => $link,
                    'date' => $date,
                    'author' => $author
                ]);
                header("Location: ../dashboard_research.php?status=success&message=Publication updated");
                exit;
            } else {
                header("Location: ../dashboard_research.php?status=error&message=Missing or invalid update input");
                exit;
            }
            break;

        // Delete publication
        case 'delete_publication':
            $id = $_POST['id'] ?? 0;
            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM publications WHERE id = :id");
                $stmt->execute(['id' => $id]);
                header("Location: ../dashboard_research.php?status=success&message=Publication deleted");
                exit;
            } else {
                header("Location: ../dashboard_research.php?status=error&message=Invalid ID for deletion");
                exit;
            }
            break;

        // Default
        default:
            header("Location: ../dashboard_research.php?status=error&message=Invalid action: " . urlencode($action));
            exit;
    }

} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: ../dashboard_research.php?status=error&message=" . urlencode("Database error: " . $e->getMessage()));
    exit;
}
?>
