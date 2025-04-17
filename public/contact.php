<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="flex items-center min-h-screen bg-cover bg-center relative" style="background-image: url('images/soroti_building2.jpeg');">
    <!-- navigation bar -->
     <?php include 'navigationbar.php'; ?>
    <!-- Background Blur Overlay -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-md"></div>

    <!-- Contact Section -->
    <div class="relative z-10 flex flex-col md:flex-row rounded-lg max-w-[1500px] w-full p-10 lg:p-0">
        
        <!-- Left: Contact Info -->
        <div class="md:w-1/2 text-white  py-10 lg:ml-52">
            <h2 class="text-3xl font-bold mb-4">Contact Us</h2>
            <p class="mb-6 mr-10">Have any questions, feedback, or need assistance? We’re always here to help! Feel free to reach out to us for any inquiries, support, or collaboration opportunities. We look forward to hearing from you and assisting in any way we can!</p>
            
            <div class="space-y-6">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white/20 flex items-center justify-center rounded-full">
                        📍
                    </div>
                    <p>Soroti university, Arapai</p>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white/20 flex items-center justify-center rounded-full">
                        📞
                    </div>
                    <p>+256 784995060</p>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-white/20 flex items-center justify-center rounded-full">
                        📧
                    </div>
                    <p>annmoveoguti@sun.ac.ug</p>
                </div>
            </div>
        </div>

        <!-- Right: Contact Form -->
        <div class="md:w-1/2 bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold mb-4">Send Message</h3>
            <form>
                <div class="mb-4">
                    <input type="text" placeholder="Full Name" class="w-full p-3 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <input type="email" placeholder="Email" class="w-full p-3 border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <textarea placeholder="Type your message..." class="w-full p-3 border border-gray-300 rounded"></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                    Send
                </button>
            </form>
        </div>

    </div>

</body>
</html>
