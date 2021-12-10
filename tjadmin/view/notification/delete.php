<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Notification\Notification;
use App\Login\Login;
// var_dump($_POST);
// die();

if(isset($_POST['notifyDeleteSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['notifyDeleteSubmit'] == 'notifyDeleteBtn'){

	$Notification = new Notification();
	$result = $Notification->delete($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
