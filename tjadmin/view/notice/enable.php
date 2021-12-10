<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use Ciu\Notice\Notice;
use Ciu\Utility\Message;

if(isset($_POST['noticeEnableButton']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
	$Notice = new Notice();
	$result = $Notice->enable($_POST);
	if(isset($_POST['link'])){
		Message::setMessage($result);
		header('location:show.php?id='.$_POST['noticeId']);
	}else{
		Message::setMessage($result);
		header('location:index.php');
	}
}else{
	header('location:'.WEBROOT.'404.php');
}