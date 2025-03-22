<?php include_once "db.php"; ?>
<?php
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$email = $_SESSION['email'];
?>
<!-- Font Awesome (for icons) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>

<div class="w-full h-screen bg-white p-4">
    <div class="flex items-center justify-between">
        <a href="index.php" class="text-xl font-bold mb-4">ChatGram</a>

        <!-- Dropdown Menu -->
        <div class="relative inline-block text-left">
            <button onclick="toggleDropdown()"
                class="bg-gray-300 p-1 h-8 w-10 rounded-md flex items-center justify-center focus:outline-none">
                <i class="fas fa-bars text-xl"></i> <!-- Font Awesome Icon -->
            </button>
            <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg hidden">
                <a href="profile.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>
                <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-cog mr-2"></i> Settings
                </a>
                <a href="logout.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
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
    <div class="space-y-4" id="userList">
        <?php
        $call_user = mysqli_query($connect, "SELECT * FROM users WHERE email != '$email'");
        while ($user = mysqli_fetch_array($call_user)) { ?>
            <a href="chat.php?user=<?= $user['id'] ?>">
                <div class="user-item flex items-center p-2 hover:bg-gray-200 rounded cursor-pointer">
                    <img src="dp/<?php if ($user['dp'] == "") {
                        echo "defaultUser.webp";
                    } else {
                        $user_dp = $user['dp'];
                        echo "$user_dp";
                    } ?>" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <?php
                        $call_self_id = mysqli_query($connect, "SELECT * FROM users WHERE email='$email'");
                        $self_id = mysqli_fetch_assoc($call_self_id);
                        $reciver_id = $self_id['id'];

                        $chat_id = $user['id'];

                        $call_send_msg = mysqli_query($connect, "SELECT * FROM chat WHERE sender_id='$chat_id' AND reciver_id='$reciver_id'ORDER BY time DESC LIMIT 1");
                        $last_message = mysqli_fetch_array($call_send_msg);


                        ?>
                        <p class="font-semibold text-lg"><?= $user['first_name'] ?>     <?= $user['last_name'] ?></p>
                        <p class="text-sm text-gray-500">
                            <?php
                            $last_msg = $last_message['message'] ?? '';
                            echo $last_msg;
                            ?>
                        </p>
                    </div>
                </div>
            </a>
        <?php } ?>
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
            if (name.includes(input)) {
                users[i].parentElement.style.display = "";
            } else {
                users[i].parentElement.style.display = "none";
            }
        }
    }
</script>