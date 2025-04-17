<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="flex items-center justify-center h-screen bg-white bg-[url('images/networking2.jpg')] bg-cover">
    <div id="overlay" class=" fixed inset-0 bg-black bg-opacity-50 z-10"></div>
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md z-20">
        <h2 class="text-2xl font-bold text-center text-gray-700">Sign Up</h2>
        <form action="signupcode.php" method="POST" class="mt-4">
            <div>
                <label class="block text-gray-600">Username</label>
                <input type="text" name="username" required class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-300">
            </div>
            <div class="mt-4">
                <label class="block text-gray-600">Email</label>
                <input type="email" name="email" required class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-300">
            </div>
            <div class="mt-4">
                <label class="block text-gray-600">Password</label>
                <input type="password" name="password" required class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-300">
            </div>
            <div class="flex mt-6 w-full justify-center">
               
            <button type="submit" name="submit" class=" bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 w-full">Sign Up</button>
            </div>
            <div class="mt-6 justify-center w-full">
                <p>Already have an account? <a href="login.php" class="text-blue-700 hover:underline">login</a></p>
            </div>

        </form>
    </div>


</body>
</html>
