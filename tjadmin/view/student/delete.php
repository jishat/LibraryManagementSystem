<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Student\Student;
use App\Login\Login;

if(isset($_POST['stdDeleteSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['stdDeleteSubmit'] == 'stdDelBtn'){

	$Student = new Student();
	$result = $Student->delete($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
