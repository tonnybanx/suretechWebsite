<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <?php include 'navigationbar.php'; ?>
    <!-- this is the side bar -->
    <div
      id="sidebar"
      class="fixed top-0 right-0 h-full w-64 bg-white shadow-md transform translate-x-full transition-transform duration-300 ease-in-out lg:hidden z-50"
    >
      <button id="close-sidebar" class="absolute top-4 right-4 text-2xl">
        &times;
      </button>
      <ul class="mt-10 space-y-4 p-6">
        <li>
          <a
            href="#"
            class="block text-gray-700 hover:text-red-600 font-semibold"
            >Home</a
          >
        </li>
        <li>
          <a
            href="#"
            class="block text-gray-700 hover:text-red-600 font-semibold"
            >Research</a
          >
        </li>
        <li>
          <a
            href="#"
            class="block text-gray-700 hover:text-red-600 font-semibold"
            >Engage</a
          >
        </li>
        <li>
          <a
            href="#"
            class="block text-gray-700 hover:text-red-600 font-semibold"
            >Team</a
          >
        </li>
        <li>
          <a
            href="#"
            class="block text-gray-700 hover:text-red-600 font-semibold"
            >Events</a
          >
        </li>
        <li>
          <a
            href="#"
            class="block text-gray-700 hover:text-red-600 font-semibold"
            >About</a
          >
        </li>
      </ul>
    </div>

    <section class="max-w-full overflow-hidden">
      <div
        class="hexagon bg-slate-50 h-[600px] w-[500px] absolute top-24 left-0 -z-20 overflow-clip"
      ></div>
      <div
        class="hexagon bg-red-50 h-[700px] w-[600px] absolute top-[300px] right-0 -z-10 opacity-80 overflow-clip"
      ></div>
    </section>

    <div
      class="p-8 rounded-lg shadow-lg max-w-lg w-full bg-white m-auto mt-40 mb-40 lg:min-w-[50vw]"
    >
      <h1 class="text-xl font-bold text-black flex items-center">
        <span
          >Subscribe to our latest updates on the emerging Technologies at
          Sure-Tech</span
        >
      </h1>

      <form class="mt-6 space-y-4">
        <div>
          <label class="block font-semibold">Email Address</label>
          <input
            type="email"
            class="w-full border p-2 rounded-md"
            placeholder="Enter your email"
            required
          />
        </div>
        <div>
          <label class="block font-semibold">First Name</label>
          <input
            type="text"
            class="w-full border p-2 rounded-md"
            placeholder="Enter your first name"
            required
          />
        </div>
        <div>
          <label class="block font-semibold">Last Name</label>
          <input
            type="text"
            class="w-full border p-2 rounded-md"
            placeholder="Enter your last name"
            required
          />
        </div>

        <div>
          <label class="block font-semibold">Country</label>
          <input
            type="text"
            class="w-full border p-2 rounded-md"
            placeholder="Enter your Country"
          />
        </div>
        <div>
          <label class="block font-semibold">City</label>
          <input
            type="text"
            class="w-full border p-2 rounded-md"
            placeholder="Enter your City"
          />
        </div>

        <button
          class="w-full bg-blue-800 text-white p-2 rounded-md font-semibold hover:bg-blue-700"
        >
          Subscribe
        </button>
      </form>
    </div>

    <!-- this is the footer section -->
     <?php include 'footer.php'; ?>
  </body>
</html>
