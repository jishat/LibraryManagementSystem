<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Student\Student;

if(isset($_POST['stuRegSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['stuRegSubmit'] === "stuRegSubmit"){
	$Student = new Student();
	$result = $Student->registerStudent($_POST, $_FILES);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
