<?php include_once "db.php"; ?>
<?php
$email = $_SESSION['email'];
if ($email != "akj41731@gmail.com") {
    echo "<script>window.location.href='login.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <!-- Tailwind CSS -->`
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-blue-600 p-4 flex items-center">
        <a href="javascript:history.back()" class="text-white text-xl mr-4">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="text-white text-lg font-bold">User List (<?= mysqli_num_rows(mysqli_query($connect,"SELECT * FROM users")) ?>)</h1>
    </nav>


    <!-- Main Container -->
    <div class="container mx-auto p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Full Name</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Mobile</th>
                        <th class="px-4 py-2 text-left">DP</th>
                        <th class="px-4 py-2 text-left">Is Public</th>
                        <th class="px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $call_user = mysqli_query($connect, "SELECT * FROM users ORDER BY id DESC");

                    while ($user = mysqli_fetch_array($call_user)) { ?>

                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2"><?= $user['id'] ?></td>
                            <td class="px-4 py-2"><?= $user['first_name'] ?>     <?= $user['last_name'] ?></td>
                            <td class="px-4 py-2"><?= $user['email'] ?></td>
                            <td class="px-4 py-2"><?= $user['mobile'] ?></td>
                            <td class="px-4 py-2">
                                <img src="dp/<?php echo empty($user['dp']) ? 'defaultUser.webp' : htmlspecialchars($user['dp']); ?>"
                                    class="w-12 h-12 rounded-full border object-cover mr-3 shadow-sm cursor-pointer"
                                    onclick="openUserPopup(this)" data-id="<?= $user['id'] ?>"
                                    data-first_name="<?= $user['first_name'] ?>" data-last_name="<?= $user['last_name'] ?>"
                                    data-email="<?= $user['email'] ?>" data-mobile="<?= $user['mobile'] ?>"
                                    data-dp="<?php echo empty($user['dp']) ? 'defaultUser.webp' : htmlspecialchars($user['dp']); ?>">
                            </td>

                            <!-- popupppppppppppppppppppppppppp -->
                            <!-- User Details Modal -->
                            <div id="userModal"
                                class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
                                <div class="bg-white rounded-lg shadow-lg p-6 relative w-11/12 md:w-1/3">
                                    <!-- Close Button -->
                                    <button onclick="closeUserPopup()"
                                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                    <!-- User Image -->
                                    <img id="modalUserImage" src="" alt="User Image"
                                        class="w-60 h-60 rounded-md mx-auto border object-cover shadow-sm">
                                    <!-- User Details -->
                                    <div id="modalUserDetails" class="mt-4 text-center">
                                        <!-- Details will be populated dynamically -->
                                    </div>
                                </div>
                            </div>


                            <td class="px-4 py-2"><?php if ($user['is_public'] == 1) {
                                echo "Public";
                            } elseif ($user['is_public'] == 2) {
                                echo "Blocked";
                            } else {
                                echo "Private";
                            } ?></td>
                            <td class="px-4 py-2">
                                <?php
                                if (isset($_GET['block'])) {
                                    $id = $_GET['block'];
                                    $block = mysqli_query($connect, "UPDATE users SET is_public=2 WHERE id='$id'");
                                    if ($block) {
                                        echo "<script>window.location.href='users.php';</script>";
                                    }
                                }

                                if (isset($_GET['unblock'])) {
                                    $id = $_GET['unblock'];
                                    $block = mysqli_query($connect, "UPDATE users SET is_public=1 WHERE id='$id'");
                                    if ($block) {
                                        echo "<script>window.location.href='users.php';</script>";
                                    }
                                }
                                ?>
                                <?php if ($user['is_public'] == 0) { ?>
                                    <a href="?block=<?= $user['id'] ?>" name="block"
                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded">
                                        Block
                                    </a>

                                <?php } elseif ($user['is_public'] == 1) { ?>
                                    <a href="?block=<?= $user['id'] ?>" name="block"
                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded">
                                        Block
                                    </a>

                                <?php } else { ?>
                                    <a href="?unblock=<?= $user['id'] ?>" name="unblock"
                                        class="bg-green-600 text-white py-1 px-3 rounded">
                                        Unblock
                                    </a>
                                <?php } ?>


                            </td>
                        </tr>

                    <?php } ?>
                    <!-- Sample Row 1 -->


                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<!-- popup ppppppppppppppppppppppppppp -->
<script>
    function openUserPopup(element) {
        // Extract data attributes from clicked image
        var id = element.getAttribute('data-id');
        var firstName = element.getAttribute('data-first_name');
        var lastName = element.getAttribute('data-last_name');
        var email = element.getAttribute('data-email');
        var mobile = element.getAttribute('data-mobile');
        var dp = element.getAttribute('data-dp');

        // Set modal image source
        document.getElementById('modalUserImage').src = "dp/" + dp;

        // Populate user details in modal
        var detailsHtml = `
        <p class="font-bold">ID: ${id}</p>
        <p class="font-bold">Name: ${firstName} ${lastName}</p>
        <p>Email: ${email}</p>
        <p>Mobile: ${mobile}</p>
    `;
        document.getElementById('modalUserDetails').innerHTML = detailsHtml;

        // Display the modal
        document.getElementById('userModal').classList.remove('hidden');
    }

    function closeUserPopup() {
        // Hide the modal
        document.getElementById('userModal').classList.add('hidden');
    }
</script>