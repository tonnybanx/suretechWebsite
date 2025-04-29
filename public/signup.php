<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body class="bg-fixed bg-[url('images/networking2.jpg')] bg-cover bg-center bg-no-repeat">
  <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-10"></div>

  <main class="relative z-20 min-h-screen overflow-auto flex justify-center py-10">
    <div class="w-full lg:w-2/3 bg-white p-8 rounded-lg shadow-md">
      <h2 class="text-2xl font-bold text-center text-gray-700">Sign Up</h2>

      <!-- ✅ ERROR MESSAGE BLOCK -->
      <?php if (isset($_GET['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4 mb-6 text-center">
          <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
      <?php endif; ?>

      <form action="signupcode.php" method="POST" class="mt-4 grid md:grid-cols-2 gap-4">
        <div class="col-span-2 md:col-span-1">
          <label class="block text-gray-600">First Name</label>
          <input type="text" name="first_name" required class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-300">
        </div>

        <div class="col-span-2 md:col-span-1">
          <label class="block text-gray-600">Last Name</label>
          <input type="text" name="last_name" required class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-300">
        </div>

        <div class="col-span-2">
          <label class="block text-gray-600">Username</label>
          <input type="text" name="username" required class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-300">
        </div>

        <div class="col-span-2">
          <label class="block text-gray-600">Email</label>
          <input type="email" name="email" required class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-300">
        </div>

        <div class="col-span-2">
          <label class="block text-gray-600">Password</label>
          <input type="password" name="password" required class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-300">
        </div>

        <div class="col-span-2">
          <label class="block text-gray-600">Location</label>
          <input type="text" name="location" class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-300">
        </div>

        <div class="col-span-2">
          <label class="block text-gray-600">Details</label>
          <textarea name="details" rows="3" class="w-full p-2 border rounded-lg mt-1 focus:ring focus:ring-blue-300"></textarea>
        </div>

        <div class="col-span-2 flex mt-6 w-full justify-center">
          <button type="submit" name="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 w-full">Sign Up</button>
        </div>

        <div class="col-span-2 mt-6 justify-center w-full text-center">
          <p>Already have an account? <a href="login.php" class="text-blue-700 hover:underline">Login</a></p>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
