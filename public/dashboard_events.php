
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sure-Tech</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/7a97402827.js" crossorigin="anonymous"></script>
    
</head>
<?php

?>
<body class="bg-slate-white w-full h-screen overflow-auto">
 <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-10"></div>
   <div class="h-screen w-full flex">
        <?php include 'dashboard_sidebar.php'; ?>
    <div class="flex-grow h-screen pl-10 ">
        <?php include 'dashboard_topbar.php'; ?>
        <!-- this is where the page is placed -->
         <div class="w-full h-[90vh] " >
       <!-- Tab Navigation -->
            <div class="my-tabs mb-6 flex space-x-4 border-b h-[10vh] h-min-[100px]" id="team_tabs">
                <button class="eventTab py-2 pr-4  border-b-2 border-blue-500 text-blue-500" id="tab-students" onclick="updatePage('hackathrons',this)">hackathrons</button>
                <button class="eventTab py-2 px-4  text-black" id="tab-staff" onclick="updatePage('conferences',this)">Conferences</button>
                <button class="eventTab py-2 px-4  text-black" id="tab-staff" onclick="updatePage('news',this)">News</button>
                
                
            </div>
   
    <!-- container with all other contents of the research tab-btn -->
   <div id="team-container" class="eventContainer   h-[80vh]" >

<!-- #################### HACKATHRON CONTENT IS ADDED HERE ####################### -->
    <div id="hackathrons" class="eventContent">
       
<div class=" inline-block items-center justify-center  relative w-full overflow-auto  ">
    
<div class="w-full ">
    <div class="w-full flex justify-between pl-6">
        <h1 class="text-2xl font-medium ">Hackathrons</h1>
         <button class=" px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-500" onclick="setAddAction(); openModal('eventsModal')"><i class="fas fa-plus "></i> Add new</button>
        
    </div>
    <!-- publications in that have been included -->
    <div class="md:columns-2 lg:columns-3  columns-1 gap-4 overflow-auto  p-6 h-[70vh]" id="hackathronContainer">

   
        <!-- event -->
    
    </div>
</div>

</div>

    </div>

    <!-- ################## cONFERENCE CONTENT IS ADDED HERE ################## -->
    <div id="conferences" class="eventContent hidden">
       
<div class=" inline-block items-center justify-center  relative w-full overflow-auto  ">
    
<div class="w-full ">
    <div class="w-full flex justify-between pl-6">
        <h1 class="text-2xl font-medium ">Conferences</h1>
         <button class=" px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-500" onclick="setAddAction(); openModal('eventsModal')"><i class="fas fa-plus "></i> Add new</button>
        
    </div>
    <!-- publications in that have been included -->
    <div class="md:columns-2 lg:columns-3  columns-1 gap-4 overflow-auto  p-6 h-[70vh]" id="conferenceContainer">

   
        <!-- event -->
    
    </div>
</div>

</div>

    </div>


    <!-- ################## NEWS CONTENT IS ADDED HERE ################## -->
    <div id="news" class="eventContent hidden">
       
<div class=" inline-block items-center justify-center  relative w-full overflow-auto  ">
    
<div class="w-full ">
    <div class="w-full flex justify-between pl-6">
        <h1 class="text-2xl font-medium ">News</h1>
         <button class=" px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-500" onclick="setAddAction(); openModal('eventsModal')"><i class="fas fa-plus "></i> Add new</button>
        
    </div>
    <!-- publications in that have been included -->
    <div class="md:columns-2 lg:columns-3  columns-1 gap-4 overflow-auto  p-6 h-[70vh]" id="newsContainer">

   
        <!-- event -->
    
    </div>
</div>

</div>

    </div>


   </div> 
    </div>

    </div>

    
</div>

 <!-- module for adding events-->
    
    <div id="eventsModal" class=" hidden fixed inset-0 flex items-center justify-center z-20">
       <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg h-[600px] overflow-auto">
        
        <form id="teamForm" action='dashboard_databasemgt/manage_team.php?action=addStudent' method="POST" enctype="multipart/form-data">

            <div class="moduleTitle mb-4">
                <label class="block text-gray-700">Title</label>
                <input type="hidden" name="id" id="id" class="id">
                <input type="hidden" name="category" id="category" class="category">
                <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Title">
            </div>

            <div class="moduleDescription mb-4">
                <label class="block text-gray-700">Details</label>
                <textarea  id="details" name="details" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Details"></textarea>
            </div>
             <div class="dateVenue">
                
            <div class="mb-4">
                <label class="block text-gray-700">Date </label>
                <input type="date" id="date" name="date" class="w-full p-2 border border-gray-300 rounded-lg">
            </div>

             <div class="mb-4">
                <label class="block text-gray-700">Location</label>
                <input type="text" id="location" name="location" class="w-full p-2 border border-gray-300 rounded-lg">
            </div>
            
             </div>

            <div class="moduleImage mb-4">
                <label class="block text-gray-700">Image</label>
                <input id="imagefile" type="file" name="image" accept="image/*" onchange="previewImage(this)"  class="w-full" />
                <!-- Image Preview -->
            <img id="imagePreview" src="#" alt="Preview" class="image hidden mt-4 w-full max-h-64 object-cover border rounded" />
            </div>
            
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-white border border-blue-500 text-blue-500 rounded-lg " onclick="closeModal('eventsModal')">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg"  onclick="fetchContent()">Confirm</button>
            </div>
        </form>
    </div>
    </div>




    <script>
        let selectedOPtion='hackathrons';
        let selectedAction='fetchHackathrons';

        fetchContent();

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
            modal.querySelector('#privilege').value=card.querySelector('.privilege').textContent;
            modal.querySelector('#details').value=card.querySelector('.details').textContent;
            modal.querySelector('#id').value= card.querySelector('.id').textContent;
            modal.querySelector('#imagePreview').src= card.querySelector('.image').getAttribute('src');
            modal.querySelector('#imagefile').src=card.querySelector('.image').getAttribute('src');
            modal.querySelector('#imagePreview').classList.remove('hidden');
            
            
        }
       

        function setAddAction(){
            switch(selectedOPtion){
                case 'hackathrons': selectedAction='addEvent';break;
                case 'conferences': selectedAction='addEvent';break;
                case 'news':selectedAction='addNews'; break;
                default:
            }
            document.getElementById('teamForm').action='dashboard_databasemgt/manage_events.php?action='+selectedAction;
        }

        function setEditAction(){
            switch(selectedOPtion){
                case 'hackathrons': selectedAction='editEvent'; break;
                case 'conferences': selectedAction='editEvent'; break;
                case 'news': selectedAction='editNews';break;
                default:
            }
            document.getElementById('teamForm').action='dashboard_databasemgt/manage_events.php?action='+selectedAction;
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
        const tabButtons = document.querySelectorAll('.eventTab');
        const tabContents = document.querySelectorAll('.eventContent');
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
      switch(selectedOPtion){
        case 'news': fetchNews();
             break;
        case 'hackathrons': fetchContent();
              break;
        case 'conferences': fetchContent();
              break;
              default:
      }

    

     }

     function closeModal(modalID) {
            document.getElementById(modalID).classList.add("hidden");
            document.getElementById('overlay').classList.add("hidden");
        }
    
    
     function openModal(modalID) {
        const modalElement=document.getElementById('eventsModal');
            document.getElementById(modalID).classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");
        


            switch(selectedOPtion){
                case 'news':
                    modalElement.querySelector('.dateVenue').classList.add('hidden');
                    modalElement.querySelector('.category').value='news';
                    break;

                case 'hackathrons':
                     modalElement.querySelector('.dateVenue').classList.remove('hidden');
                     modalElement.querySelector('.category').value='hackathron';
                     break;

                case 'conferences':
                     modalElement.querySelector('.dateVenue').classList.remove('hidden');
                     modalElement.querySelector('.category').value='conference';
                     break;
                default:
                
                          
                    
            }
            
            
               
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
            case 'hackathrons': containerID='hackathronContainer';
                             action='fetchHackathrons';
                          break;

            case 'conferences': containerID='conferenceContainer'; 
                          action='fetchConferences';
                          break;
            case 'news':containerID='newsContainer';
                         action='fetchNews';
                         break;
            default:
        }

          const contentList = document.getElementById(containerID); 
        if (!contentList) {
                console.error("main-container element not found.");
                return; // Exit early if the element doesn't exist
            }

    fetch('dashboard_databasemgt/manage_events.php?action='+action, {
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
            contentList.innerHTML += `<!-- event -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative flex flex-col max-w-[400px]">
                <img src='dashboard_databasemgt/${item.image_path}' alt="Conference" class="image w-full h-48 object-cover">
                <label for="id" name="id" class="id hidden">${item.id}</label>
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
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                </div>
            </div>
             <div class="p-4">
                    <h2 class="title text-xl font-semibold">${item.title}</h2>
                    <div class="dateVenue flex " >
                     <p class="date text-gray-600 text-sm mt-2 mr-2"> <i class="fa fa-calendar"></i> ${item.date} | </p>
                     <p class="venue text-gray-600 text-sm mt-2><i class="fas fa-location-pin ml-2 "></i>${item.location}</p>
                    </div>
                   
                    <p class="details mt-4 text-gray-700">${item.details}</p>
                </div>
        </div>

`;
        });
    })
    .catch(error => {
        console.error('Request failed', error);
    });
}

 function fetchNews() {
        let containerID='';
        let action='';
        switch (selectedOPtion){
            case 'hackathrons': containerID='hackathronContainer';
                             action='fetchHackathrons';
                          break;

            case 'conferences': containerID='conferenceContainer'; 
                          action='fetchConferences';
                          break;
            case 'news':containerID='newsContainer';
                         action='fetchNews';
                         break;
            default:
        }

          const contentList = document.getElementById(containerID); 
        if (!contentList) {
                console.error("main-container element not found.");
                return; // Exit early if the element doesn't exist
            }

    fetch('dashboard_databasemgt/manage_events.php?action='+action, {
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
            contentList.innerHTML += `<!-- event -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative flex flex-col max-w-[400px]">
                <img src='dashboard_databasemgt/${item.image_path}' alt="Conference" class="image w-full h-48 object-cover">
                <label for="id" name="id" class="id hidden">${item.id}</label>
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
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                </div>
            </div>
             <div class="p-4">
                    <h2 class="title text-xl font-semibold">${item.title}</h2>
                   
                    <p class="details mt-4 text-gray-700">${item.details}</p>
                </div>
        </div>

`;
        });
    })
    .catch(error => {
        console.error('Request failed', error);
    });
}

        

    </script>
</body>
</html>

