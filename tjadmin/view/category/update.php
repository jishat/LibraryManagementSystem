<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Category\Category;
use App\Login\Login;

if(isset($_POST['categoryEditSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['categoryEditSubmit'] == 'categoryEditSubmit'){

	$Category = new Category();
	$result = $Category->updateCategory($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
