<?php 
    include('include_path.php');
    $title = '404';
    $style = '"css/404.css"';
    include('php/head.php');
?>

<body>
    <section class="background">
        <?php include('php/navBar.php'); ?>
        <div class="access-Denied-card">
            <div class="access-Denied-content">
                <h3 class="access-Denied-title">404</h3>
                <div class="access-Denied-div">
                    <p class="above-button-text">Page not found</p>
                    <a href="index.php" class="std-btn AD-button">BACK</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
