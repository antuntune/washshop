<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Select Service</title>

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

                if ($result->num_rows > 0) {
                    echo "User with this username already exist.";
                } else {
                    $hashedPss = password_hash(
                        $inputPassword,
                        PASSWORD_DEFAULT
                    );

                    $stmt = $conn->prepare("INSERT INTO users
                    (name, password)
                    VALUES (?, ?)");

                    $stmt->bind_param("ss", $inputName, $hashedPss);

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
            <h1>Registration</h1>
            <div class="white-container"><div class=container>

                <form method="post" action="">
                    <label for="name">Name:</label>
                    <input type="text" class="text-input" id="name" name="name" required>
                    <br><br>
                    <label for="password">Password:</label>
                    <input type="password" class="text-input" id="password" name="password" required>
                    <br><br>
                    <input type="submit" value="Registration" class="button" id="registation">
                </form>


                <form method="" action="login.php">
                    <input type="submit" value="Login" class="button" id="login-button">
                </form>
            </div>
            </div>

        </main>
    </body>
</html>
