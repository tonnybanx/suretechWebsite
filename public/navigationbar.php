 <section>
      <nav
        id="navbar"
        class="bg-white shadow-md w-full fixed top-0 z-50 transition-transform duration-500"
      >
      <div class="h-10 bg-black w-full flex justify-between align-middle items-center lg:pl-52 pl-10">
        <h1 class="text-white font-semibold ">Soroti University</h1>
        <div>
          <a href="signup.php" class="text-white pr-10 hover:underline">signup</a>
          <a href="login.php" class="text-white pr-10 hover:underline">login</a>
        </div>
      </div>
        <div class="container px-4 py-3 flex justify-between items-center align-middle">
          <div class="text-2xl font-bold text-red-600 lg:ml-48">SURE-TECH</div>

          <button
            id="menu-toggle"
            class="lg:hidden block text-gray-700 focus:outline-none text-2xl"
          >
            ☰
          </button>

          <ul id="nav-menu" class="lg:flex hidden space-x-6 mr-20">
            <li>
              <a
                href="index.php"
                class="text-gray-700 hover:text-red-600 font-semibold"
                >Home</a
              >
            </li>
            <li class="relative dropdown">
              <a href="#" class="text-gray-700 hover:text-red-600 font-semibold"
                >Research</a
              >
              <ul
                class="absolute left-0 mt-2 w-48 bg-white shadow-md rounded-lg hidden dropdown-menu"
              >
                <li>
                  <a
                    href="research_areas.php"
                    class="block px-4 py-2 hover:bg-gray-200"
                    >Research areas</a
                  >
                </li>
                <li>
                  <a
                    href="research_projects.php"
                    class="block px-4 py-2 hover:bg-gray-200"
                    >Research projects</a
                  >
                </li>
                <li>
                  <a
                    href="publications.php"
                    class="block px-4 py-2 hover:bg-gray-200"
                    >Publications</a
                  >
                </li>
              </ul>
            </li>
            <li class="relative dropdown">
              <a href="#" class="text-gray-700 hover:text-red-600 font-semibold"
                >Engage</a
              >
              <ul
                class="absolute left-0 mt-2 w-48 bg-white shadow-md rounded-lg hidden dropdown-menu"
              >
                <li>
                  <a href="partner.php" class="block px-4 py-2 hover:bg-gray-200"
                    >Partner</a
                  >
                </li>
                
                <li>
                  <a
                    href="subscribe.php"
                    class="block px-4 py-2 hover:bg-gray-200"
                    >Subscribe</a
                  >
                </li>
              </ul>
            </li>
            <li class="relative dropdown">
              <a href="#" class="text-gray-700 hover:text-red-600 font-semibold"
                >Team</a
              >
              <ul
                class="absolute left-0 mt-2 w-48 bg-white shadow-md rounded-lg hidden dropdown-menu"
              >
                <li>
                  <a href="team_staff.php" class="block px-4 py-2 hover:bg-gray-200"
                    >Staff</a
                  >
                </li>
                <li>
                  <a
                    href="team_students.php"
                    class="block px-4 py-2 hover:bg-gray-200"
                    >Students</a
                  >
                </li>
              </ul>
            </li>
            <li class="relative dropdown">
              <a href="#" class="text-gray-700 hover:text-red-600 font-semibold"
                >Events</a
              >
              <ul
                class="absolute left-0 mt-2 w-48 bg-white shadow-md rounded-lg hidden dropdown-menu"
              >
                <li>
                  <a href="conferences.php" class="block px-4 py-2 hover:bg-gray-200"
                    >Conferences</a
                  >
                </li>
                <li>
                  <a href="hackathrons.php" class="block px-4 py-2 hover:bg-gray-200"
                    >Hackathons</a
                  >
                </li>
              </ul>
            </li>
            <li class="relative dropdown">
              <a href="#" class="text-gray-700 hover:text-red-600 font-semibold"
                >About</a
              >
              <ul
                class="absolute left-0 mt-2 w-48 bg-white shadow-md rounded-lg hidden dropdown-menu"
              >
                <li>
                  <a href="history.php" class="block px-4 py-2 hover:bg-gray-200"
                    >History</a
                  >
                </li>
                
                <li>
                  <a href="contact.php" class="block px-4 py-2 hover:bg-gray-200"
                    >Contact</a
                  >
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>

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
    </section>
    <script>
      document.querySelectorAll(".dropdown").forEach((item) => {
        let timeout;
        item.addEventListener("mouseenter", () => {
          clearTimeout(timeout);
          document
            .querySelectorAll(".dropdown-menu")
            .forEach((menu) => menu.classList.add("hidden"));
          item.querySelector(".dropdown-menu").classList.remove("hidden");
        });
        item.addEventListener("mouseleave", () => {
          timeout = setTimeout(() => {
            item.querySelector(".dropdown-menu").classList.add("hidden");
          }, 1000);
        });
      });

      // Mobile menu toggle
      document.getElementById("menu-toggle").addEventListener("click", () => {
        document.getElementById("sidebar").classList.toggle("translate-x-full");
      });

      document.getElementById("close-sidebar").addEventListener("click", () => {
        document.getElementById("sidebar").classList.add("translate-x-full");
      });
      let lastScrollTop = 0;
      const navbar = document.getElementById("navbar");

      window.addEventListener("scroll", function () {
        let scrollTop =
          window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop) {
          navbar.classList.add("-translate-y-full"); // Hide navbar
        } else {
          navbar.classList.remove("-translate-y-full"); // Show navbar
        }

        lastScrollTop = scrollTop;
      });
    </script>