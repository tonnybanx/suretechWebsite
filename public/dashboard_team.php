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

// Determine the selected tab from query parameter or default to 'students'
$selectedTab = isset($_GET['tab']) ? $_GET['tab'] : 'students';
$validTabs = ['students', 'staff'];
if (!in_array($selectedTab, $validTabs)) {
    $selectedTab = 'students';
}

// Get search query
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchActive = !empty($searchQuery);

// Fetch data for each tab, applying search filter
$students = $staff = [];
try {
    if ($selectedTab === 'students') {
        $sql = "SELECT * FROM team WHERE category = 'student'";
        if ($searchActive) {
            $sql .= " AND (first_name LIKE :search OR last_name LIKE :search OR email LIKE :search OR details LIKE :search)";
        }
        $stmt = $pdo->prepare($sql);
        if ($searchActive) {
            $stmt->bindValue(':search', '%' . $searchQuery . '%');
        }
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($selectedTab === 'staff') {
        $sql = "SELECT * FROM team WHERE category = 'staff'";
        if ($searchActive) {
            $sql .= " AND (first_name LIKE :search OR last_name LIKE :search OR email LIKE :search OR details LIKE :search)";
        }
        $stmt = $pdo->prepare($sql);
        if ($searchActive) {
            $stmt->bindValue(':search', '%' . $searchQuery . '%');
        }
        $stmt->execute();
        $staff = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Sure-Tech - Team</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/7a97402827.js" crossorigin="anonymous"></script>
</head>
<body class="bg-slate-white w-full h-screen">
    <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-10"></div>
    <div class="h-screen w-full flex">
        <?php include 'dashboard_sidebar.php'; ?>
        <div class="flex-grow h-screen pl-10 pr-10">
            <?php include 'dashboard_topbar.php'; ?>
            <!-- Main Content -->
            <div class="w-full h-[90vh]">
            
                <!-- Tab Navigation -->
                <div class="my-tabs mb-6 flex space-x-4 border-b h-[10vh] h-min-[100px]" id="team_tabs">
                    <button class="team-tab py-2 pr-4 <?php echo $selectedTab === 'students' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-black'; ?>" id="tab-students" onclick="updatePage('students', this)">Students</button>
                    <button class="team-tab py-2 px-4 <?php echo $selectedTab === 'staff' ? 'border-b-2 border-blue-500 text-blue-500' : 'text-black'; ?>" id="tab-staff" onclick="updatePage('staff', this)">Staff</button>
                </div>

                <!-- Container with all other contents -->
                <div id="team-container" class="team-container h-[80vh]">
                    <!-- Search Info -->
                    <?php if ($searchActive): ?>
                        <div class="w-full pl-6 mb-4">
                            <p class="text-gray-700">Showing results for "<strong><?php echo htmlspecialchars($searchQuery); ?></strong>"</p>
                            <a href="dashboard_team.php?tab=<?php echo urlencode($selectedTab); ?>" class="text-blue-500 hover:underline">Clear Search</a>
                        </div>
                    <?php endif; ?>

                    <!-- Students Content -->
                    <div id="students" class="teamContent <?php echo $selectedTab !== 'students' ? 'hidden' : ''; ?>">
                        <div class="container px-4 py-10 h-[80vh] overflow-auto">
                            <div class="w-full flex justify-between pb-10 pr-10 h-[10vh] h-min-[100px] relative">
                                <h1 class="text-2xl font-medium">Students</h1>
                                <button class="px-6 py-2 rounded bg-blue-400 text-white hover:bg-blue-500 fixed top-[20vh] right-20" onclick="openModal('addStudent', 'teamModal')"><i class="fas fa-plus"></i> Add new</button>
                            </div>
                            <div id="studentContainer" class="flex flex-wrap gap-6">
                                <?php
                                if (isset($error) && $selectedTab === 'students') {
                                    echo '<p class="text-red-600 p-4">' . htmlspecialchars($error) . '</p>';
                                } elseif ($selectedTab === 'students') {
                                    if (empty($students)) {
                                        echo '<p class="text-gray-600 p-4">No students found' . ($searchActive ? ' for "' . htmlspecialchars($searchQuery) . '"' : '') . '.</p>';
                                    } else {
                                        foreach ($students as $item) {
                                            echo '
                                            <div id="teamContainer" class="teamContainer shadow-lg w-60 overflow-clip rounded-lg relative">
                                                <label id="id" name="id" class="id hidden">' . htmlspecialchars($item['id']) . '</label>
                                                <label id="email" name="email" class="email hidden">' . htmlspecialchars($item['email']) . '</label>
                                                <label id="privilege" class="privilege hidden">' . htmlspecialchars($item['privilege']) . '</label>
                                                <img src="dashboard_databasemgt/' . htmlspecialchars($item['image_path']) . '" class="image h-60 w-60 object-cover">
                                                <div class="absolute top-3 right-3">
                                                    <button class="text-gray-800 hover:text-black font-bold bg-white rounded-full" onclick="toggleMenu(event)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 p-1" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                                            <circle cx="12" cy="6" r="1.5" />
                                                            <circle cx="12" cy="12" r="1.5" />
                                                            <circle cx="12" cy="18" r="1.5" />
                                                        </svg>
                                                    </button>
                                                    <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                                                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="setEditAction(\'' . htmlspecialchars($item['category']) . '\'); openModalEdit(this); handleMenuClick(event)">Edit</a>
                                                        <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event); deleteMember(this)">Delete</a>
                                                    </div>
                                                </div>
                                                <div class="p-4">
                                                    <div class="flex">
                                                        <h1 class="firstName font-bold mr-2">' . htmlspecialchars($item['first_name']) . '</h1>
                                                        <h1 class="lastName font-bold">' . htmlspecialchars($item['last_name']) . '</h1>
                                                    </div>
                                                    <h1 class="details text-sm text-slate-700">' . htmlspecialchars($item['details']) . '</h1>
                                                </div>
                                            </div>';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Staff Content -->
                    <div id="staff" class="teamContent <?php echo $selectedTab !== 'staff' ? 'hidden' : ''; ?>">
                        <div class="container px-4 py-10 h-[80vh] overflow-auto">
                            <div class="w-full flex justify-between pb-10 pr-10 h-[10vh] h-min-[100px] relative">
                                <h1 class="text-2xl font-medium">Staff</h1>
                                <button class="px-6 py-2 rounded bg-blue-400 text-white hover:bg-blue-500 fixed top-[20vh] right-20" onclick="openModal('addStaff', 'teamModal')"><i class="fas fa-plus"></i> Add new</button>
                            </div>
                            <div id="staffContainer" class="flex flex-wrap gap-6">
                                <?php
                                if (isset($error) && $selectedTab === 'staff') {
                                    echo '<p class="text-red-600 p-4">' . htmlspecialchars($error) . '</p>';
                                } elseif ($selectedTab === 'staff') {
                                    if (empty($staff)) {
                                        echo '<p class="text-gray-600 p-4">No staff found' . ($searchActive ? ' for "' . htmlspecialchars($searchQuery) . '"' : '') . '.</p>';
                                    } else {
                                        foreach ($staff as $item) {
                                            echo '
                                            <div id="teamContainer" class="teamContainer shadow-lg w-60 overflow-clip rounded-lg relative">
                                                <label id="id" name="id" class="id hidden">' . htmlspecialchars($item['id']) . '</label>
                                                <label id="email" name="email" class="email hidden">' . htmlspecialchars($item['email']) . '</label>
                                                <label id="privilege" class="privilege hidden">' . htmlspecialchars($item['privilege']) . '</label>
                                                <img src="dashboard_databasemgt/' . htmlspecialchars($item['image_path']) . '" class="image h-60 w-60 object-cover">
                                                <div class="absolute top-3 right-3">
                                                    <button class="text-gray-800 hover:text-black font-bold bg-white rounded-full" onclick="toggleMenu(event)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 p-1" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                                                            <circle cx="12" cy="6" r="1.5" />
                                                            <circle cx="12" cy="12" r="1.5" />
                                                            <circle cx="12" cy="18" r="1.5" />
                                                        </svg>
                                                    </button>
                                                    <div class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-md z-10">
                                                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200" onclick="setEditAction(\'' . htmlspecialchars($item['category']) . '\'); openModalEdit(this); handleMenuClick(event)">Edit</a>
                                                        <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-200" onclick="handleMenuClick(event); deleteMember(this)">Delete</a>
                                                    </div>
                                                </div>
                                                <div class="p-4">
                                                    <div class="flex">
                                                        <h1 class="firstName font-bold mr-2">' . htmlspecialchars($item['first_name']) . '</h1>
                                                        <h1 class="lastName font-bold">' . htmlspecialchars($item['last_name']) . '</h1>
                                                    </div>
                                                    <h1 class="details text-sm text-slate-700">' . htmlspecialchars($item['details']) . '</h1>
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

    <!-- Modal for Adding/Editing Team Members -->
    <div id="teamModal" class="hidden fixed inset-0 flex items-center justify-center z-20">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg h-[600px] overflow-auto">
            <form id="teamForm" action="dashboard_databasemgt/manage_team.php?action=addStudent" method="POST" enctype="multipart/form-data">
                <div class="moduleTitle mb-4">
                    <label class="block text-gray-700">First name</label>
                    <input type="hidden" name="id" id="id" class="id">
                    <input type="hidden" name="tab" id="tab" value="<?php echo htmlspecialchars($selectedTab); ?>">
                    <input type="text" id="firstName" name="firstName" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="First name" required>
                </div>
                <div class="moduleTitle mb-4">
                    <label class="block text-gray-700">Last name</label>
                    <input type="text" id="lastName" name="lastName" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Last name" required>
                </div>
                <div class="moduleTitle mb-4">
                    <label class="block text-gray-700">Email address</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Email address" required>
                </div>
                <div class="moduleDescription mb-4">
                    <label class="block text-gray-700">Details</label>
                    <textarea id="details" name="details" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Personal details" required></textarea>
                </div>
                <div class="privilege mb-4">
                    <label for="privilege">Privilege</label>
                    <select name="privilege" id="privilege" class="border rounded py-2 px-2">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="moduleImage mb-4">
                    <label class="block text-gray-700">Image</label>
                    <input id="imagefile" type="file" name="image" accept="image/*" onchange="previewImage(this)" class="w-full" required>
                    <img id="imagePreview" src="#" alt="Preview" class="image hidden mt-4 w-full max-h-64 object-cover border rounded">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="px-4 py-2 bg-white border border-blue-500 text-blue-500 rounded-lg" onclick="closeModal('teamModal')">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Confirm</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-20 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Confirm Deletion</h2>
            <p class="text-gray-600 mb-4">Are you sure you want to remove this member?</p>
            <form id="deleteForm" method="POST" action="dashboard_databasemgt/manage_team.php?action=delete">
                <input type="hidden" name="id" id="id">
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

        function deleteMember(button) {
            document.getElementById("overlay").classList.remove("hidden");
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            const card = button.closest('.teamContainer');
            modal.querySelector('#id').value = card.querySelector('.id').textContent;
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
            const modal = document.getElementById('teamModal');
            modal.classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");
            let card = button.closest('.teamContainer');

            modal.querySelector('#firstName').value = card.querySelector('.firstName').textContent;
            modal.querySelector('#lastName').value = card.querySelector('.lastName').textContent;
            modal.querySelector('#email').value = card.querySelector('.email').textContent;
            modal.querySelector('#privilege').value = card.querySelector('.privilege').textContent;
            modal.querySelector('#details').value = card.querySelector('.details').textContent;
            modal.querySelector('#id').value = card.querySelector('.id').textContent;
            modal.querySelector('#imagePreview').src = card.querySelector('.image').getAttribute('src');
            modal.querySelector('#imagePreview').classList.remove('hidden');
            modal.querySelector('#imagefile').removeAttribute('required'); // Image optional for edit
        }

        function setEditAction(category) {
            let action = category === 'student' ? 'editStudent' : 'editStaff';
            document.getElementById('teamForm').action = 'dashboard_databasemgt/manage_team.php?action=' + action;
        }

        function openModal(action, modalID) {
            const modal = document.getElementById(modalID);
            modal.classList.remove("hidden");
            document.getElementById("overlay").classList.remove("hidden");

            // Reset form
            modal.querySelector('#id').value = '';
            modal.querySelector('#firstName').value = '';
            modal.querySelector('#lastName').value = '';
            modal.querySelector('#email').value = '';
            modal.querySelector('#details').value = '';
            modal.querySelector('#privilege').value = 'user';
            modal.querySelector('#imagePreview').src = '';
            modal.querySelector('#imagePreview').classList.add('hidden');
            modal.querySelector('#imagefile').setAttribute('required', 'required');

            document.getElementById('teamForm').action = 'dashboard_databasemgt/manage_team.php?action=' + action;
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
            window.location.href = 'dashboard_team.php?tab=' + activeTab;
        }

        function closeModal(modalID) {
            document.getElementById(modalID).classList.add("hidden");
            document.getElementById('overlay').classList.add("hidden");
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