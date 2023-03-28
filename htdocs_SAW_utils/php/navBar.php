<?php
//funzione che controlla se l'utente è registrato e modifica il pulsate di conseguenza
function loginBtn()
{
    if (isset($_SESSION['uid'])) {
        echo '<li class="login-btn-decor-override"><a href="show_profile.php" class="std-btn login-btn">PROFILE</a></li>';
    } else {
        echo '<li class="login-btn-decor-override"><a href="login.php" class="std-btn login-btn">LOGIN</a></li>';
    }
}
?>


<?php
//funzione che controlla se l'utente è un admin e modifica il pulsate di conseguenza
function verifyAdmin()
{
    if (isset($_SESSION['aid'])) {
        echo '<li><a href="admin.php">ADMIN</a></li>';
    }
}
?>
<!-- html della navbar, una lista non ordinata con due campi frutto della chiamata di due funzioni-->
<nav>
    <a href="index.php"><img src="images/star-trek-logo2.png" alt="logo"></a>
    <div class="nav-links" id="navLinks">
        <i class="fa fa-times" onclick="hideMenu()"></i>
        <ul>
            <li><a href="index.php">HOME</a></li>
            <li><a href="about.php">ABOUT</a></li>
            <li><a href="programs.php">PROGRAMS</a></li>
            <li><a href="reviews.php">REVIEWS</a></li>
            <?php verifyAdmin(); ?>
            <li><a href="shopping_cart.php">CART</a></li>
            <?php loginBtn(); ?>

        </ul>
    </div>
    <i class="fa fa-bars" onclick="showMenu()"></i>
</nav>