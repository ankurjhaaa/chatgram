<?php
if(!isset($_SESSION['email'])){
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
</head>
<body class="bg-gray-100">

    <div class="flex h-screen">
        <!-- Friends List (Default for Mobile) -->
        <div class="w-full md:w-1/4 bg-white p-4 border-r h-screen md:block <?php echo isset($_GET['user']) ? 'hidden' : ''; ?>">
            <?php include_once 'friends.php'; ?>
        </div>
        
        <!-- Chat Section (Hidden by Default on Mobile) -->
        <div class="w-full md:flex-1 h-screen md:block <?php echo isset($_GET['user']) ? '' : 'hidden'; ?>">
            <?php include_once 'chat.php'; ?>
        </div>
    </div>

</body>
</html>
