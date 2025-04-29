<?php
// Include database connection file
include 'dashboard_databasemgt/database_connection.php';

// Fetch the projects where category = 'areas'
$projects = $pdo->query("SELECT * FROM projects WHERE category = 'areas'")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>research_areas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="h-full">

 <?php include 'navigationbar.php'; ?>
    <!-- Focal areas of the research -->
    <section class="z-10 lg:ml-52 mt-40 ml-10 min-h-screen">
      <h1 class="font-bold text-3xl pb-4">Focal Areas</h1>
      <div class="flex flex-col lg:flex-row">
        <?php foreach ($projects as $project): ?>
          <div class="bg-white lg:w-1/3 w-full rounded-xl shadow-md border p-4 mr-10 mb-10 justify-center align-middle flex flex-col max-w-[700px]">
            <img src="dashboard_databasemgt/<?php echo $project['image_path']; ?>" class="h-60" alt="Image for <?php echo $project['title']; ?>"/>
            <p class="text-blue-500 mt-10 text-center"><?php echo $project['title']; ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

<?php include 'footer.php'; ?>
</body>
</html>
