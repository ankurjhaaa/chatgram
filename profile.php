<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome CDN (Proper Link) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script>
        function toggleEdit() {
            document.getElementById('profileView').classList.toggle('hidden');
            document.getElementById('editSection').classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Navbar with Back Button -->
    <div class="bg-blue-500 p-4 flex items-center text-white shadow-md">
        <button onclick="history.back()" class="text-white text-xl mr-4">
            <i class="fa-solid fa-arrow-left"></i> <!-- Font Awesome Icon -->
        </button>
        <h2 class="text-lg font-semibold">Profile</h2>
    </div>

    <div class="flex-1 flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
            
            <!-- Profile View Section -->
            <div id="profileView">
                <!-- Profile Image -->
                <div class="flex justify-center">
                    <img src="https://i.pravatar.cc/100" class="w-24 h-24 rounded-full border-4 border-blue-500 shadow-md">
                </div>
                <h2 class="text-2xl font-bold text-center mt-4">John Doe</h2>
                <p class="text-center text-gray-600">Web Developer | Tech Enthusiast</p>

                <!-- Profile Details -->
                <div class="mt-6 space-y-3">
                    <p class="text-gray-700"><i class="fa-solid fa-envelope"></i> <strong>Email:</strong> johndoe@example.com</p>
                    <p class="text-gray-700"><i class="fa-solid fa-phone"></i> <strong>Mobile:</strong> +91 98765 43210</p>
                    <p class="text-gray-700"><i class="fa-solid fa-calendar"></i> <strong>Date of Birth:</strong> 15th Aug 1995</p>
                    <p class="text-gray-700"><i class="fa-solid fa-map-marker-alt"></i> <strong>Location:</strong> New Delhi, India</p>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex space-x-4">
                    <button onclick="toggleEdit()" class="w-1/2 bg-blue-500 text-white p-3 rounded-lg font-bold hover:bg-blue-600 transition">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <a href="logout.php" class="w-1/2 bg-red-500 text-white p-3 rounded-lg font-bold hover:bg-red-600 transition">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            </div>

            <!-- Edit Profile Section (Hidden Initially) -->
            <div id="editSection" class="hidden">
                <h2 class="text-xl font-semibold text-center text-gray-800 mb-4">Edit Profile</h2>
                
                <form action="update_profile.php" method="POST" class="space-y-3">
                    <div class="flex gap-3">
                    <input type="text" name="first_name" placeholder="First Name" value="John " class="w-full p-3 border rounded-lg">
                    <input type="text" name="Last" placeholder="Last Name" value=" Doe" class="w-full p-3 border rounded-lg">
                    </div>
                    <input type="email" name="email" placeholder="Email" value="johndoe@example.com" class="w-full p-3 border rounded-lg">
                    <input type="text" name="mobile" placeholder="Mobile" value="+91 98765 43210" class="w-full p-3 border rounded-lg">
                    <input type="date" name="dob" value="1995-08-15" class="w-full p-3 border rounded-lg">
                    <input type="text" name="location" placeholder="Location" value="New Delhi, India" class="w-full p-3 border rounded-lg">
                    <textarea name="bio" placeholder="Bio" class="w-full p-3 border rounded-lg">Web Developer | Tech Enthusiast</textarea>
                    
                    <div class="flex space-x-4">
                        <button type="submit" class="w-1/2 bg-green-500 text-white p-3 rounded-lg font-bold hover:bg-green-600 transition">
                            <i class="fa-solid fa-floppy-disk"></i> Save
                        </button>
                        <button type="button" onclick="toggleEdit()" class="w-1/2 bg-gray-500 text-white p-3 rounded-lg font-bold hover:bg-gray-600 transition">
                            <i class="fa-solid fa-xmark"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
