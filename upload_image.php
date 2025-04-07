<?php include_once "db.php"; ?>
<?php
if (isset($_FILES['image'])) {
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['reciver_id'];

    $image = $_FILES['image']['name'];
    $tmp_image = $_FILES['image']['tmp_name'];

    $upload_path = "dp/";
    if (!file_exists($upload_path)) {
        mkdir($upload_path, 0777, true);
    }

    $image_path = $upload_path . basename($image);

    if (move_uploaded_file($tmp_image, $image_path)) {
        $query = mysqli_query($connect, "INSERT INTO chat (sender_id, reciver_id, image, time) VALUES ('$sender_id', '$receiver_id', '$image', NOW())");

        if ($query) {
            echo "Image uploaded successfully.";
        } else {
            echo "Database insert failed.";
        }
    } else {
        echo "Image upload failed.";
    }
} else {
    echo "No image received.";
}
?>
