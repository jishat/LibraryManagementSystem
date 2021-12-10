<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');

use App\Student\Student;
use App\Utility\Token;
$Token = new Token;

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userLogSubmit']) && $_POST['userLogSubmit'] === "userLogSubmit" && isset($_POST['stuLogTkn']) && $_POST['stuLogTkn'] == $Token->tokenGet('logtoken')  ){
	$Student = new Student();
	$result = $Student->studentLogin($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
