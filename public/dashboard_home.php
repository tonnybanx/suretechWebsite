

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/7a97402827.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class="flex h-full">
        <?php include 'dashboard_sidebar.php'; ?>
       <div class="flex-grow">
        <?php include 'dashboard_topbar.php'; ?>
       <div class="p-6 max-w-6xl w-full ">
        <h1 class="text-3xl font-bold mb-6">Research Center Dashboard</h1>
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 w-full">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Total Publications</h2>
                <p class="text-2xl font-bold text-blue-600">120</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Active Researchers</h2>
                <p class="text-2xl font-bold text-green-600">35</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Ongoing Projects</h2>
                <p class="text-2xl font-bold text-purple-600">18</p>
            </div>
        </div>
        
        <!-- Recent Publications -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-bold mb-4">Recent Publications</h2>
            <ul>
                <li class="border-b py-2">The Impact of AI on Research</li>
                <li class="border-b py-2">Sustainable Energy Solutions</li>
                <li class="border-b py-2">Advancements in Quantum Computing</li>
            </ul>
        </div>
        
        <!-- Upcoming Events -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Upcoming Events</h2>
            <ul>
                <li class="border-b py-2">AI Conference - April 15, 2025</li>
                <li class="border-b py-2">Renewable Energy Summit - May 10, 2025</li>
                <li class="border-b py-2">Quantum Computing Workshop - June 5, 2025</li>
            </ul>
        </div>
    </div>

    </div>
</div>


</body>
</html>