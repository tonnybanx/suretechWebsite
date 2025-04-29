<?php
// Include database connection file
include 'dashboard_databasemgt/database_connection.php';

// Fetch the projects where category = 'projects'
$projects = $pdo->query("SELECT * FROM projects WHERE category = 'projects'")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Projects</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

   <?php include 'navigationbar.php'; ?>

    <!-- Research Projects -->
    <section class="z-10 lg:ml-52 mt-40 ml-10 min-h-[80vh]">
      <h1 class="font-bold text-3xl pb-4">Research Projects</h1>
      
      <!-- Grid layout with Tailwind CSS -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 ">
        <?php foreach ($projects as $project): ?>
          <div class="bg-white rounded-xl shadow-md border p-4 flex flex-col">
            <!-- Display project image -->
            <img src="dashboard_databasemgt/<?php echo $project['image_path']; ?>" class="w-full h-60 object-cover rounded-t-xl" alt="Image for <?php echo $project['title']; ?>" />
            <a href="#" class="text-blue-500 hover:underline mt-4 text-center"><?php echo $project['title']; ?></a>
            <p class="text-sm mt-2 text-center"><?php echo $project['description']; ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

<?php include 'footer.php'; ?>

</body>
</html>
