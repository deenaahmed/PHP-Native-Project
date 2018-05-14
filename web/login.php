<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/User.php';
include '../model/Users.php';

$error = "";
if (!empty($_POST)) {
    if (!isset($_POST['username']) || !$_POST['username']) {
        $error .= "No Username given<br>";
    }
    if (!isset($_POST['password']) || !$_POST['password']) {
        $error .= "No Password given<br>";
    }

    if ($error == "") {
        $loggedIn = false;
        $usersO = new Users($conn);
        $users00 = $usersO->getuserss();
        foreach ($users00 as $user1) {
            if ($user1->getUsername() == $_POST['username'] && $user1->getPassword() == $_POST['password']) {
                session_start();
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['userId'] = $user1->getId();
                $_SESSION['prodId'] = [];
                $_SESSION['loggedIn'] = 1;
                $_SESSION['price'] = 0;
                $_SESSION['catid'] = 0;
                $_SESSION['forwardedfromremove'] = 0;
                $loggedIn = true;
                break;
            }
        }
        if ($loggedIn) {
            header('Location: home.php');
            exit;
        } else {
            $error .= "Erorr username and password";
        }
    }
}
?>
<html>
    <body>
        <style>
            .error{
                color: red;
            }
        </style>
        <h1>Please Login to your account</h1>

        <form method="post">
            <input name="username" type="text" />
            <br/>
            <br/>
            <input name="password" type="password" />
            <br/>
            <br/>
            <button type="submit">Login</button>
        </form>
    </body></html>