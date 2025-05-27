<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'database_connection.php';

// Redirect to login if admin session is not set
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: ../login.php');
    exit;
}

// Get the action and tab
$action = isset($_GET['action']) ? $_GET['action'] : '';
$tab = isset($_POST['tab']) ? $_POST['tab'] : (isset($_GET['tab']) ? $_GET['tab'] : 'students');

// Validate tab
$validTabs = ['students', 'staff'];
if (!in_array($tab, $validTabs)) {
    $tab = 'students';
}

function redirectWithMessage($message, $status, $tab) {
    header("Location: ../dashboard_team.php?tab=" . urlencode($tab) . "&message=" . urlencode($message) . "&status=" . urlencode($status));
    exit;
}

function deleteImage($pdo, $id) {
    $stmt = $pdo->prepare("SELECT image_path FROM team WHERE id = ?");
    $stmt->execute([$id]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($record && !empty($record['image_path']) && file_exists("../dashboard_databasemgt/" . $record['image_path'])) {
        unlink("../dashboard_databasemgt/" . $record['image_path']);
    }
}

try {
    switch ($action) {
        case 'addStudent':
        case 'addStaff':
            $category = ($action === 'addStudent') ? 'student' : 'staff';
            $firstName = trim($_POST['firstName'] ?? '');
            $lastName = trim($_POST['lastName'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $details = trim($_POST['details'] ?? '');
            $privilege = trim($_POST['privilege'] ?? 'user');

            if (empty($firstName) || empty($lastName) || empty($email) || empty($details)) {
                redirectWithMessage("All fields are required.", "error", $tab);
            }

            // Handle image upload
            $imagePath = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../dashboard_databasemgt/uploads/team/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
                $imagePath = 'uploads/team/' . $imageName;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], "../dashboard_databasemgt/" . $imagePath)) {
                    redirectWithMessage("Failed to upload image.", "error", $tab);
                }
            } else {
                redirectWithMessage("Image is required.", "error", $tab);
            }

            $stmt = $pdo->prepare("
                INSERT INTO team (first_name, last_name, email, details, privilege, image_path, category)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$firstName, $lastName, $email, $details, $privilege, $imagePath, $category]);
            redirectWithMessage("Team member added successfully.", "success", $tab);
            break;

        case 'editStudent':
        case 'editStaff':
            $category = ($action === 'editStudent') ? 'student' : 'staff';
            $id = trim($_POST['id'] ?? '');
            $firstName = trim($_POST['firstName'] ?? '');
            $lastName = trim($_POST['lastName'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $details = trim($_POST['details'] ?? '');
            $privilege = trim($_POST['privilege'] ?? 'user');

            if (empty($id) || empty($firstName) || empty($lastName) || empty($email) || empty($details)) {
                redirectWithMessage("All fields are required.", "error", $tab);
            }

            // Check if a new image is uploaded
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Delete old image
                deleteImage($pdo, $id);

                // Upload new image
                $uploadDir = '../dashboard_databasemgt/uploads/team/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
                $imagePath = 'uploads/team/' . $imageName;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], "../dashboard_databasemgt/" . $imagePath)) {
                    redirectWithMessage("Failed to upload new image.", "error", $tab);
                }
            }

            // Prepare update query
            $sql = "UPDATE team SET first_name = ?, last_name = ?, email = ?, details = ?, privilege = ?, category = ?";
            $params = [$firstName, $lastName, $email, $details, $privilege, $category];
            if ($imagePath) {
                $sql .= ", image_path = ?";
                $params[] = $imagePath;
            }
            $sql .= " WHERE id = ?";
            $params[] = $id;

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            redirectWithMessage("Team member updated successfully.", "success", $tab);
            break;

        case 'delete':
            $id = trim($_POST['id'] ?? '');
            if (empty($id)) {
                redirectWithMessage("Invalid team member ID.", "error", $tab);
            }

            // Delete image
            deleteImage($pdo, $id);

            // Delete record
            $stmt = $pdo->prepare("DELETE FROM team WHERE id = ?");
            $stmt->execute([$id]);
            redirectWithMessage("Team member deleted successfully.", "success", $tab);
            break;

        default:
            redirectWithMessage("Invalid action.", "error", $tab);
    }
} catch (PDOException $e) {
    redirectWithMessage("Database error: " . $e->getMessage(), "error", $tab);
}
?>