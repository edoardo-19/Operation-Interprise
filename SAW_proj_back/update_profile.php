<?php
include('include_path.php');
session_start();
require_once('php/connection.php');
require_once('php/common/validateDOB.php');
$title = 'PROFILE';
$style = '"css/update_profile.css"';
$errorDetected = 0;
$null = null;
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
if (isset($_SESSION['uid'])) {
    $query = "
            SELECT firstname, lastname, id, email, birthday, country, address, phone
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
    $utente = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<?php
//dobbiamo usare una variabile null da poter passare come parametro per PDO 
if (isset($_POST['submit'])) {
    $nome = trim($_POST['firstname']);
    $cognome = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    //controllo se sono stati inseriti i dati aggiuntivi, se true li salvo per il bind, altrimenti uso il default NULL
    if (isset($_POST['address']))
        $address = trim($_POST['address']);
    else
        $address = NULL;
    if (isset($_POST['country']))
        $country = $_POST['country'];
    else
        $country = NULL;
    if (isset($_POST['phone']))
        $phone = trim($_POST['phone']);
    else
        $phone = NULL;
    if (isset($_POST['birthday']))
        $birthday = $_POST['birthday'];
    else
    $birthday = NULL;
    $patternNome = "/^[a-zA-Z]{2,20}$/";
    $patternPhone = "/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/";
    //controllo campi obbligatori
    if (empty($nome) || empty($cognome) || empty($email)) {
        $errorDetected = 1;
        $msg = 'Essential field empty.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorDetected = 1;
        $msg = 'Email is not valid.';
    } elseif (!preg_match($patternNome, $nome) || !preg_match($patternNome, $cognome)) {
        $errorDetected = 1;
        $msg = 'Firstname or lastname are not valid.';
    } elseif (!preg_match($patternPhone, $phone) && !($phone == '')) {
        $errorDetected = 1;
        $msg = 'Phone number is not valid';
    } elseif (!validateDOB($birthday) && !($birthday == '')) {
        $errorDetected = 1;
        $msg = 'Insert a valid birthday.';
    } else {
        if ($utente['email']  != $email) {
            $query = "
                    SELECT id
                    FROM users
                    WHERE email = :email
                ";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                error_log($e->getMessage());
                
            }

            $newUser = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($newUser) {
                $errorDetected = 1;
                $msg = 'Email is already taken.';
            } else {
                $query = "
                        UPDATE users
                        SET  email = :email,  firstname = :firstname, lastname = :lastname, birthday = :birthday, country = :country, address = :address, phone = :phone
                        WHERE id = :id
                    ";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id', $_SESSION['uid'], PDO::PARAM_INT);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':firstname', $nome, PDO::PARAM_STR);
                $stmt->bindParam(':lastname', $cognome, PDO::PARAM_STR);
                if ($birthday == NULL)
                    $stmt->bindParam(':birthday', $null, PDO::PARAM_STR);
                else
                    $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
                if ($country == NULL)
                    $stmt->bindParam(':country', $null, PDO::PARAM_STR);
                else
                    $stmt->bindParam(':country', $country, PDO::PARAM_STR);
                if ($address == NULL)
                    $stmt->bindParam(':address', $null, PDO::PARAM_STR);
                else
                    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                if ($phone == NULL)
                    $stmt->bindParam(':phone', $null, PDO::PARAM_STR);
                else
                    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                try {
                    $stmt->execute();
                }
                catch(PDOException $e) {
                    $errorDetected = 1;
                    $msg = 'Something went wrong.';
                    error_log($e->getMessage());
                    
                }
                if ($errorDetected == 0) {
                    header('Location: show_profile.php');
                }
            }
        } else {
            $query = "
                    UPDATE users
                    SET firstname = :firstname, lastname = :lastname, birthday = :birthday, country = :country, address = :address, phone = :phone
                    WHERE id = :id
                ";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $_SESSION['uid'], PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $cognome, PDO::PARAM_STR);
            if ($birthday == NULL)
                $stmt->bindParam(':birthday', $null, PDO::PARAM_STR);
            else
                $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
            if ($country == NULL)
                $stmt->bindParam(':country', $null, PDO::PARAM_STR);
            else
                $stmt->bindParam(':country', $country, PDO::PARAM_STR);
            if ($address == NULL)
                $stmt->bindParam(':address', $null, PDO::PARAM_STR);
            else
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            if ($phone == NULL)
                $stmt->bindParam(':phone', $null, PDO::PARAM_STR);
            else
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                $errorDetected = 1;
                $msg = 'Nothing has changed.';
                error_log($e->getMessage());
                
            }
            if ($errorDetected == 0) {
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
                    <form action="update_profile.php" method="POST" class="row">
                        <div class="profilePic">
                            <img src="images/anon1.png" alt="profilePic">
                        </div>
                        <div class="column">
                            <div class="row-name">
                                <input type="text" name="firstname" value="<?php echo ucfirst($utente['firstname']) ?>" class="input-name name" placeholder="Firstname">
                                <input type="text" name="lastname" value="<?php echo ucfirst($utente['lastname']) ?>" class="input-name name" placeholder="Lastname">
                            </div>
                            <div class="info-row">
                                <div class="details-column">
                                    <div><input type="date" name="birthday" value="<?php echo $utente['birthday'] ?>" class="user-content details-text input-data" placeholder="Birthday"></div>
                                    <div>
                                        <select name="country" class="user-content details-text input-data">
                                            <?php if ($utente['country'] == NULL) {
                                                echo '<option value="" disabled selected>Select your country</option>';
                                            } else {
                                                echo '<option selected="selected">' . $utente['country'] . '</option>';
                                            } ?>
                                            <?php include('php/common/country_list.php'); ?>
                                        </select>
                                    </div>
                                    <div><input type="text" name="address" value="<?php echo $utente['address'] ?>" class="user-content details-text input-data" placeholder="Address"></div>
                                </div>
                                <div class="details-column">
                                    <div><input type="email" name="email" value="<?php echo $utente['email'] ?>" class="user-content details-text input-data" placeholder="Email"></div>
                                    <div><input type="text" name="phone" value="<?php echo $utente['phone'] ?>" class="user-content details-text input-data" placeholder="Phone"></div>
                                </div>
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