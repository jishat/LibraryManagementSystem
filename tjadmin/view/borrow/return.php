<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;
use App\Borrow\Borrow;

if(isset($_POST['borrowReturn']) && isset($_POST['borrow_info']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['borrowReturn'] == 'borrowReturn'){

	$Borrow = new Borrow;
	$giveback = $Borrow->return($_POST);
	echo $giveback;
}else{
	header('location:'.WEBROOT.'404.php');
}
