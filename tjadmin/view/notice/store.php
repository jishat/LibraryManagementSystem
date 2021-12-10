<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use Ciu\Notice\Notice;
use Ciu\Utility\Message;

if(isset($_POST['noticeSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

	$Notice = new Notice();
	$result = $Notice->addNotice($_POST, $_FILES);
	if($result == "successfully" || $result == "unsuccessfully"){
		Message::setMessage($result);
		header('location:index.php');
	}else{
		Message::setMessage($result);
		header('location:create.php');
	}
}else{
	header('location:'.WEBROOT.'404.php');
}