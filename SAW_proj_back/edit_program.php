<?php
session_start();
include('include_path.php');
require_once('php/connection.php');
$title = 'EDITING PROGRAM';
$style = '"css/edit_program.css"';
$update = 1;
$errorDetected = 0;
$EDmsg1 = "";
$EDmsg2 = "";
include('php/insert_program.php');
?>  

<?php include('php/common/error_msg.php'); ?>

<?php 
    if (isset($_POST['program_id'])) { //verifico se è entrato col bottone della pagina programmi
        $program_id = $_POST['program_id']; 
    }
    elseif (isset($_POST['submit'])){ //verifico se è entrato ricaricando la pagina (dopo essere entrato tramite bottone della pagina programmi)
        $program_id = $_POST['submit'];
    }

    $query = '
                SELECT *
                FROM programs
                WHERE id = :program_id
            ';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':program_id', $program_id, PDO::PARAM_INT);
    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    } 
    $programInfo = $stmt->fetch();

    $title = $programInfo['title'];
    $id = $programInfo['id'];
    $description = $programInfo['description'];
    $price = $programInfo['price'];
    $type  = $programInfo['type'];
    $place = $programInfo['place'];
    $img = $programInfo['image'];
?>


<?php include('php/head.php'); ?>
<body>
    <section class="background">
        <?php include('php/navBar.php'); ?>
        <div class="card">
            <div class="card-content">
                <form action="edit_program.php" method="POST">
                    <div>
                        <div class="program-name-div">
                                <p>Edits for <i class="program-name-italic"></i></p>
                        </div>
                        <div class="title-div">
                            <input type="text" name="title" class="title-input-field" value="<?php echo $title; ?>" placeholder="Program title">
                        </div>
                        <div class="text-div">
                            <textarea name="description" class="text-input-field" placeholder="Write here the description"><?php echo $description; ?></textarea>
                        </div>
                        <div class="score-div">
                            <select name="type" class="score-selection-field">
                                <option value="<?php echo $type; ?>" selected><?php echo ucfirst($type); ?></option>;
                                <?php include('php/common//type_list.php'); ?>
                            </select>
                        </div>
                        <div class="score-div">
                            <select name="where" class="score-selection-field">
                                <option value="<?php echo $place; ?>" selected><?php echo ucfirst($place); ?></option>;
                                <?php include('php/common/destination_list.php'); ?>
                            </select>
                        </div>
                        <div class="title-div">
                            <input type="number" min="0" value="<?php echo $price; ?>" name="price" class="title-input-field" placeholder="Write here the price">
                        </div>
                        <div class="modifiers">
                            <button type="submit" value="<?php echo $program_id; ?>" name="submit" class="std-btn">Edit program</button>
                            <a href="programs.php" class="std-btn">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
</html>