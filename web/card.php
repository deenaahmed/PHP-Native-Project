<?php

session_start();
$output = [];
array_push($_SESSION['prodId'], $_POST['prodId']);
$arr1 = $_SESSION['prodId'];
$counter = 0;
if (sizeof($arr1) == 0) {
    $output = array(
        0 => $arr1[0],
    );
} else if (sizeof($arr1) == 0) {
    
} else {

    for ($a = 0; $a < sizeof($arr1); $a++) {
        array_push($output, $arr1[$counter]);
        $counter++;
    }
}
echo JSON_encode($output);
?>


