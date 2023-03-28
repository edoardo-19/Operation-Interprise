<?php
include('../include_path.php');
    session_start();
    require_once('php/connection.php');

    $program_id = $_POST["delete"];

    $uid = $_SESSION['uid'];

    $query = "
                DELETE FROM cart 
                WHERE program_id = :program_id
                AND user_id = :user_id
            ";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':program_id', $program_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $uid, PDO::PARAM_INT);
            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                error_log($e->getMessage());
                
            }
?>