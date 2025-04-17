
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/7a97402827.js" crossorigin="anonymous"></script>

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
    function makeEditable(id, btnId) {
      const elem = document.getElementById(id);
      const btn = document.getElementById(btnId);
      if (elem.isContentEditable) {
        elem.contentEditable = false;
        btn.textContent = 'Edit';
      } else {
        elem.contentEditable = true;
        btn.textContent = 'Save';

        // Move cursor to the end without selecting text
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
<form action="dashboard_databasemgt.php">

<main class="w-full mx-auto mt-8 bg-white p-6 rounded-lg shadow space-y-10">

    <!-- Company Overview -->
    <section class="space-y-2 ">
      <h2 class="text-xl font-semibold text-gray-800">Company Overview</h2>
      <div class="flex items-start justify-between border rounded bg-gray-50 p-3 editable-container">
        <div id="overview" name="overview" class="editable-text w-full max-w-4xl">Learn more about the diverse research groups conducting pioneering research in all areas of artificial intelligence including: Biomedicine and Health, Computational Cognitive & Neuro-science, Computational Education, Computer Vision, Empirical Machine Learning, Human-Centered and Creative AI, Natural Language Processing and Speech, Reinforcement Learning, and Statistical or Theoretical Machine Learning, in addition to blockchain Technologies</div>
        <button type="submit" id="btnOverview" onclick="makeEditable('overview', 'btnOverview')" class="text-blue-600 hover:underline ml-3 edit-button">Edit</button>
      </div>
    </section>

    <!-- Contact Information -->
    <section class="space-y-4">
      <h2 class="text-xl font-semibold text-gray-800">Contact Information</h2>

      <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <div class="flex items-start justify-between border rounded bg-gray-50 p-3 editable-container">
          <div id="email"  class="flex-1 editable-text">info@company.com</div>
          <button  type="submit" id="btnEmail" onclick="makeEditable('email', 'btnEmail')" class="text-blue-600 hover:underline ml-3 edit-button">Edit</button>
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Phone</label>
        <div class="flex items-start justify-between border rounded bg-gray-50 p-3 editable-container">
          <div id="phone" class="flex-1 editable-text">+1234567890</div>
          <button type="submit" id="btnPhone" onclick="makeEditable('phone', 'btnPhone')" class="text-blue-600 hover:underline ml-3 edit-button">Edit</button>
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Address</label>
        <div class="flex items-start justify-between border rounded bg-gray-50 p-3 editable-container">
          <div id="address" class="flex-1 editable-text">123 Main Street, City, Country</div>
          <button type="submit" id="btnAddress" onclick="makeEditable('address', 'btnAddress')" class="text-blue-600 hover:underline ml-3 edit-button">Edit</button>
        </div>
      </div>
    </section>

    <!-- Company History -->
    <section class="space-y-2">
      <h2 class="text-xl font-semibold text-gray-800">Company History</h2>
      <div class="flex items-start justify-between border rounded bg-gray-50 p-3 editable-container">
        <div id="history" class="w-full max-w-4xl editable-text">Sure-Tech founded in 2024, by Dr. Ann Move Oguti, continues to be a rich, intellectual and stimulating academic environment. Through multidisciplinary and multi-faculty collaborations, Sure-Tech promotes new discoveries and explores new ways to enhance human-robot interactions through AI; all while developing the next generation of researchers. Our staff of dedicated professionals provide support to our academic and research groups, functioning as Sure-Tech’s backbone. Sure-Tech staff support helps our researchers, visiting scholars and students to advance new discoveries and innovation. All these groups working together add to the depth and breadth of our cutting-edge research.</div>
        <button type="submit" id="btnHistory" onclick="makeEditable('history', 'btnHistory')" class="text-blue-600 hover:underline ml-3 edit-button">Edit</button>
      </div>
    </section>

  </main>

</form>
        </div>


    </div>
</div>

  
</body>
</html>