<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Student\Student;
use App\Login\Login;
use App\Utility\Token;
$Token = new Token;

if(isset($_POST['stuRegSubmit']) && isset($_POST['stuRegTkn']) && $_POST['stuRegTkn'] == $Token->tokenGet('regtoken') && $_SERVER['REQUEST_METHOD'] == 'POST'  &&
$_POST['stuRegSubmit'] == 'stuRegSubmit' && isset($_POST['cameFrom']) && $_POST['cameFrom'] == "front"){
	$Student = new Student();
	$result = $Student->registerStudent($_POST, $_FILES);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
