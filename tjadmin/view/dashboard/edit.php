<?php



$urlParts = explode("/", dirname($_SERVER['PHP_SELF']));
$urlParts = array_reverse($urlParts);
echo $urlParts[0];
// print_r($urlParts);
