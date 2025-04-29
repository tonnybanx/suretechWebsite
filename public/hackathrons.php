<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackathrons</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include 'navigationbar.php'; ?>

<section>
    <div class="max-w-full overflow-hidden top-0">
        <div class="hexagon bg-slate-100 h-[90vw] w-[90vw] absolute -top-[40vw] left-0 -z-10 overflow-clip opacity-40"></div>
        <div class="hexagon bg-red-50 h-[30vw] w-[30vw] absolute top-[20vw] right-[2vw] -z-20 overflow-clip opacity-50"></div>
    </div>
</section>

<div>
    <h1 class="text-3xl text-black font-bold mt-40 lg:ml-52 ml-10">Hackathrons</h1>
</div>

<main class="container py-10">
    <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6 lg:ml-52 ml-10 mr-10">
        <?php
        include 'dashboard_databasemgt/database_connection.php';

        try {
            $sql = "SELECT image_path, date, location, details, title FROM events WHERE category = 'hackathron'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $conferences = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($conferences) {
                foreach ($conferences as $conf) {
                    $image = htmlspecialchars($conf['image_path']);
                    $date = htmlspecialchars($conf['date']);
                    $location = htmlspecialchars($conf['location']);
                    $details = htmlspecialchars($conf['details']);
                    $title = htmlspecialchars($conf['title']);

                    echo "
                        <div class='bg-white shadow-md rounded-lg overflow-hidden'>
                            <img src='dashboard_databasemgt/$image' alt='Conference' class='w-full h-48 object-cover'>
                            <div class='p-4'>
                                <h2 class='text-xl font-semibold'>$title</h2>
                                <p class='text-gray-600 text-sm mt-2'>
                                    <i class='fa-solid fa-calendar-days mr-1 text-red-500'></i> $date 
                                    | 
                                    <i class='fa-solid fa-location-dot ml-2 mr-1 text-blue-500'></i> $location
                                </p>
                                <p class='mt-4 text-gray-700'>$details</p>
                                <a href='#' class='block mt-4 text-blue-600 font-semibold hover:underline'>Learn More →</a>
                            </div>
                        </div>
                    ";
                }
            } else {
                echo "<p class='text-gray-600 lg:ml-52 ml-10'>No conferences found in the database.</p>";
            }
        } catch (PDOException $e) {
            echo "<p class='text-red-600 lg:ml-52 ml-10'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>
