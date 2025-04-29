<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'dashboard_databasemgt/database_connection.php';

// Redirect to login if admin session is not set
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

// Fetch admin profile image
$adminId = $_SESSION['admin_id']; // Make sure this is set when logging in
$stmt = $pdo->prepare("SELECT image_path FROM admin WHERE id = ?");
$stmt->execute([$adminId]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Set profile image path or fallback to default
$profileImage = $admin && !empty($admin['image_path'])
    ?  htmlspecialchars($admin['image_path'])
    : 'dashboard_databasemgt/images/profile_pic.webp';
?>

<!-- Top Bar -->
<div class="justify-between items-center flex flex-row pl-2 pr-10 pt-4 w-full">

    <!-- Search Bar -->
    <div class="flex">
        <div>
            <button onclick="toggleSidebar()" class="rounded pl-4 hidden" id="togglebutton2">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="pl-10">
            <input type="text" placeholder="Search" class="w-[50vw] p-2 border rounded-lg">
            <button class="ml-2 p-2 rounded"><i class="fas fa-search"></i></button>
        </div>
    </div>

    <!-- Notification & Profile -->
    <div class="flex items-center space-x-4 ml-4">
        <button class="p-2 rounded"><i class="fas fa-bell"></i></button>
        <img src="<?= $profileImage ?>" alt="Profile" class="w-10 h-10 rounded-full object-cover">
    </div>
</div>
