<?php
include('../include_path.php');
    session_start();
    require_once('php/connection.php');

    $uid = $_SESSION['uid'];

    $query = "
                SELECT user_id, program_id
                FROM cart 
                WHERE user_id = :user_id
            ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $uid, PDO::PARAM_INT);
    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }
    $travelsInCart = $stmt->fetchAll();
    $rowCart = $stmt->rowCount();
    $newRowCart = $rowCart;

    $query = "
                SELECT user_id, program_id
                FROM travels 
                WHERE user_id = :user_id
            ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $uid, PDO::PARAM_INT);
    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }
    $travelsDone = $stmt->fetchAll();
    $rowTravels = $stmt->rowCount();

    for($y = 0 ; $y < $rowTravels ; $y++){
        for($x = 0 ; $x < $rowCart ; $x++){

            if($travelsInCart[$x]['program_id'] == $travelsDone[$y]['program_id']){
                $query = "
                            DELETE FROM cart 
                            WHERE user_id = :user_id AND program_id = :program_id
                        ";


                $stmt3 = $conn->prepare($query);
                $stmt3->bindParam(':user_id', $uid, PDO::PARAM_INT);
                $stmt3->bindParam(':program_id', $travelsInCart[$x]['program_id'], PDO::PARAM_INT);
                $stmt3->execute(); 
                $newRowCart--;
                echo 'Eliminato dal db duplicato: ';
                echo $travelsInCart[$x]['program_id'];
                echo '<br>';
                echo 'New row cart: ';
                echo $newRowCart;
                echo '<br>';
            }
        }
    }

    $query = "
                SELECT user_id, program_id
                FROM cart 
                WHERE user_id = :user_id
            ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $uid, PDO::PARAM_INT);
    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }
    $newTravelsInCart = $stmt->fetchAll();

    for($x = 0 ; $x < $newRowCart ; $x++){
        $query = "
                    INSERT INTO travels
                    VALUES (:user_id, :program_id)
                ";
        $stmt2 = $conn->prepare($query);
        $stmt2->bindParam(':user_id', $uid, PDO::PARAM_INT);
        $stmt2->bindParam(':program_id', $newTravelsInCart[$x]['program_id'], PDO::PARAM_INT);
        try {
            $stmt2->execute();
        }
        catch(PDOException $e) {
            error_log($e->getMessage());
            
        }
        
    }
    
    $query = "
                DELETE FROM cart 
                WHERE user_id = :user_id
            ";

    $stmt3 = $conn->prepare($query);
    $stmt3->bindParam(':user_id', $uid, PDO::PARAM_INT);
    try {
        $stmt3->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }
?>