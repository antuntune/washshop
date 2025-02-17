<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>

    <?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "washshop";

    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // User inputs
    $date = $_POST["date"]; // e.g., '2025-02-18'
    $time = $_POST["h"] . ":" . $_POST["m"] . ":00";
    $mode_id = $_POST["mode_id"];
    $service = $_POST["service"];

    // Get mode duration
    $query = "SELECT duration FROM modes WHERE modeId = '$mode_id'";
    $result = $conn->query($query);
    $mode = $result->fetch_assoc();
    $duration = $mode["duration"];

    // Calculate the end time
    $end_time = date("H:i:s", strtotime($time) + $duration * 60);

    echo $date;
    echo $time;
    echo var_dump($end_time);

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
                    (r.time >= '$time' AND r.time < '$end_time') AND
                    (r.time < '$time' AND ADDTIME(r.time, SEC_TO_TIME($duration * 60)) > '$time')
                )
            )
        ";

    $result = $conn->query($query);

    echo var_dump($result);

    $available_machine = $result->fetch_all();

    echo var_dump($available_machine);
    echo "<br>";

    if ($available_machine) {
        echo "There is at least one machine available at this time.";
    } else {
        echo "No machines are available during this time.";
    }
    ?>


    </body>
</html>
