<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Student\Student;
use App\Login\Login;

if(isset($_POST['approveBtn']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['approveBtn'] == 'approveBtn'){

	$Student 	= new Student();
	$result = $Student->approve($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
