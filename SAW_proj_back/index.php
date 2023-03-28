<?php
include('include_path.php');
session_start();
$title = 'OPERATION ENTERPRISE';
$style = '"css/index.css"';
?>
<?php include('php/head.php'); ?>
<!-- homepage del sito-->

<body>
    <section class="background-header">
        <?php include('php/navBar.php'); ?>
        <div class="text-box">
            <h1>Operation Enterprise</h1>
            <p>Prepare for warp speed.</p>
            <a href="programs.php" class="std-btn">Browse our programs</a>
        </div>
    </section>

    <!----------------program------------------->
    <section class="program">
        <h1>Programs we offer</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos culpa, exercitationem ipsum facere porro fugit excepturi delectus deserunt nulla quo dolores, qui accusamus. Ipsum ad similique blanditiis atque, officia exercitationem!</p>

        <div class="row">
            <div class="program-col">
                <h3>Colonization</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim beatae a doloremque? Suscipit, officia cupiditate? Eos, fugiat sint. Fugiat aspernatur inventore facilis odio voluptas? Fuga omnis enim velit vero minus?</p>
            </div>
            <div class="program-col">
                <h3>Space Station Vacation</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim beatae a doloremque? Suscipit, officia cupiditate? Eos, fugiat sint. Fugiat aspernatur inventore facilis odio voluptas? Fuga omnis enim velit vero minus?</p>
            </div>
            <div class="program-col">
                <h3>Interplanetary Activities</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim beatae a doloremque? Suscipit, officia cupiditate? Eos, fugiat sint. Fugiat aspernatur inventore facilis odio voluptas? Fuga omnis enim velit vero minus?</p>
            </div>
        </div>
    </section>

    <!----------------stations------------------->
    <section class="stations">
        <h1>Our Space Stations</h1>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Vero similique eveniet quidem earum, temporibus placeat omnis ducimus optio? Illo dolores delectus tempora natus perferendis sint at molestiae sequi, voluptas aliquid?</p>
        <div class="row">
            <div class="stations-col">
                <img src="images/arasaka-orbital-station-new.jpg" alt="orbital station">
                <div class="layer">
                    <h3>ARASAKA<br>ORBITAL STATION</h3>
                </div>
            </div>
            <div class="stations-col">
                <img src="images/crystal-palace-new.jpg" alt="orbital station">
                <div class="layer">
                    <h3>CRYSTAL PALACE</h3>
                </div>
            </div>
            <div class="stations-col">
                <img src="images/agos-new.jpg" alt="orbital station">
                <div class="layer">
                    <h3>AGOS</h3>
                </div>
            </div>
        </div>
    </section>

    <!----------------facilities------------------->
    <section class="facilities">
        <h1>Our facilities</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis quod, facere tenetur, nostrum aut ad autem quaerat incidunt pariatur nemo, fugiat aperiam? Praesentium vitae numquam deleniti ipsum sit magnam eos.</p>
        <div class="row">
            <div class="facilities-col">
                <img src="images/facility1-new.jpg" alt="facility">
                <h3>Secure Stractures</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Est minus perferendis hic amet dolor, labore ratione repellat ullam iure facilis, aperiam ad. Praesentium modi sequi nobis repellat exercitationem quibusdam dolores!</p>
            </div>
            <div class="facilities-col">
                <img src="images/facility2-new.jpg" alt="facility">
                <h3>Finest Oxygen Production Systems</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Est minus perferendis hic amet dolor, labore ratione repellat ullam iure facilis, aperiam ad. Praesentium modi sequi nobis repellat exercitationem quibusdam dolores!</p>
            </div>
            <div class="facilities-col">
                <img src="images/facility3.jpg" alt="facility">
                <h3>Earth's Best Medical Equipment</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Est minus perferendis hic amet dolor, labore ratione repellat ullam iure facilis, aperiam ad. Praesentium modi sequi nobis repellat exercitationem quibusdam dolores!</p>
            </div>
        </div>


    </section>

    <!------------------------testimonials---------------------->
    <section class="testimonials">
        <h1>What Our Partners Says</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum ea aperiam saepe tempora nostrum numquam, qui velit maxime! Sint corporis explicabo dolorem est ad voluptatibus, consequuntur libero deserunt ut atque?</p>

        <div class="row">
            <div class="testimonials-col">
                <img src="images/user1.jpg" alt="elon musk face">
                <div>
                    <h3>Elon Musk</h3>
                    <p>We did it boys. We conquered Mars</p>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-o"></i>

                </div>
            </div>
            <div class="testimonials-col">
                <img src="images/user2.jpg" alt="jeff bezos face">
                <div>
                    <h3>Jeff Bezos</h3>
                    <p>Fast deliveries, like mines!</p>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-half-o"></i>
                </div>
            </div>
        </div>
    </section>

    <!------------------------call to action---------------------->
    <section class="cta">
        <h1>Expand your horizons</h1>
        <a href="reviews.php" class="std-btn">See what others say</a>
    </section>

    <?php include('php/footer.php'); ?>

</body>

</html>