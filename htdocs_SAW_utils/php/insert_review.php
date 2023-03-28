<?php

    if (isset($_POST['submit'])) {
        $program = $_POST['submit'];
        $reviewTitle = trim($_POST['title']);
        $description = trim($_POST['description']);
        if (isset($_POST['score'])) {
            $score = $_POST['score'];
        }
        else {
            $score = "";
        }
        //controllo che i campi obbligatori siano compilati e delle dimensioni giuste
        if (empty($score) || empty($reviewTitle) || empty($description)) {
            $errorDetected = 1;
            $EDmsg1 = 'Essential field empty';
            $EDmsg2 = 'All fields are mandatory';
        }
        elseif (mb_strlen($reviewTitle) > 50) {
            $errorDetected = 1;
            $EDmsg1 = 'The title is too long';
            $EDmsg2 = 'Max length: 50 digits';
        }
        elseif (mb_strlen($description) > 255) {
            $errorDetected = 1;
            $EDmsg1 = 'The review is too long';
            $EDmsg2 = 'Max length: 255 digits';
        }
        //query per l'inserimento della review
        if ($update == 0 && $errorDetected != 1) {
            $query = "
                        INSERT INTO reviews
                        VALUES (0, :user_id, :program_id, :title, :description, :score)
                    ";
                    
            $stmt4 = $conn->prepare($query);
            $stmt4->bindParam(':user_id', $_SESSION['uid'], PDO::PARAM_INT);
            $stmt4->bindParam(':program_id', $program, PDO::PARAM_INT);
            $stmt4->bindParam(':title', $reviewTitle, PDO::PARAM_STR);
            $stmt4->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt4->bindParam(':score', $score, PDO::PARAM_INT);
            
            try {
                $stmt4->execute();
            }
            catch(PDOException $e) {
                $errorDetected = 1;
                $EDmsg1 = 'Something went wrong';
                $EDmsg2 = 'Your program hasn\'t been saved correctly';
                error_log($e->getMessage());
                
            }
            //se query per l'inserimento va a buon fine ricalcolerò la media dei voti nelle reviews del programma
            if ($errorDetected == 0) {
                $query = "
                            SELECT score
                            FROM reviews
                            WHERE program_id = :program_id
                        ";

                $stmt2 = $conn->prepare($query);
                $stmt2->bindParam(':program_id', $program, PDO::PARAM_INT);
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
                    $stmt2->bindParam(':program_id', $program, PDO::PARAM_INT);
                    $stmt2->bindParam(':scoreAvg', $score, PDO::PARAM_STR);
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
                    $stmt2->bindParam(':program_id', $program, PDO::PARAM_INT);
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
                    $stmt2->bindParam(':program_id', $program, PDO::PARAM_INT);
                    $stmt2->bindParam(':scoreAvg', $score, PDO::PARAM_STR);
                    try {
                        $stmt2->execute();
                    }
                    catch(PDOException $e) {
                        error_log($e->getMessage());
                        
                    }
                }
                header('Location: '.dirname($_SERVER['REQUEST_URI']).'/reviews.php');   //$_SERVER is an array which holds information of headers, paths, script locations.
                                                                                        //$_SERVER['REQUEST_URI'] contains the URI of the current page. 
            }
        } //query per la modifica della recensione
        elseif ($update == 1 && $errorDetected != 1) {
            $query = "
                        UPDATE reviews
                        SET title = :title, description = :description, score = :score
                        WHERE program_id = :program_id AND user_id = :user_id
                    ";
                    
            $stmt5 = $conn->prepare($query);
            $stmt5->bindParam(':user_id', $_SESSION['uid'], PDO::PARAM_INT);
            $stmt5->bindParam(':program_id', $program, PDO::PARAM_INT);
            $stmt5->bindParam(':title', $reviewTitle, PDO::PARAM_STR);
            $stmt5->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt5->bindParam(':score', $score, PDO::PARAM_INT);
            try {
                $stmt5->execute();
            }
            catch(PDOException $e) {
                $errorDetected = 1;
                $EDmsg1 = 'Something went wrong';
                $EDmsg2 = 'Your program hasn\'t been saved correctly';
                error_log($e->getMessage());
                
            }
            if ($errorDetected == 0) {
                $query = "
                            SELECT score
                            FROM reviews
                            WHERE program_id = :program_id
                        ";

                $stmt2 = $conn->prepare($query);
                $stmt2->bindParam(':program_id', $program, PDO::PARAM_INT);
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
                    $stmt2->bindParam(':program_id', $program, PDO::PARAM_INT);
                    $stmt2->bindParam(':scoreAvg', $score, PDO::PARAM_STR);
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
                    $stmt2->bindParam(':program_id', $program, PDO::PARAM_INT);
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
                    $stmt2->bindParam(':program_id', $program, PDO::PARAM_INT);
                    $stmt2->bindParam(':scoreAvg', $score, PDO::PARAM_STR);
                    try {
                        $stmt2->execute();
                    }
                    catch(PDOException $e) {
                        error_log($e->getMessage());
                        
                    }
                }
                header('Location: '.dirname($_SERVER['REQUEST_URI']).'/reviews.php');
            }
        }
    }
?>