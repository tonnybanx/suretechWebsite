<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if admin session is not set
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

try {
    include 'dashboard_databasemgt/database_connection.php';

    // Count total ongoing projects
    $stmt1_count = $pdo->query("SELECT COUNT(*) FROM projects WHERE status = 'ongoing' AND category = 'projects'");
    $projects_count = $stmt1_count->fetchColumn();

    // Fetch 3 featured ongoing projects
    $stmt1 = $pdo->query("SELECT * FROM projects WHERE status = 'ongoing' AND category = 'projects' ORDER BY id DESC LIMIT 3");
    $projects = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    // Count total publications
    $stmt2_count = $pdo->query("SELECT COUNT(*) FROM publications");
    $publications_count = $stmt2_count->fetchColumn();

    // Fetch 2 recent publications
    $stmt2 = $pdo->query("SELECT * FROM publications ORDER BY publisher_date DESC LIMIT 2");
    $publications = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // Count total team members
    $stmt3_count = $pdo->query("SELECT COUNT(*) FROM team");
    $team_count = $stmt3_count->fetchColumn();

    // Count total events
    $stmt4_count = $pdo->query("SELECT COUNT(*) FROM events");
    $events_count = $stmt4_count->fetchColumn();

    // Fetch 2 upcoming events
    $stmt4 = $pdo->query("SELECT * FROM events ORDER BY date ASC LIMIT 2");
    $events = $stmt4->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
    $projects = $publications = $team = $events = [];
    $projects_count = $publications_count = $team_count = $events_count = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Research Center Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .icon-blue i {
            color: #3b82f6;
        }
    </style>
</head>
<body class="bg-gray-100 h-screen flex overflow-hidden text-gray-800">
    <?php include 'dashboard_sidebar.php'; ?>
    <div class="flex-1 flex flex-col bg-white">
        <?php include 'dashboard_topbar.php'; ?>
        <main class="flex-1 overflow-y-auto p-6 max-w-7xl mx-auto space-y-12">
            <!-- Error Message -->
            <?php if (isset($error)): ?>
                <div class="p-4 mb-4 bg-red-100 text-red-700 rounded">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Stats -->
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white border rounded-lg p-5 shadow-sm flex items-center gap-4">
                    <div class="text-blue-500 text-xl"><i class="fas fa-flask"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">Ongoing Projects</p>
                        <h2 class="text-2xl font-semibold text-blue-600"><?php echo htmlspecialchars($projects_count); ?></h2>
                    </div>
                </div>
                <div class="bg-white border rounded-lg p-5 shadow-sm flex items-center gap-4">
                    <div class="text-blue-500 text-xl"><i class="fas fa-book-open"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">Publications</p>
                        <h2 class="text-2xl font-semibold text-blue-600"><?php echo htmlspecialchars($publications_count); ?></h2>
                    </div>
                </div>
                <div class="bg-white border rounded-lg p-5 shadow-sm flex items-center gap-4">
                    <div class="text-blue-500 text-xl"><i class="fas fa-users"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">Research Team</p>
                        <h2 class="text-2xl font-semibold text-blue-600"><?php echo htmlspecialchars($team_count); ?></h2>
                    </div>
                </div>
                <div class="bg-white border rounded-lg p-5 shadow-sm flex items-center gap-4">
                    <div class="text-blue-500 text-xl"><i class="fa-regular fa-calendar-days"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">Events</p>
                        <h2 class="text-2xl font-semibold text-blue-600"><?php echo htmlspecialchars($events_count); ?></h2>
                    </div>
                </div>
            </section>

            <!-- Featured Research -->
            <section>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-blue-700">Featured Research</h2>
                </div>
                <?php if (empty($projects)): ?>
                    <p class="text-gray-600">No ongoing projects found.</p>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php foreach ($projects as $proj): ?>
                            <div class="bg-white border rounded-lg p-5 shadow-sm">
                                <h3 class="font-semibold text-lg text-blue-800"><?php echo htmlspecialchars($proj['title']); ?></h3>
                                <p class="text-sm text-gray-600 mt-2"><?php echo htmlspecialchars($proj['description']); ?></p>
                                <span class="text-xs text-gray-400 italic block mt-3"><?php echo htmlspecialchars($proj['status']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Publications and Events -->
            <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Publications -->
                <div>
                    <h2 class="text-xl font-bold text-blue-700 mb-2">Recent Publications</h2>
                    <?php if (empty($publications)): ?>
                        <p class="text-gray-600">No publications found.</p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($publications as $pub): ?>
                                <div class="bg-white border rounded-lg p-4 shadow-sm">
                                    <h3 class="font-semibold text-blue-800"><?php echo htmlspecialchars($pub['title']); ?></h3>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($pub['author']); ?></p>
                                    <span class="text-xs text-gray-400"><?php echo date("F j, Y", strtotime($pub['publisher_date'])); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Events -->
                <div>
                    <h2 class="text-xl font-bold text-blue-700 mb-2">Upcoming Events</h2>
                    <?php if (empty($events)): ?>
                        <p class="text-gray-600">No upcoming events found.</p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($events as $event): ?>
                                <div class="bg-white border rounded-lg p-4 shadow-sm">
                                    <h3 class="font-semibold text-blue-800"><?php echo htmlspecialchars($event['title']); ?></h3>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fa-regular fa-calendar-days text-blue-500"></i>
                                        <?php echo date("F j, Y", strtotime($event['date'])); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const toggle_btn = document.getElementById("togglebutton2");
            toggle_btn.classList.toggle("hidden");
            sidebar.classList.toggle("hidden");
        }
    </script>
</body>
</html>