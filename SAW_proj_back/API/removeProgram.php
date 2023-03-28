<?php
    session_start();
    include('../include_path.php');
    require_once('php/connection.php');

    $program_id = $_POST["delete"];
    //se si elimina un programma occorre eliminare anche le sue recensioni
    $query = "
                        DELETE FROM reviews 
                        WHERE program_id = :program_id
                    ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':program_id', $program_id, PDO::PARAM_INT);
    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }

    $query = "
                        DELETE FROM programs 
                        WHERE id = :program_id
                    ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':program_id', $program_id, PDO::PARAM_INT);
    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }
?>