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

$host = "localhost";
$username = "root";
$password = "";
$dbname = "washshop";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT
    r.*,
    m.name
FROM
    reservations r
INNER JOIN
    modes m
ON
    r.mode_id = m.modeId
WHERE
    r.user_id = $userId;";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="reservations.css">
    <title>Reservations</title>
</head>
<body>
    <?php include "navbar.php"; ?>
    <main>
        <div class="header">
    <h1>Your Reservations</h1>
    <a href="select_service.php">Make reservation</a>
        </div>
    <div class="white-container">
        <div class="container">
    <h3>Upcoming</h3>
    <div class="cards-group">
<?php
while ($row = $result->fetch_assoc()) {
    // Remove hyphens from the date string
    $dateWithoutHyphens = str_replace("-", "", $row["date"]);
    // Convert the resulting string to an integer
    $dateAsInt = (int) $dateWithoutHyphens;

    $resId = $row["id"];

    if ($dateAsInt >= date("Ymd")) {
        echo "" .
            "<div class='res-card'><p class='date'>" .
            htmlspecialchars($row["date"]) .
            "</p><p class='time'>" .
            htmlspecialchars($row["time"]) .
            "</p><p class='mode-name'>" .
            htmlspecialchars($row["name"]) .
            "</p>
            <form action='res_details.php' method='post'>
            <input type='submit' value='More details'>
            <input type='hidden' value='$resId' name='resId'>
            </form>

            </div>";
    }
}

$result2 = $conn->query($sql);
?>
    </div>
<h3>Past</h3>
<div class="cards-group">
<?php while ($row = $result2->fetch_assoc()) {
    // Remove hyphens from the date string
    $dateWithoutHyphens = str_replace("-", "", $row["date"]);
    // Convert the resulting string to an integer
    $dateAsInt = (int) $dateWithoutHyphens;
    if ($dateAsInt < date("Ymd")) {
        echo "" .
            "<div class='res-card'><p class='date'>" .
            htmlspecialchars($row["date"]) .
            "</p><p class='time'>" .
            htmlspecialchars($row["time"]) .
            "</p><p class='mode-name'>" .
            htmlspecialchars($row["name"]) .
            "</p></div>";
    }
} ?>
    <!-- Here you can add more functionality, like fetching and displaying the user's reservations from the database -->

</div>
        </div>
    </div>
    </main>
</body>
</html>
