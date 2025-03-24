<?php 
include "db.php";
$sender_id = $_POST['sender_id'];
$reciver_id = $_POST['reciver_id'];

$query = "SELECT * FROM chat WHERE (sender_id='$sender_id' AND reciver_id='$reciver_id') OR (sender_id='$reciver_id' AND reciver_id='$sender_id') ORDER BY time DESC";
$result = mysqli_query($connect, $query);

$prev_date = '';

while ($msg = mysqli_fetch_assoc($result)) {
    $message_date = date("d M Y", strtotime($msg['time'])); // तारीख को फॉर्मेट करें
    
    // अगर तारीख बदल गई है, तो इसे दिखाएं
    if ($message_date != $prev_date) {
        echo "<div class='w-full text-center my-2'>";
        echo "<span class='bg-gray-300 text-gray-700 px-3 py-1 rounded-lg text-sm'>$message_date</span>";
        echo "</div>";
        $prev_date = $message_date;
    }

    $is_sender = ($msg['sender_id'] == $sender_id);
    echo "<div class='flex " . ($is_sender ? 'justify-end' : 'justify-start') . "'>";
    echo "<div class='max-w-[80%] px-4 py-2 rounded-lg shadow-md " . ($is_sender ? 'bg-green-700 text-white' : 'bg-gray-400 text-black') . "'>";
    echo "<p>" . nl2br(htmlspecialchars($msg['message'])) . "</p>";
    echo "<span class='text-xs block text-right'>" . date("h:i A", strtotime($msg['time'])) . "</span>";
    echo "</div></div>";
}

?>

