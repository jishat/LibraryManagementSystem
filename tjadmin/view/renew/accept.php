<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;
use App\Renew\Renew;

if(isset($_POST['acceptRenew']) && isset($_POST['renew_info']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['acceptRenew'] == 'acceptRenew'){
	// var_dump($_POST);
	// die();
	$Renew = new Renew;
	$result = $Renew->acceptRequest($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
