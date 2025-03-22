<?php include_once "db.php"; ?>
<?php
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$email = $_SESSION['email'];
?>

<!-- Font Awesome (for icons) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

<div class="w-full bg-white p-4">
    <div class="flex items-center justify-between">
        <a href="index.php" class="text-xl font-bold mb-4">ChatGram</a>

        <div class="flex space-x-4">
            <!-- New Chat Popup Button -->
            <button onclick="toggleChatPopup()"
                class="bg-gray-300 p-1 h-8 w-10 rounded-md flex items-center justify-center focus:outline-none">
                <i class="fas fa-comment-dots text-xl"></i>
            </button>

            <!-- Dropdown Menu -->
            <div class="relative inline-block text-left">
                <button onclick="toggleDropdown()"
                    class="bg-gray-300 p-1 h-8 w-10 rounded-md flex items-center justify-center focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg hidden">
                    <a href="profile.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i> Profile
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                    <a href="about.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-info-circle mr-2"></i> About
                    </a>
                    <a href="logout.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Search for a user..."
            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
            onkeyup="searchUsers()">
    </div>

    <!-- User List -->
    <div class="space-y-4 overflow-y-auto max-h-[600px]  rounded-lg p-2 [&::-webkit-scrollbar]:hidden" id="userList">
        <?php
        $call_user = mysqli_query($connect, "SELECT DISTINCT 
        CASE 
            WHEN sender_id = (SELECT id FROM users WHERE email = '$email') THEN reciver_id 
            ELSE sender_id 
        END AS chat_user_id 
        FROM chat 
        WHERE sender_id = (SELECT id FROM users WHERE email = '$email') 
           OR reciver_id = (SELECT id FROM users WHERE email = '$email')");

        while ($chat = mysqli_fetch_array($call_user)) {
            $chat_user_id = $chat['chat_user_id'];

            $user_query = mysqli_query($connect, "SELECT * FROM users WHERE id = '$chat_user_id'");
            $user = mysqli_fetch_assoc($user_query);

            $call_send_msg = mysqli_query($connect, "SELECT * FROM chat 
            WHERE (sender_id='$chat_user_id' AND reciver_id=(SELECT id FROM users WHERE email='$email')) 
               OR (sender_id=(SELECT id FROM users WHERE email='$email') AND reciver_id='$chat_user_id')
            ORDER BY time DESC LIMIT 1");

            $last_message = mysqli_fetch_array($call_send_msg);
            ?>
            <a href="message.php?user=<?= $user['id'] ?>">
                <div class="user-item flex items-center p-2 hover:bg-gray-200 rounded cursor-pointer">
                    <img src="dp/<?php echo empty($user['dp']) ? "defaultUser.webp" : $user['dp']; ?>"
                        class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <p class="font-semibold text-lg"><?= $user['first_name'] . " " . $user['last_name'] ?></p>
                        <p class="text-sm text-gray-500">
                            <?= $last_message['message'] ?? 'No messages yet'; ?>
                        </p>
                    </div>
                </div>
            </a>

        <?php } ?>
    </div>

</div>

<!-- Chat Popup -->
<div id="chatPopup" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white w-full max-w-lg h-4/5 rounded-lg shadow-lg p-6 flex flex-col">
        <!-- Popup Header -->
        <div class="flex justify-between items-center border-b pb-4">
            <h2 class="text-xl font-bold">Find People</h2>
            <button onclick="toggleChatPopup()" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Search Bar -->
        <input type="text" id="chatSearch" placeholder="Search chats..."
            class="w-full p-3 border rounded-lg mt-4 focus:outline-none focus:ring-2 focus:ring-blue-400"
            onkeyup="searchChats()">

        <!-- Chat List -->
        <div class="flex-1 overflow-y-auto mt-4 space-y-4" id="chatList">
            <?php
            $call_chats = mysqli_query($connect, "SELECT * FROM users WHERE email !='$email'");
            while ($chat = mysqli_fetch_array($call_chats)) {
                // $user_id = ($chat['sender_id'] == $email) ? $chat['reciver_id'] : $chat['sender_id'];
                // $user_info = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE id='$user_id'"));
                ?>
                <a href="message.php?user=<?= $chat['id'] ?>">
                    <div class="chat-item flex items-center p-2 hover:bg-gray-200 rounded cursor-pointer">
                        <img src="dp/<?= ($chat['dp'] == "") ? "defaultUser.webp" : $chat['dp'] ?>"
                            class="w-12 h-12 rounded-full mr-3">
                        <div>
                            <p class="font-semibold text-lg"><?= $chat['first_name'] ?>     <?= $chat['last_name'] ?></p>
                            <p class="text-sm text-gray-500">Tap to open chat</p>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    function toggleDropdown() {
        document.getElementById("dropdownMenu").classList.toggle("hidden");
    }

    function searchUsers() {
        let input = document.getElementById("searchInput").value.toLowerCase();
        let users = document.getElementsByClassName("user-item");

        for (let i = 0; i < users.length; i++) {
            let name = users[i].getElementsByTagName("p")[0].innerText.toLowerCase();
            users[i].parentElement.style.display = name.includes(input) ? "" : "none";
        }
    }

    function toggleChatPopup() {
        document.getElementById("chatPopup").classList.toggle("hidden");
    }

    function searchChats() {
        let input = document.getElementById("chatSearch").value.toLowerCase();
        let chats = document.getElementsByClassName("chat-item");

        for (let i = 0; i < chats.length; i++) {
            let name = chats[i].getElementsByTagName("p")[0].innerText.toLowerCase();
            chats[i].parentElement.style.display = name.includes(input) ? "" : "none";
        }
    }
</script>