<script src="https://kit.fontawesome.com/897ce9ffbc.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="navbar.css">

<nav>

    <div id="logo-div">
    <a href="reservations.php"><img src="src/logo.svg" alt="logo" id="logo"></a>
    <h1>Lavandería Brillante</h1>

    </div><div class="header-left">
    <a href="reservations.php"><i class="fa-solid fa-calendar"> </i> Reservations</a>

    <div class="user">

    <span><i class="fa-solid fa-circle-user"> </i> <?php echo $_SESSION[
        "name"
    ]; ?></span>
    <a href="logout.php" class="logout">LOGOUT</a></div>
</div>


</nav>
 <img src="src/nav.svg" alt="svg" id="svg">
