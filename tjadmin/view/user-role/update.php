<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Userrole\Userrole;
use App\Login\Login;

if(isset($_POST['userRoleEditSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['userRoleEditSubmit'] == 'userRoleEditSubmit'){
	$Userrole = new Userrole();
	$result = $Userrole->updateUserRole($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
