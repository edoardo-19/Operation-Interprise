<?php
    // File usato solo per connettersi al database

    // Credenziali per il database del server UniGe
    // $user = "S4831619";         
    // $pass = "Prosciutto"; 

    // Credenziali per il database locale
    $user = "root";             
    $pass = "";
    
    //gestione eccezioni
    try {
        //$conn = new PDO("mysql:host=localhost; dbname=S4831619", $user, $pass); // Connessione al DB di UniGe
        $conn = new PDO("mysql:host=localhost; dbname=saw-proj", $user, $pass); // Connessione al DB locale
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        exit;
    }
?>