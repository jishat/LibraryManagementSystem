<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use Ciu\Notice\Notice;
use Ciu\Utility\Message;

if(isset($_POST['noticeDeleteButton']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
	$Notice = new Notice();
	$result = $Notice->delete($_POST);
	if($result){
		Message::setMessage($result);
		header('location:index.php');
	}
}else{
	header('location:'.WEBROOT.'404.php');
}