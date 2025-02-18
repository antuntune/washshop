<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <h1>Select Service</h1>
        <form action="select_mode.php" method="post">

            <label>
                    <input type="radio" name="service" value="washing">
                    Washing
                </label><br>
                <label>
                    <input type="radio" name="service" value="drying">
                    Drying
                </label>

            <input type="submit">
        </form>
    </body>
</html>
