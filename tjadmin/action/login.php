<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\User\User;
use App\Utility\Message;

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userLogSubmit']) && $_POST['userLogSubmit'] === "userLogSubmit"){
	$User = new User();
	$result = $User->userLogin($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
