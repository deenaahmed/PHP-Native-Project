<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Product.php';
include '../model/category.php';
include '../model/categories.php';

session_start();


$product = new Product($conn,$_SESSION['prodIdnow']);
    $product->delete();

    header("Location: home.php");
    exit;
?>
