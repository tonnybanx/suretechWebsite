<?php
// Get the current page name
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside id="sidebar" class="pl-6 pr-6 transition-all h-screen w-[300px] bg-slate-50">
    <nav>
        <!-- Sidebar Toggle Button -->
        <div class="flex justify-start py-6">
            <button onclick="toggleSidebar()" class="rounded pl-2 pr-4">
                <i class="fas fa-bars"></i>
            </button>
            <h1 class="text-lg font-bold text-red-600">Sure-Tech</h1>
        </div>
        <ul>
            <a href="dashboard_home.php" id="sidebarHome">
                <li class="tab mb-2 p-2 hover:bg-blue-100 rounded <?php echo $currentPage === 'dashboard_home.php' ? 'bg-blue-100 text-blue-600' : ''; ?>">
                    <i class="fas fa-home mr-2"></i>Home
                </li>
            </a>
            <a href="dashboard_research.php" id="sidebarResearch">
                <li class="tab mb-2 p-2 hover:bg-blue-100 rounded <?php echo $currentPage === 'dashboard_research.php' ? 'bg-blue-100 text-blue-600' : ''; ?>">
                    <i class="fas fa-folder-open mr-2"></i>Research
                </li>
            </a>
            <a href="dashboard_team.php" id="sidebarTeam">
                <li class="tab mb-2 p-2 hover:bg-blue-100 rounded <?php echo $currentPage === 'dashboard_team.php' ? 'bg-blue-100 text-blue-600' : ''; ?>">
                    <i class="fas fa-users mr-2"></i>Team
                </li>
            </a>
            <a href="dashboard_events.php" id="sidebarEvents">
                <li class="tab mb-2 p-2 hover:bg-blue-100 rounded <?php echo $currentPage === 'dashboard_events.php' ? 'bg-blue-100 text-blue-600' : ''; ?>">
                    <i class="fas fa-bullhorn mr-2"></i>Events
                </li>
            </a>
            <a href="dashboard_about.php" id="sidebarAbout">
                <li class="tab mb-2 p-2 hover:bg-blue-100 rounded <?php echo $currentPage === 'dashboard_about.php' ? 'bg-blue-100 text-blue-600' : ''; ?>">
                    <i class="fas fa-location-dot mr-2"></i>About
                </li>
            </a>
            <a href="dashboard_engagements.php" id="sidebarEngagements">
                <li class="tab mb-2 p-2 hover:bg-blue-100 rounded <?php echo $currentPage === 'dashboard_engagements.php' ? 'bg-blue-100 text-blue-600' : ''; ?>">
                    <i class="fas fa-handshake mr-2"></i>Engagements
                </li>
            </a>
            <a href="dashboard_settings.php" id="sidebarSettings">
                <li class="tab mb-2 p-2 hover:bg-blue-100 rounded <?php echo $currentPage === 'dashboard_settings.php' ? 'bg-blue-100 text-blue-600' : ''; ?>">
                    <i class="fas fa-gear mr-2"></i>Settings
                </li>
            </a>
            <a href="logout.php" id="sidebarLogout">
                <li class="tab mb-2 p-2 hover:bg-blue-100 rounded <?php echo $currentPage === 'logout.php' ? 'bg-blue-100 text-blue-600' : ''; ?>">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </li>
            </a>
        </ul>
    </nav>
</aside>