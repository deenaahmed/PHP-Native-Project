<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/User.php';

session_start();
//print_r($_SESSION['prodId']);
if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == 1) && isset($_SESSION['userId'])) {

    if (!isset($_SESSION['userId']) || !$_SESSION['userId']) {
        header("Location: login.php");
        exit;
    }
    $userId = $_SESSION['userId'];

//    if (isset($_GET['id']) && $_GET['id']) {
//        $userId = $_GET['id'];
//    }

    $user = new User($conn, $userId);
} else {
    
}
?>
<?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 1): ?>
    <h1>LoggedIn User Info</h1>
    <a href="home.php"><h1>home</h1></a>
    <img src="<?= $user->getPhoto() ?>" width="100" height="100" />
    <h3>Username: <?= $user->getUsername() ?></h3>
    <h3>Email: <?= $user->getEmail() ?></h3>
    <h3>Phone: <?= $user->getPhone() ?></h3>
    <?php if ($userId == $_SESSION['userId']): ?>
        <h3><a href="editprofile.php">Edit Profile</a></h3>
    <?php endif; ?>
<?php else: ?>
<?php endif; ?>
