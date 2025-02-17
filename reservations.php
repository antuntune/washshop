<?php
session_start();

// Check if the user is logged in by ensuring session variables are set
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["name"])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Access session data
$userId = $_SESSION["user_id"];
$userName = $_SESSION["name"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservations</title>
</head>
<body>
    <h1>Your Reservations</h1>

    <!-- Echo out session data -->
    <p>User ID: <?php echo htmlspecialchars($userId); ?></p>
    <p>Username: <?php echo htmlspecialchars($userName); ?></p>

    <!-- Here you can add more functionality, like fetching and displaying the user's reservations from the database -->

    <a href="select_service.php">Make reservation</a>

    <br>

    <a href="logout.php">Logout</a>
</body>
</html>
