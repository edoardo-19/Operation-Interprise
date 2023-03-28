<?php
include('include_path.php');
    session_start();
    require_once('php/connection.php');
    $title = 'WRITE REVIEW';
    $style = '"css/write_review.css"';
    $update = 0;
    $errorDetected = 0;
    $accessDenied = 0;
    $ADmsg = "";
    $EDmsg1 = "";
    $EDmsg2 = "";
?>

<?php
    function errorDetected($errorDetected)
    {
        if ($errorDetected == 1) { echo '
            <div class="error-div">
                <div class="error-card">
                    <p class="message-error error1">' . $GLOBALS['EDmsg1'] . '</p>
                    <p class="message-error">' . $GLOBALS['EDmsg2'] . '</p>
                </div>
            </div>';
        }
    }
?>

<?php 
    // 1) Verifico se l'utente ha fatto il login
    if (!isset($_SESSION['uid'])) {
        $accessDenied = 1;
        $ADmsg = 'Login required';
    }
    else { //ok, utente è già autenticato con login
        // 2) Verifico se l' utente è entrato in maniera corretta
        $program_id = "";
        if (isset($_POST['program_id'])) { //verifico se è entrato col bottone della pagina programmi
            $program_id = $_POST['program_id']; 
        }
        elseif (isset($_POST['submit'])){ //verifico se è entrato ricaricando la pagina (dopo essere entrato tramite bottone della pagina programmi)
            $program_id = $_POST['submit'];
        }
        if($program_id == "") {
            $accessDenied = 2;
            $ADmsg = 'Unauthorized access';
        }
        else { //ok, utente è entrato nella pagina usando il bottone
            // 3) Verifico se l' utente ha effettuato il programma
            //    Un utente non può scrivere recensioni di programmi che non ha mai fatto
            $query = "
                        SELECT user_id, program_id
                        FROM travels
                        WHERE program_id = :program_id AND user_id = :user_id
                    ";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $_SESSION['uid'], PDO::PARAM_INT);
            $stmt->bindParam(':program_id', $program_id, PDO::PARAM_INT);
            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                error_log($e->getMessage());
                
            }
            $travelConfirmed = $stmt->rowCount();
            if ($travelConfirmed == 0) {
                $accessDenied = 3;
                $ADmsg = 'Fake review detected';
            }
            else { //ok, utente ha già fatto questo programma, quindi ci può scrivere una recensione
                // 4) Verifico se l'utente ha già scritto una recensione su questo programma
                $query = "
                            SELECT user_id, program_id, title, description, score
                            FROM reviews
                            WHERE program_id = :program_id AND user_id = :user_id
                        ";

                $stmt2 = $conn->prepare($query);
                $stmt2->bindParam(':user_id', $_SESSION['uid'], PDO::PARAM_INT);
                $stmt2->bindParam(':program_id', $program_id, PDO::PARAM_INT);
                try {
                    $stmt2->execute();
                }
                catch(PDOException $e) {
                    error_log($e->getMessage());
                    
                }
                $alreadyReviewed = $stmt2->rowCount();
                if ($alreadyReviewed != 0){  // utente ha già scritto una recensione su questo programma
                    $review = $stmt2->fetch(PDO::FETCH_ASSOC);
                    $update = 1; 
                }
                $query = "
                            SELECT title
                            FROM travels, programs
                            WHERE travels.program_id = programs.id AND program_id = :program_id
                        ";
                $stmt3 = $conn->prepare($query);
                $stmt3->bindParam(':program_id', $program_id, PDO::PARAM_INT);
                try {
                    $stmt3->execute();
                }
                catch(PDOException $e) {
                    error_log($e->getMessage());
                    
                }
                $programArray = $stmt3->fetch();
                $programTitle = $programArray['title'];
                include('php/insert_review.php'); // Invio nuova recensione al database



                include('php/head.php'); ?>
                <body>
                    <section class="background">
                        <?php include('php/navBar.php'); ?>
                        <div class="card">
                            <div class="card-content">
                                <form action="write_review.php" method="POST">
                                    <div>
                                        <div class="program-name-div">
                                            <?php 
                                            if($update == 0) { ?>
                                                <p>Review for <i class="program-name-italic"><?php echo $programTitle;?></i></p>
                                            <?php }
                                            elseif($update == 1) { ?>
                                                <p>Update review for <i class="program-name-italic"><?php echo $programTitle;?></i></p>
                                            <?php } ?>
                                        </div>
                                        <div class="title-div">
                                            <input type="text" name="title" class="title-input-field" <?php if($update == 1){ echo 'value = "' . $review['title'] . '"'; }?> placeholder="Review title">
                                        </div>
                                        <div class="score-div">
                                            <?php if ($update == 0) { ?>
                                                <select name="score" class="score-selection-field">
                                                    <option value="" disabled selected>Select score</option>;
                                                    <?php include('php/common/score_list.php'); ?>
                                                </select>
                                            <?php }
                                            elseif ($update == 1) { ?>
                                                <select name="score" class="score-selection-field">
                                                    <option value="<?php echo $review['score'] ?>" selected><?php echo $review['score'] ?></option>;
                                                    <?php include('php/common/score_list.php'); ?>
                                                </select>
                                            <?php } ?>
                                        </div>
                                        <div class="text-div">
                                            <textarea name="description" class="text-input-field" placeholder="Write here your review"><?php if($update == 1){ echo $review['description']; }?></textarea>
                                        </div>
                                        <?php errorDetected($errorDetected); ?>
                                        <div class="modifiers">
                                            <?php if ($update == 0) { ?>
                                                <button type="submit" value="<?php echo $program_id ?>" name="submit" class="std-btn">Send review</button>
                                            <?php }
                                            elseif ($update == 1) { ?>
                                                <button type="submit" value="<?php echo $program_id ?>" name="submit" class="std-btn">Update review</button>
                                            <?php } ?>
                                            <a href="programs.php" class="std-btn">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </body>
                </html>
                <?php
            }
        }
    }
    if ($accessDenied != 0) {
        include('php/head.php'); ?>
        <body>
            <section class="background">
                <?php include('php/navBar.php'); ?>
                <div class="access-Denied-card">
                    <div class="access-Denied-content">
                        <h3 class="access-Denied-title"> <?php echo $ADmsg;?> </h3>
                        <div class="access-Denied-div">
                            <?php if ($accessDenied == 1) { ?>
                                <p class="above-button-text">If you want to write a review, you have to be logged in.</p>
                                <a href="login.php" class="std-btn AD-button">Sign in</a>
                            <?php }
                            elseif ($accessDenied == 2) { ?>
                                <p class="above-button-text">If you want to write a review, you have to click on the "Write review" button through the programs page.</p>
                                <a href="programs.php" class="std-btn AD-button">Go to programs</a>
                            <?php }
                            elseif ($accessDenied == 3) { ?>
                                <p class="above-button-text">If you want to write a review about this program, you have to buy it first.</p>
                                <div class="buttons-div">
                                    <a href="programs.php" class="std-btn AD-button">Go to programs</a>
                                    <a href="shopping_cart.php" class="std-btn AD-button">Go to your cart</a>
                                </div>
                            <?php }
                            elseif ($accessDenied == 4) { ?>
                                <p class="above-button-text">If you want to write a new review about this program, delete the old one through the reviews page.</p>
                                <a href="reviews.php" class="std-btn AD-button">Go to reviews</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </section>
        </body>
        </html>
        <?php
    } 
?>