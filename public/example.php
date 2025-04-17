<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-gray-800 text-white w-64 p-4 hidden md:block">
            <h2 class="text-xl font-semibold mb-4">Admin Panel</h2>
            <nav>
                <ul>
                    <li class="mb-3 cursor-pointer" onclick="setActiveTab('publications')">
                        <i class="fas fa-book mr-2"></i> Publications
                    </li>
                    <li class="mb-3 cursor-pointer" onclick="setActiveTab('events')">
                        <i class="fas fa-calendar-alt mr-2"></i> Events
                    </li>
                    <li class="mb-3 cursor-pointer" onclick="setActiveTab('projects')">
                        <i class="fas fa-project-diagram mr-2"></i> Projects
                    </li>
                    <li class="mb-3 cursor-pointer" onclick="setActiveTab('users')">
                        <i class="fas fa-users mr-2"></i> Users
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <button onclick="toggleMenu()" class="md:hidden bg-gray-800 text-white p-2 rounded">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="text-2xl font-semibold">Dashboard</h1>
            </div>
            
            <!-- Tab Navigation -->
            <div class="mb-6 flex space-x-4 border-b">
                <button class="tab-btn py-2 px-4 text-gray-600" id="tab-publications" onclick="setActiveTab('publications')">Publications</button>
                <button class="tab-btn py-2 px-4 text-gray-600" id="tab-events" onclick="setActiveTab('events')">Events</button>
                <button class="tab-btn py-2 px-4 text-gray-600" id="tab-projects" onclick="setActiveTab('projects')">Projects</button>
                <button class="tab-btn py-2 px-4 text-gray-600" id="tab-users" onclick="setActiveTab('users')">Users</button>
            </div>
            
            <!-- Dynamic Content -->
            <div id="tab-content" class="p-4 bg-white rounded-lg shadow"></div>
        </main>
    </div>

    <script>
        let activeTab = "publications";
        const tabContent = document.getElementById("tab-content");

        function setActiveTab(tab) {
            activeTab = tab;
            updateContent();
            updateTabStyles();
        }

        function toggleMenu() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("hidden");
        }

        function updateContent() {
            switch (activeTab) {
                case "publications":
                    tabContent.innerHTML = `<h3 class='text-xl font-semibold mb-4'>Existing Publications</h3>
                        <p>Manage research papers and publications here.</p>`;
                    break;
                case "events":
                    tabContent.innerHTML = `<h3 class='text-xl font-semibold mb-4'>Events</h3>
                        <p>Schedule and manage upcoming events.</p>`;
                    break;
                case "projects":
                    tabContent.innerHTML = `<h3 class='text-xl font-semibold mb-4'>Projects</h3>
                        <p>Track ongoing research projects.</p>`;
                    break;
                case "users":
                    tabContent.innerHTML = `<h3 class='text-xl font-semibold mb-4'>Users</h3>
                        <p>Manage user accounts and permissions.</p>`;
                    break;
                default:
                    tabContent.innerHTML = `<h3 class='text-xl font-semibold mb-4'>Welcome</h3>
                        <p>Select a tab to view content.</p>`;
            }
        }

        function updateTabStyles() {
            document.querySelectorAll(".tab-btn").forEach(button => {
                button.classList.remove("border-b-2", "border-blue-500", "text-blue-500");
                button.classList.add("text-gray-600");
            });
            
            document.getElementById(`tab-${activeTab}`).classList.add("border-b-2", "border-blue-500", "text-blue-500");
        }
        
        updateContent();
        updateTabStyles();
    </script>
</body>
</html>
