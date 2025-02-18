<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Select Service</title>
    </head>
    <body>

        <h1>Registration</h1>
        <?php
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "washshop";

        $conn = new mysqli($host, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $inputName = $_POST["name"];
            $inputPassword = $_POST["password"];
            $sql = "SELECT * FROM users WHERE name = '$inputName';";
            $result = $conn->query($sql);
            if($result->num_rows > 0){
                echo "User with this username already exist.";
            } else {
                $hashedPss = password_hash($inputPassword, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO users
                (name, password)
                VALUES (?, ?)");

                $stmt->bind_param(
                    "ss",
                    $inputName,
                    $hashedPss);

                if ($stmt->execute()) {
                    $infoMessage = "User successfully added!";
                } else {
                    $infoMessage = "Error: " . $stmt->error;
                }
                $stmt->close();
        
                echo $infoMessage;
            }

        }

        $conn->close();
        ?>

        <form method="post" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <input type="submit" value="Registration">
        </form>

        <form method="" action="login.php">
            
            <input type="submit" value="< Back to Login">
        </form>
    </body>
</html>