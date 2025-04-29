<?php
include 'dashboard_databasemgt/database_connection.php';

// Fetch company data (assuming a single row)
try{
$stmt = $pdo->query("SELECT * FROM about LIMIT 1");
$company = $stmt->fetch(PDO::FETCH_ASSOC);
}
catch(PDOException $e){
  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Company Profile</title>
  <script src="https://kit.fontawesome.com/7a97402827.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css" />

  <style>
    .edit-button {
      opacity: 0;
      transition: opacity 0.3s;
    }
    .editable-container:hover .edit-button {
      opacity: 1;
    }
    .editable-text {
      white-space: pre-wrap;
      word-break: break-word;
    }
  </style>

  <script>
    function makeEditable(id, btnId, event) {
      event.preventDefault(); // prevent form from submitting by default

      const elem = document.getElementById(id);
      const btn = document.getElementById(btnId);
      const form = elem.closest('form');

      if (elem.isContentEditable) {
        elem.contentEditable = false;
        btn.textContent = 'Edit';

        // Update hidden input with edited content
        const inputId = btn.getAttribute('data-input');
        document.getElementById(inputId).value = elem.innerText.trim();

        form.submit(); // submit only on Save
      } else {
        elem.contentEditable = true;
        btn.textContent = 'Save';

        // Move cursor to end of text
        const range = document.createRange();
        const sel = window.getSelection();
        range.selectNodeContents(elem);
        range.collapse(false);
        sel.removeAllRanges();
        sel.addRange(range);
        elem.focus();
      }
    }
  </script>
</head>
<body>
  <div class="flex h-full">
    <?php include 'dashboard_sidebar.php'; ?>
    <div class="flex-grow">
      <?php include 'dashboard_topbar.php'; ?>

      <div class="p-10 h-[90vh] overflow-auto mt-4">
        <main class="w-full mx-auto mt-8 bg-white p-6 rounded-lg shadow space-y-10">

          <!-- Company Name -->
          <section class="space-y-2">
            <h2 class="text-xl font-semibold text-gray-800">Company Name</h2>
            <form method="POST" action="dashboard_databasemgt/update_company.php">
              <input type="hidden" name="field" value="name" />
              <input type="hidden" name="value" id="nameInput" />
              <div class="flex items-start justify-between border rounded bg-gray-50 p-3 editable-container">
                <div id="name" class="editable-text w-full max-w-4xl"><?= htmlspecialchars($company['name']) ?></div>
                <button type="button" id="btnName" data-input="nameInput" onclick="makeEditable('name', 'btnName', event)" class="text-blue-600 hover:underline ml-3 edit-button">Edit</button>
              </div>
            </form>
          </section>

          <!-- Company Overview -->
          <section class="space-y-2">
            <h2 class="text-xl font-semibold text-gray-800">Company Overview</h2>
            <form method="POST" action="dashboard_databasemgt/update_company.php">
              <input type="hidden" name="field" value="overview" />
              <input type="hidden" name="value" id="overviewInput" />
              <div class="flex items-start justify-between border rounded bg-gray-50 p-3 editable-container">
                <div id="overview" class="editable-text w-full max-w-4xl"><?= htmlspecialchars($company['overview']) ?></div>
                <button type="button" id="btnOverview" data-input="overviewInput" onclick="makeEditable('overview', 'btnOverview', event)" class="text-blue-600 hover:underline ml-3 edit-button">Edit</button>
              </div>
            </form>
          </section>

          <!-- Contact Information -->
          <section class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-800">Contact Information</h2>

            <!-- Email -->
            <form method="POST" action="dashboard_databasemgt/update_company.php">
              <input type="hidden" name="field" value="email" />
              <input type="hidden" name="value" id="emailInput" />
              <label class="block text-sm font-medium text-gray-700">Email</label>
              <div class="flex items-start justify-between border rounded bg-gray-50 p-3 editable-container">
                <div id="email" class="editable-text flex-1"><?= htmlspecialchars($company['email']) ?></div>
                <button type="button" id="btnEmail" data-input="emailInput" onclick="makeEditable('email', 'btnEmail', event)" class="text-blue-600 hover:underline ml-3 edit-button">Edit</button>
              </div>
            </form>

            <!-- Phone -->
            <form method="POST" action="dashboard_databasemgt/update_company.php">
              <input type="hidden" name="field" value="telephone" />
              <input type="hidden" name="value" id="phoneInput" />
              <label class="block text-sm font-medium text-gray-700">Phone</label>
              <div class="flex items-start justify-between border rounded bg-gray-50 p-3 editable-container">
                <div id="phone" class="editable-text flex-1"><?= htmlspecialchars($company['telephone']) ?></div>
                <button type="button" id="btnPhone" data-input="phoneInput" onclick="makeEditable('phone', 'btnPhone', event)" class="text-blue-600 hover:underline ml-3 edit-button">Edit</button>
              </div>
            </form>

            <!-- Address / Location -->
            <form method="POST" action="dashboard_databasemgt/update_company.php">
              <input type="hidden" name="field" value="location" />
              <input type="hidden" name="value" id="addressInput" />
              <label class="block text-sm font-medium text-gray-700">Address</label>
              <div class="flex items-start justify-between border rounded bg-gray-50 p-3 editable-container">
                <div id="address" class="editable-text flex-1"><?= htmlspecialchars($company['location']) ?></div>
                <button type="button" id="btnAddress" data-input="addressInput" onclick="makeEditable('address', 'btnAddress', event)" class="text-blue-600 hover:underline ml-3 edit-button">Edit</button>
              </div>
            </form>
          </section>

          <!-- Company History -->
          <section class="space-y-2">
            <h2 class="text-xl font-semibold text-gray-800">Company History</h2>
            <form method="POST" action="dashboard_databasemgt/update_company.php">
              <input type="hidden" name="field" value="history" />
              <input type="hidden" name="value" id="historyInput" />
              <div class="flex items-start justify-between border rounded bg-gray-50 p-3 editable-container">
                <div id="history" class="editable-text w-full max-w-4xl"><?= htmlspecialchars($company['history']) ?></div>
                <button type="button" id="btnHistory" data-input="historyInput" onclick="makeEditable('history', 'btnHistory', event)" class="text-blue-600 hover:underline ml-3 edit-button">Edit</button>
              </div>
            </form>
          </section>

        </main>
      </div>
    </div>
  </div>
</body>
</html>
