<?php
include_once "db.php";
// session_start();

if (!isset($_SESSION['email'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$email = $_SESSION['email'];

$query = "SELECT chat_user_id, users.first_name, users.last_name, users.dp, 
    (SELECT message FROM chat 
    WHERE (sender_id = chat_user_id AND reciver_id = (SELECT id FROM users WHERE email = '$email')) 
       OR (sender_id = (SELECT id FROM users WHERE email = '$email') AND reciver_id = chat_user_id) 
    ORDER BY time DESC LIMIT 1) AS last_message,
    (SELECT time FROM chat 
    WHERE (sender_id = chat_user_id AND reciver_id = (SELECT id FROM users WHERE email = '$email')) 
       OR (sender_id = (SELECT id FROM users WHERE email = '$email') AND reciver_id = chat_user_id) 
    ORDER BY time DESC LIMIT 1) AS last_chat_time
FROM users
JOIN (
    SELECT DISTINCT 
        CASE 
            WHEN sender_id = (SELECT id FROM users WHERE email = '$email') THEN reciver_id 
            ELSE sender_id 
        END AS chat_user_id
    FROM chat
    WHERE sender_id = (SELECT id FROM users WHERE email = '$email') 
       OR reciver_id = (SELECT id FROM users WHERE email = '$email')
) AS chat_users ON users.id = chat_users.chat_user_id
ORDER BY last_chat_time DESC";

$result = mysqli_query($connect, $query);
$output = "";

while ($chat = mysqli_fetch_assoc($result)) {
    $chat_user_id = $chat['chat_user_id'];

    $user_query = mysqli_query($connect, "SELECT * FROM users WHERE id = '$chat_user_id'");
    $user = mysqli_fetch_assoc($user_query);

    $output .= '
        <a href="message.php?user='.$user['id'].'">
            <div class="user-item flex items-center p-2 hover:bg-gray-200 rounded cursor-pointer">
                <img src="dp/'.(empty($user['dp']) ? "defaultUser.webp" : $user['dp']).'" class="w-12 h-12 rounded-full mr-3">
                <div>
                    <h1 class="text-xl font-medium text-gray-800">'.$user['first_name'].' '.$user['last_name'].'</h1>
                    <p class="text-sm text-gray-500">'.(isset($chat['last_message']) && strlen($chat['last_message']) > 25
                        ? substr($chat['last_message'], 0, 25) . "..."
                        : ($chat['last_message'] ?? 'No messages yet')).'</p>
                </div>
            </div>
        </a>';
}

// Output Users List
echo $output;
?>
