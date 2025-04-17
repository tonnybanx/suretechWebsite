<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

   <?php include 'navigationbar.php'; ?>
    <!-- Research projects -->
    <section class="z-10 lg:ml-52 mt-40 ml-10 min-h-[80vh]">
      <h1 class="font-bold text-3xl pb-4">Research projects</h1>
      <div class="flex flex-col lg:flex-row">
        <div class="bg-white lg:w-1/3 w-full rounded-xl shadow-md border p-4 mr-10 mb-10  justify-center align-middle flex flex-col max-w-[700px]">
          <img src="images/developer-8829711_640.jpg" class="h-60"/>
        <a href="" class="text-blue-500 hover:underline m-auto">Mental health awareness system</a>
        <p class="text-sm">This is a mental health awareness application with a chatbot. It provides other services to the viewer such as medicine and videos to improve on the users moods...</p>
        </div>
        <div class="bg-white lg:w-1/3 w-full rounded-xl shadow-md border p-4 mr-10 mb-10  justify-center align-middle flex flex-col max-w-[700px]">
          <img src="images/networking2.jpg" class="h-60"/>
        <a href="" class="text-blue-500 hover:underline m-auto">E-voting system</a>
        <p class="text-sm">This is a  secure online voting system for soroti university that uses blockchain technology to ensure that voting if free and fair</p>
        </div>
        <div class="bg-white lg:w-1/3 w-full rounded-xl shadow-md border p-4 mr-10 mb-10  justify-center align-middle flex flex-col max-w-[700px]">
          <img src="images/programmer.jpg" class="h-60"/>
        <a href="" class="text-blue-500 hover:underline m-auto">Intrusion detection system using machinne learning</a>
        <p class="text-sm">A machine learning based system for that classifies anomalies in the system and send a notification the system administrator or takes other necessary actions to mitigate the intrusion</p>
        </div>
        
        
        
        </div>
      </div>
    </section>
<?php include 'footer.php'; ?>
</body>
</html>