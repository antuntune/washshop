<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>

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

        <?php include "navbar.php"; ?>
        <?php
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "washshop";

        $conn = new mysqli($host, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $mode_id = $_POST["mode_id"];
        $date = $_POST["date"];
        $time = $_POST["time"];
        $machine_id = $_POST["machine_id"];

        $qrcode = bin2hex(random_bytes(20 / 2));

        $stmt = $conn->prepare("INSERT INTO reservations
        (user_id, machine_id, mode_id, date, time, qrcode)
        VALUES (?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "iiisss",
            $userId,
            $machine_id,
            $mode_id,
            $date,
            $time,
            $qrcode
        );

        if ($stmt->execute()) {
            $infoMessage = "Reservation successfully added!";
        } else {
            $infoMessage = "Fehler: " . $stmt->error;
        }
        $stmt->close();

        echo $infoMessage;
        ?>




    </body>
</html>
