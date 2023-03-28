<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once("connection.php");

$query = '
                SELECT email, firstname, lastname, id
                FROM users
            ';
$stmt = $conn->prepare($query);
try {
    $stmt->execute();
}
catch(PDOException $e) {
    error_log($e->getMessage());
}
$usersList = $stmt->fetchAll();

$result = "";
$totalUsers = $stmt->rowCount();

for ($x = 0; $x < $totalUsers; $x++) {
    $user_id = $usersList[$x]['id'];
    $firstname = $usersList[$x]['firstname'];
    $lastname = $usersList[$x]['lastname'];
    $email = $usersList[$x]['email'];

    $result .= '    
                        <div class="row user-row">
                            <div class="user-info">' . $firstname . " " . $lastname . '</div>
                            <div class="user-info">' . $email . '</div>
                            <form method="POST" class="button-container" >
                                <button type="submit" class="std-btn delete" name="delete" value="' . $user_id . '" onclick="removeFromUsers(this.value)">BAN</button>
                            </form>
                        </div>
                    ';
}
echo $result;
