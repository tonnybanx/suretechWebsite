<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- navigationbar -->
   <?php include 'navigationbar.php'; ?>

    <!--background hexagons  -->
    <section class="overflow-hidden">
      <div
        class="hexagon bg-slate-50 h-[600px] w-[500px] absolute top-24 left-0 -z-20 overflow-clip"
      ></div>
      <div
        class="hexagon bg-red-50 h-[800px] w-[700px] absolute top-[300px] right-0 -z-10 opacity-80 overflow-clip"
      ></div>
      <div class="hexagon h-52 w-52 bg-slate-100 absolute top-40 right-[240px] -z-10"></div>
    </section > 
    
    <!-- brief introduction to History -->
     <section class="lg:pl-52 pl-10 pr-10 flex flex-wrap lg:h-[130vh] mb-20">
    <div class="lg:w-5/12 w-full mt-40">
        <h1 class="text-3xl text-black font-bold ">History</h1>
        <p class="pr-10">Sure-Tech founded in 2024, by Dr. Ann Move Oguti, continues to be a rich, intellectual and stimulating academic environment. Through multidisciplinary and multi-faculty collaborations, Sure-Tech promotes new discoveries and explores new ways to enhance human-robot interactions through AI; all while developing the next generation of researchers. Our staff of dedicated professionals provide support to our academic and research groups, functioning as Sure-Tech’s backbone. Sure-Tech staff support helps our researchers, visiting scholars and students to advance new discoveries and innovation. All these groups working together add to the depth and breadth of our cutting-edge research.</p>
       <!--  <iframe class="w-full h-[300px] object-cover pt-4" 
  src="https://www.youtube.com/watch?v=SKaxq9REw5I" 
  frameborder="0" 
  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
  allowfullscreen>
</iframe> -->


     </div>
     <!-- hexagons and images -->
     <div >
         
     <div class="mt-40 overflow-clip flex flex-wrap">
     <div class="hexagon bg-blue-100 lg:h-[500px] lg:w-[400px] lg:absolute lg:top-40 lg:left-[800px] w-[40vw] h-[40vw]">
        <img src="images\shimon.jpg" class="bg-cover object-cover lg:h-[500px] lg:w-[400px] w-[40vw] h-[40vw]">
     </div>
      <div class="hexagon bg-blue-100 lg:h-[300px] lg:w-[300px] lg:absolute lg:top-[316px] lg:left-[1220px] w-[30vw] h-[30vw]">
        <img src="images/kato.jpg" class="lg:h-[300px] w-[300px]">
      </div>
      <div class="hexagon  lg:h-52 lg:w-52 bg-slate-100 lg:absolute lg:top-[560px] lg:left-[1100px] w-[20vw] h-[20vw]">
        <img src="images/anthony.jpg" class="lg:h-52 lg:w-52 h-[20vw] w-[20vw]">
      </div>
     </div>
        
     </div>


     </section>

     
   <?php include 'footer.php'; ?>

</body>
</html>