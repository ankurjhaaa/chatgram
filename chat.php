<?php include_once "db.php"; ?>

<?php
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href='login.php';</script>";
}

$email = $_SESSION['email'];
?>
<?php
if (isset($_GET['user'])) {
    $id = $_GET['user'];
    $call_user_name = mysqli_query($connect, "SELECT * FROM users WHERE id='$id'");
    $user_name = mysqli_fetch_assoc($call_user_name);

}

?>
<?php
$call_self_id = mysqli_query($connect, "SELECT * FROM users WHERE email='$email'");
$self_id = mysqli_fetch_assoc($call_self_id);
?>
<?php
// $user_id = $user_name['id'];
// $call_dp = mysqli_query($connect, "SELECT * FROM users WHERE id='$id'");
// $dp = mysqli_fetch_assoc($call_dp);

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
                    <button onclick="history.back()" class="text-white text-xl mr-4">
                    <i class="fa-solid fa-arrow-left text-black"></i> <!-- Font Awesome Icon -->
                    </button>
                    <img src="dp/<?php if ($user_name['dp'] == "") {
                        echo "defaultUser.webp";
                    } ?>" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <p class="font-semibold text-lg"><?= $user_name['first_name'] ?> <?= $user_name['last_name'] ?>
                        </p>
                        <p class="text-sm text-green-500">Online</p>
                    </div>
                </div>

                <!-- Messages (Scrollable) -->
                <div class="flex-1 p-4 overflow-y-auto space-y-4 flex flex-col-reverse mt-16 mb-16">
                    <?php
                    $sender_id = $self_id['id'];
                    $reciver_id = $user_name['id'];
                    $call_send_msg = mysqli_query($connect, "SELECT * FROM chat WHERE sender_id='$sender_id' AND reciver_id='$reciver_id' ORDER BY time DESC");
                    while ($send_msg = mysqli_fetch_array($call_send_msg)) { ?>
                        <div class="flex flex-col items-end mt-2">
                            <div class="bg-blue-500 text-white p-3 rounded-lg w-fit max-w-xs"><?= $send_msg['message'] ?>
                            </div>
                            <span class="text-xs text-gray-500 mt-1">
                                <?php
                                $timestamp = $send_msg['time'];
                                $formatted_time = date("h:i A", strtotime($timestamp));
                                echo $formatted_time;
                                ?>
                            </span>
                        </div>
                    <?php } ?>


                    <?php
                    $sender_id = $self_id['id'];
                    $reciver_id = $user_name['id'];
                    $call_recive_msg = mysqli_query($connect, "SELECT * FROM chat WHERE sender_id='$reciver_id' AND reciver_id='$sender_id' ORDER BY time DESC");
                    while ($recive_msg = mysqli_fetch_array($call_recive_msg)) { ?>
                        <div class="flex flex-col items-start">
                            <div class="bg-gray-300 p-3 rounded-lg w-fit max-w-xs">Hi! How are you?</div>
                            <span class="text-xs text-gray-500 mt-1">
                                <?php
                                $timestamp = $recive_msg['time'];
                                $formatted_time = date("h:i A", strtotime($timestamp));
                                echo $formatted_time;
                                ?>
                            </span>
                        </div>
                    <?php } ?>


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
                if (isset($_POST['msg_sent'])) {
                    $msg = $_POST['msg'];
                    $sender_id = $self_id['id'];
                    $reciver_id = $user_name['id'];

                    $insert_msg = mysqli_query($connect, "INSERT INTO chat (reciver_id,sender_id,message) VALUE ('$reciver_id','$sender_id','$msg')");
                    if ($insert_msg) {
                        echo "<script>window.location.href='';</script>";
                    }
                }

                ?>

                <!-- Font Awesome CDN -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>


            </div>

        </div>
    </div>

</body>

</html>