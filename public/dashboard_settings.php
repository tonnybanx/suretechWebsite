
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/7a97402827.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class="flex h-full">
        <?php include 'dashboard_sidebar.php'; ?>
       <div class="flex-grow">
        <?php include 'dashboard_topbar.php'; ?>
       <div class="p-6 max-w-6xl w-full ">

<div class="w-full px-6" >
        <h1 class=" text-xl font-medium">Account settings</h1>
        
        <div class="flex items-center space-x-4 mb-6 mt-4 relative">
            <img id="profile-pic" src="images/anthony.jpg" alt="Profile Picture" class="w-[100px] h-[100px] rounded-full object-cover">
            <i class="fas fa-camera fa-2x text-blue-400 text-inherit"></i>
            
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">First name</label>
                <input type="text" class="w-full p-2 border rounded" value="Tonny Brian">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Last name</label>
                <input type="text" class="w-full p-2 border rounded" value="Putra">
            </div>
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Current position</label>
                <input type="text" class="w-full p-2 border rounded" value="Interaction Designer at GoPay">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Location</label>
            <div class="flex items-center space-x-2">
                
                <input type="text" class="w-full p-2 border rounded" value="Soroti, Uganda">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea class="w-full p-2 border rounded h-24">A software engineer at soroti university</textarea>
        </div>

        <div class="flex justify-start space-x-4">
            <button class="border border-blue-500 text-black px-6 py-2 rounded hover:bg-blue-500 hover:text-white">Cancel</button>
            <button class="bg-blue-400 text-white px-6 py-2 rounded hover:bg-blue-500">Update</button>
        </div>
    </div>
       </div>

    </div>
</div>


</body>
</html>