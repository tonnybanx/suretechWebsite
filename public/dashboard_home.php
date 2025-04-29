<?php


try {
  include 'dashboard_databasemgt/database_connection.php';

  $stmt1 = $pdo->query("SELECT * FROM projects WHERE status = 'ongoing' AND category = 'projects' ORDER BY id DESC LIMIT 3");
  $stmt2 = $pdo->query("SELECT * FROM publications ORDER BY publisher_date DESC LIMIT 2");
  $stmt3 = $pdo->query("SELECT * FROM team");
  $stmt4 = $pdo->query("SELECT * FROM events ORDER BY date ASC LIMIT 2");

  $projects = $stmt1->fetchAll(PDO::FETCH_ASSOC);
  $publications = $stmt2->fetchAll(PDO::FETCH_ASSOC);
  $team = $stmt3->fetchAll(PDO::FETCH_ASSOC);
  $events = $stmt4->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  header('location: dashboard_home.php?message=' . $e->getMessage());
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
      <!-- Stats -->
      <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white border rounded-lg p-5 shadow-sm flex items-center gap-4">
          <div class="text-blue-500 text-xl"><i class="fas fa-flask"></i></div>
          <div>
            <p class="text-sm text-gray-500">Ongoing Projects</p>
            <h2 class="text-2xl font-semibold text-blue-600"><?php echo count($projects); ?></h2>
          </div>
        </div>
        <div class="bg-white border rounded-lg p-5 shadow-sm flex items-center gap-4">
          <div class="text-blue-500 text-xl"><i class="fas fa-book-open"></i></div>
          <div>
            <p class="text-sm text-gray-500">Publications</p>
            <h2 class="text-2xl font-semibold text-blue-600"><?php echo count($publications); ?></h2>
          </div>
        </div>
        <div class="bg-white border rounded-lg p-5 shadow-sm flex items-center gap-4">
          <div class="text-blue-500 text-xl"><i class="fas fa-users"></i></div>
          <div>
            <p class="text-sm text-gray-500">Research Team</p>
            <h2 class="text-2xl font-semibold text-blue-600"><?php echo count($team); ?></h2>
          </div>
        </div>
      </section>

      <!-- Featured Research -->
      <section>
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-2xl font-bold text-blue-700">Featured Research</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <?php foreach ($projects as $proj): ?>
            <div class="bg-white border rounded-lg p-5 shadow-sm">
              <h3 class="font-semibold text-lg text-blue-800"><?php echo $proj['title']; ?></h3>
              <p class="text-sm text-gray-600 mt-2"><?php echo $proj['description']; ?></p>
              <span class="text-xs text-gray-400 italic block mt-3"><?php echo $proj['status']; ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- Publications and Events -->
      <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Publications -->
        <div>
          <h2 class="text-xl font-bold text-blue-700 mb-2">Recent Publications</h2>
          <div class="space-y-4">
            <?php foreach ($publications as $pub): ?>
              <div class="bg-white border rounded-lg p-4 shadow-sm">
                <h3 class="font-semibold text-blue-800"><?php echo $pub['title']; ?></h3>
                <p class="text-sm text-gray-600"><?php echo $pub['author']; ?></p>
                <span class="text-xs text-gray-400"><?php echo date("F j, Y", strtotime($pub['publisher_date'])); ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Events -->
        <div>
          <h2 class="text-xl font-bold text-blue-700 mb-2">Upcoming Events</h2>
          <div class="space-y-4">
            <?php foreach ($events as $event): ?>
              <div class="bg-white border rounded-lg p-4 shadow-sm">
                <h3 class="font-semibold text-blue-800"><?php echo $event['title']; ?></h3>
                <div class="text-xs text-gray-500 mt-1">
                  <i class="fa-regular fa-calendar-days text-blue-500"></i>
                  <?php echo date("F j, Y", strtotime($event['date'])); ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>