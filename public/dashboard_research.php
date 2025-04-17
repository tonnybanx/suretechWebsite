
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sure-Tech</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/7a97402827.js" crossorigin="anonymous"></script>
</head>
<body class="bg-slate-white w-full h-screen overflow-auto">
   <div class="h-screen w-full flex">
     <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-10"></div>
        <?php include 'dashboard_sidebar.php'; ?>
    <div class="flex-grow h-screen pl-10 pr-10">
        <?php include 'dashboard_topbar.php'; ?>
        <!-- this is where the page is placed -->
         <div class="w-full h-[90vh] " >
       <!-- Tab Navigation -->
            <div class="my-tabs mb-6 flex space-x-4 border-b h-[10vh] h-min-[100px]" id="project_tabs">
                <button class="tab py-2 pr-4  border-b-2 border-blue-500 text-blue-500" id="tab-areas" onclick="updatePage('areas','research',this)">Areas</button>
                <button class="tab py-2 px-4  text-black" id="tab-projects" onclick="updatePage('projects','research',this)">Projects</button>
                <button class="tab py-2 px-4 text-black " id="tab-publications" onclick="updatePage('publications','research',this)">Publications</button>
                
            </div>
   
    <!-- container with all other contents of the research tab-btn -->
   <div id="research-container" class="research-container   h-[80vh]" >

   <!-- ################RESEARCH AREAS PAGE ########################## -->

    <div id="areas" class="research-page">

    <div class="w-full h-full" id="publicationstabElement">
    
    <div class=" inline-block items-center justify-center  relative w-full overflow-auto  ">
    
   

    <!-- project areas tab -->
   <div class="w-full ">
    <div class="w-full flex justify-between pl-6">
        <h1 class="text-2xl font-medium ">Key areas</h1>
         <button class=" px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-600" onclick="openModalAdd('add_areas','areaModal')"><i class="fas fa-plus "></i> Add new</button>
        
    </div>

    <!-- This is where project areas will be included -->
    <div class="md:columns-2 lg:columns-3  columns-1 gap-4 overflow-auto  p-6 h-[70vh]" id="main-container">

    </div>
</div>
</div>
</div>
    </div>




    <!--##################### RESEARCH PROJECTS PAGE ##########################-->
     
    <div id="projects" class="research-page hidden">
       <div class="w-full h-full" id="publicationstabElement">
    
<div class=" inline-block items-center justify-center  relative w-full overflow-auto  ">
    
    <!-- projects tab -->
<div class="w-full ">
    <div class="w-full flex justify-between pl-6">
        <h1 class="text-2xl font-medium ">Projects</h1>
         <button class=" px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-500" onclick="openModalAdd('add_project','projectModal')"><i class="fas fa-plus "></i> Add new</button>
        
    </div>
    <!-- projects in that have been included -->
    <div class="md:columns-2 lg:columns-3 space-y-6 columns-1 gap-4 overflow-auto  p-6 h-[70vh]" id="projects-list">

    </div>
</div>

</div>


</div>
    </div>

    <!-- ################### RESEARCH PUBLICATIONS PAGE##########################-- -->

    <div id="publications" class="research-page hidden">
       <div class="w-full h-full" id="publicationstabElement">
    
<div class=" inline-block items-center justify-center  relative w-full overflow-auto  ">
    
    
    <!-- publications tab -->
<div class="w-full">
    <div class="w-full flex justify-between pl-6">
        <h1 class="text-2xl font-medium ">Publications</h1>
         <button class=" px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-500" onclick="openModalAdd('add_publication','pubModal')"><i class="fas fa-plus "></i> Add new </button>
        
    </div>
    <!-- publications in that have been included -->
    <div class="md:columns-2 lg:columns-3  columns-1 gap-4 space-y-6  overflow-auto  p-6 h-[70vh]" id="publications-list">

    <!-- thi is the container for adding publication content -->
    </div>

   </div>

</div>

</div>
    </div>

   </div> 

    <!-- module for adding areas-->
    
    <div id="areaModal" class=" hidden fixed inset-0 flex items-center justify-center z-20">
       <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg h-[600px] overflow-auto">
        
        <form id="areaForm"  action='dashboard_databasemgt/manage_research_areas.php?action=add_area' method="POST" enctype="multipart/form-data">

            <div class="moduleTitle mb-4">
                <label class="block text-gray-700">Title</label>
                <input type="hidden" name="id" id="id" class="id">
                <input type="text" id="areaTitle" name="areaTitle" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter title">
            </div>

            <div class="moduleImage mb-4">
                <label class="block text-gray-700">Image</label>
                <input id="imagefile" type="file" name="image" accept="image/*" onchange="previewImage(this)" required class="w-full" />
                <!-- Image Preview -->
            <img id="imagePreview" src="#" alt="Preview" class="image hidden mt-4 w-full max-h-64 object-cover border rounded" />
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-gray-400 text-white rounded-lg " onclick="closeModal('areaModal')">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg" onclick="fetchAreaContent()">Confirm</button>
            </div>
        </form>
    </div>
    </div>


    <!-- module for adding projects-->
    
    <div id="projectModal" class=" hidden fixed inset-0 flex items-center justify-center z-20">
       <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg h-[600px] overflow-auto">
        
        <form id="projectForm" action='dashboard_databasemgt/manage_research_projects.php?action=add_project' method="POST" enctype="multipart/form-data">

            <div class="moduleTitle mb-4">
                <label class="block text-gray-700">Title</label>
                <input type="hidden" name="id" id="id" class="id">
                <input type="text" id="areaTitle" name="areaTitle" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter title">
            </div>

            <div class="moduleDescription mb-4">
                <label class="block text-gray-700">Project description</label>
                <textarea  id="projectDescription" name="projectDescription" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter project description"></textarea>
            </div>

            <div class="moduleImage mb-4">
                <label class="block text-gray-700">Image</label>
                <input id="imagefile" type="file" name="image" accept="image/*" onchange="previewImage(this)"  class="w-full" />
                <!-- Image Preview -->
            <img id="imagePreview" src="#" alt="Preview" class="image hidden mt-4 w-full max-h-64 object-cover border rounded" />
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-gray-400 text-white rounded-lg " onclick="closeModal('projectModal')">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg" onclick="fetchProjectContent()">Confirm</button>
            </div>
        </form>
    </div>
    </div>


     <!-- publication module module for editing the content of a Publication -->
    
    <div id="pubModal" class="hidden fixed inset-0 flex items-center justify-center z-20">
       <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg h-[600px] overflow-auto">
        <form id="pubForm" action='dashboard_databasemgt/manage_research_publications.php?action=add_publication' method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <input type="hidden" name="id" id="id" class="id">
                <label class="block text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter title">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Content</label>
                <textarea id="content" name="content" class="w-full p-2 border border-gray-300 rounded-lg" rows="4" placeholder="Enter content"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Publication link</label>
                <input type="text" id="link" name="link" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Paste publication link here">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Author</label>
                <input type="text" id="editAuthor" name="author" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter author name">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Date of Publication</label>
                <input type="date" id="date" name="date" class="w-full p-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-gray-400 text-white rounded-lg " onclick="closeModal('pubModal')">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg" onclick="fetchPubContent(); ">Confirm</button>
            </div>
        </form>
    </div>
    </div>


    <!-- end of the module -->

    </div>

    </div>

    
</div>


    <script>
    let selectedOPtion='areas';
   function toggleMenu(event) {
            let menu = event.currentTarget.nextElementSibling;
            menu.classList.toggle("hidden");
        }
        
        function handleMenuClick(event) {
            let menu = event.currentTarget.parentElement;
            menu.classList.add("hidden");
        }

  function updatePage(activeTab,activePage,selectedTab){
    selectedOPtion=activeTab;
        const tabButtons = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.research-page');
        // Hide all content
         tabContents.forEach(content => content.classList.add('hidden'));


       tabButtons.forEach(button => {
    
      // Remove active styles from all buttons
      button.classList.remove('border-b-2','border-blue-500', 'text-blue-500');   
      // Show selected tab content
      document.getElementById(activeTab).classList.remove('hidden');
    
       });

     // Add active styles to clicked button
      selectedTab.classList.add('border-b-2','border-blue-500', 'text-blue-500');
      switch(activeTab){
        case 'areas':fetchAreaContent();
        break;
        case 'projects':fetchProjectContent();
        break;
        case 'publications': fetchPublicationContent();
        break;

      }

     }

     

        function toggleSidebar() {
            
            const sidebar = document.getElementById("sidebar");
            const toggle_btn=document.getElementById("togglebutton2");
            toggle_btn.classList.toggle("hidden");
            sidebar.classList.toggle("hidden");
        }

       
         const form = document.getElementById('contentForm');
         let loaded=false;

        
        function openModalAdd(action,modalID) {
            document.getElementById(modalID).classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");
            
               
        }

        function openModalEdit(action,button,modalID) {
            const modal=document.getElementById(modalID);
            modal.classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");
            let card=button.closest('.areaContainer');

            switch(modalID){
                case 'areaModal':
                 
                  modal.querySelector('#areaTitle').value= card.querySelector('.title').textContent;
                  modal.querySelector('#id').value= card.querySelector('.id').textContent;
                  modal.querySelector('#imagePreview').src= card.querySelector('.image_path').getAttribute('src');
                  modal.querySelector('#imagefile').src=card.querySelector('.image_path').getAttribute('src');
                  modal.querySelector('#imagePreview').classList.remove('hidden');
                  document.getElementById('areaForm').action='dashboard_databasemgt/manage_research_areas.php?action='+action;
                  break;

                case 'projectModal':
                  card=button.closest('.projectContainer');
                  modal.querySelector('#areaTitle').value= card.querySelector('.title').textContent;
                  modal.querySelector('#id').value= card.querySelector('.id').textContent;
                  modal.querySelector('#imagePreview').src= card.querySelector('.image_path').getAttribute('src');
                  modal.querySelector('#imagefile').src=card.querySelector('.image_path').getAttribute('src');
                  modal.querySelector('#projectDescription').value=card.querySelector('.description').textContent;
                  modal.querySelector('#imagePreview').classList.remove('hidden');
                  document.getElementById('projectForm').action='dashboard_databasemgt/manage_research_projects.php?action='+action;
                  break;
                
                case 'pubModal':
                  card=button.closest('.pubContainer');
                  modal.querySelector('#title').value= card.querySelector('.title').textContent;
                  modal.querySelector('#id').value= card.querySelector('.id').textContent;
                  modal.querySelector('#content').value= card.querySelector('.description').textContent;
                  modal.querySelector('#date').value= card.querySelector('.publishedDate').textContent;
                  modal.querySelector('#editAuthor').classList.remove('hidden');
                  document.getElementById('pubForm').action='dashboard_databasemgt/manage_research_publications.php?action='+action;


                    break;
                
                default:



    
            }

            
        }

        function clearEditModal(modalID) {
            const modal=document.getElementById(modalID);
         
            switch(modalID){
                case 'areaModal':
                 
                  modal.querySelector('#areaTitle').value='';
                  modal.querySelector('#id').value= ''
                  modal.querySelector('#imagePreview').src='';
                  modal.querySelector('#imagefile').src='';
                 
                  break;

                case 'projectModal':
                  modal.querySelector('#areaTitle').value= '';
                  modal.querySelector('#id').value='';
                  modal.querySelector('#imagePreview').src= '';
                  modal.querySelector('#imagefile').src='';
                  modal.querySelector('#projectDescription').value='';
                 
                  break;
                
                case 'pubModal':
                  modal.querySelector('#title').value= '';
                  modal.querySelector('#id').value= '';
                  modal.querySelector('#content').value='';
                  modal.querySelector('#date').value='';

                  


                    break;
                
                default:



    
            }

            
        }
       
        function closeModal(modalID) {
            document.getElementById(modalID).classList.add("hidden");
            document.getElementById('overlay').classList.add("hidden");
        }
       
       function fetchAreaContent() {
          const contentList = document.getElementById('main-container'); 
        if (!contentList) {
                console.error("main-container element not found.");
                return; // Exit early if the element doesn't exist
            }

    fetch('dashboard_databasemgt/manage_research_areas.php?action=fetch_areas', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) {
            console.error('Error: ' + res.status);  // Log the error status
        }
        return res.json();
    })
    .then(data => {
        console.log(data);  // Log the data to see if it’s coming back correctly
        contentList.innerHTML = '';
        data.forEach(item => {
            contentList.innerHTML += `<div class="areaContainer bg-white shadow-md rounded-lg overflow-hidden relative flex flex-col max-w-[400px] justify-center items-center ">
                <img src="dashboard_databasemgt/${item.image_path}" alt="Conference" class="image_path w-full h-[250px] object-cover">
                <div class="absolute top-3 right-3">
                    <button class="text-gray-800 hover:text-black font-bold bg-white rounded-full" onclick="toggleMenu(event)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 p-1" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                            <circle cx="12" cy="6" r="1.5" />
                            <circle cx="12" cy="12" r="1.5" />
                            <circle cx="12" cy="18" r="1.5" />
                        </svg>
                    </button>
                    <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="handleMenuClick(event); openModalEdit('update_areas',this,'areaModal') ">Edit</a>
                        <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                    </div>
                </div>
                <div class="p-4">
                    <h2 class="title text-xl font-semibold align-center items-center text-blue-500">${item.title}</h2>
                    <label name="id" class="id hidden" id="id" >${item.id}</label>
                </div>
            </div>`;
        });
    })
    .catch(error => {
        console.error('Request failed', error);
    });
}

function fetchProjectContent() {
          const contentList = document.getElementById('projects-list'); 
        if (!contentList) {
                console.error("main-container element not found.");
                return; // Exit early if the element doesn't exist
            }

    fetch('dashboard_databasemgt/manage_research_projects.php?action=fetch_projects', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) {
            console.error('Error: ' + res.status);  // Log the error status
        }
        return res.json();
    })
    .then(data => {
        console.log(data);  // Log the data to see if it’s coming back correctly
        contentList.innerHTML = '';
        data.forEach(item => {
            contentList.innerHTML += ` <!-- project card -->
        <div class="projectContainer bg-white shadow-md rounded-lg overflow-hidden relative flex flex-col max-w-[400px]">
                <img src="dashboard_databasemgt/${item.image_path}" alt="Conference" class="image_path w-full h-48 object-cover">
                <label name="id" class="id hidden" id="id" >${item.id}</label>
                <div class="absolute top-3 right-3">
                <button class="text-gray-800 hover:text-black font-bold bg-white rounded-full" onclick="toggleMenu(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 p-1" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                        <circle cx="12" cy="6" r="1.5" />
                        <circle cx="12" cy="12" r="1.5" />
                        <circle cx="12" cy="18" r="1.5" />
                    </svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openModalEdit('update_project', this, 'projectModal'); handleMenuClick(event)">Edit</a>
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                </div>
            </div>
                <div class="p-4">
                    <h2 class="title text-xl font-semibold">${item.title}</h2>
                    <p class="description mt-4 text-gray-700">${item.description}</p>
                    
                </div>
        </div>
`;
        });
    })
    .catch(error => {
        console.error('Request failed', error);
    });
}

function fetchPublicationContent() {
          const contentList = document.getElementById('publications-list'); 
        if (!contentList) {
                console.error("main-container element not found.");
                return; // Exit early if the element doesn't exist
            }

    fetch('dashboard_databasemgt/manage_research_publications.php?action=fetch_publications', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(res => {
        if (!res.ok) {
            console.error('Error: ' + res.status);  // Log the error status
        }
        return res.json();
    })
    .then(data => {
        console.log(data);  // Log the data to see if it’s coming back correctly
        contentList.innerHTML = '';
        data.forEach(item => {
            contentList.innerHTML += `<!-- publication -->
        <div  class="pubContainer bg-white rounded-2xl shadow-md overflow-hidden p-5 relative flex flex-col max-w-[400px] h-[500px]">
            <label class="id hidden" id="id">${item.id}</label>
            <div class="absolute top-3 right-3">
                <button class="text-gray-800 hover:text-black font-bold" onclick="toggleMenu(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                        <circle cx="12" cy="6" r="1.5" />
                        <circle cx="12" cy="12" r="1.5" />
                        <circle cx="12" cy="18" r="1.5" />
                    </svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openModalEdit('fetch_publications', this,'pubModal'); handleMenuClick(event)">Edit</a>
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                </div>
            </div>
            <h2 id="pubTitle" class="text-xl font-semibold text-gray-800">
                <a href="${item.link}" class="linktitle text-blue-600 hover:underline">${item.title}</a>
            </h2>
            <p id="pubContent" class="description text-gray-600 mt-2">${item.description}</p>
            <div class="flex items-center mt-4">
                <span class="text-sm text-gray-500">By</span>
                <span id="pubAuthor" class="author ml-1 font-medium text-gray-700">${item.author}</span>
            </div>
            <div class="flex justify-between items-center mt-4">
                <span id="pubDate" class="publishedDate text-sm text-gray-500">Published: ${item.published_date}</span>
            </div>
        </div>

`;
        });
    })
    .catch(error => {
        console.error('Request failed', error);
    });
}


    
function previewImage(input) {
      const preview = document.getElementById('imagePreview');
      const file = input.files[0];

      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
          preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
      }
    }

 // Use MutationObserver to wait until the main-container is available
        const observer = new MutationObserver((mutationsList, observer) => {
            const contentList = document.getElementById('main-container');
            const sidebar=document.getElementById('sidebarHome');
            if (contentList) {
                observer.disconnect(); // Stop observing once the element is found
                if(!loaded){
                    loaded=true;
                 fetchAreaContent(); // Call the function once the element is available
                }
                
            }
            
        
        });

        // Start observing for changes in the DOM
        observer.observe(document.body, { childList: true, subtree: true });

          
    </script>
</body>
</html>

