<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Faculty\Faculty;
use App\Login\Login;

if(isset($_POST['facultyRegSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['facultyRegSubmit'] == 'facultyRegSubmit'){
	$Faculty = new Faculty();
	$result = $Faculty->registerFaculty($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
