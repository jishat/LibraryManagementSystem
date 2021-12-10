<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Student\Student;
use App\Login\Login;

if(isset($_POST['stdRejectSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['stdRejectSubmit'] == 'stdRejectBtn'){

	$Student = new Student();
	$result = $Student->reject($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
