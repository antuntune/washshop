<script src="https://kit.fontawesome.com/897ce9ffbc.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="navbar.css">

<nav>
    <div id="logo-div">
    <img src="src/logo.svg" alt="logo" id="logo">
    <h1>Lavandería Brillante</h1>
    </div><div>
    <a href="reservations.php">Reservations</a>
    <i class="fa-solid fa-circle-user"></i>
    <p><?php echo $_SESSION["name"]; ?></p>
    <a href="logout.php">LOGOUT</a></div>



</nav>
 <img src="src/nav.svg" alt="svg" id="svg">
