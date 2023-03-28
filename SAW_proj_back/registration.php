<?php
include('include_path.php');
require_once('php/connection.php');
$title = 'REGISTRATION';
$style = '"css/form.css"';

global $msg;
$successDetected = 0;
$errorDetected = 0;

function showError()
{
    echo '<div class="form-message-error">' . $GLOBALS['msg'] . '</div>';
}

function showSuccess()
{
    echo '<div class="form-message-success">' . $GLOBALS['msg'] . '<a href="login.php">Sign In</a> with your new account!</div>';
}

if (isset($_POST['submit'])) {

    $nome = trim($_POST['firstname']);
    $cognome = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    $confirm = trim($_POST['confirm']);
    $patternNome = "/^[a-zA-Z]{2,20}$/"; //regex per il nome
    $pwLenght = mb_strlen($pass);

    //controlli vari
    if (empty($nome) || empty($cognome) || empty($email) || empty($pass) || empty($confirm)) {
        $errorDetected = 1;
        $msg = 'Essential field empty';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorDetected = 1;
        $msg = 'Email is not valid';
    } elseif (!preg_match($patternNome, $nome) || !preg_match($patternNome, $cognome)) {
        $errorDetected = 1;
        $msg = 'Firstname is not valid';
    } elseif ($pwLenght > 20) {
        $errorDetected = 1;
        $msg = 'Password is too long';
    } elseif ($pwLenght < 4) {
        $errorDetected = 1;
        $msg = 'Password is too short';
    } elseif ($pass != $confirm) {
        $errorDetected = 1;
        $msg = 'Passwords don\'t match, retry.';
    } else {
        //TODO: SE MAIL è CHIAVE SECONDARIA  O UNIQUE QUESTO CONTROLLO NON HA SENSO, IL DB DA GIA ERRORE
        /*$query = "
                SELECT id
                FROM users
                WHERE email = :email
            ";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $utente = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($utente) {
            $errorDetected = 1;
            $msg = 'User already exists.';
        } else */{ //Se passo tutti i controlli aggiungo il nuovo utente
            $pwHash = password_hash($pass, PASSWORD_DEFAULT);
            $query = "
                INSERT INTO users
                VALUES (0, :email, :password, :firstname, :lastname, NULL, NULL, NULL, NULL, NULL, NULL)
            ";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $pwHash, PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $cognome, PDO::PARAM_STR);
            try {
                $stmt->execute();
            } catch(PDOException $e){
                if ($e->getCode() == '23000') { //controllo che gestisce Uncaught PDOException: SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry
                    $errorDetected = 1;
                    $msg = 'User already exists.';
                    error_log($e->getMessage());
                    
                } else {
                    $errorDetected = 1;
                    $msg = 'Something went wrong.';
                    error_log($e->getMessage());
                    
                }
            }
            if($errorDetected == 0){
                $successDetected = 1;
                $msg = 'Congratulations, your account has been successfully created.<br>';
            }
        }
    }
}

?>

<?php include('php/head.php'); ?>

<body>
    <section class="background">
        <nav>
            <a href="index.php"><img src="images/star-trek-logo2.png" alt="logo"></a>
        </nav>
        <div class="card">
            <div class="card-content">
                <form action="registration.php" method="POST" class="form">
                    <h1 class="form-title">Sign up</h1>
                    <input type="text" name="firstname" class="form-input" placeholder="Firstname">
                    <input type="text" name="lastname" class="form-input" placeholder="Lastname">
                    <input type="email" name="email" class="form-input" placeholder="Email">
                    <input type="password" name="pass" class="form-input" placeholder="Password">
                    <input type="password" name="confirm" class="form-input" placeholder="Confirm Password">
                    <?php
                    if ($errorDetected == 1) {
                        showError();
                    } elseif ($successDetected == 1) {
                        showSuccess();
                    }
                    ?>
                    <div class="div-below-form">
                        <?php if ($successDetected != 1) { ?>
                        <input type="submit" class="std-btn form-btn" name="submit" value="Register">
                        <?php } else { ?>
                            <button type="button" class="std-btn form-btn">Register</button>
                        <?php } if ($successDetected != 1) { ?>
                            <p class="login-link">Already a Member? <a href="login.php">Sign In here!</a></p>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>