<?php

include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/productcomment.php';
include '../model/User.php';
include '../model/Product.php';

session_start();
$conn;
$varusername;
$vardate;

if (!empty($_POST)) {


    $errorComment = $errorRate = "";
    if (!isset($_POST['text']) || !$_POST['text']) {
        $errorComment = "The Comment field is empty.";
    }
    if (!isset($_POST['ratee']) || !$_POST['ratee']) {
        $errorRate = "The rate field is empty.";
    }
    if ($errorComment == "" && $errorRate == "") {
        $productcomment1 = new productcomment($conn);
        $productcomment1->setComment($_POST['text']);
        $productcomment1->setRate($_POST['ratee']);
        $productcomment1->setProductid($_SESSION['prodIdnow']);
        $productcomment1->setUserid($_SESSION['userId']);
        $_SESSION['productcommentid'] = $productcomment1->save();
        $productcomment2 = new productcomment($conn);
        $vardate = $productcomment2->getcreatedatbycmmentid($_SESSION['productcommentid']);
        $commentinst = new User($conn, $_SESSION['userId']);
        $varusername = $commentinst->getUsername();
        $output = [];
        $output = [
            'date' => $vardate,
            'comment' => $_POST['text'],
            'username' => $varusername,
        ];
    }
} else {
    $output = [];
}
echo json_encode($output);
?>
