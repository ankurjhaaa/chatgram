<?php include_once "db.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">

    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-lg">
        <!-- Title -->
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-5">Create an Account</h2>

        <!-- Signup Form -->
        <form action="" method="POST" class="space-y-4">

            <!-- First Name -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">First Name</label>
                <input type="text" name="first_name"
                    class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Enter first name" required>
            </div>

            <!-- Last Name -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Last Name</label>
                <input type="text" name="last_name"
                    class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Enter last name" required>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email"
                    class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Enter email" required>
            </div>

            <!-- Mobile -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Mobile</label>
                <input type="tel" name="mobile"
                    class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Enter mobile number" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="tel" name="password"
                    class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Enter mobile number" required>
            </div>

            <!-- Signup Button -->
            <button type="submit" name="signup"
                class="w-full bg-blue-500 text-white p-3 rounded-md font-bold text-lg hover:bg-blue-600 transition duration-300">Sign
                Up</button>

            <!-- Already have an account -->
            <p class="text-center text-gray-600 text-sm mt-3">
                Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login</a>
            </p>
        </form>
    </div>

</body>

</html>
<?php
if (isset($_POST['signup'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    // Simple validation (For demo purposes)
    if (empty($first_name) || empty($last_name) || empty($email) || empty($mobile)) {
        die("All fields are required!");
    }

    $insert_user = mysqli_query($connect,"INSERT INTO users (first_name,last_name,email,mobile,password) VALUE ('$first_name','$last_name','$email','$mobile','$password')");

}
?>