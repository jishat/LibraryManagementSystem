<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;
use App\Renew\Renew;

if(isset($_POST['rejectRenew']) && isset($_POST['renew_info']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['rejectRenew'] == 'rejectRenew'){
	$Renew 	= new Renew;
	$result = $Renew->rejectRequest($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
