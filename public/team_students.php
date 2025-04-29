<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navigationbar.php'; ?>

<section class="max-w-full overflow-clip mt-40">
    <div class="container px-4 py-10 lg:ml-52">
        <h2 class="text-3xl font-bold mb-6">Members</h2>
        <div class="flex flex-wrap gap-6">
            <?php
            include 'dashboard_databasemgt/database_connection.php';

            try {
                // Query to get students from the team table
                $sql = "SELECT image_path, first_name, last_name, details FROM team WHERE category = 'student'";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($students) {
                    foreach ($students as $student) {
                        $image = htmlspecialchars($student['image_path']);
                        $name = htmlspecialchars($student['first_name'] . ' ' . $student['last_name']);
                        $details = htmlspecialchars($student['details']);

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
                    echo "<p class='text-slate-600'>No students found in the database.</p>";
                }
            } catch (PDOException $e) {
                echo "<p class='text-red-600'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
