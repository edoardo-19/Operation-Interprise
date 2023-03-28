<?php
include('../include_path.php');

    //funzione di controllo per verificare se l'utente è admin e far comparire i tasti riservati
    function showEditBtn($id)
    {
        if (isset($_SESSION['aid'])) {
            return '
                        <div class="links">
                            <div class="button-container">
                                <form class="link-form-div" action="edit_program.php" method="POST">
                                    <button type="submit" class="button-with-form std-btn" name="program_id" value="' . $id . '">
                                        <p class="button-text">Edit</p>
                                    </button>
                                </form>
                            </div>
                            <div class="button-container">
                                <form class="link-form-div" method="POST">
                                    <button type="submit" class="button-with-form std-btn" name="program_id" value="' . $id . '" onclick="removeProgram(this.value)">
                                        <p class="button-text">Delete</p>
                                    </button>
                                </form>
                            </div>
                        </div>
                    ';
        }
    }


    session_start();
    require_once('php/connection.php');
    include('php/common/score_to_stars.php');
    $search = $_REQUEST["search"];
    if(is_string($search) && strlen($search)>0){

    $query = "
                SELECT *
                FROM programs
                WHERE title LIKE :title
            ";
    $var = '%'.$search.'%';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':title', $var, PDO::PARAM_STR);

    } else {
        $query = "
                SELECT *
                FROM programs
            ";
        $stmt = $conn->prepare($query);
    }

    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }
    $programs = $stmt->fetchAll();
    $result = "";
        for($x = 0 ; $x < $stmt->rowCount() ; $x++){
            $id = $programs[$x]['id'];
            $title = $programs[$x]['title'];
            $description = $programs[$x]['description'];
            $price = $programs[$x]['price'];
            $type  = $programs[$x]['type'];
            $place = $programs[$x]['place'];
            $img = $programs[$x]['image'];
            $scoreAvg = $programs[$x]['scoreAvg'];
            $buttonID = (-$x) - 1;
            $editBtn = showEditBtn($id);
            if($scoreAvg == 0){
                $stars = '  <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        ';
            } else {
                $stars = score($scoreAvg);
            }
            if($stmt->rowCount() > 0){
                if (isset($_SESSION['uid'])) {
                    $result .= '
                    <div class="program-card">
                        <div>
                            <div class="program-image"><img src="images/programs-img/' . $img . '" alt=""></div>
                            <div class="program-title">
                                <h3>' . $title . '</h3>
                            </div>
                            <div class="program-description">
                                <p>' . $description . '</p>
                            </div>
                            <div class="program-stars">'.$stars.'</div>
                            <div class="program-stats-container">
                                <div class="program-stats">
                                    <p>Type</p>
                                    <h5>'.$type.'</h5>
                                </div>
                                <div class="program-stats">
                                    <p>Where</p>
                                    <h5>'.$place.'</h5>
                                </div>
                                <div class="program-stats">
                                    <p>Prize</p>
                                    <h5>' . $price . ' Doge Coins</h5>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="links">
                                <div class="button-container">
                                    <form class="link-form-div" action="write_review.php" method="POST">
                                        <button type="submit" class="button-with-form std-btn" name="program_id" value="' . $id . '">
                                            <p class="button-text">Write review</p>
                                        </button>
                                    </form>
                                </div>
                                <div class="button-container">
                                    <form class="link-form-div" method="GET">
                                        <button type="button" class="button-with-form std-btn" id="' . $buttonID . '" name="program" value="' . $id . '" onclick="addToCart(this.value,this.id)">
                                            <p class="button-text" id="' . $id . '">Add to cart</p>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            '.$editBtn.'
                        </div>
                    </div>';
                } 
                else {
                    $result .= '
                    <div class="program-card">
                        <div>
                            <div class="program-image"><img src="images/programs-img/' . $img . '" alt=""></div>
                            <div class="program-title">
                                <h3>' . $title . '</h3>
                            </div>
                            <div class="program-description">
                                <p>' . $description . '</p>
                            </div>
                            <div class="program-stars">'.$stars.'</div>
                            <div class="program-stats-container">
                                <div class="program-stats">
                                    <p>Type</p>
                                    <h5>'.$type.'</h5>
                                </div>
                                <div class="program-stats">
                                    <p>Where</p>
                                    <h5>'.$place.'</h5>
                                </div>
                                <div class="program-stats">
                                    <p>Prize</p>
                                    <h5>' . $price . ' Doge Coins</h5>
                                </div>
                            </div>
                        </div>
                        <div class="links">
                            <div class="button-container">
                                <div class="link-form-div">
                                    <a href="write_review.php" class="button std-btn">
                                        <p class="button-text">Write review</p>
                                    </a>
                                </div>
                            </div>
                            <div class="button-container">
                                <div class="link-form-div">
                                    <a href="shopping_cart.php" class="button std-btn">
                                        <p class="button-text" id="' . $id . '">Add to cart</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }
        }

    //se ho result uguale a vuoto e search diverso da vuoto significa che non ho corrispondenza
    if($result == "" && $search != ""){
        echo $result;
    } else {
        if (isset($_SESSION["aid"])) {
            $result .= '
                    <div class="program-card addProgram">
                        <a href="add_program.php" class="addProgramBtn">
                            +
                        </a>
                    </div>';
            }
        echo $result;
    }