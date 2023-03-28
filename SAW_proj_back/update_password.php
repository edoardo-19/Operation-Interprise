<?php
include('include_path.php');
session_start();
require_once('php/connection.php');
require_once('php/common/validateDOB.php');
$title = 'PROFILE';
$style = '"css/update_password.css"';
$errorDetected = 0;
?>

<?php

function showError($errorDetected)
{
    if ($errorDetected == 1) {
        echo '<div class="error-card"><div class="message-error">' . $GLOBALS['msg'] . '</div></div>';
    }
}

?>

<?php
if (isset($_POST['submit'])) {
    $oldPass = trim($_POST['old']);
    $newPass = trim($_POST['new']);
    $confirmPass = trim($_POST['confirm']);
    $pwLenght = mb_strlen($newPass);
    //controlli vari
    if (empty($oldPass) || empty($newPass) || empty($confirmPass)) {
        $errorDetected = 1;
        $msg = 'Essential field empty.';
    } elseif ($newPass != $confirmPass) {
        $errorDetected = 1;
        $msg = 'Passwords don\'t match, retry.';
    } elseif ($pwLenght > 20) {
        $errorDetected = 1;
        $msg = 'Password is too long';
    } elseif ($pwLenght < 4) {
        $errorDetected = 1;
        $msg = 'Password is too short';
    } else {
        $query = "
                SELECT password
                FROM users
                WHERE id = :id
            ";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $_SESSION['uid'], PDO::PARAM_STR);
        try {
            $stmt->execute();
        }
        catch(PDOException $e) {
            error_log($e->getMessage());
            
        }
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($oldPass, $user['password']) === false) { //controllo che la password vecchia non sia gia stata inserita
            $errorDetected = 1;
            $msg = 'The old password you wrote did not match our records.';
        } else { //aggiorno la password dopo aver passato i controlli
            $pwHash = password_hash($newPass, PASSWORD_DEFAULT);
            $query = "
                    UPDATE users
                    SET  password = :password
                    WHERE id = :id
                ";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':password', $pwHash, PDO::PARAM_STR);
            $stmt->bindParam(':id', $_SESSION['uid'], PDO::PARAM_STR);
            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                $errorDetected = 1;
                $msg = 'Something went wrong.';
                error_log($e->getMessage());
                
            }
            if ($errorDetected == 0) { //rimanda allo showprofile se tutto va bene
                header('Location: show_profile.php');
            }
        }
    }
}
?>

<?php if (isset($_SESSION['uid'])) : ?>

    <?php include('php/head.php'); ?>

    <body>
        <section class="background">
            <?php include('php/navBar.php'); ?>
            <div class="profile-card card-bg">
                <div class="profile-content">
                    <form action="update_password.php" method="POST" class="row">
                        <div class="column">
                            <div class="row-password">
                                <input type="password" name="old" class="input-password password" placeholder="Old password">
                                <input type="password" name="new" class="input-password password" placeholder="New password">
                                <input type="password" name="confirm" class="input-password password" placeholder="Confirm new password">

                            </div>
                            <?php showError($errorDetected) ?>
                            <div class="modifiers">
                                <input type="submit" name="submit" class="std-btn" value="Save changes">
                                <a href="show_profile.php" class="std-btn">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    <?php endif ?>
    </body>

    </html>