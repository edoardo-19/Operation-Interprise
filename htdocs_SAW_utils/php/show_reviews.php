<?php
if (!isset($_SESSION)) {
    session_start();
}

function showDeleteBtn($id)
{
    if (isset($_SESSION['aid'])) {
        return '
                    <div class="button-div">
                        <form method="POST">
                            <button type="submit" name="review_id" value="' . $id . '" class="button std-btn" onclick="removeReview(this.value)">
                                <p class="review-now">Delete</p>
                            </button>
                        </form>
                    </div>
                ';
    }
}



require_once("connection.php");
$query = "
                SELECT *
                FROM reviews
                ORDER BY id DESC
            ";

$stmt = $conn->prepare($query);
try {
    $stmt->execute();
}
catch(PDOException $e) {
    error_log($e->getMessage());
}
$reviews = $stmt->fetchAll();


$result = "";

for ($x = 0; $x < $stmt->rowCount(); $x++) {
    $title = $reviews[$x]['title'];
    $id = $reviews[$x]['id'];
    $description = $reviews[$x]['description'];
    $score  = $reviews[$x]['score'];
    $user_id = $reviews[$x]['user_id'];
    $program_id = $reviews[$x]['program_id'];
    $stars = score($score);
    $deleteBtn = showDeleteBtn($id);
    $query = "
                    SELECT title
                    FROM programs
                    WHERE id = :program_id
                ";

    $stmt2 = $conn->prepare($query);
    $stmt2->bindParam(':program_id', $program_id, PDO::PARAM_INT);
    try {
        $stmt2->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
    }
    $program = $stmt2->fetch();
    $programTitle = $program['title'];

    $query = "
                    SELECT firstname, lastname
                    FROM users
                    WHERE id = :user_id
                ";

    $stmt3 = $conn->prepare($query);
    $stmt3->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    try {
        $stmt3->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
    }
    $user = $stmt3->fetch();
    $userName = $user['firstname'];
    $userLastName = $user['lastname'];
    $image = dirname($_SERVER['REQUEST_URI'])."/images/anon1.png";
    $result .= '
                            <div class="review-card">
                                <div class="first-half">
                                    <img src= "' . $image . '" alt="profile pic">
                                    <div class="review-user">' . $userName . " " . $userLastName . '</div>
                                </div>
                                <div class="second-half">
                                    <div class="review-program">Review for <i>' . $programTitle . '</i></div>                    
                                    <div class="review-title">' . $title . '</div>                                      
                                    <div class="review-text">' . $description . '</div>
                                    <div class="review-stars">' . $stars . ' </div>
                                    ' .  $deleteBtn . '
                                </div>

                            </div>
                        ';
}
echo $result;
