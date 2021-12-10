<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Login\Login;

if(isset($_POST['studentLogout']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
	Login::logout();
	Message::setMessage('logout');
	header('location:index.php');
}else{
	header('location:'.WEBROOT.'404.php');
}
