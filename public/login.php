<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="flex items-center justify-center h-screen bg-slate-50 bg-[url('images/networking2.jpg')] bg-cover w-screen">
    
    <div class=" w-[90vw] max-w-[700px] bg-white p-8 rounded-lg shadow-md z-20">
        <h2 class="text-2xl font-bold text-center text-gray-700">Login</h2>
        <form action="logincode.php" method="POST" class="mt-4">
            <div>
                <label class="block text-gray-600">Username</label>
                <input type="text" name="username" required class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-300">
            </div>
            
            <div class="mt-4 w-full">
                <label class="block text-gray-600">Password</label>
                <input type="password" name="password" required class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-300">
            </div>
            <div class="flex mt-6 justify-center w-full">
               
            <button type="submit" name="submit" class=" bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 w-full">login</button>
            </div>

            <div class="flex justify-center mt-6">
                <p>Don't have an account? <a href="signup.php" class="text-blue-600 hover:underline">signup</a></p>
            </div>
            <div>
       <?php
                if (isset($_GET['message'])) {
            echo "<p class='text-center mt-10 " . ($_GET['status'] == 'success' ? 'text-green-500' : 'text-red-500') . "'>" . htmlspecialchars($_GET['message']) . "</p>";
        }
        ?>

            </div>


        </form>
    </div>


</body>
</html>
