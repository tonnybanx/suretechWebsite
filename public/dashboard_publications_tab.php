<div class="w-full h-full" id="publicationstabElement">
    
    <script>
        function toggleMenu(event) {
            let menu = event.currentTarget.nextElementSibling;
            menu.classList.toggle("hidden");
        }
        
        function handleMenuClick(event) {
            let menu = event.currentTarget.parentElement;
            menu.classList.add("hidden");
        }

        function openEditModal() {
            document.getElementById("editModal").classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");
            
            document.getElementById("editTitle").value = document.getElementById("pubTitle").innerText;
            document.getElementById("editContent").value = document.getElementById("pubContent").innerText;
            document.getElementById("editAuthor").value = document.getElementById("pubAuthor").innerText;
            document.getElementById("editDate").value = document.getElementById("pubDate").innerText.replace("Published: ", "");
        }
        function openpubModal() {
            document.getElementById("pubModal").classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");

        }

        function closeEditModal() {
            document.getElementById("editModal").classList.add("hidden");
            document.getElementById("overlay").classList.add("hidden");
        }
        function closepubModal() {
            document.getElementById("pubModal").classList.add("hidden");
            document.getElementById("overlay").classList.add("hidden");
        }

        function saveChanges() {
            document.getElementById("pubTitle").innerText = document.getElementById("editTitle").value;
            document.getElementById("pubContent").innerText = document.getElementById("editContent").value;
            document.getElementById("pubAuthor").innerText = document.getElementById("editAuthor").value;
            document.getElementById("pubDate").innerText = "Published: " + document.getElementById("editDate").value;
            closeEditModal();
        }

        function addPublications() {
            const listContainer = document.getElementById('publications-list');
             const title= document.getElementById("Title").value;
            const content= document.getElementById("Content").value;
            const author= document.getElementById("Author").value;
            const date= "Published: " + document.getElementById("Date").value;
                const pubElement = document.createElement('div');
                pubElement.innerHTML = `
                    <!-- publication -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden p-5 relative flex flex-col max-w-[400px]">
            <div class="absolute top-3 right-3">
                <button class="text-gray-800 hover:text-black font-bold" onclick="toggleMenu(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                        <circle cx="12" cy="6" r="1.5" />
                        <circle cx="12" cy="12" r="1.5" />
                        <circle cx="12" cy="18" r="1.5" />
                    </svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openEditModal(); handleMenuClick(event)">Edit</a>
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                </div>
            </div>
            <h2 id="pubTitle" class="text-xl font-semibold text-gray-800">
                <a href="#" class="text-blue-600 hover:underline">${title}</a>
            </h2>
            <p id="pubContent" class="text-gray-600 mt-2">${content}</p>
            <div class="flex items-center mt-4">
                <span class="text-sm text-gray-500">By</span>
                <span id="pubAuthor" class="ml-1 font-medium text-gray-700">${author}</span>
            </div>
            <div class="flex justify-between items-center mt-4">
                <span id="pubDate" class="text-sm text-gray-500">Published:${date}</span>
            </div>
        </div>
                `;
        listContainer.appendChild(pubElement);
     closepubModal();
    
        }
    </script>

<div class=" inline-block items-center justify-center  relative w-full overflow-auto  ">
    
    <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-10"></div>

    <!-- publication module module for editing the content of a Publication -->
    
    <div id="pubModal" class="hidden fixed inset-0 flex items-center justify-center z-20">
       <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-xl font-medium mb-4">New publication</h2>
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
                <button type="button" class="px-4 py-2 bg-gray-400 text-white rounded-lg " onclick="closepubModal()">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg" onclick="addPublication(); ">Add</button>
            </div>
        </form>
    </div>
    </div>

    
    <!-- edit module for editing the content of a Publication -->
    
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


    <!-- publications tab -->
<div class="w-full">
    <div class="w-full flex justify-between pl-6">
        <h1 class="text-2xl font-medium ">Publications</h1>
         <button class=" px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-500" onclick="openpubModal()"><i class="fas fa-plus "></i> Add new publication</button>
        
    </div>
    <!-- publications in that have been included -->
    <div class="md:columns-2 lg:columns-3  columns-1 gap-2 space-y-6  w-full  overflow-auto  p-6 h-2/3" id="publications-list">

    
    <!-- publication -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden p-5 relative flex flex-col max-w-[400px]">
            <div class="absolute top-3 right-3">
                <button class="text-gray-800 hover:text-black font-bold" onclick="toggleMenu(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                        <circle cx="12" cy="6" r="1.5" />
                        <circle cx="12" cy="12" r="1.5" />
                        <circle cx="12" cy="18" r="1.5" />
                    </svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openEditModal(); handleMenuClick(event)">Edit</a>
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                </div>
            </div>
            <h2 id="pubTitle" class="text-xl font-semibold text-gray-800">
                <a href="#" class="text-blue-600 hover:underline">Understanding AI in Research</a>
            </h2>
            <p id="pubContent" class="text-gray-600 mt-2">A comprehensive study on the impact of artificial intelligence in academic research. This paper discusses the various applications of AI in research methodologies, data analysis, and automation of complex tasks in multiple scientific domains.</p>
            <div class="flex items-center mt-4">
                <span class="text-sm text-gray-500">By</span>
                <span id="pubAuthor" class="ml-1 font-medium text-gray-700">Dr. John Doe</span>
            </div>
            <div class="flex justify-between items-center mt-4">
                <span id="pubDate" class="text-sm text-gray-500">Published: March 2025</span>
            </div>
        </div>

    <!-- publication -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden p-5 relative flex flex-col max-w-[400px]">
            <div class="absolute top-3 right-3">
                <button class="text-gray-800 hover:text-black font-bold" onclick="toggleMenu(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                        <circle cx="12" cy="6" r="1.5" />
                        <circle cx="12" cy="12" r="1.5" />
                        <circle cx="12" cy="18" r="1.5" />
                    </svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openEditModal(); handleMenuClick(event)">Edit</a>
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                </div>
            </div>
            <h2 id="pubTitle" class="text-xl font-semibold text-gray-800">
                <a href="#" class="text-blue-600 hover:underline">Understanding AI in Research</a>
            </h2>
            <p id="pubContent" class="text-gray-600 mt-2">A comprehensive study on the impact of artificial intelligence in academic research.</p>
            <div class="flex items-center mt-4">
                <span class="text-sm text-gray-500">By</span>
                <span id="pubAuthor" class="ml-1 font-medium text-gray-700">Dr. John Doe</span>
            </div>
            <div class="flex justify-between items-center mt-4">
                <span id="pubDate" class="text-sm text-gray-500">Published: March 2025</span>
            </div>
        </div>

    <!-- publication -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden p-5 relative flex flex-col max-w-[400px]">
            <div class="absolute top-3 right-3">
                <button class="text-gray-800 hover:text-black font-bold" onclick="toggleMenu(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                        <circle cx="12" cy="6" r="1.5" />
                        <circle cx="12" cy="12" r="1.5" />
                        <circle cx="12" cy="18" r="1.5" />
                    </svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openEditModal(); handleMenuClick(event)">Edit</a>
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                </div>
            </div>
            <h2 id="pubTitle" class="text-xl font-semibold text-gray-800">
                <a href="#" class="text-blue-600 hover:underline">Understanding AI in Research</a>
            </h2>
            <p id="pubContent" class="text-gray-600 mt-2">A comprehensive study on the impact of artificial intelligence in academic research. This paper discusses the various applications of AI in research methodologies, data analysis, and automation of complex tasks in multiple scientific domains.</p>
            <div class="flex items-center mt-4">
                <span class="text-sm text-gray-500">By</span>
                <span id="pubAuthor" class="ml-1 font-medium text-gray-700">Dr. John Doe</span>
            </div>
            <div class="flex justify-between items-center mt-4">
                <span id="pubDate" class="text-sm text-gray-500">Published: March 2025</span>
            </div>
        </div>

    <!-- publication -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden p-5 relative flex flex-col max-w-[400px]">
            <div class="absolute top-3 right-3">
                <button class="text-gray-800 hover:text-black font-bold" onclick="toggleMenu(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                        <circle cx="12" cy="6" r="1.5" />
                        <circle cx="12" cy="12" r="1.5" />
                        <circle cx="12" cy="18" r="1.5" />
                    </svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openEditModal(); handleMenuClick(event)">Edit</a>
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                </div>
            </div>
            <h2 id="pubTitle" class="text-xl font-semibold text-gray-800">
                <a href="#" class="text-blue-600 hover:underline">Understanding AI in Research</a>
            </h2>
            <p id="pubContent" class="text-gray-600 mt-2">A comprehensive study on the impact of artificial intelligence in academic research. This paper discusses the various applications of AI in research methodologies, data analysis, and automation of complex tasks in multiple scientific domains.</p>
            <div class="flex items-center mt-4">
                <span class="text-sm text-gray-500">By</span>
                <span id="pubAuthor" class="ml-1 font-medium text-gray-700">Dr. John Doe</span>
            </div>
            <div class="flex justify-between items-center mt-4">
                <span id="pubDate" class="text-sm text-gray-500">Published: March 2025</span>
            </div>
        </div>

    <!-- publication -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden p-5 relative flex flex-col max-w-[400px]">
            <div class="absolute top-3 right-3">
                <button class="text-gray-800 hover:text-black font-bold" onclick="toggleMenu(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                        <circle cx="12" cy="6" r="1.5" />
                        <circle cx="12" cy="12" r="1.5" />
                        <circle cx="12" cy="18" r="1.5" />
                    </svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openEditModal(); handleMenuClick(event)">Edit</a>
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                </div>
            </div>
            <h2 id="pubTitle" class="text-xl font-semibold text-gray-800">
                <a href="#" class="text-blue-600 hover:underline">Understanding AI in Research</a>
            </h2>
            <p id="pubContent" class="text-gray-600 mt-2">A comprehensive study on the impact of artificial intelligence in academic research. This paper discusses the various applications of AI in research methodologies, data analysis, and automation of complex tasks in multiple scientific domains.</p>
            <div class="flex items-center mt-4">
                <span class="text-sm text-gray-500">By</span>
                <span id="pubAuthor" class="ml-1 font-medium text-gray-700">Dr. John Doe</span>
            </div>
            <div class="flex justify-between items-center mt-4">
                <span id="pubDate" class="text-sm text-gray-500">Published: March 2025</span>
            </div>
        </div>

    <!-- publication -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden p-5 relative flex flex-col max-w-[400px]">
            <div class="absolute top-3 right-3">
                <button class="text-gray-800 hover:text-black font-bold" onclick="toggleMenu(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                        <circle cx="12" cy="6" r="1.5" />
                        <circle cx="12" cy="12" r="1.5" />
                        <circle cx="12" cy="18" r="1.5" />
                    </svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openEditModal(); handleMenuClick(event)">Edit</a>
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                </div>
            </div>
            <h2 id="pubTitle" class="text-xl font-semibold text-gray-800">
                <a href="#" class="text-blue-600 hover:underline">Understanding AI in Research</a>
            </h2>
            <p id="pubContent" class="text-gray-600 mt-2">A comprehensive study on the impact of artificial intelligence in academic research. This paper discusses the various applications of AI in research methodologies, data analysis, and automation of complex tasks in multiple scientific domains.</p>
            <div class="flex items-center mt-4">
                <span class="text-sm text-gray-500">By</span>
                <span id="pubAuthor" class="ml-1 font-medium text-gray-700">Dr. John Doe</span>
            </div>
            <div class="flex justify-between items-center mt-4">
                <span id="pubDate" class="text-sm text-gray-500">Published: March 2025</span>
            </div>
        </div>

    <!-- publication -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden p-5 relative flex flex-col max-w-[400px]">
            <div class="absolute top-3 right-3">
                <button class="text-gray-800 hover:text-black font-bold" onclick="toggleMenu(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                        <circle cx="12" cy="6" r="1.5" />
                        <circle cx="12" cy="12" r="1.5" />
                        <circle cx="12" cy="18" r="1.5" />
                    </svg>
                </button>
                <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openEditModal(); handleMenuClick(event)">Edit</a>
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event)">Delete</a>
                </div>
            </div>
            <h2 id="pubTitle" class="text-xl font-semibold text-gray-800">
                <a href="#" class="text-blue-600 hover:underline">Understanding AI in Research</a>
            </h2>
            <p id="pubContent" class="text-gray-600 mt-2">A comprehensive study on the impact of artificial intelligence in academic research. </p>
            <div class="flex items-center mt-4">
                <span class="text-sm text-gray-500">By</span>
                <span id="pubAuthor" class="ml-1 font-medium text-gray-700">Dr. John Doe</span>
            </div>
            <div class="flex justify-between items-center mt-4">
                <span id="pubDate" class="text-sm text-gray-500">Published: March 2025</span>
            </div>
        </div>


    </div>
</div>

</div>


</div>