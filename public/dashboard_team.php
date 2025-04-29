
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
 <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-10"></div>
   <div class="h-screen w-full flex">
        <?php include 'dashboard_sidebar.php'; ?>
    <div class="flex-grow h-screen pl-10 ">
        <?php include 'dashboard_topbar.php'; ?>
        <!-- this is where the page is placed -->
         <div class="w-full h-[90vh] " >
       <!-- Tab Navigation -->
            <div class="my-tabs mb-6 flex space-x-4 border-b h-[10vh] h-min-[100px]" id="team_tabs">
                <button class="team-tab py-2 pr-4  border-b-2 border-blue-500 text-blue-500" id="tab-students" onclick="updatePage('students',this)">Students</button>
                <button class="team-tab py-2 px-4  text-black" id="tab-staff" onclick="updatePage('staff',this)">Staff</button>
                
                
            </div>
   
    <!-- container with all other contents of the research tab-btn -->
   <div id="team-container" class="team-container   h-[80vh]" >

<!-- ####################STUDENT CONTENT IS ADDED HERE ####################### -->
    <div id="students" class="teamContent">
       <div class="container px-4 py-10 h-[80vh] overflow-auto  ">
        <div class="w-full flex justify-between pb-10 pr-10 h-[10vh] h-min-[100px] relative">
    
        
         <button class=" px-6 py-2 rounded bg-blue-400 text-white hover:bg-blue-500 fixed top-[20vh] right-20" onclick="openModal('add-student', 'teamModal')"><i class="fas fa-plus "></i> Add new</button>
        
    </div>
        <div id="studentContainer" class=" flex flex-wrap gap-6">

<!-- space in which each student module is displayed -->
        </div>
</div>
    </div>

    <!-- ################## STAFF CONTENT IS ADDED HERE ################## -->
    <div id="staff" class="teamContent hidden">
        <div class="container px-4 py-10 h-[80vh] overflow-auto  ">
        <div class="w-full flex justify-between pb-10 pr-10 h-[10vh] h-min-[100px] relative">
    
        
         <button class=" px-6 py-2 rounded bg-blue-400 text-white hover:bg-blue-500 fixed top-[20vh] right-20" onclick="setAddAction(); openModal('add-student', 'teamModal')"><i class="fas fa-plus "></i> Add new</button>
        
    </div>
        <div id="staffContainer" class=" flex flex-wrap gap-6">

<!-- space in which each student module is displayed -->
        </div>
</div>

    </div>


   </div> 
    </div>

    </div>

    
</div>

 <!-- module for adding events-->
    
    <div id="teamModal" class="hidden fixed inset-0 flex items-center justify-center z-20">
       <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg h-[600px] overflow-auto">
        
        <form id="teamForm" action='dashboard_databasemgt/manage_team.php?action=addStudent' method="POST" enctype="multipart/form-data">

            <div class="moduleTitle mb-4">
                <label class="block text-gray-700">First name</label>
                <input type="hidden" name="id" id="id" class="id">
                <input type="text" id="firstName" name="firstName" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="First name">
            </div>

            <div class="moduleTitle mb-4">
                <label class="block text-gray-700">Last name</label>
                <input type="text" id="lastName" name="lastName" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Last name">
            </div>

            <div class="moduleTitle mb-4">
                <label class="block text-gray-700">Email address</label>
                <input type="text" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Email address">
            </div>

            <div class="moduleDescription mb-4">
                <label class="block text-gray-700">Details</label>
                <textarea  id="details" name="details" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Personal details"></textarea>
            </div>

            <div class="privilege mb-4 ">
                <label for="">Privilege</label>
            <select name="privilege" id="privilege" class="border rounded py-2 px-2">
                <option value="user">user</option>
                <option value="admin">Admin</option>
            </select>
            </div>
            

            <div class="moduleImage mb-4">
                <label class="block text-gray-700">Image</label>
                <input id="imagefile" type="file" name="image" accept="image/*" onchange="previewImage(this)"  class="w-full" />
                <!-- Image Preview -->
            <img id="imagePreview" src="#" alt="Preview" class="image hidden mt-4 w-full max-h-64 object-cover border rounded" />
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-white border border-blue-500 text-blue-500 rounded-lg " onclick="closeModal('teamModal')">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg"  onclick="fetchContent()">Confirm</button>
            </div>
        </form>
    </div>
    </div>
    <!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-20 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
    <h2 class="text-lg font-bold text-gray-800 mb-4">Confirm Deletion</h2>
    <p class="text-gray-600 mb-4">Are you sure you want to remove this member?</p>

    <!-- Hidden Form for Deletion -->
    <form id="deleteForm" method="POST" action="dashboard_databasemgt/manage_team.php?action=delete">
      <input type="hidden" name="id" id="id">
      <div class="flex justify-end gap-4">
        <button type="button" onclick="closeDeleteModal()" class="bg-white border-blue-500 text-blue-500 px-4 py-2 rounded hover:bg-blue-500 hover:text-white">
          Cancel
        </button>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Delete
        </button>
      </div>
    </form>
  </div>
</div>



    <script>


function deleteMember(button){
    document.getElementById("overlay").classList.remove("hidden");
    const modal=document.getElementById('deleteModal');
    modal.classList.remove('hidden');

    const card=button.closest('.teamContainer');
    
    modal.querySelector('#id').value=card.querySelector('.id').textContent;

    }
    
    function closeDeleteModal(){
       document.getElementById("overlay").classList.add("hidden");
       document.getElementById('deleteModal').classList.add('hidden');
 
    }


        let selectedOPtion='students';
        let selectedAction='addStudent';

        function handleMenuClick(event) {
            let menu = event.currentTarget.parentElement;
            menu.classList.add("hidden");
        }

        function openModalEdit(button) {
            const modal=document.getElementById('teamModal');
            modal.classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");
            let card=button.closest('.teamContainer');
           
            modal.querySelector('#firstName').value= card.querySelector('.firstName').textContent;
            modal.querySelector('#lastName').value=card.querySelector('.lastName').textContent;
            modal.querySelector('#email').value=card.querySelector('.email').textContent;
            modal.querySelector('#privilege').value=card.querySelector('.privilege').textContent;
            modal.querySelector('#details').value=card.querySelector('.details').textContent;
            modal.querySelector('#id').value= card.querySelector('.id').textContent;
            modal.querySelector('#imagePreview').src= card.querySelector('.image').getAttribute('src');
            modal.querySelector('#imagefile').src=card.querySelector('.image').getAttribute('src');
            modal.querySelector('#imagePreview').classList.remove('hidden');
            
            
        }
       

        function setAddAction(){
            switch(selectedOPtion){
                case 'students': selectedAction='addStudent';break;
                case 'staff':selectedAction='addStaff'; break;
                default:
            }
            document.getElementById('teamForm').action='dashboard_databasemgt/manage_team.php?action='+selectedAction;
        }

        function setEditAction(){
            switch(selectedOPtion){
                case 'students': selectedAction='editStudent'; break;
                case 'staff': selectedAction='editStaff';break;
                default:
            }
            document.getElementById('teamForm').action='dashboard_databasemgt/manage_team.php?action='+selectedAction;
        }

         function toggleMenu(event) {
            let menu = event.currentTarget.nextElementSibling;
            menu.classList.toggle("hidden");
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

        function updatePage(activeTab,selectedButton){
        selectedOPtion=activeTab;
        const tabButtons = document.querySelectorAll('.team-tab');
        const tabContents = document.querySelectorAll('.teamContent');
        // Hide all content
         tabContents.forEach(content => content.classList.add('hidden'));


       tabButtons.forEach(button => {
    
      // Remove active styles from all buttons
      button.classList.remove('border-b-2','border-blue-500', 'text-blue-500');   
     
    
       });

        // Show selected tab content
      document.getElementById(activeTab).classList.remove('hidden');

     // Add active styles to clicked button
      selectedButton.classList.add('border-b-2','border-blue-500', 'text-blue-500');

      fetchContent();

     }

     function closeModal(modalID) {
            document.getElementById(modalID).classList.add("hidden");
            document.getElementById('overlay').classList.add("hidden");
        }
    
    
     function openModal(action,modalID) {
            document.getElementById(modalID).classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");
            
               
        }

     

        function toggleSidebar() {
            
            const sidebar = document.getElementById("sidebar");
            const toggle_btn=document.getElementById("togglebutton2");
            toggle_btn.classList.toggle("hidden");
            sidebar.classList.toggle("hidden");
        }

       function fetchContent() {
        let containerID='';
        let action='';
        switch (selectedOPtion){
            case 'students': containerID='studentContainer';
                             action='fetchStudents';
                          break;

            case 'staff': containerID='staffContainer'; 
                          action='fetchStaff';
                          break;
            default:
        }

          const contentList = document.getElementById(containerID); 
        if (!contentList) {
                console.error("main-container element not found.");
                return; // Exit early if the element doesn't exist
            }

    fetch('dashboard_databasemgt/manage_team.php?action='+action, {
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
            contentList.innerHTML += `<!-- News Item 1 -->
            <div id="teamContainer" class="teamContainer shadow-lg w-60 overflow-clip rounded-lg relative">
                <label id="id" name="id" class="id hidden">${item.id}</label>
                <label id="email" name="email" class="email hidden">${item.email}</label>
                <label id="privilege" class="privilege hidden">${item.privilege}</label>
                <img src="dashboard_databasemgt/${item.image_path}" class="image h-60 w-60">
                <div class="absolute top-3 right-3">
                <button class="text-gray-800 hover:text-black font-bold bg-white rounded-full" onclick="toggleMenu(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 p-1" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                        <circle cx="12" cy="6" r="1.5" />
                        <circle cx="12" cy="12" r="1.5" />
                        <circle cx="12" cy="18" r="1.5" />
                    </svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="setEditAction(); openModalEdit(this); handleMenuClick(event)">Edit</a>
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event); deleteMember(this)">Delete</a>
                </div>
             </div>
                <div class="p-4">
                <div class="flex ">
                <h1 class="firstName font-bold mr-2">${item.first_name}</h1>
                <h1 class="lastName font-bold">${item.last_name}</h1>
                </div>
                    
                 <h1 class="details text-sm text-slate-700">${item.details}</h1>
                </div>
        </div>

`;
        });
    })
    .catch(error => {
        console.error('Request failed', error);
    });
}

        
    
 // Use MutationObserver to wait until the main-container is available
        const observer = new MutationObserver((mutationsList, observer) => {
            const contentList = document.getElementById('studentContainer');
            const sidebar=document.getElementById('sidebarHome');
            if (contentList) {
                observer.disconnect('studentContainer'); // Stop observing once the element is found
        
                 fetchContent(); // Call the function once the element is available
                
                
            }
            
        
        });

        // Start observing for changes in the DOM
        observer.observe(document.body, { childList: true, subtree: true });


    </script>
</body>
</html>

