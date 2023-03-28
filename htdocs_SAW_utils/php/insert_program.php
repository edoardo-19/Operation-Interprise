<?php


if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $price = $_POST['price'];
    $description = trim($_POST['description']);
    $program_id = $_POST['submit'];

    if ($update == 0) {//eseguito solo se sto inserendo per la prima volta un programma
        $uploaddir = realpath(dirname(__FILE__) . '/../../'  . 'public_html/images/programs-img'); 
        //stringa per lavorare in locale: $uploaddir = $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['REQUEST_URI']).'/images/programs-img';
        $tmp_name = $_FILES["program_image"]["tmp_name"];
        $name = basename($_FILES["program_image"]["name"]);
        $serverFilename = basename($_FILES['program_image']['name']);

        if (move_uploaded_file($tmp_name, "$uploaddir/$name")) {
        } else {
            $errorDetected = 1;
            $EDmsg1 = 'File not valid';
            $EDmsg2 = 'Supported images: png, jpeg, jpg';
        }
    }

    //controlli vari
    if (isset($_POST['type'])) {
        $type = $_POST['type'];
    } else {
        $errorDetected = 1;
        $EDmsg1 = 'Essential field empty';
        $EDmsg2 = 'All fields are mandatory';
    }
    if (isset($_POST['where'])) {
        $where = $_POST['where'];
    } else {
        $errorDetected = 1;
        $EDmsg1 = 'Essential field empty';
        $EDmsg2 = 'All fields are mandatory';
    }
    if (empty($title) || empty($description) || empty($price)) {
        $errorDetected = 1;
        $EDmsg1 = 'Essential field empty';
        $EDmsg2 = 'All fields are mandatory';
    } elseif (mb_strlen($title) > 50) {
        $errorDetected = 1;
        $EDmsg1 = 'The title is too long';
        $EDmsg2 = 'Max length: 50 digits';
    } elseif (mb_strlen($description) > 255) {
        $errorDetected = 1;
        $EDmsg1 = 'The description is too long';
        $EDmsg2 = 'Max length: 255 digits';
    }

    //query per inseire un programmma
    if ($update == 0 && $errorDetected != 1) {
        $query = "
                    INSERT INTO programs
                    VALUES (0, :title, :description, :price, :type, :where, :img, NULL)
                ";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':where', $where, PDO::PARAM_STR);
        $stmt->bindParam(':img', $serverFilename, PDO::PARAM_STR);

        try {
            $stmt->execute();
        }
        catch(PDOException $e) {
            $errorDetected = 1;
            $EDmsg1 = 'Something went wrong';
            $EDmsg2 = 'Your program hasn\'t been saved correctly';
            error_log($e->getMessage());
            
        }

        //query a buon fine, ho aggiunto righe
        if ($errorDetected == 0) {
            header('Location: ' . dirname($_SERVER['REQUEST_URI']) . '/programs.php');
        }
    }   //query per salvare le modifiche ad un programma
    elseif ($update == 1 && $errorDetected != 1) {
        $query = "
                        UPDATE programs
                        SET title = :title, description = :description, price = :price, type = :type, place = :where
                        WHERE id = :program_id
                    ";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':program_id', $program_id, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':where', $where, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) { //query a buon fine
            header('Location: '.dirname($_SERVER['REQUEST_URI']).'/programs.php');
        } else {
            $errorDetected = 1;
            $EDmsg1 = 'Something went wrong';
            $EDmsg2 = 'Your program hasn\'t been saved correctly';
        }
    }
}
?>


