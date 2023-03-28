<?php
include('include_path.php');
require_once('php/connection.php');
$title = 'LOGIN';
$style = '"css/form.css"';

$errorDetected = 0;

//funzione usata per stampare messaggi di errore vari
function showError($errorDetected)
{
    if ($errorDetected == 1) {
        echo '<div class="form-message-error">' . $GLOBALS['msg'] . '</div>';
    }
}

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);

    //controllo che i campi non siano vuoti
    if (empty($email) || empty($pass)) {
        $errorDetected = 1;
        $msg = 'Essential field empty.';
    } else {
        $query = "
                SELECT email, password, id, isAdmin
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
        $utente = $stmt->fetch(PDO::FETCH_ASSOC);

        
        if (!$utente) {
            $errorDetected = 1;
            $msg = 'The Email you entered doesn\'t exist in our records. Please double-check your data and try again.';
        } elseif (password_verify($pass, $utente['password']) === false) {
            $errorDetected = 1;
            $msg = 'The password you entered did not match our records. Please double-check your data and try again.';
        } else {
            $uid = $utente['id'];
            session_start();
            $_SESSION['uid'] = $uid;
            if($utente['isAdmin']){
                $aid = $utente['id'];
                $_SESSION['aid'] = $aid;
                header('Location: admin.php');
                
            } else{
                header('Location: show_profile.php');
                
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
                <form action="login.php" method="post" class="form">
                    <h1 class="form-title">Sign in</h1>
                    <input type="email" name="email" class="form-input" placeholder="Email" autofocus>
                    <input type="password" name="pass" class="form-input" placeholder="Password">
                    <?php showError($errorDetected); ?>
                    <div class="div-below-form">
                        <input class="std-btn form-btn" name="submit" type="submit" value="Continue">
                        <p class="login-link">New user? <a href="registration.php">Sign Up now!</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>