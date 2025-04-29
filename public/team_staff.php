<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leadership and staff</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navigationbar.php'; ?>

<section class="max-w-full overflow-clip mt-40">
    <div class="container px-4 py-10 lg:ml-52">
        <h2 class="text-3xl font-bold mb-6">Leadership and staff</h2>
        <div class="flex flex-wrap gap-6">
            <?php
            include 'dashboard_databasemgt/database_connection.php';

            try {
                // Prepare and execute the query
                $sql = "SELECT image_path, first_name, last_name, details FROM team WHERE category = 'staff'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                // Fetch results as associative array
                $teamMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($teamMembers) {
                    foreach ($teamMembers as $row) {
                        $image = htmlspecialchars($row['image_path']);
                        $name = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                        $details = htmlspecialchars($row['details']);

                        echo "
                            <div class='shadow-lg w-60 overflow-clip rounded'>
                                <img src='dashboard_databasemgt/$image' class='h-60 w-60'>
                                <div class='p-4'>
                                    <h1 class='font-bold'>$name</h1>
                                    <h1 class='text-sm text-slate-700'>$details</h1>
                                </div>
                            </div>
                        ";
                    }
                } else {
                    echo "<p class='text-slate-600'>No staff members found in the database.</p>";
                }
            } catch (PDOException $e) {
                echo "<p class='text-red-600'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }

            // No need to explicitly close PDO, it does on script end
            ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
