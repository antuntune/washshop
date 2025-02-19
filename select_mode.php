<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="select_mode.css">
        <title>Select Service</title>
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

        $service = $_POST["service"];
        $sql = "SELECT * FROM modes WHERE type='$service';";
        $result = $conn->query($sql);
        ?>

        <main>
            <h1>New Reservation</h1>
            <div class="white-container">
            <img src="src/step2.png" alt="" class="step">
            <div class="container"></div>

        <form action="validation.php" method="post">
            <div class=form-left>
                <h3>Mode:</h3>
            <div class="radio-card-group">
                <?php while ($row = $result->fetch_assoc()) { ?>

                        <input type="radio" name="mode_id" value="<?php echo $row[
                            "modeId"
                        ]; ?>" id="<?php echo $row["modeId"]; ?>">

                            <label class="radio-card" for="<?php echo $row[
                                "modeId"
                            ]; ?>">
                                <?php echo htmlspecialchars($row["name"]) .
                                    " - " .
                                    htmlspecialchars($row["price"]) .
                                    "€ (" .
                                    htmlspecialchars($row["duration"]) .
                                    "min)"; ?>
                    </label><br>

                <?php } ?>
            </div>
            </div>
            <div class="form-right">
                <h3>Time:</h3>
            <label for="date">Date:</label>
              <input type="date" id="dateInput" name="date">
              <div>
              <label for="h">Hour:</label>
              <select name="h" id="h">
                  <?php for ($i = 0; $i < 24; $i++) {
                      $formattedNumber = sprintf("%02d", $i);
                      echo "<option value='$formattedNumber'>$formattedNumber</option>";
                  } ?>
              </select>

              <label for="m">Minute:</label>
              <select name="m" id="m">
                  <option value="00">00</option>
                  <option value="15">15</option>
                  <option value="30">30</option>
                  <option value="45">45</option>
              </select></div>
            </div>
            <input type="submit" value="Next">

            <input type="hidden" name="service" id="hiddenField" value="<?php echo $service; ?>" />
        </form>
        </div>
</main>
        <!-- only for setting default day to today -->
        <script>
            // Create a new Date object for today
            const today = new Date();

            // Get the year, month, and day, and format them to YYYY-MM-DD
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            const day = String(today.getDate()).padStart(2, '0');

            // Set the value of the date input to today’s date in the format YYYY-MM-DD
            document.getElementById('dateInput').value = `${year}-${month}-${day}`;
        </script>
    </body>
</html>
