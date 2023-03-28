<?php
include('include_path.php');
session_start();
require_once("php/connection.php");
$title = 'SHOPPING CART';
$style = '"css/shopping_cart.css"';
?>

<?php include('php/head.php'); ?>

<body>
    <section class="background-header">
        <?php include('php/navBar.php'); ?>
        <div class="title">
            <h3>Shopping cart</h3>
        </div>
        <div class="card-bg">
            <?php if (isset($_SESSION['uid'])) { // mostro il carrello solo se utente è loggato ?>
                <div class="wrap">
                    <div class="items-content">
                        <?php include('php/show_cart.php'); ?>
                    </div>
                    <div class="final">
                        <div class="price">
                            <div class=total>Total</div>
                            <div class=number><?php echo $total?> DOGE COINS</div>
                        </div>
                        <form action="shopping_cart.php" method="POST" class="button-form">
                            <!-- rimango in shopping cart ma uso la funzione proceed per svuotare il carrello--> 
                            <button type="submit" class="std-btn proceed" onclick="proceed()"><p class="buy">Proceed</p></button> 
                        </form>
                    </div>
                </div>
            <?php } else {?>
                <div class="not-logged-in-card">
                    <div class="not-logged-in">
                        <div class="not-logged-in-content">
                            <p class =not-logged-in-text>If you want to use the cart you have to be logged in.</p>
                            <a href="login.php" class="std-btn sign-in">Sign in</a>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </section>
</body>
</html>