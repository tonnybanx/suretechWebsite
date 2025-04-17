<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Research Hub Support</title>
   <link rel="stylesheet" href="style.css">
  </head>
  <body class="bg-gray-50 font-sans m-0">
    <div class="fixed top-0 left-0 w-screen h-screen -z-20">
      <img src="images/soroti_building.jpeg" class="w-[100vw] h-[100vh]" />
    </div>

<?php include 'navigationbar.php'; ?>

<!-- this is the side bar -->
     <div id="sidebar" class="fixed top-0 right-0 h-full w-64 bg-white shadow-md transform translate-x-full transition-transform duration-300 ease-in-out lg:hidden z-50">
        <button id="close-sidebar" class="absolute top-4 right-4 text-2xl">&times;</button>
        <ul class="mt-10 space-y-4 p-6">
            <li><a href="#" class="block text-gray-700 hover:text-red-600 font-semibold">Home</a></li>
            <li><a href="#" class="block text-gray-700 hover:text-red-600 font-semibold">Research</a></li>
            <li><a href="#" class="block text-gray-700 hover:text-red-600 font-semibold">Engage</a></li>
            <li><a href="#" class="block text-gray-700 hover:text-red-600 font-semibold">Team</a></li>
            <li><a href="#" class="block text-gray-700 hover:text-red-600 font-semibold">Events</a></li>
            <li><a href="#" class="block text-gray-700 hover:text-red-600 font-semibold">About</a></li>
        </ul>
    </div>
 <div id="overlay" class=" fixed inset-0 bg-black bg-opacity-50 -z-10"></div>
    <div class="max-w-5xl space-y-6 m-auto mb-20 top-0 mt-20 p-10 z-20">
      <!-- Support Options Section -->
      
      <div>
            
        <h2 class="text-3xl font-semibold text-gray-800 mb-4 ">Support</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Monetary Support -->
          <div class="p-6 border rounded-lg shadow-sm bg-white">
            <h3 class="text-2xl font-medium text-gray-800">Make a Donation</h3>
            <p class="text-gray-600 mt-2">
              Your financial contributions help fund groundbreaking research.
            </p>
            <button
              class="mt-4 bg-blue-800 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition"
            >
              Donate Now
            </button>
          </div>
          <!-- Non-Monetary Support -->
          <div class="p-6 border rounded-lg shadow-sm bg-white">
            <h3 class="text-2xl font-medium text-gray-800">
              Volunteer & Collaborate
            </h3>
            <p class="text-gray-600 mt-2">
              Join our community, contribute your skills, and support research
              efforts.
            </p>
            <button
              class="mt-4 bg-white text-black px-6 py-3 rounded-lg font-medium hover:bg-blue-800 hover:text-white border-blue-800 border transition"
            >
              Get Involved
            </button>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-3xl font-semibold text-gray-800 mb-4">
          Need Further Assistance?
        </h2>
        <form class="space-y-4">
          <div>
            <label class="block text-gray-700 font-medium">Your Name</label>
            <input
              type="text"
              placeholder="Enter your name"
              class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-700 focus:outline-none"
            />
          </div>
          <div>
            <label class="block text-gray-700 font-medium">Your Email</label>
            <input
              type="email"
              placeholder="Enter your email"
              class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-700 focus:outline-none"
            />
          </div>
          <div>
            <label class="block text-gray-700 font-medium">Your Message</label>
            <textarea
              placeholder="Write your message here"
              class="w-full p-3 border rounded-lg h-32 focus:ring-2 focus:blue-700 focus:outline-none"
            ></textarea>
          </div>
          <button
            class="w-full bg-blue-800 text-white px-6 py-3 rounded-lg font-medium text-lg hover:bg-blue-700 transition"
          >
            Submit
          </button>
        </form>
      </div>
    </div>

    <?php include 'footer.php'; ?>
      </body>
</html>
