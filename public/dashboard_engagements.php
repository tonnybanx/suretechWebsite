
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sure-Tech</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/7a97402827.js" crossorigin="anonymous"></script>
</head>
<body class="bg-slate-white w-full h-screen ">
   <div class="h-screen w-full flex">
        <?php include 'dashboard_sidebar.php'; ?>
    <div class="flex-grow h-screen pl-10 pr-10">
        <?php include 'dashboard_topbar.php'; ?>
        <!-- this is where the page is placed -->
         <div class="w-full h-[90vh] " >
       <!-- Tab Navigation -->
            <div class="my-tabs mb-6 flex space-x-4 border-b h-[10vh] h-min-[100px]" id="project_tabs">
                <button class="tab py-2 pr-4  border-b-2 border-blue-500 text-blue-500" id="tab-partnerships" onclick="updatePage('partnership','engagements',this)">Partnerships</button>
                <button class="tab py-2 px-4  text-black" id="tab-partnerships" onclick="updatePage('subscriptions','engagements',this)">Subscriptions</button>
               
                
            </div>
   
    <!-- container with all other contents of the research tab-btn -->
   <div id="research-container" class="research-container   h-[80vh]" >

    <div id="areas" class="research-page">
        
    </div>
    <div id="projects" class="research-page hidden">
        
    </div>

    <div id="publications" class="research-page hidden">
        
    </div>

   </div> 
    </div>

    </div>

    
</div>



 <!-- editing the content of a Project -->
    
    <div id="editModal" class="hidden fixed inset-0 flex items-center justify-center z-20">
       <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-xl font-medium mb-4">Publication</h2>
        <form>
            <div class="mb-4">
                <label class="block text-gray-700">Title</label>
                <input type="text" id="editTitle" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter title">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Content</label>
                <textarea id="editContent" class="w-full p-2 border border-gray-300 rounded-lg" rows="4" placeholder="Enter content"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Author</label>
                <input type="text" id="editAuthor" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter author name">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Date of Publication</label>
                <input type="date" id="editDate" class="w-full p-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-gray-400 text-white rounded-lg " onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg" onclick="saveChanges()">Save</button>
            </div>
        </form>
    </div>
    </div>

     <!-- new project module for editing the content of a Publication -->
    
    <div id="projectModal" class="hidden fixed inset-0 flex items-center justify-center z-20">
       <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-xl font-medium mb-4">Publication</h2>
        <form>
            <div class="mb-4">
                <label class="block text-gray-700">Title</label>
                <input type="text" id="editTitle" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter title">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Content</label>
                <textarea id="editContent" class="w-full p-2 border border-gray-300 rounded-lg" rows="4" placeholder="Enter content"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Author</label>
                <input type="text" id="editAuthor" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter author name">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Date of Publication</label>
                <input type="date" id="editDate" class="w-full p-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-gray-400 text-white rounded-lg " onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg" onclick="saveChanges()">Save</button>
            </div>
        </form>
    </div>
    </div>



    <script>
      function openModal() {
            document.getElementById("projectModal").classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");

        }

  function updatePage(activeTab,activePage,selectedTab){
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

    }

        
       


        function toggleSidebar() {
            
            const sidebar = document.getElementById("sidebar");
            const toggle_btn=document.getElementById("togglebutton2");
            toggle_btn.classList.toggle("hidden");
            sidebar.classList.toggle("hidden");
        }

       
        
    

    </script>
</body>
</html>

