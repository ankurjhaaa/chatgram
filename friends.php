<?php include_once "db.php"; ?>
<?php
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$email = $_SESSION['email'];
?>
<!-- <script src="https://kit.fontawesome.com/YOUR_FA_KIT.js" crossorigin="anonymous"></script> -->
<div class="w-full h-screen bg-white p-4">
    <div class="flex items-center justify-between ">
        <h2 class="text-xl font-bold mb-4">Chats</h2>
        <h2 class="text-xl font-bold mb-4">
            <div class="relative inline-block text-left">
                <!-- Dropdown Button -->
                <button onclick="toggleDropdown()"
                    class="bg-gray-300 p-1 h-8 w-10 rounded-md flex items-center justify-center focus:outline-none">
                    <i class="fas fa-bars text-xl"></i> <!-- Font Awesome Icon -->
                </button>

                <!-- Dropdown Menu -->
                <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg hidden">
                    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-user mr-2"></i> <?= $_SESSION['email']; ?>
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-cog mr-2"></i> Settings
                    </a>
                    <a href="logout.php" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </div>

            
        </h2>
    </div>
    <div class="space-y-4">
        <?php
        $call_user = mysqli_query($connect, "SELECT * FROM users WHERE email != '$email'");
        while ($user = mysqli_fetch_array($call_user)) { ?>
            <a href="chat.php?user=<?= $user['id'] ?>">
                <div class="flex items-center p-2 hover:bg-gray-200 rounded cursor-pointer"
                    onclick="window.location.href='chat.php?user=John Doe'">
                    <img src="https://i.pravatar.cc/40" class="w-12 h-12 rounded-full mr-3">
                    <div>
                        <p class="font-semibold text-lg"><?= $user['first_name'] ?>     <?= $user['last_name'] ?></p>
                        <p class="text-sm text-gray-500">Hey, how are you?</p>
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
</script>