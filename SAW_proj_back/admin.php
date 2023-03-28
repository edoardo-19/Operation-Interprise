<?php
include('include_path.php');
session_start();
$title = 'CONTACTS';
$style = '"css/admin.css"';
//pagina dell'admin per rimuovere utenti dal sito, (non abbiamo un database delle mail non piu valide) 

?>

<?php if (isset($_SESSION['aid'])) { ?>

    <?php include('php/head.php'); ?>

    <body>
        <section class="background-header">
            <?php include('php/navBar.php'); ?>
            <div class="title">
                <h3>All Users</h3>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="all-users">
                        <?php include('php/show_users.php'); // includiamo show_user per mostrare i profili ?>
                    </div>
                    <!-- la classe css "price" e "final" è riutilizzata--> 
                    <div class="total-div">
                        <div class="total-text">Total Users:</div>
                        <div class="total-number"><?php echo $totalUsers ?></div>
                    </div>
                </div>
            </div>
        </section>
    </body>

    </html>
<?php } ?>