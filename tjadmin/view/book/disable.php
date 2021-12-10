<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Student\Student;

if(isset($_POST['disableStudentAcc']) && $_SERVER['REQUEST_METHOD'] == 'POST' && Login::loginGet('userlogin') == true &&  $_POST['disableStudentAcc'] === "disableStudentAcc"){

	$Student = new Student();
	$result = $Student->disable($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404');
}
