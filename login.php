<?php
session_start();

// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$dbname = "washshop";

// Create connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputName = $_POST["name"];
    $inputPassword = $_POST["password"];

    // Simple SQL query (without parameterization)
    $sql = "SELECT id, name, password FROM users WHERE name = '$inputName'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the result row
        $row = $result->fetch_assoc();

        // Compare input password with the password from the database
        if (password_verify($inputPassword, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["name"] = $row["name"];
            echo "Login successful! Welcome, " .
                htmlspecialchars($row["name"]) .
                ".";
            // Redirect or load a protected page, e.g., dashboard.php
            header("Location: reservations.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that name.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <div class="logo-div">
            <img src="src/logo.svg" alt="logo" id="logo">

            <h1>Lavandería Brillante</h1>
        </div>
        <img src="src/nav.svg" alt="logo" id="wave1">
        <img src="src/nav.svg" alt="logo" id="wave2">

    </header>

    <main>
    <h1>Login</h1>
        <div class="white-container"><div class="container">
            <form method="post" action="">
                <label for="name">Name:</label>
                <input type="text" class="text-input" id="name" name="name" required>
                <br><br>
                <label for="password">Password:</label>
                <input type="password" class="text-input" id="password" name="password" required>
                <br><br>
                <input type="submit" value="Login" class="button" id="login-button">
            </form>

            <form method="" action="registration.php">
                <input type="submit" value="Registration" class="button" id="registation">
            </form>
        </div>
        </div>
    </main>



</body>
</html>
