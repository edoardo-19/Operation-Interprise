<?php
include('include_path.php');
session_start();
$title = 'ABOUT';
$style = '"css/about.css"';
?>
<?php include('php/head.php'); ?>

<body>
    <section class="sub-header">

        <?php include('php/navBar.php'); ?>

        <h1>About Us</h1>
    </section>

    <!----------------about us content------------------->
    <section class="about-us">
        <h1>What we offer</h1>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sint earum quaerat quibusdam, enim ex aperiam praesentium fuga temporibus ullam hic qui nesciunt! Error voluptatum facilis vero numquam, neque minus nemo?</p>
        <div class="row">
            <div class="program-detail-col">
                <h1>Colonization</h1>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quae dolore asperiores eos nesciunt eum laboriosam porro minus reiciendis possimus nam unde molestias doloremque, adipisci at consequuntur vel, totam itaque. Dignissimos.</p>
            </div>
            <div class="program-detail-col">
                <img src="images/mars-colony3.jpg" alt="mars colony image">
            </div>
        </div>
        <div class="row">
            <div class="program-detail-col">
                <img src="images/room1.jpg" alt="room">
            </div>
            <div class="program-detail-col">
                <h1>Space Station Vacation</h1>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quae dolore asperiores eos nesciunt eum laboriosam porro minus reiciendis possimus nam unde molestias doloremque, adipisci at consequuntur vel, totam itaque. Dignissimos.</p>
            </div>
        </div>
        <div class="row">
            <div class="program-detail-col">
                <h1>Interplanetary Activities</h1>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quae dolore asperiores eos nesciunt eum laboriosam porro minus reiciendis possimus nam unde molestias doloremque, adipisci at consequuntur vel, totam itaque. Dignissimos.</p>
            </div>
            <div class="program-detail-col">
                <img src="images/road-trip.jpg" alt="roard trip">
            </div>
        </div>
        <div class="row">
            <div class="about-col">
                <img src="images/about.jpg" alt="technicians talking">
            </div>
            <div class="about-col">
                <h1>We have the most brilliant engineers <br>the universe can offer</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate sit aperiam natus delectus debitis eaque nostrum asperiores dolore doloremque tempore accusamus perspiciatis dolores modi odio perferendis corrupti, aut assumenda animi.</p>
            </div>
        </div>
    </section>

    <?php include('php/footer.php'); ?>

</body>

</html>