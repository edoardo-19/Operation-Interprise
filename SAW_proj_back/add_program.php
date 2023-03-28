<?php
session_start();
include('include_path.php');
require_once('php/connection.php');
$title = 'ADDING PROGRAM';
$style = '"css/edit_program.css"';
$update = 0;
$errorDetected = 0;
$EDmsg1 = "";
$EDmsg2 = "";
include('php/insert_program.php');
?>  

<?php include('php/common/error_msg.php'); ?>

<?php include('php/head.php'); ?>
<body>
    <section class="background">
        <?php include('php/navBar.php'); ?>
        <div class="card">
            <div class="card-content">
                <form action="add_program.php" method="POST" enctype="multipart/form-data">
                    <div>
                        <div class="program-name-div">
                            <p>Adding program<i class="program-name-italic"></i></p>
                        </div>
                        <div class="title-div">
                            <input type="text" name="title" class="title-input-field" placeholder="Program title">
                        </div>
                        <div class="title-div">
                            <input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
                            <input type="file" accept=".png, .jpg, .jpeg" name="program_image" class="title-input-field" placeholder="Program image">
                        </div>
                        <div class="text-div">
                            <textarea name="description" class="text-input-field" placeholder="Write here the description"></textarea>
                        </div>
                        <div class="score-div">
                            <select name="type" class="score-selection-field">
                                <option value="" disabled selected>Select type</option>;
                                <?php include('php/common/type_list.php'); ?>
                            </select>
                        </div>
                        <div class="score-div">
                            <select name="where" class="score-selection-field">
                                <option value="" disabled selected>Select place</option>;
                                <?php include('php/common/destination_list.php'); ?>
                            </select>
                        </div>
                        <div class="title-div">
                            <input type="number" min="0" value="" name="price" class="title-input-field" placeholder="Write here the price">
                        </div>
                        <?php errorDetected($errorDetected); ?>
                        <div class="modifiers">
                            <button type="submit" value="" name="submit" class="std-btn">Add program</button>
                            <a href="programs.php" class="std-btn">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>