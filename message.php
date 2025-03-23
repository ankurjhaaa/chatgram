<?php include_once "db.php"; ?>

<?php
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.href='login.php';</script>";
}

$email = $_SESSION['email'];
$call_self_id = mysqli_query($connect, "SELECT * FROM users WHERE email='$email'");
$self_id = mysqli_fetch_assoc($call_self_id);
$sender_id = $self_id['id'];

if (isset($_GET['user'])) {
    $id = $_GET['user'];
    $call_user_name = mysqli_query($connect, "SELECT * FROM users WHERE id='$id'");
    $user_name = mysqli_fetch_assoc($call_user_name);
    $reciver_id = $user_name['id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">
        <!-- Friends List -->
        <div
            class="w-full md:w-1/4 bg-white p-4 border-r h-screen md:block <?php echo isset($_GET['user']) ? 'hidden' : ''; ?>">
            <?php include_once 'friends.php'; ?>
        </div>

        <!-- Chat Section -->
        <div class="w-full md:w-3/4 h-screen md:block">
            <div class="w-full flex flex-col h-screen">

                <!-- Header -->
                <div class="bg-white p-4 border-b flex items-center shadow-md fixed top-0 left-0 right-0 md:relative">
                    <button onclick="history.back()" class="text-black text-xl mr-4">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <img src="dp/<?php echo empty($user_name['dp']) ? 'defaultUser.webp' : $user_name['dp']; ?>"
                        class="w-12 h-12 rounded-full mr-3 cursor-pointer" onclick="openProfilePopup()">

                    <div class="flex-1">
                        <p class="font-semibold text-lg"><?= $user_name['first_name'] ?> <?= $user_name['last_name'] ?>
                        </p>
                        <p id="typingStatus" class="text-sm text-green-500">Online</p>
                    </div>
                    <!-- <button onclick="refreshPage()" class="text-xl text-gray-700 hover:text-blue-500">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button> -->
                </div>
                <!-- user detail popup  -->
                <div id="profilePopup"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg p-6 w-80 shadow-lg relative">

                        <!-- Close Button -->
                        <button onclick="closeProfilePopup()" class="absolute top-2 right-2 text-gray-600 text-xl">
                            <i class="fa-solid fa-xmark"></i>
                        </button>

                        <!-- Profile Image in Popup -->
                        <div class="flex justify-center">
                            <img src="dp/<?php echo empty($user_name['dp']) ? 'defaultUser.webp' : $user_name['dp']; ?>"
                                class="w-50 h-70 rounded-md border-4 border-blue-500 shadow-md">
                        </div>

                        <h2 class="text-xl font-bold text-center mt-4">
                            <?= $user_name['first_name'] ?> <?= $user_name['last_name'] ?>
                        </h2>
                        <p class="text-center text-gray-600"><?= $user_name['bio'] ?></p>

                        <!-- Profile Details -->
                        <div class="mt-4 space-y-2 text-gray-700">
                            <p><i class="fa-solid fa-envelope"></i> <strong>Email:</strong>
                                <?= $user_name['email'] ?>
                            </p>
                            <p><i class="fa-solid fa-phone"></i> <strong>Mobile:</strong> +91
                                <?= $user_name['mobile'] ?>
                            </p>
                            <p><i class="fa-solid fa-calendar"></i> <strong>DOB:</strong>
                                <?php if ($user_name['dob'] != 0) {
                                    $dob = date('Y-m-d', strtotime($user_name['dob']));
                                    echo "$dob";
                                } ?>
                            </p>
                            <p><i class="fa-solid fa-map-marker-alt"></i> <strong>Location:</strong>
                                <?= $user_name['location'] ?></p>
                        </div>
                    </div>
                </div>
                <!-- popup ka javascript -->
                <script>
                    function openProfilePopup() {
                        document.getElementById('profilePopup').classList.remove('hidden');
                    }

                    function closeProfilePopup() {
                        document.getElementById('profilePopup').classList.add('hidden');
                    }
                </script>



                <!-- Messages -->
                <div id="chatBox"
                    class="flex-1 p-4 space-y-2 flex flex-col-reverse mt-20 mb-16 overflow-y-auto overflow-x-hidden">
                    <!-- Messages will be loaded here via AJAX -->
                </div>



                <!-- Input Box -->
                <!-- Image Preview Popup -->
                <div id="imagePopup"
                    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
                    <div class="bg-white p-4 rounded-lg shadow-lg relative w-80">
                        <button id="closePopup"
                            class="absolute top-2 right-2 text-gray-600 hover:text-red-500 text-xl">&times;</button>
                        <img id="popupImg" src="#" class="w-full h-auto rounded-lg">
                        <p class="text-center mt-2 text-sm text-gray-500">Selected Image</p>
                    </div>
                </div>

                <form id="chatForm" method="post" enctype="multipart/form-data">
                    <div
                        class="bg-white p-3 border-t shadow-lg fixed bottom-0 left-0 right-0 md:relative flex items-center gap-2">
                        <label for="imageInput" class="cursor-pointer">
                            <i class="fas fa-image text-2xl text-gray-500 hover:text-blue-500"></i>
                            <input type="file" id="imageInput" name="image" accept="image/*" class="hidden">
                        </label>
                        <input type="text" id="messageInput" name="msg" placeholder="Type a message..."
                            class="w-full p-3 border rounded-md focus:ring-2 bg-gray-100">
                        <button type="submit" name="msg"
                            class="bg-blue-500 text-white px-5 py-3 rounded-md hover:bg-blue-600 shadow-md">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
                <?php
                // Check if a message was submitted
                // if (isset($_POST['msg'])) {
                //     // $sender_id = $_POST['sender_id']; // Adjust according to your session or data
                //     // $receiver_id = $_POST['reciver_id']; // Adjust according to your session or data
                //     // $message = mysqli_real_escape_string($connect, $_POST['msg']);
                

                //     $image = $_FILES['image']['name'];
                //     $tmp_image = $_FILES['image']['tmp_name'];
                //     move_uploaded_file($tmp_image, "dp/$image");

                //     $query = mysqli_query($connect, "INSERT INTO chat (sender_id, receiver_id, image, time) VALUES ('$sender_id', '$reciver_id', '$image', NOW())");

                // }
                ?>


                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function () {
                        $("#imageInput").change(function (event) {
                            let reader = new FileReader();
                            reader.onload = function () {
                                $("#popupImg").attr("src", reader.result);
                                $("#imagePopup").removeClass("hidden"); // Popup Show करो
                            };
                            reader.readAsDataURL(event.target.files[0]);
                        });

                        $("#closePopup").click(function () {
                            $("#imagePopup").addClass("hidden"); // Popup Close करो
                            $("#imageInput").val(""); // Image Reset करो
                        });

                        $("#chatForm").on("submit", function (e) {
                            e.preventDefault();
                            let formData = new FormData(this);
                            formData.append("sendMessage", true);
                            formData.append("receiver_id", "<?= $_GET['user']; ?>");

                            $.ajax({
                                url: "sendMessage.php",
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function () {
                                    $("#messageInput").val("");
                                    $("#imageInput").val("");
                                    $("#imagePopup").addClass("hidden"); // Popup बंद करो
                                    loadMessages();
                                }
                            });
                        });

                        function loadMessages() {
                            $.ajax({
                                url: "loadMessages.php?receiver_id=<?= $_GET['user']; ?>",
                                type: "GET",
                                success: function (data) {
                                    $("#chatContainer").html(data);
                                }
                            });
                        }

                        setInterval(loadMessages, 2000);
                    });
                </script>


            </div>
        </div>

    </div>

    <!-- jQuery & AJAX Script -->
    <script>
        $(document).ready(function () {
            let chatBox = $("#chatBox");
            let isUserScrolling = false;

            function loadMessages(scrollToBottom = false) {
                $.ajax({
                    url: "load_messages.php",
                    type: "POST",
                    data: { sender_id: <?= $sender_id ?>, reciver_id: <?= $reciver_id ?> },
                    success: function (data) {
                        let previousHeight = chatBox[0].scrollHeight; // पुराने मैसेज लोड करने से पहले ऊंचाई

                        chatBox.html(data);

                        if (!isUserScrolling || scrollToBottom) {
                            chatBox.scrollTop(chatBox[0].scrollHeight); // केवल तभी स्क्रॉल जब यूजर स्क्रॉल नहीं कर रहा
                        } else {
                            let newHeight = chatBox[0].scrollHeight;
                            chatBox.scrollTop(chatBox.scrollTop() + (newHeight - previousHeight)); // पुरानी पोजीशन बनाए रखो
                        }
                    }
                });
            }

            loadMessages(true); // लोडिंग के समय हमेशा नीचे स्क्रॉल
            setInterval(loadMessages, 1000);

            $("#chatForm").submit(function (event) {
                event.preventDefault();
                let message = $("#messageInput").val();
                if (message.trim() !== "") {
                    $.ajax({
                        url: "send_message.php",
                        type: "POST",
                        data: { sender_id: <?= $sender_id ?>, reciver_id: <?= $reciver_id ?>, msg: message },
                        success: function () {
                            $("#messageInput").val('');
                            loadMessages(true); // मैसेज भेजने के बाद नीचे स्क्रॉल करो
                        }
                    });
                }
            });

            // जब यूजर स्क्रॉल करता है, तो ऑटो-स्क्रॉल को रोक दो
            chatBox.on("scroll", function () {
                if (chatBox.scrollTop() + chatBox.innerHeight() < chatBox[0].scrollHeight - 50) {
                    isUserScrolling = true;
                } else {
                    isUserScrolling = false;
                }
            });


        });

    </script>




</body>

</html>