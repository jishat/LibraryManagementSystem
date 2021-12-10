<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;
use App\Utility\Message;

if(isset($_POST['stdnLogout']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('login') == true && $_POST['stdnLogout'] == 'logout'){
	Login::logout();
	echo "success";
}else{
	header('location:'.WEBROOT.'404.php');
}
