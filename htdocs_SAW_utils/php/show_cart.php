<?php
    require_once("connection.php");
    $uid = $_SESSION['uid'];
    //estraggo dal db il carello dell'utente
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
    $programsList = $stmt->fetchAll();
    
    $result = "";
    $total = 0;
    //ciclo per scorrere tutti gli elementi
    for($x = 0 ; $x < $stmt->rowCount() ; $x++){
        $query = "
                    SELECT title, image, price
                    FROM programs
                    WHERE id = :program_id
                ";
        
        $stmt2 = $conn->prepare($query);
        $stmt2->bindParam(':program_id', $programsList[$x]['program_id'], PDO::PARAM_INT);
        try {
            $stmt2->execute();
        }
        catch(PDOException $e) {
            error_log($e->getMessage());
        }
        $program = $stmt2->fetch();

        $title = $program['title'];
        $id = $programsList[$x]['program_id'];
        $price = $program['price'];
        $img = $program['image'];
        //result sarà una concatenazioni di tutti i risultati delle query fatto per ogni programma che l'utente ha nel carrello
        $result .= '    
                        <div class="row items-row">
                            <div class="item item-img"><img src="images/programs-img/' . $img . '" alt="program image"></div>
                            <div class="item item-title">' . $title . '</div>
                            <div class="item item-price">' . $price . ' DOGE COINS</div>
                            <form method="POST" class="remove-from-cart">
                                <button type="submit" name="delete" value="' . $id . '" class="std-btn delete" onclick="removeFromCart(this.value)">x</button>
                            </form>
                        </div>
                    ';
        $total += $price;
    }

    //carrello vuoto
    if($result === ""){
        $result .= '<div class="empty-cart-msg">Your cart is empty</div>';
    }

    echo $result;

?>