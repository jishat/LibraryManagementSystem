<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Category\Category;
use App\Login\Login;

if(isset($_POST['categoryDelBtn']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['categoryDelBtn'] == 'categoryDelBtn'){
	$Category = new Category();
	$result = $Category->delete($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
