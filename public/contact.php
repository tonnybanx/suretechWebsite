<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php
include 'navigationbar.php';
include 'dashboard_databasemgt/database_connection.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $message) {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
        $successMessage = "Message sent successfully!";
    } else {
        $errorMessage = "All fields are required.";
    }
}

// Fetch contact info
$stmt = $pdo->query("SELECT location, telephone, email FROM about LIMIT 1");
$contact = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch background image for support page
$bgQuery = $pdo->prepare("SELECT path FROM cover_images WHERE page = 'support' LIMIT 1");
$bgQuery->execute();
$bgImage = $bgQuery->fetch(PDO::FETCH_ASSOC);
$backgroundImage = $bgImage ? $bgImage['path'] : 'images/default.jpg';
?>

<!-- Page Wrapper with Background -->
<div class="flex items-center min-h-screen bg-cover bg-center relative" style="background-image: url('<?= htmlspecialchars($backgroundImage) ?>');">

    <!-- Background Blur Overlay -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-md z-0"></div>

    <!-- Contact Section -->
    <div class="relative z-10 flex flex-col md:flex-row rounded-lg max-w-[1500px] w-full p-10 lg:p-0">

        <!-- Left: Contact Info -->
        <div class="md:w-1/2 text-white py-10 lg:ml-52">
            <h2 class="text-3xl font-bold mb-4">Contact Us</h2>
            <p class="mb-6 mr-10">Have any questions, feedback, or need assistance? We’re always here to help! Feel free to reach out to us for any inquiries, support, or collaboration opportunities. We look forward to hearing from you and assisting in any way we can!</p>

            <div class="space-y-6">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white/20 flex items-center justify-center rounded-full text-green-300">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <p><?= htmlspecialchars($contact['location'] ?? 'Location not available') ?></p>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white/20 flex items-center justify-center rounded-full text-yellow-300">
                        <i class="fas fa-phone"></i>
                    </div>
                    <p><?= htmlspecialchars($contact['telephone'] ?? 'Phone not available') ?></p>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white/20 flex items-center justify-center rounded-full text-blue-400">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <p class="text-blue-300"><?= htmlspecialchars($contact['email'] ?? 'Email not available') ?></p>
                </div>
            </div>
        </div>

        <!-- Right: Contact Form -->
        <div class="md:w-1/2 bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold mb-4">Send Message</h3>

            <!-- Success/Error messages -->
            <?php if (!empty($successMessage)): ?>
                <div class="mb-4 text-green-600 font-medium"><?= $successMessage ?></div>
            <?php elseif (!empty($errorMessage)): ?>
                <div class="mb-4 text-red-600 font-medium"><?= $errorMessage ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-4">
                    <input type="text" name="name" placeholder="Full Name" required class="w-full p-3 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Email" required class="w-full p-3 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <textarea name="message" placeholder="Type your message..." required class="w-full p-3 border border-gray-300 rounded"></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                    Send
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
