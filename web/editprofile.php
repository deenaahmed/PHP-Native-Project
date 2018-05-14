<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/User.php';

session_start();
//print_r($_SESSION['prodId']);
if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == 1) && isset($_SESSION['userId'])) { //if user is not logged in he woukdn't eneter that page
    $userId = $_SESSION['userId'];
    $user = new User($conn, $userId);

    if (!empty($_POST)) {
        if (!empty($_FILES['fileToUpload']['tmp_name'])) {
            $filename = $_FILES['fileToUpload']['tmp_name'];
            $filePath = "\uploads/" . time() . '.jpeg';
            $destination = __DIR__ . $filePath;
            if (!move_uploaded_file($filename, $destination)) {
                die('cant upload');
            }
            $user->setPhoto($filePath);
        }
        $user->setUsername($_POST['username']);
        $user->setPhone($_POST['phone']);
        $user->setEmail($_POST['email']);
        $user->update();

        header("Location: account.php");
        exit;
    }
} else {
    
}
?>
<?php if (isset($_SESSION['loggedIn']) && ($_SESSION['loggedIn'] == 1) && isset($_SESSION['userId'])): ?>
    <a href="home.php"><h1>home</h1></a>
    <form method="post" enctype="multipart/form-data">
        <img src="<?= $user->getPhoto() ?>" width="100" height="100" />
        Change photo:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <br/>
        Username<input name="username" value="<?= $user->getUsername() ?>" />
        <br/>
        Email<input name="email" value="<?= $user->getEmail() ?>" />
        <br/>
        Phone<input name="phone" value="<?= $user->getPhone() ?>" />
        <br/>

        <button type="submit">Update</button>
    </form>
<?php else: ?>


<?php endif; ?>
