<?php include_once "db.php"; ?>

<?php
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href='login.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
        crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">
        <!-- Friends List (Default for Mobile) -->
        <div
            class="w-full md:w-1/4 bg-white p-4 border-r h-screen md:block <?php echo isset($_GET['user']) ? 'hidden' : ''; ?>">
            <?php include_once 'friends.php'; ?>
        </div>

        <!-- Chat Section (Hidden by Default on Mobile) -->
        <div class="w-full md:flex-1 h-screen md:block <?php echo isset($_GET['user']) ? '' : 'hidden'; ?>">
            <?php $user = $_GET['user'] ?? 'Unknown'; ?>
            <div class="h-screen flex items-center justify-center bg-gray-100 text-gray-800 flex-col w-full">
                <i class="fas fa-comments text-6xl opacity-30"></i> <!-- Custom Icon -->
                <h1 class="text-xl mt-4 font-semibold">ChatApp for Windows</h1>
                <p class="text-sm text-gray-600 mt-2 text-center">
                    Stay connected and chat seamlessly across devices. <br>
                    Use ChatApp on multiple devices without needing your phone online.
                </p>
                <p class="text-xs text-gray-500 mt-6">🔒 Secure & Private Messaging</p>
            </div>


        </div>
    </div>

    

</body>

</html>