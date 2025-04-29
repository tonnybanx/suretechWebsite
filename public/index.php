<?php
// Include database connection file
include 'dashboard_databasemgt/database_connection.php';

// Fetch the About Table Content
$aboutContent = $pdo->query("SELECT * FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);

// Fetch the Events Table Content (filtering by category = 'news')
$events = $pdo->query("SELECT * FROM events WHERE category = 'news' ORDER BY id DESC LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Soroti University Research Center</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body class="bg-white w-full">
  <!-- Navigation Bar -->
  <?php include 'navigationbar.php'; ?>

  <!-- Main Content Section -->
  <section class="relative z-20 max-w-full overflow-hidden mt-20">
    <div class="lg:w-5/12 w-3/4 p-10 lg:ml-40">
      <!-- About Section -->
      <h1 class="text-black font-bold font-custom text-3xl pt-10">
        <?php echo nl2br($aboutContent['name']); ?>
      </h1>
      <p class="font-custom text-xl">
        <?php echo nl2br($aboutContent['overview']); ?>
      </p>
    </div>
    <div class="lg:h-[150px] h-[70vh]">
      <div class="absolute pt-10 lg:top-0 lg:left-1/3 lg:ml-64 h-1/2 w-full ml-10">
        <div class="hexagon lg:h-[400px] lg:w-[400px] lg:top-20 lg:left-0 lg:ml-4 lg:mt-2 h-[50vw] w-[50vw] absolute top-0 left-0 mt-2 max-w-[500px] max-h-[500px]">
          <img src="images/woman.webp" class="bg-clip-padding lg:h-[400px] lg:w-[400px] h-full w-full" />
        </div>
        <div class="hexagon lg:h-72 lg:w-72 lg:top-[170px] lg:left-96 lg:ml-16 lg:mt-0 h-[30vw] w-[30vw] absolute top-[12vw] left-[50vw] ml-4 mt-6 max-w-[300px] max-h-[300px]">
          <img src="images/programmer.jpg" class="bg-clip-padding h-[30vw] w-[30vw]" />
        </div>
        <!-- <div class="hexagon lg:h-52 lg:w-52 lg:top-[370px] lg:left-64 lg:ml-20 lg:mt-10 h-[30vw] w-[30vw] absolute top-[35vw] left-[35vw] ml-6 mt-10 max-w-[300px] max-h-[300px]">
          <img src="images/networking2.jpg" class="bg-clip-padding h-[30vw] w-[30vw]" />
        </div> -->
        <div class="hexagon lg:h-72 lg:w-72 lg:top-0 lg:left-72 lg:ml-20 lg:mt-14 absolute bg-slate-100 -z-10"></div>
      </div>
    </div>
  </section>

  <!-- Background Hexagons -->
  <section class="max-w-full overflow-hidden">
    <div class="hexagon bg-slate-50 h-[600px] w-[500px] absolute top-24 left-0 -z-20 overflow-clip"></div>
    <div class="hexagon bg-red-50 h-[600px] w-[400px] absolute top-[300px] right-0 -z-10 opacity-80 overflow-clip"></div>
  </section>

  <!-- News Section -->
  <section class="overflow-clip w-full">
    <div class="container px-4 py-10 lg:ml-52">
      <h2 class="text-3xl font-bold mb-6">Latest News</h2>
      <div class="columns-1 md:columns-2 lg:columns-3 sm:columns-2 space-y-6 gap-6 lg:mr-52">
        <?php foreach ($events as $item): ?>
          <div class="bg-white p-6 shadow-md rounded-lg flex flex-col">
            <h3 class="font-bold text-lg"><?php echo $item['title']; ?></h3>
            <?php if (!empty($item['details'])): ?>
              <p class="text-gray-600 mt-2"><?php echo $item['details']; ?></p>
            <?php endif; ?>
            <a href="" class="text-blue-600 font-semibold mt-3 inline-block">Read More →</a>
          </div>
          
                   
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include 'footer.php'; ?>
</body>
</html>
