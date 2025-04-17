<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackathrons</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- navigation bar -->
 <?php include 'navigationbar.php'; ?>
<section>
    <div class="max-w-full overflow-hidden top-0">
      <div
        class="hexagon bg-slate-100 h-[90vw] w-[90vw] absolute -top-[40vw] left-0 -z-10 overflow-clip opacity-40  "
      ></div>
      <div
        class="hexagon bg-red-50 h-[30vw] w-[30vw] absolute top-[20vw] right-[2vw] -z-20  overflow-clip opacity-50"
      ></div>
      </div>
    </section>
    
    
    <div>
        <h1 class="text-3xl text-black font-bold mt-40 lg:ml-52 ml-10">Hackathrons</h1>
    </div>
    <!-- Main Content -->
    <main class="container  py-10 ">
        
        <!-- Conference Grid -->
        <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6 lg:ml-52 ml-10 mr-10">
            
            <!-- Conference Cards -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="images/woman.webp" alt="Conference" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold">AI & Tech Summit</h2>
                    <p class="text-gray-600 text-sm mt-2">📅 April 15, 2025 | 📍 San Francisco, USA</p>
                    <p class="mt-4 text-gray-700">A global conference on AI advancements and future tech trends.</p>
                    <a href="#" class="block mt-4 text-blue-600 font-semibold hover:underline">Learn More →</a>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="images/networking.jpg" alt="Conference" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold">Networking workshop</h2>
                    <p class="text-gray-600 text-sm mt-2">📅 April 15, 2025 | 📍 San Francisco, USA</p>
                    <p class="mt-4 text-gray-700">A global conference on AI advancements and future tech trends.</p>
                    <a href="#" class="block mt-4 text-blue-600 font-semibold hover:underline">Learn More →</a>
                </div>
            </div>


            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="images/blockchain.jpeg" alt="Conference" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold">Block chain technology and other applications</h2>
                    <p class="text-gray-600 text-sm mt-2">📅 April 15, 2025 | 📍 San Francisco, USA</p>
                    <p class="mt-4 text-gray-700">A global conference on AI advancements and future tech trends.</p>
                    <a href="#" class="block mt-4 text-blue-600 font-semibold hover:underline">Learn More →</a>
                </div>
            </div>


            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="images/networking.jpg" alt="Conference" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold">Networking workshop</h2>
                    <p class="text-gray-600 text-sm mt-2">📅 April 15, 2025 | 📍 San Francisco, USA</p>
                    <p class="mt-4 text-gray-700">A global conference on AI advancements and future tech trends.</p>
                    <a href="#" class="block mt-4 text-blue-600 font-semibold hover:underline">Learn More →</a>
                </div>
            </div>


            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="images/blockchain.jpeg" alt="Conference" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-semibold">Block chain technology and other applications</h2>
                    <p class="text-gray-600 text-sm mt-2">📅 April 15, 2025 | 📍 San Francisco, USA</p>
                    <p class="mt-4 text-gray-700">A global conference on AI advancements and future tech trends.</p>
                    <a href="#" class="block mt-4 text-blue-600 font-semibold hover:underline">Learn More →</a>
                </div>
            </div>


        </div>
    </main>

  <?php include 'footer.php'; ?>
</body>
</html>