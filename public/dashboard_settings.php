<?php
// Include your DB connection file
include 'dashboard_databasemgt/database_connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['admin_id'] ?? 1; // Default to 1 for testing

// Fetch user data
$sql = "SELECT * FROM admin WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$profilePicPath = !empty($user['image_path'])
    ? htmlspecialchars($user['image_path']) . '?t=' . time()
    : "dashboard_databasemgt/images/profile_pic.webp";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    if (!empty($_FILES['profile_pic']['name'])) {
        $uploadDir = 'images/';
        $fileName = uniqid() . '_' . basename($_FILES['profile_pic']['name']);
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadPath)) {
            $sql = "UPDATE admin SET first_name = ?, last_name = ?, username = ?, email = ?, location = ?, details = ?, image_path = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$firstName, $lastName, $username, $email, $location, $description, $uploadPath, $user_id]);

            echo "<script>
                alert('Profile updated successfully!');
                window.location.href = window.location.href;
            </script>";
            exit;
        }
    } else {
        $sql = "UPDATE admin SET first_name = ?, last_name = ?, username = ?, email = ?, location = ?, details = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$firstName, $lastName, $username, $email, $location, $description, $user_id]);

        echo "<script>
            alert('Profile updated successfully!');
            window.location.href = window.location.href;
        </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/7a97402827.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="flex h-full w-full">
    <?php include 'dashboard_sidebar.php'; ?>
    <div class="flex-1">
        <?php include 'dashboard_topbar.php'; ?>
        <div class="pt-10 w-full">
            <div class="w-full px-6 h-[80vh] overflow-auto">

                <form method="POST"  enctype="multipart/form-data">
                    <div class="flex items-center space-x-4 mb-6 relative h-[100px] w-[120px] ">
                        <img id="profile-pic" src="<?php echo $profilePicPath; ?>" alt="Profile Picture" class="w-[100px] h-[100px] rounded-full object-cover">
                        <input type="file" id="profile-input" name="profile_pic" accept="image/*" class="hidden" onchange="previewImage(this)">
                        <div class="top-[50px] left-[80px] absolute h-10 w-10 justify-center align-middle"><span class="fa-stack fa-sm">
                       <i class="fas fa-circle fa-stack-2x text-blue-400"></i>
                          <i class="fas fa-pen  text-white cursor-pointer fa-stack-1x fa-inverse" onclick="document.getElementById('profile-input').click();"></i>
                       </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">First name</label>
                            <input type="text" name="first_name" class="w-full p-2 border rounded" value="<?php echo htmlspecialchars($user['first_name']); ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last name</label>
                            <input type="text" name="last_name" class="w-full p-2 border rounded" value="<?php echo htmlspecialchars($user['last_name']); ?>">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" class="w-full p-2 border rounded" value="<?php echo htmlspecialchars($user['username']); ?>">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" class="w-full p-2 border rounded" value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" class="w-full p-2 border rounded" value="<?php echo htmlspecialchars($user['location']); ?>">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" class="w-full p-2 border rounded h-24"><?php echo htmlspecialchars($user['details']); ?></textarea>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="bg-blue-400 text-white px-6 py-2 rounded hover:bg-blue-500">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('profile-pic').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</body>
</html>
