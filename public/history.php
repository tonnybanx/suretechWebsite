<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>History</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
// Include navbar
include 'navigationbar.php';
include 'dashboard_databasemgt/database_connection.php';

try {

  // Fetch history text
  $stmt1 = $pdo->prepare("SELECT history FROM about LIMIT 1");
  $stmt1->execute();
  $about = $stmt1->fetch(PDO::FETCH_ASSOC);

  // Fetch cover images for history page
  $stmt2 = $pdo->prepare("SELECT path FROM cover_images WHERE page = 'history'");
  $stmt2->execute();
  $images = $stmt2->fetchAll(PDO::FETCH_ASSOC);
}
catch(Exception $e){
  die("An error occurred");
}

?>

<!-- Background hexagons -->
<section class="overflow-hidden">
  <div class="hexagon bg-slate-50 h-[600px] w-[500px] absolute top-24 left-0 -z-20 overflow-clip"></div>
  <div class="hexagon bg-red-50 h-[800px] w-[700px] absolute top-[300px] right-0 -z-10 opacity-80 overflow-clip"></div>
  <div class="hexagon h-52 w-52 bg-slate-100 absolute top-40 right-[240px] -z-10"></div>
</section>

<!-- History Section -->
<section class="lg:pl-52 pl-10 pr-10 flex flex-wrap lg:h-[130vh] mb-20">
  <div class="lg:w-1/3 w-full mt-40">
    <h1 class="text-3xl text-black font-bold">History</h1>
    <p class="pr-10 text-lg">
      <?= htmlspecialchars($about['history'] ?? 'No history found.') ?>
    </p>
  </div>

  <div>
    <?php if (!empty($images)) : ?>
      <div class="mt-40 overflow-clip flex flex-wrap">
        <?php foreach ($images as $index => $img): ?>
          <div class="hexagon bg-blue-100
            <?= $index === 0 ? 'lg:h-[500px] lg:w-[400px] lg:absolute lg:top-40 lg:left-[800px] w-[40vw] h-[40vw]' : '' ?>
            <?= $index === 1 ? 'lg:h-[300px] lg:w-[300px] lg:absolute lg:top-[316px] lg:left-[1220px] w-[30vw] h-[30vw]' : '' ?>
            <?= $index === 2 ? 'lg:h-52 lg:w-52 lg:absolute lg:top-[560px] lg:left-[1100px] w-[20vw] h-[20vw]' : '' ?>
          ">
            <img src="<?= htmlspecialchars($img['path']) ?>" class="object-cover w-full h-full">
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
