<?php
include('include_path.php');
session_start();
require_once("php/connection.php");
$title = 'PROGRAMS';
$style = '"css/programs.css"';
?>

<?php include('php/head.php');?>

<body>

    <section class="background">
        <?php include('php/navBar.php'); ?>

        <form action="" class="search" id="form">
            <input autofocus type="text" name="search" class="search-input" id="search-input" autocomplete="off" placeholder="Search" onkeyup="showResults(this.value)">
        </form>
        <div class="programs-wrap-container" id="wrap-container">
            
        </div>
    </section>
    <?php include('php/footer.php'); ?>
    <script> showResults(''); </script>
</body>

</html>