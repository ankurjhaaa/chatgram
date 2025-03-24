<?php include_once "db.php"; ?>
<?php
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <!-- FontAwesome CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex flex-col">

    <!-- Navbar -->
    <nav class="bg-gray-400 p-4 shadow-md flex items-center">
        <a href="index.php" class="text-white text-lg font-semibold flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </nav>
    <?php
    $call = mysqli_query($connect, "SELECT * FROM users where email='$email'");
    $privecy = mysqli_fetch_assoc($call);
    if ($privecy['is_public'] == 0) {
        $ppp = "Private";
    } else {
        $ppp = "Public";
    }
    ?>

    <!-- Settings Container -->
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md mx-auto mt-32">
        <h1 class="text-2xl font-semibold text-center text-gray-700 mb-6">Account Settings</h1>

        <!-- Account Privacy -->
        <form action="" method="post">
            <div class="mb-4">
                <label for="account-privacy" class="block text-gray-600 font-medium mb-2">Account Privacy</label>
                <select id="account-privacy" name="pp"
                    class="block w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    <option value="<?= $ppp ?> "><?= $ppp ?> </option>
                    <option value="1">Public</option>
                    <option value="0">Private</option>
                </select>
            </div>

            <!-- Email Notifications -->
            <div class="mb-4 flex items-center">
                <label for="notifications" class="text-gray-600 font-medium mr-4">Email Notifications</label>
                <input type="checkbox" id="notifications" class="form-checkbox text-blue-500 h-5 w-5" checked>
            </div>

            <!-- Dark Mode -->
            <div class="mb-4 flex items-center">
                <label for="dark-mode" class="text-gray-600 font-medium mr-4">Dark Mode</label>
                <input type="checkbox" id="dark-mode" name="mode" class="form-checkbox text-blue-500 h-5 w-5">
            </div>

            <!-- Two Factor Authentication -->
            <div class="mb-6 flex items-center">
                <label for="two-factor-auth" class="text-gray-600 font-medium mr-4">Two-Factor Authentication</label>
                <input type="checkbox" id="two-factor-auth" class="form-checkbox text-blue-500 h-5 w-5">
            </div>

            <!-- Save Button -->
            <div class="flex justify-center">
                <button name="save"
                    class="bg-blue-500 text-white py-2 px-6 rounded-md hover:bg-blue-600 transition duration-300">Save
                    Changes</button>
            </div>
            <?php
            if (isset($_POST['save'])) {
                $priv = $_POST['pp'];
                if ($priv == 1) {
                    $pp = 1;
                } else {
                    $pp = 0;
                }

                $chan = mysqli_query($connect, "UPDATE users SET is_public='$pp' where email='$email'");


                $call = mysqli_query($connect, "SELECT * FROM users where email='$email'");
                $privecy = mysqli_fetch_assoc($call);
                if ($privecy['is_public'] == 0) {
                    $ppp = "Private";
                } else {
                    $ppp = "Public";
                }
                if ($chan) {
                    echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            title: '$ppp Successful!',
                            text: 'Your account $ppp successfully.',
                            icon: 'success',
                            confirmButtonText: 'Home',
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'index.php'; // Replace with your login page URL
                            }
                        });
                    </script>";
                }
            }
            ?>
        </form>
    </div>

</body>

</html>