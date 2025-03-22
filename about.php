<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    
    <!-- ✅ Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ✅ FontAwesome (Now Fixed) -->
    <!-- FontAwesome (Free Version) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" crossorigin="anonymous"></script>

</head>
<body class="bg-gray-100">

    <!-- ✅ Navbar -->
    <nav class="bg-gray-800 p-4 text-white shadow-md">
        <div class="max-w-4xl mx-auto flex items-center">
            <!-- ✅ Back Button (Left Side) -->
            <a href="javascript:history.back()" class="text-xl mr-4">
                <i class="fas fa-arrow-left"></i> <!-- ✅ Now Icon is Visible -->
            </a>
            <h2 class="text-lg font-semibold">About Us</h2>
        </div>
    </nav>

    <!-- ✅ About Section -->
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6 flex flex-col md:flex-row">
        
        <!-- ✅ Developer Image (Left) -->
        <div class="w-full md:w-1/3 flex justify-center md:justify-start">
            <img src="dp/2023-08-17_2207375980601642814.jpg" class="object-cover h-72 w-52 shadow-lg rounded-lg">
        </div>

        <!-- ✅ Developer Info (Right) -->
        <div class="w-full md:w-2/3 md:pl-6">
            <h1 class="text-2xl font-bold text-gray-800">About This ChatGram</h1>
            <p class="text-gray-700 mt-2">
            This website is a modern chatting platform that offers a fast, secure, and user-friendly experience.
            </p>

            <h2 class="text-xl font-semibold text-gray-800 mt-4">Developer</h2>
            <p class="text-gray-600">Ankur Jha - Future Softwere Developer</p>

            <!-- ✅ Website Details -->
            <div class="mt-4 space-y-2">
                <p class="text-gray-800"><i class="fas fa-code text-gray-700 mr-2"></i> <strong>Version:</strong> 1.0.0</p>
                <p class="text-gray-800"><i class="fas fa-envelope text-gray-700 mr-2"></i> <strong>Email:</strong> akj41731@gmail</p>
                <p class="text-gray-800"><i class="fas fa-globe text-gray-700 mr-2"></i> <strong>Website:</strong> www.ankurjha.kesug.com</p>
                <p class="text-gray-800"><i class="fa-brands fa-instagram mr-2"></i> <strong>Instagram:</strong> <a href="https://www.instagram.com/ankurjha.07/" style="color :blue;">instagram.com/ankurjha.07</a></p>
                <p class="text-gray-800"><i class="fa-brands fa-facebook mr-2"></i> <strong>Facebook:</strong> <a href="https://www.facebook.com/ankurjha.07"  style="color :blue;">facebook.com/ankurjha.07</a></p>
            </div>

            <!-- ✅ Direct Chat Button -->
            <div class="mt-6">
                <a href="chat.php" class="bg-gray-800 text-white px-6 py-3 rounded-lg shadow-md hover:bg-gray-900 transition">
                    <i class="fas fa-comments mr-2"></i> Start Chat
                </a>
            </div>
        </div>
    </div>

    <!-- ✅ Features Section -->
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Features</h2>
        <ul class="list-disc list-inside text-gray-700 space-y-2">
            <li>🚀 Fast & Secure Chat</li>
            <li>📱 Responsive UI</li>
            <li>🎨 Tailwind CSS Integration</li>
            <li>🔧 MySQL Database</li>
            <li>💻 PHP Backend Support</li>
        </ul>
    </div>

    <!-- ✅ Footer -->
    <footer class="text-center text-gray-500 py-4 mt-6">
        &copy; <?= date("Y") ?> Your Website. All Rights Reserved.
    </footer>

</body>
</html>
