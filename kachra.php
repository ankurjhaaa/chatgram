<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" crossorigin="anonymous"></script>
    <title>Dropdown Menu</title>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">

    <div class="relative inline-block text-left">
        <!-- Dropdown Button -->
        <button onclick="toggleDropdown()" class="bg-gray-200 p-3 rounded-full focus:outline-none">
            <i class="fas fa-bars text-xl"></i>  <!-- Font Awesome Icon -->
        </button>

        <!-- Dropdown Menu -->
        <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg hidden">
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-user mr-2"></i> Profile
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-cog mr-2"></i> Settings
            </a>
            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById("dropdownMenu").classList.toggle("hidden");
        }
    </script>

</body>
</html>
