<?php
include('../include_path.php');
session_start();
require_once('php/connection.php');
$null = NULL;

$user_id = $_POST["delete"];
if ($_SESSION["uid"] != $user_id) {
    $query = "
                DELETE FROM users 
                WHERE id = :user_id
            ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }

    $query = "
                SELECT program_id
                FROM reviews 
                WHERE user_id = :user_id
            ";

    $stmt5 = $conn->prepare($query);
    $stmt5->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    try {
        $stmt5->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }
    $programsReviewed = $stmt5->fetchAll();

    $query = "
                DELETE FROM reviews 
                WHERE user_id = :user_id
            ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }

    for ($x = 0; $x < $stmt5->rowCount(); $x++) {
        $query = "
                    SELECT score
                    FROM reviews
                    WHERE program_id = :program_id
                ";

        $stmt2 = $conn->prepare($query);
        $stmt2->bindParam(':program_id', $programsReviewed[$x]['program_id'], PDO::PARAM_INT);
        try {
            $stmt2->execute();
        }
        catch(PDOException $e) {
            error_log($e->getMessage());
            
        }
        $programScores = $stmt2->fetchAll();
        $numOfReviews = $stmt2->rowCount();
        if ($numOfReviews == 0) {
            $query = "
                        UPDATE programs
                        SET scoreAvg = :scoreAvg
                        WHERE id = :program_id
                    ";
            $stmt2 = $conn->prepare($query);
            $stmt2->bindParam(':program_id', $programsReviewed[$x]['program_id'], PDO::PARAM_INT);
            $stmt2->bindParam(':scoreAvg', $null, PDO::PARAM_STR);
            try {
                $stmt2->execute();
            }
            catch(PDOException $e) {
                error_log($e->getMessage());
                
            }
        } else {
            $query = "
                        SELECT SUM(score) 
                        AS sumScore 
                        FROM reviews
                        WHERE program_id = :program_id
                    ";

            $stmt2 = $conn->prepare($query);
            $stmt2->bindParam(':program_id', $programsReviewed[$x]['program_id'], PDO::PARAM_INT);
            try {
                $stmt2->execute();
            }
            catch(PDOException $e) {
                error_log($e->getMessage());
                
            }
            $row = $stmt2->fetch(PDO::FETCH_ASSOC);
            $scoreSum = $row['sumScore'];
            $scoreAvg = $scoreSum / $numOfReviews;
            $score = strval($scoreAvg);
            $query = "
                        UPDATE programs
                        SET scoreAvg = :scoreAvg
                        WHERE id = :program_id
                    ";
            $stmt2 = $conn->prepare($query);
            $stmt2->bindParam(':program_id', $programsReviewed[$x]['program_id'], PDO::PARAM_INT);
            $stmt2->bindParam(':scoreAvg', $score, PDO::PARAM_STR);
            try {
                $stmt2->execute();
            }
            catch(PDOException $e) {
                error_log($e->getMessage());
                
            }
        }
    }
}
