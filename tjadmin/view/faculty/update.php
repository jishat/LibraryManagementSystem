<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Faculty\Faculty;
use App\Login\Login;

if(isset($_POST['facultyEditSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['facultyEditSubmit'] == 'facultyEditSubmit'){
	$Faculty = new Faculty();
	$result = $Faculty->updateFaculty($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
