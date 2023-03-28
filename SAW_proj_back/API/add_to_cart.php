<?php
include('../include_path.php');
    //php con query per inserire un oggetto nel carrello
    session_start();
    require_once('php/connection.php');

    $program_id = $_REQUEST["program"];

    $uid = $_SESSION['uid'];

    $query = "
                INSERT INTO cart 
                VALUES (:user_id, :program_id)
            ";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $uid, PDO::PARAM_INT);
        $stmt->bindParam(':program_id', $program_id, PDO::PARAM_INT);
        try {
            $stmt->execute();
        }
        catch(PDOException $e) {
            error_log($e->getMessage());
            
        }
?>