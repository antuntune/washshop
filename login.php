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
        if ($row["password"] === $inputPassword) {
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
</head>
<body>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
