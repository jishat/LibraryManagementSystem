<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\User\User;
use App\Login\Login;

if(isset($_POST['admnDelBtn']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['admnDelBtn'] == 'admnDelBtn'){
	if(($_POST['admninfo'] == "1" && Login::loginGet('userid') != 1) || Login::loginGet('userid') == $_POST['admninfo']){
    echo "error";
  }else {
		$User = new User();
		$result = $User->delete($_POST);
		echo $result;
	}
}else{
	header('location:'.WEBROOT.'404.php');
}
