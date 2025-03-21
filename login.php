<?php include_once "db.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">

    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-lg">
        <!-- Title -->
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-5">Login to Your Account</h2>
        
        <!-- Login Form -->
        <form action="" method="POST" class="space-y-4">
            
            <!-- Email -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Enter your email" required>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="password" name="password" class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Enter your password" required>
            </div>

            <!-- Login Button -->
            <button type="submit" name="login" class="w-full bg-blue-500 text-white p-3 rounded-md font-bold text-lg hover:bg-blue-600 transition duration-300">Login</button>

            <!-- Forgot Password & Signup -->
            <div class="flex justify-between text-sm text-gray-600 mt-3">
                <a href="#" class="hover:underline">Forgot Password?</a>
                <a href="signup.php" class="text-blue-500 hover:underline">Create Account</a>
            </div>
        </form>
        <?php
            if(isset($_POST['login'])){
                $email = $_POST['email'];
                
                $password = $_POST['password'];

                $count_user = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM users where email='$email' AND password='$password'"));
                if($count_user > 0 ){
                    $_SESSION['email'] = $email ;
                    echo "<script>window.location.href='index.php';</script>";
                } else {
                    echo "faileddddddddddddddddd";
                }
            }
        ?>
    </div>

</body>
</html>
