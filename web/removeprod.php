<?php

include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Product.php';
session_start();
$arr = $_SESSION['prodId'];

//$_SESSION['forwardedfromremove'] = 1;
//print_r($_POST['removedprodId']);
//print_r(sizeof($arr));

for ($a = 0; $a < sizeof($arr); $a++): {
        if ($arr[$a] == $_POST['removedprodId']) {
            array_splice($arr, $a, 1);
        }
    }

endfor;
//print_r($_SESSION['price']);
$_SESSION['prodId'] = $arr; //bashel l product da mn l session
$var = $_SESSION['price'];
//print_r($_POST['priceyala']);
//$var = $_SESSION['price'];
$productu = new Product($conn, $_POST['removedprodId']);
$temp = $productu->getPrice();
//print_r($temp);
$var = (int) $var - (int) $temp;
//print_r($var);
$_SESSION['price'] = $var;
/* $output = array(
  'price' =>$var,
  ); */
$output = $var;
//print_r($_SESSION['price']);
//print_r($_SESSION['prodId'] );
/* foreach ($arr as $productuid): 
  if($productuid==$_POST['prodId'])
  {
  unset($productuid[])
  }
  endforeach; */


echo JSON_encode($output);
