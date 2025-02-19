<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="res_details.css">
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

        $resId = $_POST["resId"];

        $sql = "SELECT
            r.*,
            m.name, m.duration, m.price
        FROM
            reservations r
        INNER JOIN
            modes m
        ON
            r.mode_id = m.modeId
        WHERE
            r.id = $resId;";

        $result = $conn->query($sql);

        $details = $result->fetch_assoc();

        $end_time = date(
            "H:i:s",
            strtotime($details["time"]) + $details["duration"] * 60
        );
        ?>
        <main>
        <h1>Reservation Details</h1>
        <div class="white-container">
        <div class="container">
            <div class="left">
                <h2>QR Code</h2>
                <div id="qrcode" class="qrcode"></div>
                <p>Scan this QR code at the laundry to access your reservation.</p>

            </div>
            <div class="right">
                <h2>Service Type</h2>
                <p><?php echo $details["name"]; ?></p>
                <h2>Time</h2>
                <p></p>
                <h3>Begintime</h3>
                <p><?php echo $details["time"]; ?></p>
                <h3>Endtime</h3>
                <p><?php echo $end_time; ?></p>
                <h3>Duration</h3>
                <p><?php echo $details["duration"]; ?> min</p>

                <h2>Price</h2>
                <p><?php echo $details["price"]; ?> €</p>
            </div>


        </div>
        </div>
        </main>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <script type="text/javascript">
        new QRCode(document.getElementById("qrcode"), "<?php echo $details[
            "qrcode"
        ]; ?>");
        </script>
    </body>
</html>
