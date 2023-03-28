<?php
include('include_path.php');
session_start();
require_once("php/connection.php");
include('php/common/score_to_stars.php');
$title = 'REVIEWS';
$style = '"css/reviews.css"';
//sfrutto un'altra pagina per stampre le reviwes a video
?>

<?php include('php/head.php'); ?>

<body>
    <section class="background">
        <?php include('php/navBar.php'); ?>
        <div class="page-title">
            <h3>Reviews</h3>
        </div>
        <section class="reviews-container" id="result-container">
            <?php include('php/show_reviews.php'); ?>
        </section>
    </section>
    <?php include('php/footer.php'); ?>
</body>
</html>