<?php
include('../include_path.php');
session_start();
require_once('php/connection.php');

$review_id = $_POST["delete"];
//rimuove la reviews e ricalcola il valore della media delle valutazioni


$query = "
                    SELECT program_id 
                    FROM reviews
                    WHERE id = :review_id
                ";

$stmt = $conn->prepare($query);
$stmt->bindParam(':review_id', $review_id, PDO::PARAM_INT);
try {
    $stmt->execute();
}
catch(PDOException $e) {
    error_log($e->getMessage());
    
}
$programReviewed = $stmt->fetch();

$query = "
                    DELETE FROM reviews 
                    WHERE id = :review_id
                ";

$stmt = $conn->prepare($query);
$stmt->bindParam(':review_id', $review_id, PDO::PARAM_INT);
try {
    $stmt->execute();
}
catch(PDOException $e) {
    error_log($e->getMessage());
    
}

$query = "
            SELECT score
            FROM reviews
            WHERE program_id = :program_id
        ";

$stmt2 = $conn->prepare($query);
$stmt2->bindParam(':program_id', $programReviewed['program_id'], PDO::PARAM_INT);
try {
    $stmt2->execute();
}
catch(PDOException $e) {
    error_log($e->getMessage());
    
}
$programScores = $stmt2->fetchAll();
$numOfReviews = $stmt2->rowCount();

if($numOfReviews == 0){
    $query = "
                UPDATE programs
                SET scoreAvg = :scoreAvg
                WHERE id = :program_id
            ";
    $stmt2 = $conn->prepare($query);
    $stmt2->bindParam(':program_id', $programReviewed['program_id'], PDO::PARAM_INT);
    $stmt2->bindParam(':scoreAvg', $null, PDO::PARAM_STR);
    try {
        $stmt2->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }
} else{
    $query = "
                SELECT SUM(score) 
                AS sumScore 
                FROM reviews
                WHERE program_id = :program_id
            ";

    $stmt2 = $conn->prepare($query);
    $stmt2->bindParam(':program_id', $programReviewed['program_id'], PDO::PARAM_INT);
    try {
        $stmt2->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);
    $scoreSum = $row['sumScore'];
    $scoreAvg = $scoreSum/$numOfReviews;
    $score = strval($scoreAvg);
    $query = "
                UPDATE programs
                SET scoreAvg = :scoreAvg
                WHERE id = :program_id
            ";
    $stmt2 = $conn->prepare($query);
    $stmt2->bindParam(':program_id', $programReviewed['program_id'], PDO::PARAM_INT);
    $stmt2->bindParam(':scoreAvg', $score, PDO::PARAM_STR);
    try {
        $stmt2->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }
}
?>