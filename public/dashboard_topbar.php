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

// Fetch admin profile image
$adminId = $_SESSION['admin_id']; // Make sure this is set when logging in
$stmt = $pdo->prepare("SELECT image_path FROM admin WHERE id = ?");
$stmt->execute([$adminId]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Set profile image path or fallback to default
$profileImage = $admin && !empty($admin['image_path'])
    ? htmlspecialchars($admin['image_path'])
    : 'dashboard_databasemgt/images/profile_pic.webp';

// Get current page and tab
$currentPage = basename($_SERVER['PHP_SELF']);
$currentTab = isset($_GET['tab']) ? htmlspecialchars($_GET['tab']) : '';

// Define valid tabs for each page
$validTabs = [
    'dashboard_research.php' => ['areas', 'projects', 'publications'],
    'dashboard_events.php' => ['hackathrons', 'conferences','news'],
    'dashboard_team.php' => ['students', 'staff'],
    'dashboard_engagements.php' => ['partners', 'subscribers'],
    'dashboard_about.php' => [], // No tabs
    'dashboard_home.php' => [], // No tabs
    'dashboard_settings.php' => [] // No tabs
];

// Set default tab for pages with tabs
$defaultTabs = [
    'dashboard_research.php' => 'areas',
    'dashboard_events.php' => 'hackathrons',
    'dashboard_team.php' => 'students',
    'dashboard_engagements.php' => 'partners'
];

// Validate tab
if (isset($validTabs[$currentPage]) && !empty($validTabs[$currentPage])) {
    if (!in_array($currentTab, $validTabs[$currentPage])) {
        $currentTab = $defaultTabs[$currentPage] ?? '';
    }
} else {
    $currentTab = ''; // No tabs for this page
}

// Determine if search is enabled
$searchEnabled = !in_array($currentPage, ['dashboard_home.php', 'dashboard_settings.php']);

// Get search query
$searchQuery = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '';
?>

<!-- Top Bar -->
<div class="justify-between items-center flex flex-row pl-2 pr-10 pt-4 w-full">
    <!-- Search Bar -->
    <div class="flex">
        <div>
            <button onclick="toggleSidebar()" class="rounded pl-4 hidden" id="togglebutton2">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="pl-10">
            <?php if ($searchEnabled): ?>
                <form action="<?php echo htmlspecialchars($currentPage); ?>" method="GET" class="flex items-center">
                    <?php if (!empty($currentTab)): ?>
                        <input type="hidden" name="tab" value="<?php echo htmlspecialchars($currentTab); ?>">
                    <?php endif; ?>
                    <input type="text" name="search" placeholder="Search" value="<?php echo $searchQuery; ?>" class="w-[50vw] p-2 border rounded-lg" id="searchInput">
                    <button type="submit" class="ml-2 p-2 rounded"><i class="fas fa-search"></i></button>
                    <?php if ($searchQuery): ?>
                        <button type="button" onclick="clearSearch()" class="ml-2 p-2 rounded text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></button>
                    <?php endif; ?>
                </form>
            <?php else: ?>
                <input type="text" placeholder="Search not available" class="w-[50vw] p-2 border rounded-lg bg-white" disabled>
                <button class="ml-2 p-2 rounded" disabled><i class="fas fa-search"></i></button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Notification & Profile -->
    <div class="flex items-center space-x-4 ml-4">
        <a href="index.php"><i class="fas fa-home"></i></a>
        <button id="notificationBell" class="p-2 rounded hover:bg-gray-100"><i class="fas fa-bell"></i></button>
        <img src="<?= $profileImage ?>" alt="Profile" class="w-10 h-10 rounded-full object-cover">
    </div>
</div>

<!-- Notification Popup Modal -->
<div id="notificationModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-60 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-[90%] max-w-[900px] max-h-[80vh] overflow-y-auto modal-content relative">
        <!-- Close Button -->
        <button id="closeNotificationModal" class="fixed top-4 right-4 text-gray-500 hover:text-red-600 transition-colors duration-200 z-20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <!-- Modal Content -->
        <div>
            <!-- Fixed Header -->
            <div class="sticky top-0 bg-white z-10 px-8 py-6 mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Notifications</h3>
            </div>
            <!-- Scrollable Messages -->
            <div class="px-8 pb-6">
                <div id="messagesContainer">
                    <!-- Messages will be loaded here via JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .modal-content {
        animation: modalFadeIn 0.3s ease-out;
    }

    .backdrop-blur-sm {
        backdrop-filter: blur(8px);
    }
</style>

<script>
// Function to fetch and display messages
function loadMessages() {
    fetch('dashboard_databasemgt/fetch_messages.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('messagesContainer');
            if (data.success && data.messages.length > 0) {
                container.innerHTML = `
                    <div class="space-y-4">
                        ${data.messages.map(message => `
                            <div class="group border rounded-lg p-4 flex justify-between items-start bg-gray-50 hover:bg-gray-100 transition w-full">
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600"><strong>Email:</strong> ${message.email}</p>
                                    <p class="text-gray-700 mt-1">${message.message}</p>
                                    <p class="text-sm text-gray-500 mt-1"><strong>Date:</strong> ${message.date}</p>
                                </div>
                                <button onclick="deleteMessage(${message.id})" class="text-blue-500 hover:text-blue-700 hidden group-hover:block">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `).join('')}
                    </div>
                `;
            } else {
                container.innerHTML = '<p class="text-gray-600">No messages found.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
            document.getElementById('messagesContainer').innerHTML = '<p class="text-red-600">Error loading messages.</p>';
        });
}

// Function to delete a message
function deleteMessage(messageId) {
    if (confirm('Are you sure you want to delete this message?')) {
        fetch('dashboard_databasemgt/delete_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${messageId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadMessages(); // Refresh messages
            } else {
                alert('Error deleting message: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error deleting message:', error);
            alert('Error deleting message.');
        });
    }
}

// Event listeners for notification bell and modal
document.getElementById('notificationBell').addEventListener('click', () => {
    document.getElementById('notificationModal').classList.remove('hidden');
    document.getElementById('notificationModal').classList.add('flex');
    loadMessages(); // Load messages when modal is opened
});

document.getElementById('closeNotificationModal').addEventListener('click', () => {
    document.getElementById('notificationModal').classList.remove('flex');
    document.getElementById('notificationModal').classList.add('hidden');
});

document.getElementById('notificationModal').addEventListener('click', (e) => {
    if (e.target === document.getElementById('notificationModal')) {
        document.getElementById('notificationModal').classList.remove('flex');
        document.getElementById('notificationModal').classList.add('hidden');
    }
});

function clearSearch() {
    const input = document.getElementById('searchInput');
    input.value = '';
    // Redirect to the current page with tab (if applicable)
    const url = '<?php echo htmlspecialchars($currentPage); ?>' +
                '<?php echo !empty($currentTab) ? '?tab=' . urlencode($currentTab) : ''; ?>';
    window.location.href = url;
}
</script>