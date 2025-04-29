<?php
// Include database connection file
include 'dashboard_databasemgt/database_connection.php';

// Fetch publications from the database
$publications = $pdo->query("SELECT * FROM publications")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Publications</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <?php include 'navigationbar.php'; ?>

    <!-- Publications -->
    <h1 class="text-3xl font-bold mt-40 ml-10 lg:ml-52">Publications</h1>
    <div class="flex flex-wrap gap-6 mt-20 pb-20 min-h-screen lg:ml-52 ml-10">

    <?php foreach ($publications as $publication): ?>
      <!-- Publication Card -->
      <div class="bg-white rounded-2xl shadow-md overflow-hidden p-5 flex flex-col max-w-[400px] h-[400px]">
        <h2 class="text-xl font-semibold text-gray-800">
          <a href="<?php echo $publication['link']; ?>" class="text-blue-600 hover:underline">
            <?php echo $publication['title']; ?>
          </a>
        </h2>
        <p class="text-gray-600 mt-2"><?php echo $publication['description']; ?></p>
        <div class="flex items-center mt-4">
          <span class="text-sm text-gray-500">By</span>
          <span class="ml-1 font-medium text-gray-700"><?php echo $publication['author']; ?></span>
        </div>
        <div class="flex justify-between items-center mt-4">
          <span class="text-sm text-gray-500">Published: <?php echo date('F j, Y', strtotime($publication['publisher_date'])); ?></span>
        </div>
      </div>
      
     
     
    <?php endforeach; ?>

    </div>

    <?php include 'footer.php'; ?> 
  </body>
</html>
