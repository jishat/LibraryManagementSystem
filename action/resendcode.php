<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Student\Student;
use App\Login\Login;

if(isset($_POST['resendCodeSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST' && Login::loginGet('action') != false && Login::loginGet('action') == 'verify' && $_POST['resendCodeSubmit'] === "resendCodeSubmit"){
	$Student = new Student();
	$result = $Student->resendVerifyCode();
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
