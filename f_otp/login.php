<?php

session_start();
$UserError1 = false;
$UserError = false;
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the reCAPTCHA response token from the form
    $recaptcha_response = $_POST['g-recaptcha-response'];  
    $secret_key = '6Legj50qAAAAAOllnvKKOCr39sYhp-a60hxQo2Xm';  // Secret Key for verification

    // Check if the reCAPTCHA response is empty
    if (empty($recaptcha_response)) {
        $UserError1 = true;
    }

    // Send the reCAPTCHA response to Google’s server for validation
    $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $recaptcha_response);
    $response_keys = json_decode($response);  // Decode the JSON response from Google

    // Check if the verification was successful
    if ($response_keys->success) {
        // reCAPTCHA verification successful, proceed with login
        $email = $_POST['email'];
        $password = $_POST['password'];

        include "conn.php";  // Database connection

        // Sanitize user input to prevent SQL injection
        $email = mysqli_real_escape_string($con, $email);
        $password = mysqli_real_escape_string($con, $password);

        // Query to check if user exists
        $query = "SELECT * FROM users WHERE email='$email' AND status='active'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            // Fetch user data
            $row = mysqli_fetch_assoc($result);

            // Verify password
            if (password_verify($password, $row['password'])) {
                // Password is correct
                $_SESSION['user_id'] = $row['uid'];  // Store user ID in session
                header('Location: home.php');  // Redirect to home page after successful login
                exit();
            } else {
                echo "<script>alert('Invalid login credentials!!')</script>";
            }
        } else {
            echo "<script>alert('No active user found with that email!!')</script>";
        }

        mysqli_close($con);
    } else {
        $UserError = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php echo $UserError ? "<h1 class='errorText'>ERROR TRY ONE MORE !</h1>" : ""; ?>
        <?php echo $UserError1 ? "<h1 class='errorText'>Please complete the reCAPTCHA verification.</h1>" : ""; ?>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            
            <!-- reCAPTCHA Widget -->
            <div class="g-recaptcha" data-sitekey="6Legj50qAAAAALZZmfZBYCpqIPHzmiJp2p8dlQJJ"></div>

            
            <button type="submit">Login</button>
            <br><br>
            <a href="register.php">Register</a>
        </form>
    </div>
</body>
</html>
