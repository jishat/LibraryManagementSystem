<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Student\Student;
use App\Login\Login;

if(isset($_POST['stuRegSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['stuRegSubmit'] == 'stuRegSubmit'){
	$Student = new Student();
	$result = $Student->registerStudent($_POST, $_FILES);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
