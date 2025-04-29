<?php
// Include database connection
include 'dashboard_databasemgt/database_connection.php';

try{

// Handle new partner form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_partner'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $date = date("Y-m-d H:i:s");

    $stmt = $pdo->prepare("INSERT INTO partners (name, email, country, city, date) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $country, $city, $date]);
}

}catch(PDOException $e){
  
}

// Fetch all subscribers and partners
try {
    $subscribers = $pdo->query("SELECT * FROM subscribers ORDER BY date DESC")->fetchAll(PDO::FETCH_ASSOC);
    $partners = $pdo->query("SELECT * FROM partners ORDER BY date ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching data: " . $e->getMessage();
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

    <!-- Tabs -->
    <div class="flex space-x-4 border-b mb-4 h-[10vh]">
      <button class="tab-btn text-blue-600 border-b-2 border-blue-600 pb-2 font-medium" onclick="switchTab(event, 'partners')">Partners</button>
      <button class="tab-btn text-gray-600 hover:text-blue-500 pb-2" onclick="switchTab(event, 'subscribers')">Subscribers</button>
    </div>

    <!-- Partners Tab -->
    <div id="partners" class="tab-content h-[70vh] overflow-auto">
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
            <?php foreach ($partners as $partner): ?>
            <tr class="group hover:bg-gray-50 transition" id="partner-row-<?= $partner['id'] ?>">
              <form method="POST" action="dashboard_databasemgt/manage_partner.php">
                <input type="hidden" name="id" value="<?= $partner['id'] ?>">
                <td class="py-2 px-4">
                  <span class="text-display"><?= htmlspecialchars($partner['name']) ?></span>
                  <input type="text" name="name" value="<?= htmlspecialchars($partner['name']) ?>" class="text-input hidden border px-2 py-1 w-full">
                </td>
                <td class="py-2 px-4">
                  <span class="text-display"><?= htmlspecialchars($partner['email']) ?></span>
                  <input type="email" name="email" value="<?= htmlspecialchars($partner['email']) ?>" class="text-input hidden border px-2 py-1 w-full">
                </td>
                <td class="py-2 px-4"><?= htmlspecialchars($partner['country']) ?></td>
                <td class="py-2 px-4"><?= htmlspecialchars($partner['city']) ?></td>
                <td class="py-2 px-4">
                  <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    <button type="button" class="text-blue-600 hover:text-blue-800 edit-btn" onclick="enableEdit(<?= $partner['id'] ?>)" title="Edit">
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
          </tbody>
        </table>
      </div>
    </div>

    <!-- Subscribers Tab -->
    <div id="subscribers" class="tab-content hidden h-[70vh] overflow-auto">
      <h3 class="text-lg font-semibold mb-2">Subscribers</h3>
      <p class="text-gray-600">Manage users who have subscribed to updates from this website.</p>

      <ul class="mt-4 space-y-2">
        <?php foreach ($subscribers as $subscriber): ?>
        <li class="bg-gray-100 p-4 rounded shadow-sm flex justify-between items-center group hover:bg-gray-200 transition">
          <form method="POST" action="dashboard_databasemgt/manage_subscriber.php" class="flex justify-between w-full items-center">
            <div>
              <input type="hidden" name="id" value="<?= htmlspecialchars($subscriber['id']) ?>">
              <p class="font-medium"><?= htmlspecialchars($subscriber['name']) ?></p>
              <p class="text-sm text-gray-500"><?= htmlspecialchars($subscriber['email']) ?></p>
            </div>
            <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
              <button type="submit" name="action" value="unsubscribe" class="text-red-500 hover:text-red-700" title="Unsubscribe" onclick="return confirm('Unsubscribe this user?');">
                <i class="fas fa-times-circle"></i>
              </button>
            </div>
          </form>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>

  </div>
</div>

<!-- Modal for Adding New Partner -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden">
  <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg relative">
    <h2 class="text-xl font-bold mb-4">Add New Partner</h2>
    <form method="POST">
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
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.getElementById(tabId).classList.remove('hidden');

    document.querySelectorAll('.tab-btn').forEach(el => {
      el.classList.remove('text-blue-600', 'border-blue-600', 'border-b-2', 'font-medium');
      el.classList.add('text-gray-600');
    });

    event.target.classList.add('text-blue-600', 'border-blue-600', 'border-b-2', 'font-medium');
    event.target.classList.remove('text-gray-600');
  }

  function enableEdit(id) {
    const row = document.getElementById(`partner-row-${id}`);
    row.querySelectorAll('.text-display').forEach(el => el.classList.add('hidden'));
    row.querySelectorAll('.text-input').forEach(el => el.classList.remove('hidden'));
    row.querySelector('.edit-btn').classList.add('hidden');
    row.querySelector('.save-btn').classList.remove('hidden');
  }
</script>

</body>
</html>
