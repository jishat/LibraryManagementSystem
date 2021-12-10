<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;
use App\Renew\Renew;

if(isset($_POST['deleteRenew']) && isset($_POST['checkedrenewrequest']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['deleteRenew'] == 'deleteRenew'){

	// var_dump($_POST);
	// die();
	$Renew = new Renew;
	$result = $Renew->deleteRequest($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
