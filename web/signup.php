<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/User.php';

$errorUsername = $errorPhoto = $errorPassword = $errorPhone = $errorEmail = "";

if (!empty($_POST)) {

    $filename = $_FILES['fileToUpload']['tmp_name'];
    $filePath = '/uploads/' . time() . '.jpeg';
    $destination = __DIR__ . $filePath;
    if (empty($_FILES['fileToUpload']['tmp_name'])) {
        $filePath = "/Projecttrial/web/empty-img.png";  //display empty image       
    } else if (!move_uploaded_file($filename, $destination)) {
        $errorPhoto .= "This Field required.";
        die('cant upload');
    } else {
        
    }
    if (!isset($_POST['username']) || !$_POST['username']) {
        $errorUsername .= "This Field required.";
    } else {
        if (strlen($_POST['username']) > 20 || strlen($_POST['username']) < 5) {
            $errorUsername .= "Max Legth is 20Char AND Min Length 6";
        }
    }
    if (!isset($_POST['email']) || !$_POST['email']) {
        $errorEmail .= "This Field required.";
    } else {
        
    }
    if (!isset($_POST['phone']) || !$_POST['phone']) {
        $errorPhone .= "This Field required.";
    } else {
        
    }

    if (!isset($_POST['password']) || !$_POST['password'] || !isset($_POST['confirm_password']) || !$_POST['confirm_password']) {
        $errorPassword = "Password ANd confirm paswword is required";
    } else {
        if ($_POST['password'] != $_POST['confirm_password']) {
            $errorPassword = "Password Not Match";
        }
    }
    if ($errorPassword == "" && $errorUsername == "" && $errorEmail == "" && $errorPhone == "" && $errorPhoto == "") {
        session_start();
        $user = new User($conn);
        $user->setUsername($_POST['username']);
        $user->setPassword($_POST['password']);
        $user->setEmail($_POST['email']);
        $user->setPhone($_POST['phone']);
        $user->setPhoto($filePath);
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['userId'] = $user->save();
        $_SESSION['prodId'] = [];
        $_SESSION['loggedIn'] = 1;
        $_SESSION['price'] = 0;
        $_SESSION['catid'] = 0;
        $_SESSION['forwardedfromremove'] = 0;

        header('Location: home.php');
        exit;
    }
}
?>
<html>
    <head>

    </head>
    <body>
        <h1>Sign up </h1>
        <form method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <br/>
            <br/>
            Username:<input name="username" type="text"  value="<?php echo isset($_POST['username']) ? $_POST['username'] : "" ?>"/>
            <br/>
<?php echo $errorUsername ?>
            <br/>
            Email: <input name="email" type="text" />
            <br/>
            <br/>
            Phone: <input name="phone" type="text" />
            <br/>
            <br/>
            Password: <input name="password" type="password" />
            <br/>
            <br/>
            Confirm Password:<input name="confirm_password" type="password" />
            <br/>
<?php echo $errorPassword ?>
            <br/>
            <button type="submit">Signup</button>
        </form>
    </body>
</html>
