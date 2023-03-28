 <?php

    session_start();
    session_destroy();
    header('Location: index.php');
    

    /*
    session_start();
    if(isset($_SESSION['uid'])){
        unset($_SESSION['uid']);            //in questo modo vengono mantenute le variabili di sessione definite in precedenza
    }
    header('Location: ../index.php');
    
*/

    ?> 

