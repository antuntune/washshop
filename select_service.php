<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="select_service.css">
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

        <main>
        <h1>New Reservation</h1>
        <div class="white-container">
            <img src="src/step1.png" alt="" class="step">

        <form action="select_mode.php" method="post">

                <div class="radio-card-group">
                        <input type="radio" id="option1" name="service" value="washing">
                        <label for="option1" class="radio-card">
                            <img src="src/washing.svg" alt="saafsas" id="washing-icon">
                            <h3>Washing</h3>
                        </label>

                        <input type="radio" id="option2" name="service" value="drying">
                        <label for="option2" class="radio-card">
                            <img src="src/dry.svg" alt="saafsas"id="dry-icon">
                            <h3>Drying</h3>
                        </label>


                    </div>

            <input type="submit">
        </form>
        </div>
        </main>
    </body>
</html>
