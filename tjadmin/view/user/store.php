<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\User\User;
use App\Login\Login;

if(isset($_POST['admnRegSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['admnRegSubmit'] == 'admnRegSubmit'){
	$User = new User();
	$result = $User->registerUser($_POST, $_FILES);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
