<?php
include_once "db.php";
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href='login.php';</script>";
}


$email = $_SESSION['email'];
$call_user_detail = mysqli_query($connect, "SELECT * FROM users WHERE email='$email'");
$user_detail = mysqli_fetch_array($call_user_detail);


$profile_pic = !empty($user_detail['dp']) ? "dp/" . $user_detail['dp'] : "dp/defaultUser.webp";


if (isset($_POST['save'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile = $_POST['mobile'];
    $dob = $_POST['dob'];
    $location = $_POST['location'];
    $bio = $_POST['bio'];

    $update_query = mysqli_query($connect, "UPDATE users SET first_name='$first_name', last_name='$last_name', mobile='$mobile', dob='$dob', location='$location', bio='$bio' WHERE email='$email'");

    if ($update_query) {
        echo "<script>window.location.href='profile.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($connect);
    }
}


if (isset($_FILES['profile_pic'])) {
    $file_name = time() . "_" . $_FILES['profile_pic']['name'];
    $file_tmp = $_FILES['profile_pic']['tmp_name'];
    $upload_dir = "dp/" . $file_name;

    if (move_uploaded_file($file_tmp, $upload_dir)) {
        $update_dp = mysqli_query($connect, "UPDATE users SET dp='$file_name' WHERE email='$email'");
        if ($update_dp) {
            echo json_encode(["status" => "success", "new_image_url" => $upload_dir]);
            exit;
        }
    }
    echo json_encode(["status" => "error"]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script>
        function toggleEdit() {
            document.getElementById('profileView').classList.toggle('hidden');
            document.getElementById('editSection').classList.toggle('hidden');
        }

        // प्रोफ़ाइल इमेज अपडेट करने का AJAX
        function uploadProfilePic(event) {
            let file = event.target.files[0];
            let formData = new FormData();
            formData.append('profile_pic', file);

            fetch('profile.php', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        document.getElementById('profilePic').src = data.new_image_url;
                    } else {
                        alert("Failed to update profile picture.");
                    }
                });
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
                    <label for="profilePicInput" class="cursor-pointer">
                        <img id="profilePic" src="<?= $profile_pic ?>" class="w-24 h-24 rounded-full border-4 border-blue-500 shadow-md">
                    </label>
                    <input type="file" id="profilePicInput" class="hidden" accept="image/*" onchange="uploadProfilePic(event)">
                </div>
                <h2 class="text-2xl font-bold text-center mt-4"><?= $user_detail['first_name'] ?> <?= $user_detail['last_name'] ?></h2>
                <p class="text-center text-gray-600"><?= $user_detail['bio'] ?></p>

                <!-- Profile Details -->
                <div class="mt-6 space-y-3">
                    <p class="text-gray-700"><i class="fa-solid fa-envelope"></i> <strong>Email:</strong> <?= $user_detail['email'] ?></p>
                    <p class="text-gray-700"><i class="fa-solid fa-phone"></i> <strong>Mobile:</strong> +91 <?= $user_detail['mobile'] ?></p>
                    <p class="text-gray-700"><i class="fa-solid fa-calendar"></i> <strong>Date of Birth:</strong> <?= date('Y-m-d', strtotime($user_detail['dob'])) ?></p>
                    <p class="text-gray-700"><i class="fa-solid fa-map-marker-alt"></i> <strong>Location:</strong> <?= $user_detail['location'] ?></p>
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

                <form action="" method="POST" class="space-y-3">
                    <div class="flex gap-3">
                        <input type="text" name="first_name" value="<?= $user_detail['first_name'] ?>" class="w-full p-3 border rounded-lg">
                        <input type="text" name="last_name" value="<?= $user_detail['last_name'] ?>" class="w-full p-3 border rounded-lg">
                    </div>
                    <input type="text" name="mobile" value="<?= $user_detail['mobile'] ?>" class="w-full p-3 border rounded-lg">
                    <input type="date" name="dob" value="<?= date('Y-m-d', strtotime($user_detail['dob'])) ?>" class="w-full p-3 border rounded-lg">
                    <input type="text" name="location" value="<?= $user_detail['location'] ?>" class="w-full p-3 border rounded-lg">
                    <textarea name="bio" class="w-full p-3 border rounded-lg"><?= $user_detail['bio'] ?></textarea>

                    <div class="flex space-x-4">
                        <button type="submit" name="save" class="w-1/2 bg-green-500 text-white p-3 rounded-lg font-bold hover:bg-green-600 transition">
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
