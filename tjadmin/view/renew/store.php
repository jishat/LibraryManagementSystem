<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Category\Category;
use App\Login\Login;

if(isset($_POST['categoryRegSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('adminlogin') == true && $_POST['categoryRegSubmit'] == 'categoryRegSubmit'){

	$Category = new Category();
	$result = $Category->registerCategory($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
