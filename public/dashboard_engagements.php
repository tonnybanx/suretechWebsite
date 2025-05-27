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

// Determine the selected tab from query parameter or default to 'partners'
$selectedTab = isset($_GET['tab']) ? $_GET['tab'] : 'partners';
$validTabs = ['partners', 'subscribers'];
if (!in_array($selectedTab, $validTabs)) {
    $selectedTab = 'partners';
}

// Get search query
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchActive = !empty($searchQuery);

// Handle new partner form submission
try {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_partner'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $country = trim($_POST['country']);
        $city = trim($_POST['city']);
        $date = date("Y-m-d H:i:s");

        if (empty($name) || empty($email) || empty($country) || empty($city)) {
            $error = "All fields are required.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO partners (name, email, country, city, date) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $country, $city, $date]);
            header("Location: dashboard_engagements.php?tab=partners&message=Partner added successfully&status=success");
            exit;
        }
    }
} catch (PDOException $e) {
    $error = "Error adding partner: " . $e->getMessage();
}

// Fetch subscribers and partners with search filtering
try {
    // Fetch partners
    $partnerSql = "SELECT * FROM partners";
    if ($searchActive) {
        $partnerSql .= " WHERE name LIKE ? OR email LIKE ? OR country LIKE ? OR city LIKE ?";
    }
    $partnerSql .= " ORDER BY date ASC";
    $stmt = $pdo->prepare($partnerSql);
    if ($searchActive) {
        $searchParam = '%' . $searchQuery . '%';
        $stmt->execute([$searchParam, $searchParam, $searchParam, $searchParam]);
    } else {
        $stmt->execute();
    }
    $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch subscribers
    $subscriberSql = "SELECT * FROM subscribers";
    if ($searchActive) {
        $subscriberSql .= " WHERE name LIKE ? OR email LIKE ?";
    }
    $subscriberSql .= " ORDER BY date DESC";
    $stmt = $pdo->prepare($subscriberSql);
    if ($searchActive) {
        $searchParam = '%' . $searchQuery . '%';
        $stmt->execute([$searchParam, $searchParam]);
    } else {
        $stmt->execute();
    }
    $subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching data: " . $e->getMessage();
    $partners = [];
    $subscribers = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Engagements</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/7a97402827.js" crossorigin="anonymous"></script>
</head>
<body class="bg-white flex h-full w-full">
    <?php include 'dashboard_sidebar.php'; ?>
    <div class="flex-1">
        <?php include 'dashboard_topbar.php'; ?>
        <div class="w-full mx-auto p-6 mt-10 bg-white h-[80vh]">
            <!-- Display Messages or Errors -->
            <?php if (isset($_GET['message'])): ?>
                <div class="p-4 mb-4 <?php echo $_GET['status'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?> rounded">
                    <?php echo htmlspecialchars($_GET['message']); ?>
                </div>
            <?php elseif (isset($error)): ?>
                <div class="p-4 mb-4 bg-red-100 text-red-700 rounded">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Search Info -->
            <?php if ($searchActive): ?>
                <div class="w-full mb-4">
                    <p class="text-gray-700">Showing results for "<strong><?php echo htmlspecialchars($searchQuery); ?></strong>"</p>
                    <a href="dashboard_engagements.php?tab=<?php echo urlencode($selectedTab); ?>" class="text-blue-500 hover:underline">Clear Search</a>
                </div>
            <?php endif; ?>

            <!-- Tabs -->
            <div class="flex space-x-4 border-b mb-4 h-[10vh]">
                <button class="tab-btn <?php echo $selectedTab === 'partners' ? 'text-blue-600 border-b-2 border-blue-600 font-medium' : 'text-gray-600 hover:text-blue-500'; ?> pb-2" onclick="switchTab(event, 'partners')">Partners</button>
                <button class="tab-btn <?php echo $selectedTab === 'subscribers' ? 'text-blue-600 border-b-2 border-blue-600 font-medium' : 'text-gray-600 hover:text-blue-500'; ?> pb-2" onclick="switchTab(event, 'subscribers')">Subscribers</button>
            </div>

            <!-- Partners Tab -->
            <div id="partners" class="tab-content <?php echo $selectedTab !== 'partners' ? 'hidden' : ''; ?> h-[70vh] overflow-auto">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-semibold">Partners</h3>
                        <p class="text-gray-600 text-sm">Manage your partner organizations or collaborators.</p>
                    </div>
                    <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        + Add Partner
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white shadow rounded">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-left text-sm">
                                <th class="py-2 px-4">Name</th>
                                <th class="py-2 px-4">Email</th>
                                <th class="py-2 px-4">Country</th>
                                <th class="py-2 px-4">City</th>
                                <th class="py-2 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($partners)): ?>
                                <tr>
                                    <td colspan="5" class="py-4 px-4 text-gray-600 text-center">
                                        No partners found<?php echo $searchActive ? ' for "' . htmlspecialchars($searchQuery) . '"' : ''; ?>.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($partners as $partner): ?>
                                    <tr class="group hover:bg-gray-50 transition" id="partner-row-<?= htmlspecialchars($partner['id']) ?>">
                                        <form method="POST" action="dashboard_databasemgt/manage_partner.php">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($partner['id']) ?>">
                                            <input type="hidden" name="tab" value="<?php echo htmlspecialchars($selectedTab); ?>">
                                            <td class="py-2 px-4">
                                                <span class="text-display"><?php echo htmlspecialchars($partner['name']); ?></span>
                                                <input type="text" name="name" value="<?php echo htmlspecialchars($partner['name']); ?>" class="text-input hidden border px-2 py-1 w-full">
                                            </td>
                                            <td class="py-2 px-4">
                                                <span class="text-display"><?php echo htmlspecialchars($partner['email']); ?></span>
                                                <input type="email" name="email" value="<?php echo htmlspecialchars($partner['email']); ?>" class="text-input hidden border px-2 py-1 w-full">
                                            </td>
                                            <td class="py-2 px-4"><?php echo htmlspecialchars($partner['country']); ?></td>
                                            <td class="py-2 px-4"><?php echo htmlspecialchars($partner['city']); ?></td>
                                            <td class="py-2 px-4">
                                                <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                    <button type="button" class="text-blue-600 hover:text-blue-800 edit-btn" onclick="enableEdit(<?php echo htmlspecialchars($partner['id']); ?>)" title="Edit">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                    <button type="submit" name="action" value="edit" class="text-green-600 hover:text-green-800 save-btn hidden" title="Save">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="submit" name="action" value="delete" class="text-red-600 hover:text-red-800" title="Delete" onclick="return confirm('Are you sure you want to delete this partner?');">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </form>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Subscribers Tab -->
            <div id="subscribers" class="tab-content <?php echo $selectedTab !== 'subscribers' ? 'hidden' : ''; ?> h-[70vh] overflow-auto">
                <h3 class="text-lg font-semibold mb-2">Subscribers</h3>
                <p class="text-gray-600">Manage users who have subscribed to updates from this website.</p>
                <ul class="mt-4 space-y-2">
                    <?php if (empty($subscribers)): ?>
                        <li class="bg-gray-100 p-4 rounded shadow-sm text-gray-600">
                            No subscribers found<?php echo $searchActive ? ' for "' . htmlspecialchars($searchQuery) . '"' : ''; ?>.
                        </li>
                    <?php else: ?>
                        <?php foreach ($subscribers as $subscriber): ?>
                            <li class="bg-gray-100 p-4 rounded shadow-sm flex justify-between items-center group hover:bg-gray-200 transition">
                                <form method="POST" action="dashboard_databasemgt/manage_subscriber.php" class="flex justify-between w-full items-center">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($subscriber['id']); ?>">
                                    <input type="hidden" name="tab" value="<?php echo htmlspecialchars($selectedTab); ?>">
                                    <div>
                                        <p class="font-medium"><?php echo htmlspecialchars($subscriber['name']); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo htmlspecialchars($subscriber['email']); ?></p>
                                    </div>
                                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <button type="submit" name="action" value="unsubscribe" class="text-red-500 hover:text-red-700" title="Unsubscribe" onclick="return confirm('Unsubscribe this user?');">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </div>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal for Adding New Partner -->
    <div id="addModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg relative">
            <h2 class="text-xl font-bold mb-4">Add New Partner</h2>
            <form method="POST">
                <input type="hidden" name="tab" value="<?php echo htmlspecialchars($selectedTab); ?>">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input name="name" required class="border p-2 w-full rounded" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input name="email" type="email" required class="border p-2 w-full rounded" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Country</label>
                        <input name="country" required class="border p-2 w-full rounded" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">City</label>
                        <input name="city" required class="border p-2 w-full rounded" />
                    </div>
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="bg-white border border-blue-500 text-blue-400 px-4 py-2 rounded hover:bg-blue-500 hover:text-white">Cancel</button>
                    <button type="submit" name="add_partner" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function switchTab(event, tabId) {
            // Preserve search query
            const searchParams = new URLSearchParams(window.location.search);
            const searchQuery = searchParams.get('search') || '';
            const url = `dashboard_engagements.php?tab=${tabId}${searchQuery ? '&search=' + encodeURIComponent(searchQuery) : ''}`;
            window.location.href = url;
        }

        function enableEdit(id) {
            const row = document.getElementById(`partner-row-${id}`);
            row.querySelectorAll('.text-display').forEach(el => el.classList.add('hidden'));
            row.querySelectorAll('.text-input').forEach(el => el.classList.remove('hidden'));
            row.querySelector('.edit-btn').classList.add('hidden');
            row.querySelector('.save-btn').classList.remove('hidden');
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