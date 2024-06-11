<nav>
    <img src="assets/logo.png">
    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        echo '<a href="process/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Uitloggen</a>';
    }
    ?>
</nav>