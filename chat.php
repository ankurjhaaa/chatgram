<?php include_once "db.php"; ?>

<?php
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href='login.php';</script>";
}
?>
<?php
if (isset($_GET['user'])) {
    $id = $_GET['user'];
    $call_user_name = mysqli_query($connect, "SELECT * FROM users WHERE id='$id'");
    $user_name = mysqli_fetch_assoc($call_user_name);
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
        <div class="w-full md:flex-1 h-screen md:block">

            <div class="w-full md:flex-1 flex flex-col h-screen">

                <!-- Header (Fixed) -->
                <div class="bg-white p-4 border-b flex items-center shadow-md fixed top-0 left-0 right-0 md:relative">
                    <a href="index.php" class="md:hidden p-2">🔙</a>
                    <img src="https://i.pravatar.cc/42" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <p class="font-semibold text-lg"><?= $user_name['first_name'] ?> <?= $user_name['last_name'] ?>
                        </p>
                        <p class="text-sm text-green-500">Online</p>
                    </div>
                </div>

                <!-- Messages (Scrollable) -->
                <div class="flex-1 p-4 overflow-y-auto space-y-4 flex flex-col-reverse mt-16 mb-16">
                    <div class="flex flex-col items-end">
                        <div class="bg-blue-500 text-white p-3 rounded-lg w-fit max-w-xs">Hello!</div>
                        <span class="text-xs text-gray-500 mt-1">10:30 AM</span>
                    </div>
                    <div class="flex flex-col items-start">
                        <div class="bg-gray-300 p-3 rounded-lg w-fit max-w-xs">Hi! How are you?</div>
                        <span class="text-xs text-gray-500 mt-1">10:32 AM</span>
                    </div>
                </div>

                <!-- Input Box (Fixed) -->
                <form action="" method="post">
                    <div
                        class="bg-white p-2 border-t flex items-center shadow-lg fixed bottom-0 left-0 right-0 md:relative">
                        <!-- Emoji Button -->
                        <button class="p-3 text-gray-500 hover:text-blue-500">
                            <i class="fas fa-smile text-2xl"></i>
                        </button>

                        <!-- Message Input -->
                        <div class="relative flex-1 mx-3">
                            <input type="text" placeholder="Type a message..." name="msg"
                                class="w-full p-4 pl-12 border rounded-full focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-100">

                            <!-- Paperclip (Attachment) Icon -->
                            <i
                                class="fas fa-paperclip absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500 cursor-pointer"></i>
                        </div>

                        <!-- Send Button -->
                        <button
                            class="bg-blue-500 text-white px-6 py-3 rounded-full hover:bg-blue-600 transition-all duration-300"
                            name="msg_sent">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
                <?php
                    if(isset($_POST['msg_sent'])){
                        $msg = $_POST['msg'];
                    }

                ?>

                <!-- Font Awesome CDN -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>


            </div>

        </div>
    </div>

</body>

</html>