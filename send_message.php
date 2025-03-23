<?php 
include "db.php";
$sender_id = $_POST['sender_id'];
$reciver_id = $_POST['reciver_id'];
$msg = mysqli_real_escape_string($connect, $_POST['msg']);



mysqli_query($connect, "INSERT INTO chat (reciver_id, sender_id, message, time) VALUES ('$reciver_id', '$sender_id', '$msg', NOW())");
?>

