<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sample form document</title>
    <link rel="stylesheet" href="..\style.css">
</head>
<body class="w-full flex justify-center  items-center">
   <form action="formhandler.php" class="border border-red-50 border-t-2 w-1/2 p-10 max-w-[500px]">
    <h6 class="text-3xl font-bold mb-10">Delete Database Data</h6>

    <div class="mb-10">
    <label for="username" name="username" id="username">Username</label>
    <input type="text" name="username" id="username" class="px-2 ml-4 rounded-md h-10 border border-black">
    </div>
<!-- this is the password field -->

    <div class="mb-10">
    <label for="password">Password</label>
    <input type="password" class="border border-black rounded-md h-10 ml-4 px-2" name="password" id="password">
    </div>
    <button class="px-4 py-2 bg-blue-500 text-white text-lg rounded-md">submit</button>

    
   </form> 
</body>
</html>