<?php
session_start();
include("email.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile_number = $_POST['mobile_number'];
    $password = $_POST['password'];

    include "conn.php";

    // Check if email or mobile number already exists
    $query = "SELECT * FROM users WHERE email='$email' OR mobile_number='$mobile_number'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "Email or Mobile Number already exists!";
    } else {
        // the password hide
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user details into users table
        $insert_query = "INSERT INTO users (name, email, mobile_number, password) VALUES ('$name', '$email', '$mobile_number', '$hashed_password')";
        if (mysqli_query($con, $insert_query)) {
            $user_id = mysqli_insert_id($con);  // Get the inserted user ID

            // Generate a 6-digit OTP
            $otp = rand(100000, 999999);

            // Store OTP in otp_verification table
            $otp_query = "INSERT INTO otp_verification (user_id, otp) VALUES ('$user_id', '$otp')";
            mysqli_query($con, $otp_query);

            // Send OTP to the user's email
            send_otp($email, "OTP for Registration", $otp);

            $_SESSION['user_id'] = $user_id;
            echo "OTP sent to your email. Please verify!";
            header("location:verify_otp.php");
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }

    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="text" name="mobile_number" placeholder="Enter your mobile number" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Register</button>
            <br>
            <br>
            <a href="login.php">Login</a>
        </form>
    </div>
</body>
</html>
