<div class="w-full h-full" id="engagemntElement">


    <script>
      
        function setEngagmentTab(tab){
          updatEngagemtTab(tab);
          hideEngagements();
          const mypage = document.getElementById(tab);
         mypage.classList.remove("hidden");

          
        }
        function hideEngagements() {
            var container = document.getElementById('engagement_container');
            var children = container.children;

            // Hide each child
            for (var i = 0; i < children.length; i++) {
                children[i].classList.add('hidden');
            }
        }

      function updateEnagagementTab(activeTab) {
            document.getElementById("engagment_tabs").children.forEach(button => {
                button.classList.remove("border-b-2", "border-blue-500", "text-blue-500");
                button.classList.add("text-gray-600");
            });
            
            document.getElementById(`tab-${activeTab}`).classList.add("border-b-2", "border-blue-500", "text-blue-500");
        }

    </script>
 <!-- editing the content of editing engagements -->
    
    <div id="engagementEdit" class="hidden fixed inset-0 flex items-center justify-center z-20">
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
    
    <div id="newEngagements" class="hidden fixed inset-0 flex items-center justify-center z-20">
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




<div class="w-full h-full " >
       <!-- Tab Navigation -->
            <div class="mb-6 flex space-x-4 border-b h-[10vh] h-min-[100px]" id="engagment_tabs">
                <button class="tab-btn py-2 pr-4  border-b-2 border-blue-500 text-blue-500" id="tab-support" onclick="setActiveTab('support')">support</button>
                <button class="tab-btn py-2 px-4 text-gray-600" id="tab-partnerships" onclick="setActiveTab('partnerships')">Partnerships</button>
                
                
            </div>
   
    <!-- container with all other contents of the research tab-btn -->
   <div id="engagement_container" >


   </div> 


    </div>


</div>