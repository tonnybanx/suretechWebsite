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

// Determine the selected tab from query parameter or default to 'hackathrons'
$selectedTab = isset($_GET['tab']) ? $_GET['tab'] : 'hackathrons';
$validTabs = ['hackathrons', 'conferences', 'news'];
if (!in_array($selectedTab, $validTabs)) {
    $selectedTab = 'hackathrons';
}

// Get search query
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchActive = !empty($searchQuery);

// Fetch events based on the selected tab and search query
try {
    $category = $selectedTab === 'news' ? 'news' : ($selectedTab === 'conferences' ? 'conference' : 'hackathron');
    $sql = "SELECT * FROM events WHERE category = ?";
    if ($searchActive) {
        $sql .= " AND (title LIKE ? OR details LIKE ? OR location LIKE ?)";
    }
    $stmt = $pdo->prepare($sql);
    $params = [$category];
    if ($searchActive) {
        $searchParam = '%' . $searchQuery . '%';
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
    }
    $stmt->execute($params);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $events = [];
    $error = "Error fetching events: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sure-Tech - Events</title>
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


                <!-- Tab Navigation -->
                <div class="my-tabs mb-6 flex space-x-4 border-b h-[10vh] h-min-[100px]" id="event_tabs">
                    <button class="eventTab py-2 pr-4 <?php echo $selectedTab === 'hackathrons' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-black'; ?>" id="tab-hackathrons" onclick="updatePage('hackathrons', this)">Hackathrons</button>
                    <button class="eventTab py-2 px-4 <?php echo $selectedTab === 'conferences' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-black'; ?>" id="tab-conferences" onclick="updatePage('conferences', this)">Conferences</button>
                    <button class="eventTab py-2 px-4 <?php echo $selectedTab === 'news' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-black'; ?>" id="tab-news" onclick="updatePage('news', this)">News</button>
                </div>

                <!-- Container with all other contents -->
                <div id="event-container" class="eventContainer h-[80vh]">
                    <!-- Search Info -->
                    <?php if ($searchActive): ?>
                        <div class="w-full pl-6 mb-4">
                            <p class="text-gray-700">Showing results for "<strong><?php echo htmlspecialchars($searchQuery); ?></strong>"</p>
                            <a href="dashboard_events.php?tab=<?php echo urlencode($selectedTab); ?>" class="text-blue-500 hover:underline">Clear Search</a>
                        </div>
                    <?php endif; ?>

                    <!-- Hackathron Content -->
                    <div id="hackathrons" class="eventContent <?php echo $selectedTab !== 'hackathrons' ? 'hidden' : ''; ?>">
                        <div class="inline-block items-center justify-center relative w-full overflow-auto">
                            <div class="w-full">
                                <div class="w-full flex justify-between pl-6">
                                    <h1 class="text-2xl font-medium">Hackathrons</h1>
                                    <button class="px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-600" onclick="setAddAction(); openModal('eventsModal')"><i class="fas fa-plus"></i> Add new</button>
                                </div>
                                <div class="md:columns-2 lg:columns-3 columns-1 gap-4 overflow-auto p-6 h-[70vh]" id="hackathronContainer">
                                    <?php
                                    if (isset($error) && $selectedTab === 'hackathrons') {
                                        echo '<p class="text-red-600 p-4">' . htmlspecialchars($error) . '</p>';
                                    } elseif ($selectedTab === 'hackathrons') {
                                        if (empty($events)) {
                                            echo '<p class="text-gray-600 p-4">No hackathrons found' . ($searchActive ? ' for "' . htmlspecialchars($searchQuery) . '"' : '') . '.</p>';
                                        } else {
                                            foreach ($events as $item) {
                                                $formattedDate = $item['date'] && strtotime($item['date']) ? htmlspecialchars(date('Y-m-d', strtotime($item['date']))) : '';
                                                echo '
                                                <div class="eventContainer bg-white shadow-md rounded-lg overflow-hidden relative flex flex-col max-w-[400px] h-[400px]">
                                                    <img src="dashboard_databasemgt/' . htmlspecialchars($item['image_path']) . '" alt="Hackathron" class="image w-full h-48 object-cover">
                                                    <label for="id" name="id" class="id hidden">' . htmlspecialchars($item['id']) . '</label>
                                                    <label for="category" name="category" class="category hidden">' . htmlspecialchars($item['category']) . '</label>
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
                                                            <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event); deleteEvent(this)">Delete</a>
                                                        </div>
                                                    </div>
                                                    <div class="p-4">
                                                        <h2 class="title text-xl font-semibold">' . htmlspecialchars($item['title']) . '</h2>
                                                        <div class="dateVenue flex">
                                                            <p class="text-gray-600 text-sm mt-2 mr-2"><i class="fa fa-calendar"></i> <span class="date">' . $formattedDate . '</span> | <span class="raw-date hidden">' . $formattedDate . '</span></p>
                                                            <p class="text-gray-600 text-sm mt-2"><i class="fas fa-location-pin ml-2"></i> <span class="venue">' . htmlspecialchars($item['location'] ?? '') . '</span></p>
                                                        </div>
                                                        <p class="details mt-4 text-gray-700">' . htmlspecialchars($item['details']) . '</p>
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

                    <!-- Conference Content -->
                    <div id="conferences" class="eventContent <?php echo $selectedTab !== 'conferences' ? 'hidden' : ''; ?>">
                        <div class="inline-block items-center justify-center relative w-full overflow-auto">
                            <div class="w-full">
                                <div class="w-full flex justify-between pl-6">
                                    <h1 class="text-2xl font-medium">Conferences</h1>
                                    <button class="px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-600" onclick="setAddAction(); openModal('eventsModal')"><i class="fas fa-plus"></i> Add new</button>
                                </div>
                                <div class="md:columns-2 lg:columns-3 columns-1 gap-4 overflow-auto p-6 h-[70vh]" id="conferenceContainer">
                                    <?php
                                    if (isset($error) && $selectedTab === 'conferences') {
                                        echo '<p class="text-red-600 p-4">' . htmlspecialchars($error) . '</p>';
                                    } elseif ($selectedTab === 'conferences') {
                                        if (empty($events)) {
                                            echo '<p class="text-gray-600 p-4">No conferences found' . ($searchActive ? ' for "' . htmlspecialchars($searchQuery) . '"' : '') . '.</p>';
                                        } else {
                                            foreach ($events as $item) {
                                                $formattedDate = $item['date'] && strtotime($item['date']) ? htmlspecialchars(date('Y-m-d', strtotime($item['date']))) : '';
                                                echo '
                                                <div class="eventContainer bg-white shadow-md rounded-lg overflow-hidden relative flex flex-col max-w-[400px] h-[400px]">
                                                    <img src="dashboard_databasemgt/' . htmlspecialchars($item['image_path']) . '" alt="Conference" class="image w-full h-48 object-cover">
                                                    <label for="id" name="id" class="id hidden">' . htmlspecialchars($item['id']) . '</label>
                                                    <label for="category" name="category" class="category hidden">' . htmlspecialchars($item['category']) . '</label>
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
                                                            <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event); deleteEvent(this)">Delete</a>
                                                        </div>
                                                    </div>
                                                    <div class="p-4">
                                                        <h2 class="title text-xl font-semibold">' . htmlspecialchars($item['title']) . '</h2>
                                                        <div class="dateVenue flex">
                                                            <p class="text-gray-600 text-sm mt-2 mr-2"><i class="fa fa-calendar"></i> <span class="date">' . $formattedDate . '</span> | <span class="raw-date hidden">' . $formattedDate . '</span></p>
                                                            <p class="text-gray-600 text-sm mt-2"><i class="fas fa-location-pin ml-2"></i> <span class="venue">' . htmlspecialchars($item['location'] ?? '') . '</span></p>
                                                        </div>
                                                        <p class="details mt-4 text-gray-700">' . htmlspecialchars($item['details']) . '</p>
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

                    <!-- News Content -->
                    <div id="news" class="eventContent <?php echo $selectedTab !== 'news' ? 'hidden' : ''; ?>">
                        <div class="inline-block items-center justify-center relative w-full overflow-auto">
                            <div class="w-full">
                                <div class="w-full flex justify-between pl-6">
                                    <h1 class="text-2xl font-medium">News</h1>
                                    <button class="px-6 py-2 rounded bg-blue-500 text-white hover:bg-blue-600" onclick="setAddAction(); openModal('eventsModal')"><i class="fas fa-plus"></i> Add new</button>
                                </div>
                                <div class="md:columns-2 lg:columns-3 columns-1 gap-4 overflow-auto p-6 h-[70vh]" id="newsContainer">
                                    <?php
                                    if (isset($error) && $selectedTab === 'news') {
                                        echo '<p class="text-red-600 p-4">' . htmlspecialchars($error) . '</p>';
                                    } elseif ($selectedTab === 'news') {
                                        if (empty($events)) {
                                            echo '<p class="text-gray-600 p-4">No news found' . ($searchActive ? ' for "' . htmlspecialchars($searchQuery) . '"' : '') . '.</p>';
                                        } else {
                                            foreach ($events as $item) {
                                                echo '
                                                <div class="eventContainer bg-white shadow-md rounded-lg overflow-hidden relative flex flex-col max-w-[400px] h-[400px]">
                                                    <img src="dashboard_databasemgt/' . htmlspecialchars($item['image_path']) . '" alt="News" class="image w-full h-48 object-cover">
                                                    <label for="id" name="id" class="id hidden">' . htmlspecialchars($item['id']) . '</label>
                                                    <label for="category" name="category" class="category hidden">' . htmlspecialchars($item['category']) . '</label>
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
                                                            <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event); deleteEvent(this)">Delete</a>
                                                        </div>
                                                    </div>
                                                    <div class="p-4">
                                                        <h2 class="title text-xl font-semibold">' . htmlspecialchars($item['title']) . '</h2>
                                                        <p class="details mt-4 text-gray-700">' . htmlspecialchars($item['details']) . '</p>
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
        </div>
    </div>

    <!-- Modal for Adding/Editing Events -->
    <div id="eventsModal" class="hidden fixed inset-0 flex items-center justify-center z-20">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg h-[600px] overflow-auto">
            <form id="eventForm" action="dashboard_databasemgt/manage_events.php?action=addEvent" method="POST" enctype="multipart/form-data">
                <div class="moduleTitle mb-4">
                    <label class="block text-gray-700">Title</label>
                    <input type="hidden" name="id" id="id" class="id">
                    <input type="hidden" name="category" id="category" class="category">
                    <input type="hidden" name="tab" id="tab" value="<?php echo htmlspecialchars($selectedTab); ?>">
                    <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Title" required>
                </div>
                <div class="moduleDescription mb-4">
                    <label class="block text-gray-700">Details</label>
                    <textarea id="details" name="details" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Details" required></textarea>
                </div>
                <div class="dateVenue">
                    <div class="mb-4">
                        <label class="block text-gray-700">Date</label>
                        <input type="date" id="date" name="date" class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Location</label>
                        <input type="text" id="location" name="location" class="w-full p-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
                <div class="moduleImage mb-4">
                    <label class="block text-gray-700">Image</label>
                    <input id="imagefile" type="file" name="image" accept="image/*" onchange="previewImage(this)" class="w-full" required>
                    <img id="imagePreview" src="#" alt="Preview" class="image hidden mt-4 w-full max-h-64 object-cover border rounded">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="px-4 py-2 bg-white border border-blue-500 text-blue-500 rounded-lg" onclick="closeModal('eventsModal')">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Confirm</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-20 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Confirm Deletion</h2>
            <p class="text-gray-600 mb-4">Are you sure you want to remove this event?</p>
            <form id="deleteForm" method="POST" action="dashboard_databasemgt/manage_events.php?action=deleteEvent">
                <input type="hidden" name="id" id="deleteId">
                <input type="hidden" name="tab" id="tab" value="<?php echo htmlspecialchars($selectedTab); ?>">
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeDeleteModal()" class="bg-white border-blue-500 text-blue-500 px-4 py-2 rounded hover:bg-blue-500 hover:text-white">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let selectedOption = '<?php echo $selectedTab; ?>';
        let selectedAction = '<?php echo $selectedTab === 'news' ? 'addNews' : 'addEvent'; ?>';

        function deleteEvent(button) {
            document.getElementById("overlay").classList.remove("hidden");
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            const card = button.closest('.eventContainer');
            modal.querySelector('#deleteId').value = card.querySelector('.id').textContent;
        }

        function closeDeleteModal() {
            document.getElementById("overlay").classList.add("hidden");
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function handleMenuClick(event) {
            let menu = event.currentTarget.parentElement;
            menu.classList.add("hidden");
        }

        function openModalEdit(button) {
            const modal = document.getElementById('eventsModal');
            modal.classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");
            let card = button.closest('.eventContainer');

            try {
                const title = card.querySelector('.title')?.textContent || '';
                const details = card.querySelector('.details')?.textContent || '';
                const id = card.querySelector('.id')?.textContent || '';
                const category = card.querySelector('.category')?.textContent || '';
                const imageSrc = card.querySelector('.image')?.getAttribute('src') || '';

                modal.querySelector('#title').value = title;
                modal.querySelector('#details').value = details;
                modal.querySelector('#id').value = id;
                modal.querySelector('#category').value = category;
                modal.querySelector('#imagePreview').src = imageSrc;
                modal.querySelector('#imagePreview').classList.remove('hidden');
                modal.querySelector('#imagefile').removeAttribute('required'); // Image optional for edit

                const dateElement = card.querySelector('.raw-date');
                const venueElement = card.querySelector('.venue');

                if (dateElement && venueElement) {
                    const dateText = dateElement.textContent.trim();
                    if (/^\d{4}-\d{2}-\d{2}$/.test(dateText)) {
                        modal.querySelector('#date').value = dateText;
                    } else {
                        modal.querySelector('#date').value = '';
                    }
                    modal.querySelector('#location').value = venueElement.textContent.trim();
                } else {
                    modal.querySelector('#date').value = '';
                    modal.querySelector('#location').value = '';
                }

                if (selectedOption === 'news') {
                    modal.querySelector('.dateVenue').classList.add('hidden');
                } else {
                    modal.querySelector('.dateVenue').classList.remove('hidden');
                }

                setEditAction();
            } catch (error) {
                console.error('Error in openModalEdit:', error);
                alert('Failed to load event data for editing. Please try again.');
            }
        }

        function setAddAction() {
            switch (selectedOption) {
                case 'hackathrons': selectedAction = 'addEvent'; break;
                case 'conferences': selectedAction = 'addEvent'; break;
                case 'news': selectedAction = 'addNews'; break;
            }
            document.getElementById('eventForm').action = 'dashboard_databasemgt/manage_events.php?action=' + selectedAction;
        }

        function setEditAction() {
            switch (selectedOption) {
                case 'hackathrons': selectedAction = 'editEvent'; break;
                case 'conferences': selectedAction = 'editEvent'; break;
                case 'news': selectedAction = 'editNews'; break;
            }
            document.getElementById('eventForm').action = 'dashboard_databasemgt/manage_events.php?action=' + selectedAction;
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

        function updatePage(activeTab, selectedButton) {
            selectedOption = activeTab;
            window.location.href = 'dashboard_events.php?tab=' + activeTab;
        }

        function closeModal(modalID) {
            document.getElementById(modalID).classList.add("hidden");
            document.getElementById('overlay').classList.add("hidden");
        }

        function openModal(modalID) {
            const modalElement = document.getElementById('eventsModal');
            modalElement.classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");
            modalElement.querySelector('#title').value = '';
            modalElement.querySelector('#details').value = '';
            modalElement.querySelector('#date').value = '';
            modalElement.querySelector('#location').value = '';
            modalElement.querySelector('# Reflections on the 2024 Hackathonid').value = '';
            modalElement.querySelector('#imagePreview').src = '';
            modalElement.querySelector('#imagePreview').classList.add('hidden');
            modalElement.querySelector('#imagefile').setAttribute('required', 'required');
            switch (selectedOption) {
                case 'news':
                    modalElement.querySelector('.dateVenue').classList.add('hidden');
                    modalElement.querySelector('.category').value = 'news';
                    break;
                case 'hackathrons':
                    modalElement.querySelector('.dateVenue').classList.remove('hidden');
                    modalElement.querySelector('.category').value = 'hackathron';
                    break;
                case 'conferences':
                    modalElement.querySelector('.dateVenue').classList.remove('hidden');
                    modalElement.querySelector('.category').value = 'conference';
                    break;
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const toggle_btn = document.getElementById("togglebutton2");
            toggle_btn.classList.toggle("hidden");
            sidebar.classList.toggle("hidden");
        }
    </script>
</body>
</html>