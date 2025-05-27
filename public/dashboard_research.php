<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'dashboard_databasemgt/database_connection.php';

// Redirect to login if admin session is not set
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

// Determine the selected tab from query parameter or default to 'areas'
$selectedTab = isset($_GET['tab']) ? $_GET['tab'] : 'areas';
$validTabs = ['areas', 'projects', 'publications'];
if (!in_array($selectedTab, $validTabs)) {
    $selectedTab = 'areas';
}

// Get search query
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchActive = !empty($searchQuery);

// Fetch data for each tab, applying search filter
$areas = $projects = $publications = [];
try {
    if ($selectedTab === 'areas') {
        $sql = "SELECT * FROM projects WHERE category = 'areas'";
        if ($searchActive) {
            $sql .= " AND (title LIKE :search OR description LIKE :search)";
        }
        $stmt = $pdo->prepare($sql);
        if ($searchActive) {
            $stmt->bindValue(':search', '%' . $searchQuery . '%');
        }
        $stmt->execute();
        $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($selectedTab === 'projects') {
        $sql = "SELECT * FROM projects WHERE category = 'projects'";
        if ($searchActive) {
            $sql .= " AND (title LIKE :search OR description LIKE :search)";
        }
        $stmt = $pdo->prepare($sql);
        if ($searchActive) {
            $stmt->bindValue(':search', '%' . $searchQuery . '%');
        }
        $stmt->execute();
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($selectedTab === 'publications') {
        $sql = "SELECT * FROM publications";
        if ($searchActive) {
            $sql .= " WHERE (title LIKE :search OR description LIKE :search  OR author LIKE :search)";
        }
        $stmt = $pdo->prepare($sql);
        if ($searchActive) {
            $stmt->bindValue(':search', '%' . $searchQuery . '%');
        }
        $stmt->execute();
        $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    $error = "Error fetching data: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sure-Tech - Research</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/7a97402827.js" crossorigin="anonymous"></script>
</head>
<body class="bg-slate-white w-full h-screen overflow-auto">
    <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-10"></div>
    <div class="h-screen w-full flex">
        <?php include 'dashboard_sidebar.php'; ?>
        <div class="flex-grow h-screen pl-10 pr-10">
            <?php include 'dashboard_topbar.php'; ?>
            <!-- Main Content -->
            <div class="w-full h-[90vh]">
                <!-- Display Messages -->
                <?php if (isset($_GET['message'])): ?>
                    <div class="p-4 mb-4 <?php echo $_GET['status'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> rounded">
                        <?php echo htmlspecialchars($_GET['message']); ?>
                    </div>
                <?php endif; ?>

                <!-- Tab Navigation -->
                <div class="my-tabs mb-6 flex space-x-4 border-b h-[10vh] h-min-[100px]" id="project_tabs">
                    <button class="tab py-2 pr-4 <?php echo $selectedTab === 'areas' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-black'; ?>" id="tab-areas" onclick="updatePage('areas', this)">Areas</button>
                    <button class="tab py-2 px-4 <?php echo $selectedTab === 'projects' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-black'; ?>" id="tab-projects" onclick="updatePage('projects', this)">Projects</button>
                    <button class="tab py-2 px-4 <?php echo $selectedTab === 'publications' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-black'; ?>" id="tab-publications" onclick="updatePage('publications', this)">Publications</button>
                </div>

                <!-- Container with all other contents -->
                <div id="research-container" class="research-container h-[80vh]">
                    <!-- Search Info -->
                    <?php if ($searchActive): ?>
                        <div class="w-full pl-6 mb-4">
                            <p class="text-gray-700">Showing results for "<strong><?php echo htmlspecialchars($searchQuery); ?></strong>"</p>
                            <a href="dashboard_research.php?tab=<?php echo urlencode($selectedTab); ?>" class="text-blue-500 hover:underline">Clear Search</a>
                        </div>
                    <?php endif; ?>

                    <!-- Research Areas Page -->
                    <div id="areas" class="research-page <?php echo $selectedTab !== 'areas' ? 'hidden' : ''; ?>">
                        <div class="w-full h-full">
                            <div class="inline-block items-center justify-center relative w-full overflow-auto">
                                <div class="w-full">
                                    <div class="w-full flex justify-between pl-6">
                                        <h1 class="text-2xl font-medium">Key areas</h1>
                                        <button class="px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-600" onclick="openModal('areaModal', 'add_areas')"><i class="fas fa-plus"></i> Add new</button>
                                    </div>
                                    <div class="md:columns-2 lg:columns-3 columns-1 gap-4 overflow-auto p-6 h-[70vh]" id="main-container">
                                        <?php
                                        if (isset($error) && $selectedTab === 'areas') {
                                            echo '<p class="text-red-600 p-4">' . htmlspecialchars($error) . '</p>';
                                        } elseif ($selectedTab === 'areas') {
                                            if (empty($areas)) {
                                                echo '<p class="text-gray-600 p-4">No areas found' . ($searchActive ? ' for "' . htmlspecialchars($searchQuery) . '"' : '') . '.</p>';
                                            } else {
                                                foreach ($areas as $item) {
                                                    echo '
                                                    <div id="researchCard" class="areaContainer bg-white shadow-md rounded-lg overflow-hidden relative flex flex-col max-w-[400px] justify-center items-center">
                                                        <img src="dashboard_databasemgt/' . htmlspecialchars($item['image_path']) . '" alt="Area" class="image_path w-full h-[250px] object-cover">
                                                        <label name="id" class="id hidden" id="id">' . htmlspecialchars($item['id']) . '</label>
                                                        <div class="absolute top-3 right-3">
                                                            <button class="text-gray-800 hover:text-black font-bold bg-white rounded-full" onclick="toggleMenu(event)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 p-1" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                                                    <circle cx="12" cy="6" r="1.5" />
                                                                    <circle cx="12" cy="12" r="1.5" />
                                                                    <circle cx="12" cy="18" r="1.5" />
                                                                </svg>
                                                            </button>
                                                            <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                                                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openModalEdit(this, \'update_areas\', \'areaModal\'); handleMenuClick(event)">Edit</a>
                                                                <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event); deleteCard(this, \'areas\')">Delete</a>
                                                            </div>
                                                        </div>
                                                        <div class="p-4">
                                                            <h2 class="title text-xl font-semibold align-center items-center text-blue-500">' . htmlspecialchars($item['title']) . '</h2>
                                                        </div>
                                                    </div>';
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Research Projects Page -->
                    <div id="projects" class="research-page <?php echo $selectedTab !== 'projects' ? 'hidden' : ''; ?>">
                        <div class="w-full h-full">
                            <div class="inline-block items-center justify-center relative w-full overflow-auto">
                                <div class="w-full">
                                    <div class="w-full flex justify-between pl-6">
                                        <h1 class="text-2xl font-medium">Projects</h1>
                                        <button class="px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-600" onclick="openModal('projectModal', 'add_project')"><i class="fas fa-plus"></i> Add new</button>
                                    </div>
                                    <div class="md:columns-2 lg:columns-3 space-y-6 columns-1 gap-4 overflow-auto p-6 h-[70vh]" id="projects-list">
                                        <?php
                                        if (isset($error) && $selectedTab === 'projects') {
                                            echo '<p class="text-red-600 p-4">' . htmlspecialchars($error) . '</p>';
                                        } elseif ($selectedTab === 'projects') {
                                            if (empty($projects)) {
                                                echo '<p class="text-gray-600 p-4">No projects found' . ($searchActive ? ' for "' . htmlspecialchars($searchQuery) . '"' : '') . '.</p>';
                                            } else {
                                                foreach ($projects as $item) {
                                                    echo '
                                                    <div id="researchCard" class="projectContainer bg-white shadow-md rounded-lg overflow-auto relative flex flex-col max-w-[400px] h-[400px]">
                                                        <img src="dashboard_databasemgt/' . htmlspecialchars($item['image_path']) . '" alt="Project" class="image_path w-full h-48 object-cover">
                                                        <label name="id" class="id hidden" id="id">' . htmlspecialchars($item['id']) . '</label>
                                                        <div class="absolute top-3 right-3">
                                                            <button class="text-gray-800 hover:text-black font-bold bg-white rounded-full" onclick="toggleMenu(event)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 p-1" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                                                    <circle cx="12" cy="6" r="1.5" />
                                                                    <circle cx="12" cy="12" r="1.5" />
                                                                    <circle cx="12" cy="18" r="1.5" />
                                                                </svg>
                                                            </button>
                                                            <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                                                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openModalEdit(this, \'update_project\', \'projectModal\'); handleMenuClick(event)">Edit</a>
                                                                <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event); deleteCard(this, \'projects\')">Delete</a>
                                                            </div>
                                                        </div>
                                                        <div class="p-4">
                                                            <h2 class="title text-xl font-semibold">' . htmlspecialchars($item['title']) . '</h2>
                                                            <p class="description mt-4 text-gray-700">' . htmlspecialchars($item['description'] ?? '') . '</p>
                                                        </div>
                                                    </div>';
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Research Publications Page -->
                    <div id="publications" class="research-page <?php echo $selectedTab !== 'publications' ? 'hidden' : ''; ?>">
                        <div class="w-full h-full">
                            <div class="inline-block items-center justify-center relative w-full overflow-auto">
                                <div class="w-full">
                                    <div class="w-full flex justify-between pl-6">
                                        <h1 class="text-2xl font-medium">Publications</h1>
                                        <button class="px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-600" onclick="openModal('pubModal', 'add_publication')"><i class="fas fa-plus"></i> Add new</button>
                                    </div>
                                    <div class="md:columns-2 lg:columns-3 space-y-6 columns-1 gap-4 overflow-auto p-6 h-[70vh]" id="publications-list">
                                        <?php
                                        if (isset($error) && $selectedTab === 'publications') {
                                            echo '<p class="text-red-600 p-4">' . htmlspecialchars($error) . '</p>';
                                        } elseif ($selectedTab === 'publications') {
                                            if (empty($publications)) {
                                                echo '<p class="text-gray-600 p-4">No publications found' . ($searchActive ? ' for "' . htmlspecialchars($searchQuery) . '"' : '') . '.</p>';
                                            } else {
                                                foreach ($publications as $item) {
                                                    $formattedDate = $item['publisher_date'] && strtotime($item['publisher_date']) ? htmlspecialchars(date('Y-m-d', strtotime($item['publisher_date']))) : '';
                                                    echo '
                                                    <div id="researchCard" class="pubContainer bg-white rounded-2xl shadow-md overflow-hidden p-5 relative max-w-[400px] h-[300px]">
                                                        <label class="id hidden" id="id">' . htmlspecialchars($item['id']) . '</label>
                                                        <div class="absolute top-3 right-3">
                                                            <button class="text-gray-800 hover:text-black font-bold" onclick="toggleMenu(event)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                                                    <circle cx="12" cy="6" r="1.5" />
                                                                    <circle cx="12" cy="12" r="1.5" />
                                                                    <circle cx="12" cy="18" r="1.5" />
                                                                </svg>
                                                            </button>
                                                            <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                                                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="openModalEdit(this, \'update_publication\', \'pubModal\'); handleMenuClick(event)">Edit</a>
                                                                <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event); deleteCard(this, \'publications\')">Delete</a>
                                                            </div>
                                                        </div>
                                                        <h2 id="pubTitle" class="titlelink text-xl font-semibold text-gray-800">
                                                            <a href="' . htmlspecialchars($item['link']) . '" class="text-blue-600 hover:underline">' . htmlspecialchars($item['title']) . '</a>
                                                        </h2>
                                                        <div class="h-[100px] text-ellipsis">
                                                            <p id="pubContent" class="description text-gray-600 mt-2 text-ellipsis">' . htmlspecialchars($item['description']) . '</p>
                                                        </div>
                                                        <div class="flex items-center mt-4">
                                                            <span class="text-sm text-gray-500">By</span>
                                                            <span id="pubAuthor" class="author ml-1 font-medium text-gray-700">' . htmlspecialchars($item['author']) . '</span>
                                                        </div>
                                                        <div class="flex justify-between items-center mt-4">
                                                            <span id="pubDate" class="publishedDate text-sm text-gray-500">Published: ' . $formattedDate . '</span>
                                                        </div>
                                                    </div>';
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Adding/Editing Areas -->
                <div id="areaModal" class="hidden fixed inset-0 flex items-center justify-center z-20">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg h-[600px] overflow-auto">
                        <form id="areaForm" action="dashboard_databasemgt/manage_research_areas.php?action=add_areas" method="POST" enctype="multipart/form-data">
                            <div class="moduleTitle mb-4">
                                <label class="block text-gray-700">Title</label>
                                <input type="hidden" name="id" id="id" class="id">
                                <input type="hidden" name="tab" id="tab" value="<?php echo htmlspecialchars($selectedTab); ?>">
                                <input type="text" id="areaTitle" name="areaTitle" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter title" required>
                            </div>
                            <div class="moduleImage mb-4">
                                <label class="block text-gray-700">Image</label>
                                <input id="imagefile" type="file" name="image" accept="image/*" onchange="previewImage(this)" class="w-full" required>
                                <img id="imagePreview" src="#" alt="Preview" class="image hidden mt-4 w-full max-h-64 object-cover border rounded">
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" class="px-4 py-2 bg-gray-400 text-white rounded-lg" onclick="closeModal('areaModal')">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal for Adding/Editing Projects -->
                <div id="projectModal" class="hidden fixed inset-0 flex items-center justify-center z-20">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg h-[600px] overflow-auto">
                        <form id="projectForm" action="dashboard_databasemgt/manage_research_projects.php?action=add_project" method="POST" enctype="multipart/form-data">
                            <div class="moduleTitle mb-4">
                                <label class="block text-gray-700">Title</label>
                                <input type="hidden" name="id" id="id" class="id">
                                <input type="hidden" name="tab" id="tab" value="<?php echo htmlspecialchars($selectedTab); ?>">
                                <input type="text" id="areaTitle" name="areaTitle" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter title" required>
                            </div>
                            <div class="moduleDescription mb-4">
                                <label class="block text-gray-700">Project description</label>
                                <textarea id="projectDescription" name="projectDescription" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter project description" required></textarea>
                            </div>
                            <div class="moduleImage mb-4">
                                <label class="block text-gray-700">Image</label>
                                <input id="imagefile" type="file" name="image" accept="image/*" onchange="previewImage(this)" class="w-full" required>
                                <img id="imagePreview" src="#" alt="Preview" class="image hidden mt-4 w-full max-h-64 object-cover border rounded">
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" class="px-4 py-2 bg-gray-400 text-white rounded-lg" onclick="closeModal('projectModal')">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal for Adding/Editing Publications -->
                <div id="pubModal" class="hidden fixed inset-0 flex items-center justify-center z-20">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg h-[600px] overflow-auto">
                        <form id="pubForm" action="dashboard_databasemgt/manage_research_publications.php?action=add_publication" method="POST" enctype="multipart/form-data">
                            <div class="mb-4">
                                <input type="hidden" name="id" id="id" class="id">
                                <input type="hidden" name="tab" id="tab" value="<?php echo htmlspecialchars($selectedTab); ?>">
                                <label class="block text-gray-700">Title</label>
                                <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter title" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Content</label>
                                <textarea id="content" name="content" class="w-full p-2 border border-gray-300 rounded-lg" rows="4" placeholder="Enter content" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Publication link</label>
                                <input type="text" id="link" name="link" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Paste publication link here" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Author</label>
                                <input type="text" id="editAuthor" name="author" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Enter author name" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Date of Publication</label>
                                <input type="date" id="date" name="date" class="w-full p-2 border border-gray-300 rounded-lg" required>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" class="px-4 py-2 bg-gray-400 text-white rounded-lg" onclick="closeModal('pubModal')">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-20 hidden">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Confirm Deletion</h2>
                        <p class="text-gray-600 mb-4">Are you sure you want to remove this item?</p>
                        <form id="deleteForm" method="POST">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="tab" id="tab" value="<?php echo htmlspecialchars($selectedTab); ?>">
                            <div class="flex justify-end gap-4">
                                <button type="button" onclick="closeDeleteModal()" class="bg-white border-blue-500 text-blue-500 px-4 py-2 rounded hover:bg-blue-500 hover:text-white">Cancel</button>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        console.log('JavaScript loaded');

        let selectedOption = '<?php echo $selectedTab; ?>';

        function closeModal(modalID) {
            console.log('Closing modal:', modalID);
            document.getElementById(modalID).classList.add("hidden");
            document.getElementById('overlay').classList.add("hidden");
        }

        function openModal(modalID, action) {
            console.log('Opening modal:', modalID, 'Action:', action);
            const modal = document.getElementById(modalID);
            modal.classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");
            modal.querySelector('#id').value = '';
            modal.querySelector('#areaTitle') ? modal.querySelector('#areaTitle').value = '' : null;
            modal.querySelector('#projectDescription') ? modal.querySelector('#projectDescription').value = '' : null;
            modal.querySelector('#imagePreview') ? modal.querySelector('#imagePreview').src = '' : null;
            modal.querySelector('#imagePreview') ? modal.querySelector('#imagePreview').classList.add('hidden') : null;
            modal.querySelector('#title') ? modal.querySelector('#title').value = '' : null;
            modal.querySelector('#content') ? modal.querySelector('#content').value = '' : null;
            modal.querySelector('#link') ? modal.querySelector('#link').value = '' : null;
            modal.querySelector('#editAuthor') ? modal.querySelector('#editAuthor').value = '' : null;
            modal.querySelector('#date') ? modal.querySelector('#date').value = '' : null;

            if (modalID === 'areaModal') {
                document.getElementById('areaForm').action = 'dashboard_databasemgt/manage_research_areas.php?action=' + action;
            } else if (modalID === 'projectModal') {
                document.getElementById('projectForm').action = 'dashboard_databasemgt/manage_research_projects.php?action=' + action;
            } else if (modalID === 'pubModal') {
                document.getElementById('pubForm').action = 'dashboard_databasemgt/manage_research_publications.php?action=' + action;
            }
        }

        function openModalEdit(button, action, modalID) {
            console.log('Opening edit modal:', modalID, 'Action:', action);
            const modal = document.getElementById(modalID);
            modal.classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");
            let card = button.closest('#researchCard');

            try {
                if (modalID === 'areaModal') {
                    modal.querySelector('#areaTitle').value = card.querySelector('.title').textContent;
                    modal.querySelector('#id').value = card.querySelector('.id').textContent;
                    modal.querySelector('#imagePreview').src = card.querySelector('.image_path').getAttribute('src');
                    modal.querySelector('#imagePreview').classList.remove('hidden');
                    modal.querySelector('#imagefile').removeAttribute('required');
                    document.getElementById('areaForm').action = 'dashboard_databasemgt/manage_research_areas.php?action=' + action;
                } else if (modalID === 'projectModal') {
                    modal.querySelector('#areaTitle').value = card.querySelector('.title').textContent;
                    modal.querySelector('#id').value = card.querySelector('.id').textContent;
                    modal.querySelector('#projectDescription').value = card.querySelector('.description').textContent || '';
                    modal.querySelector('#imagePreview').src = card.querySelector('.image_path').getAttribute('src');
                    modal.querySelector('#imagePreview').classList.remove('hidden');
                    modal.querySelector('#imagefile').removeAttribute('required');
                    document.getElementById('projectForm').action = 'dashboard_databasemgt/manage_research_projects.php?action=' + action;
                } else if (modalID === 'pubModal') {
                    const titleLink = card.querySelector('.titlelink a');
                    modal.querySelector('#title').value = titleLink.textContent.trim();
                    modal.querySelector('#id').value = card.querySelector('.id').textContent;
                    modal.querySelector('#link').value = titleLink.getAttribute('href');
                    modal.querySelector('#content').value = card.querySelector('.description').textContent;
                    modal.querySelector('#editAuthor').value = card.querySelector('.author').textContent;
                    const dateText = card.querySelector('.publishedDate').textContent.replace('Published: ', '').trim();
                    console.log('Published date text:', dateText);
                    if (/^\d{4}-\d{2}-\d{2}$/.test(dateText)) {
                        modal.querySelector('#date').value = dateText;
                    } else {
                        modal.querySelector('#date').value = '';
                    }
                    document.getElementById('pubForm').action = 'dashboard_databasemgt/manage_research_publications.php?action=' + action;
                }
            } catch (error) {
                console.error('Error in openModalEdit:', error);
                alert('Failed to load data for editing. Please try again.');
            }
        }

        function deleteCard(button, category) {
            console.log('Deleting card, category:', category);
            document.getElementById("overlay").classList.remove("hidden");
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            const card = button.closest('#researchCard');
            modal.querySelector('#id').value = card.querySelector('.id').textContent;

            switch (category) {
                case 'areas':
                    document.getElementById('deleteForm').action = `dashboard_databasemgt/manage_research_areas.php?action=delete_area&tab=${selectedOption}`;
                    break;
                case 'projects':
                    document.getElementById('deleteForm').action = `dashboard_databasemgt/manage_research_projects.php?action=delete_project&tab=${selectedOption}`;
                    break;
                case 'publications':
                    document.getElementById('deleteForm').action = `dashboard_databasemgt/manage_research_publications.php?action=delete_publication&tab=${selectedOption}`;
                    break;
                default:
                    console.error('Invalid category:', category);
                    break;
            }
        }

        function closeDeleteModal() {
            console.log('Closing delete modal');
            document.getElementById("overlay").classList.add("hidden");
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function toggleMenu(event) {
            console.log('Toggling menu');
            let menu = event.currentTarget.nextElementSibling;
            menu.classList.toggle("hidden");
        }

        function handleMenuClick(event) {
            console.log('Menu item clicked');
            let menu = event.currentTarget.parentElement;
            menu.classList.add("hidden");
        }

        function updatePage(activeTab, selectedTab) {
            console.log('Updating page to tab:', activeTab);
            selectedOption = activeTab;
            window.location.href = 'dashboard_research.php?tab=' + activeTab;
        }

        function previewImage(input) {
            console.log('Previewing image');
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

        function toggleSidebar() {
            console.log('Toggling sidebar');
            const sidebar = document.getElementById("sidebar");
            const toggle_btn = document.getElementById("togglebutton2");
            toggle_btn.classList.toggle("hidden");
            sidebar.classList.toggle("hidden");
        }
    </script>
</body>
</html>