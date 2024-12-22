<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get OTP from form and user session
    $otp_input = $_POST['otp'];
    $user_id = $_SESSION['user_id'];

    include "conn.php"; // Make sure the database connection is included

    // Fetch the stored OTP for the user
    $query = "SELECT * FROM otp_verification WHERE user_id='$user_id' ORDER BY created_at DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if ($otp_input == $row['otp']) {
        // Update user status to 'active' after successful OTP verification
        $update_query = "UPDATE users SET status='active' WHERE uid='$user_id'";
        mysqli_query($con, $update_query);

        // Show success message and then redirect to login page
        echo "<script>
                alert('You have been registered successfully!');
                window.location.href = 'login.php';
            </script>";
    } else {
        echo "<script>alert('Invalid OTP!');</script>";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="form-container">
        <h2>Verify OTP</h2>
        <form method="POST" action="">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>

</html>