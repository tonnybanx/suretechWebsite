<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sure-Tech</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/7a97402827.js" crossorigin="anonymous"></script>
</head>
<body class="bg-slate-white w-full h-full ">
    <div class="h-screen" >
        
        
            
      <section class="flex h-screen ">
       
      <div id="sidecolumn" class="h-full   bg-slate-100 ">
       
        <aside id="sidebar" class=" h-full pl-6 pr-6  transition-all w-[300px]">
           
            <nav>
                      
             <!-- Sidebar Toggle Button -->
             <div class="flex justify-start py-6">
                 <button onclick="toggleSidebar()" class="rounded pl-2 pr-4 ">
                <i class="fas fa-bars"></i>
            </button>
             <h1 class="text-lg font-bold text-red-600">Sure-Tech</h1>
             </div>
                <ul >
                    <li class="tab mb-2 p-2 hover:bg-blue-100 rounded bg-blue-100" onclick="updateContent('home',this)"><i class="fas fa-home mr-2"></i>Home</li>
                    <li class="tab mb-2 p-2 hover:bg-blue-100 rounded" onclick="updateContent('projects',this)"><i class="fas fa-folder-open mr-2"></i>Research</li>
                    <li class="tab mb-2 p-2 hover:bg-blue-100 rounded" onclick="updateContent('team',this)"><i class="fas fa-users mr-2"></i>Team</li>
                    <li class="tab mb-2 p-2 hover:bg-blue-100 rounded" onclick="updateContent('events',this)"><i class="fas fa-bullhorn mr-2"></i>Events</li>
                    <li class="tab mb-2 p-2 hover:bg-blue-100 rounded" onclick="updateContent('about',this)" ><i class="fas fa-location-dot mr-2"></i>About</li>
                    <li class="tab mb-2 p-2 hover:bg-blue-100 rounded" onclick="updateContent('engagements',this)"><i class="fas fa-handshake mr-2"></i>Engagements</li>
                    <li class="tab mb-2 p-2 hover:bg-blue-100 rounded" onclick="updateContent('settings',this)"><i class="fas fa-gear mr-2"></i>Settings</li>
                </ul>
            </nav>
        </aside>


      </div>
      
        <div  class="flex-grow overflow-auto">
            <!-- Top Bar -->
            <div class="justify-between items-center flex flex-row  pl-2 pr-10 pt-4 pb-4 h-max-[80px] h-[10vh] ">
            
                <!-- Search Bar-->
                <div class="flex ">
                    <div >
                
                    <button onclick="toggleSidebar()" class="rounded pl-4  hidden " id="togglebutton2">
                    <i class="fas fa-bars"></i>
                   </button>
                 </div>
                   <div class="pl-10">
                     <input type="text" placeholder="Search" class="w-[50vw] p-2 border rounded-lg">
                    <button class="ml-2 p-2  rounded"><i class="fas fa-search"></i></button>
                   </div>
                </div>
                <div class="flex items-center space-x-4 ml-4">
                    <button class="p-2 rounded"><i class="fas fa-bell"></i></button>
                    <img src="images/anthony.jpg" alt="Profile" class="w-10 h-10 rounded-full">
                </div>
            </div>

         <!-- this is where other content will be placed -->
            <div id="dashboardspace" class="w-full p-10 h-[90vh] ">
            
             </div>

        </div>
        
       
      </section>
        
    </div>

    

    <script>
      const dasboardContent=document.getElementById('dashboardspace');

        function toggleSidebar() {
            
            const sidebar = document.getElementById("sidebar");
            const toggle_btn=document.getElementById("togglebutton2");
            toggle_btn.classList.toggle("hidden");
            sidebar.classList.toggle("hidden");
        }

  

                

        function updateContent(activePage,tab) {
          
          
          
          document.querySelectorAll(".tab").forEach(btn => btn.classList.remove("bg-blue-100"));
          tab.classList.add("bg-blue-100");

         

            switch (activePage) {
                case "home": fetch('dashboard_home.php')
                .then(response => response.text())
                .then(data => {
                    dasboardContent.innerHTML = data; // Inject page content
                })
                .catch(error => {
                    dasboardContent.innerHTML = "<p class='text-red-500'>Error loading content.</p>";
                    console.error("Error fetching content:", error);
                });
                    
                    break;
                case "projects":fetch('dashboard_projects.php')
                .then(response => response.text())
                .then(data => {
                    dasboardContent.innerHTML = data; // Inject page content
                })
                .catch(error => {
                    dasboardContent.innerHTML = "<p class='text-red-500'>Error loading content.</p>";
                    console.error("Error fetching content:", error);
                });
                    break;
                case "team": fetch('dashboard_team.php')
                .then(response => response.text())
                .then(data => {
                    dasboardContent.innerHTML = data; // Inject page content
                })
                .catch(error => {
                    dasboardContent.innerHTML = "<p class='text-red-500'>Error loading content.</p>";
                    console.error("Error fetching content:", error);
                });
                    break;
                case "events": fetch('dashboard_events.php')
                .then(response => response.text())
                .then(data => {
                    dasboardContent.innerHTML = data; // Inject page content
                })
                .catch(error => {
                    dasboardContent.innerHTML = "<p class='text-red-500'>Error loading content.</p>";
                    console.error("Error fetching content:", error);
                });
                    break;
                 case "about": fetch('dashboard_about.php')
                .then(response => response.text())
                .then(data => {
                    dasboardContent.innerHTML = data; // Inject page content
                })
                .catch(error => {
                    dasboardContent.innerHTML = "<p class='text-red-500'>Error loading content.</p>";
                    console.error("Error fetching content:", error);
                });
                    break; 
                  case "engagements":
                    fetch('dashboard_engagements.php')
                .then(response => response.text())
                .then(data => {
                    dasboardContent.innerHTML = data; // Inject page content
                })
                .catch(error => {
                    dasboardContent.innerHTML = "<p class='text-red-500'>Error loading content.</p>";
                    console.error("Error fetching content:", error);
                });
                    break;
                  case "settings":
                    fetch('dashboard_settings.php')
                .then(response => response.text())
                .then(data => {
                    dasboardContent.innerHTML = data; // Inject page content
                })
                .catch(error => {
                    dasboardContent.innerHTML = "<p class='text-red-500'>Error loading content.</p>";
                    console.error("Error fetching content:", error);
                });
                    break;
                default:
                    dashboardContent.innerHTML = `<h3 class='text-xl font-semibold mb-4'>Logging out...</h3>`;
            }
        }

        function loadHomepage(){

        }

    </script>
</body>
</html>
