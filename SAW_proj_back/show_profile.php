<?php
include('include_path.php');
session_start();
require_once('php/connection.php');
$title = 'PROFILE';
$style = '"css/show_profile.css"';
?>
<?php
if (isset($_SESSION['uid'])) {
    $query = "
            SELECT firstname, lastname, id, email, birthday, country, address, phone
            FROM users
            WHERE id = :id
            ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $_SESSION['uid'], PDO::PARAM_STR);
    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
        
    }
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $query = '
                SELECT COUNT(program_id)
                AS rowCount
                FROM reviews
                WHERE user_id = :user_id
            ';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['uid'], PDO::PARAM_STR);
    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
    }
    $rowTotReview = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalReviews = $rowTotReview['rowCount'];

    $query = '
                SELECT COUNT(program_id)
                AS rowCount
                FROM travels
                WHERE user_id = :user_id
            ';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['uid'], PDO::PARAM_STR);
    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
    }
    $rowTotTravels = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalTravels = $rowTotTravels['rowCount'];

    $query = '
                SELECT COUNT(DISTINCT place)
                AS rowCount
                FROM travels, programs
                WHERE user_id = :user_id AND travels.program_id = programs.id AND type = :type
            ';
    $spaceStationStr = 'space station';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['uid'], PDO::PARAM_STR);
    $stmt->bindParam(':type', $spaceStationStr, PDO::PARAM_STR);
    try {
        $stmt->execute();
    }
    catch(PDOException $e) {
        error_log($e->getMessage());
    }
    $rowTotSS = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalSpaceStation = $rowTotSS['rowCount'];
} 

?>
<?php if (isset($_SESSION['uid'])) : ?>

    <?php include('php/head.php'); ?>

    <body>
        <section class="background">
            <?php include('php/navBar.php'); ?>
            <div class="profile-card card-bg">
                <div class="profile-content">
                    <div class="row">
                        <div class="profilePic">
                            <img src="images/anon1.png" alt="profilePic">
                        </div>
                        <div class="column">
                            <div class="name"> <?php echo ucfirst($user['firstname']) . ' ' . ucfirst($user['lastname']) ?> </div>
                            <div class="info-row">
                                <div class="details-column details-text">
                                    <div class="user-content">Birthday: <?php echo $user['birthday'] ?> </div>
                                    <div class="user-content">Country: <?php echo ucfirst($user['country']) ?> </div>
                                    <div class="user-content">Address: <?php echo ucfirst($user['address']) ?> </div>
                                </div>
                                <div class="details-column details-text">
                                    <div class="user-content">E-mail: <?php echo $user['email'] ?> </div>
                                    <div class="user-content">Phone: <?php echo $user['phone'] ?> </div>
                                    <div class="user-content"></div>
                                </div>
                            </div>
                            <div class="modifiers">
                                <a href="update_profile.php" class="std-btn">Edit profile</a>
                                <a href="update_password.php" class="std-btn">Change password</a>
                                <a href="logout.php" class="std-btn logout">Logout</a>
                            </div>
                        </div>
                    </div>
                    <div class="row stats-row">
                        <div class="column">
                            <div class="stats"><?php echo $totalTravels ?></div>
                            <div class="stat-name">Number of different travels</div>
                        </div>
                        <div class="column">
                            <div class="stats"><?php echo $totalReviews;?></div>
                            <div class="stat-name">Number of reviews</div>
                        </div>
                        <div class="column">
                            <div class="stats"><?php echo $totalSpaceStation . '/4' ?></div>
                            <div class="stat-name">Space stations visited</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif ?>

    </body>

    </html>