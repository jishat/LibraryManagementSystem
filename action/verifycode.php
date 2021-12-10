<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Student\Student;
use App\Login\Login;

if(isset($_POST['verifySumbit']) && $_SERVER['REQUEST_METHOD'] == 'POST' && Login::loginGet('action') != false && Login::loginGet('action') == 'verify' && $_POST['verifySumbit'] === "verifySumbit"){
	// echo "resent";
	$Student = new Student();
	$result = $Student->verifyEmail($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
