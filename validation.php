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


<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "washshop";
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} // User inputs
$date = $_POST["date"]; // e.g., '2025-02-18'
$time = $_POST["h"] . ":" . $_POST["m"] . ":00";
$mode_id = $_POST["mode_id"];
$service = $_POST["service"]; // Get mode duration
$query = "SELECT * FROM modes WHERE modeId = '$mode_id'";
$result = $conn->query($query);
$mode = $result->fetch_assoc();
$duration = $mode["duration"];
$mode_name = $mode["name"];
$price = $mode["price"]; // Calculate the end time
$end_time = date("H:i:s", strtotime($time) + $duration * 60);
// Check if any machine is available at the given time
$query = "
     SELECT m.id
     FROM machines m
     WHERE m.type = '$service' AND
     NOT EXISTS (
         SELECT 1
         FROM reservations r
         WHERE r.machine_id = m.id
         AND r.date = '$date'
         AND (
             (r.time >= '$time' AND r.time < '$end_time') OR
             (r.time < '$time' AND ADDTIME(r.time, SEC_TO_TIME($duration * 60)) > '$time')
         )
     )
 ";
$result = $conn->query($query);
$available_machine = $result->fetch_all();
$machine_id = $available_machine[0][0];
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="validation.css">
        <title>Document</title>
    </head>
    <body>
<?php include "navbar.php"; ?>
<main>
    <h1>New Reservation</h1>
    <div class="white-container">
    <img src="src/step3.png" alt="" class="step">
    <div class="container">
<?php if ($available_machine) {
    echo "

        <div class='form-left'>
        <h2>Checkout: </h2>
        <h3>Service: </h3>
        <p>$service</p>
        <h3>Mode: </h3>
        <p>$mode_name</p>
        <h3>Time: </h3>
        <p>$time - $end_time ($duration min)</p>
        <h3>Price: </h3>
        <p>$price €</p>
        </div>
        <div class='form-right'>
        <form action='finish.php'' method='post''>
        <h2>Payment Method:</h2>

                <div class='radio-card-group'>
                        <input type='radio' name='pay' id='option1'>
                        <label for='option1' class='radio-card'>
                        <i class='fa-brands fa-google-pay'></i>
                            Google Pay
                        </label>
                        <input type='radio' name='pay' id='option2'>
                        <label for='option2' class='radio-card'>
                        <i class='fa-brands fa-apple-pay'></i>
                            Apple Pay
                        </label>
                        <input type='radio' name='pay' id='option3'>
                        <label for='option3' class='radio-card'>
                        <i class='fa-brands fa-cc-paypal'></i>
                            PayPal
                        </label>
                        <input type='radio' name='pay' id='option4'>
                        <label for='option4' class='radio-card'>
                        <i class='fa-brands fa-cc-visa'></i>
                            Visa
                        </label>

                    </div>


            <input type='hidden'' name='mode_id'' id='hiddenField'' value='$mode_id' />
            <input type='hidden'' name='date'' id='hiddenField'' value='$date' />
            <input type='hidden'' name='time'' id='hiddenField'' value='$time' />
            <input type='hidden'' name='machine_id'' id='hiddenField'' value='$machine_id' />



                <input type='submit' value='Pay'>
            </form>
        </div>



        ";
} else {
    echo "No machines are available during this time.";
} ?>
    </div>
</div>
</main>
    </body>
</html>
