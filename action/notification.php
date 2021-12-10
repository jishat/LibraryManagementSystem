<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Notification\Notification;
use App\Login\Login;

if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('login') == true){

	if(isset($_POST['dataMethod']) && isset($_POST['dataID']) && isset($_POST['isRead']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('login') == true && $_POST['dataMethod'] == 'readNotification'){
		// var_dump($_POST);
		// die();
		$Student = new Notification();
		$result = $Student->show($_POST);
		if($result != 'error'){
			echo json_encode($result);
		}else {
			echo "error";
		}
	}else {
		echo "error";
	}

}else{
	header('location:'.WEBROOT.'404.php');
}


// if(isset($_POST['dataMethod']) && isset($_POST['dataID']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('adminlogin') == true && $_POST['dataMethod'] == 'readNotification'){
// 	$Student = new Notification();
// 	$result = $Student->show($_POST['dataID']);
// 	if($result != 'error'){
// 		echo $result;
// 	}else {
// 		echo "error";
// 	}
// }else{
// 	header('location:'.WEBROOT.'404.php');
// }
