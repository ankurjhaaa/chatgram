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
    $user_dp = $user_name['dp'];

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
                        <i class="fa-solid fa-arrow-left text-black"></i> <!-- Back Button Icon -->
                    </button>

                    <!-- Profile Image (Click to Open Popup) -->
                    <img src="dp/<?php echo empty($user_name['dp']) ? 'defaultUser.webp' : $user_name['dp']; ?>"
                        class="w-12 h-12 rounded-full mr-3 cursor-pointer" onclick="openProfilePopup()">

                    <div class="flex-1">
                        <p class="font-semibold text-lg"><?= $user_name['first_name'] ?> <?= $user_name['last_name'] ?>
                        </p>
                        <p class="text-sm text-green-500">Online</p>
                    </div>

                    <!-- Refresh Button -->
                    <button onclick="refreshPage()" class="text-xl text-gray-700 hover:text-blue-500 transition">
                        <i class="fa-solid fa-rotate-right"></i> <!-- Refresh Icon -->
                    </button>
                </div>

                <!-- Profile Popup Modal -->
                <div id="profilePopup"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
                    <div class="bg-white rounded-lg p-6 w-80 shadow-lg relative">

                        <!-- Close Button -->
                        <button onclick="closeProfilePopup()" class="absolute top-2 right-2 text-gray-600 text-xl">
                            <i class="fa-solid fa-xmark"></i>
                        </button>

                        <!-- Profile Image in Popup -->
                        <div class="flex justify-center">
                            <img src="dp/<?php echo empty($user_name['dp']) ? 'defaultUser.webp' : $user_name['dp']; ?>"
                                class="w-24 h-24 rounded-full border-4 border-blue-500 shadow-md">
                        </div>

                        <h2 class="text-xl font-bold text-center mt-4">
                            <?= $user_name['first_name'] ?> <?= $user_name['last_name'] ?>
                        </h2>
                        <p class="text-center text-gray-600"><?= $user_name['bio'] ?></p>

                        <!-- Profile Details -->
                        <div class="mt-4 space-y-2 text-gray-700">
                            <p><i class="fa-solid fa-phone"></i> <strong>Mobile:</strong> +91
                                <?= $user_name['mobile'] ?>
                            </p>
                            <p><i class="fa-solid fa-calendar"></i> <strong>DOB:</strong>
                                <?= date('Y-m-d', strtotime($user_name['dob'])) ?></p>
                            <p><i class="fa-solid fa-map-marker-alt"></i> <strong>Location:</strong>
                                <?= $user_name['location'] ?></p>
                        </div>
                    </div>
                </div>

                <!-- JavaScript for Modal & Refresh -->
                <script>
                    function openProfilePopup() {
                        document.getElementById('profilePopup').classList.remove('hidden');
                    }

                    function closeProfilePopup() {
                        document.getElementById('profilePopup').classList.add('hidden');
                    }

                    function refreshPage() {
                        location.reload();
                    }
                </script>


                <!-- Messages (Scrollable) -->
                <div class="flex-1 p-4 overflow-y-auto space-y-4 flex flex-col-reverse mt-16 mb-16">
                    <?php
                    $sender_id = $self_id['id'];
                    $reciver_id = $user_name['id'];
                    $fetch_messages = mysqli_query(
                        $connect,
                        "SELECT * FROM chat WHERE (sender_id='$sender_id' AND reciver_id='$reciver_id') OR (sender_id='$reciver_id' AND reciver_id='$sender_id') ORDER BY time DESC"
                    );
                    while ($msg = mysqli_fetch_array($fetch_messages)) {

                        $is_sender = ($msg['sender_id'] == $sender_id);
                        ?>
                        <div class="flex flex-col <?= $is_sender ? 'items-end' : 'items-start' ?> mt-2">
                            <div
                                class="<?= $is_sender ? 'bg-blue-500 text-white' : 'bg-gray-300' ?> p-3 rounded-lg w-fit max-w-xs">
                                <?= htmlspecialchars($msg['message']) ?>
                            </div>
                            <span class="text-xs text-gray-500 mt-1">
                                <?= date("h:i A", strtotime($msg['time'])) ?>
                            </span>
                        </div>
                    <?php } ?>
                </div>


                <!-- Input Box (Fixed) -->
                <form action="" method="post" id="chatForm">
                    <div
                        class="bg-white p-3 border-t shadow-lg fixed bottom-0 left-0 right-0 md:relative flex items-center gap-2">

                        <!-- Emoji Button -->
                        <button type="button"
                            class="p-2 text-gray-600 hover:text-yellow-500 transition duration-300 ease-in-out focus:outline-none">
                            <i class="fas fa-smile text-xl"></i>
                        </button>

                        <!-- Message Input -->
                        <div class="relative flex-1">
                            <input type="text" placeholder="Type a message..." name="msg" id="messageInput"
                                class="w-full p-3 px-12 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-100 shadow-md">

                            <!-- Paperclip (Attachment) Icon -->
                            <i
                                class="fas fa-paperclip absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-blue-500 cursor-pointer transition duration-300"></i>
                        </div>

                        <!-- Send Button -->
                        <button type="submit"
                            class="bg-blue-500 text-white px-5 py-3 rounded-md hover:bg-blue-600 shadow-md transform transition-all duration-300"
                            name="msg_sent">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>

                <script>
                    // Enter key से मैसेज भेजने का फंक्शन
                    document.getElementById("messageInput").addEventListener("keypress", function (event) {
                        if (event.key === "Enter") {
                            event.preventDefault(); // डिफ़ॉल्ट Enter behavior को रोकना
                            document.getElementById("chatForm").submit(); // फॉर्म सबमिट करना
                        }
                    });
                </script>

                <?php
                if (isset($_POST['msg_sent'])) {
                    $msg = $_POST['msg'];
                    $sender_id = $self_id['id'];
                    $reciver_id = $user_name['id'];
                    date_default_timezone_set("Asia/Kolkata");
                    $time = date("Y-m-d H:i:s");


                    if ($msg != '') {
                        $insert_msg = mysqli_query($connect, "INSERT INTO chat (reciver_id,sender_id,message,time) VALUE ('$reciver_id','$sender_id','$msg','$time')");
                        if ($insert_msg) {
                            echo "<script>window.location.href='';</script>";
                        }
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