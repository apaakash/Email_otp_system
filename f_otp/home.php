<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

include"conn.php";


$query = "SELECT * FROM users WHERE uid='$user_id'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="home-container">
        <h1>Welcome, <?php echo $row['name']; ?>!</h1>
        <p>Email: <?php echo $row['email']; ?></p>
        <p>Mobile Number: <?php echo $row['mobile_number']; ?></p>
        <p>Status: <?php echo $row['status']; ?></p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
