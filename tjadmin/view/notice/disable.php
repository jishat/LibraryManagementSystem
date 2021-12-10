<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use Ciu\Notice\Notice;
use Ciu\Utility\Message;

if(isset($_POST['noticeDisableButton']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
	$Notice = new Notice();
	$result = $Notice->disable($_POST);
	if(isset($_POST['link'])){
		Message::setMessage($result);
		header('location:show.php?id='.$_POST['noticeId']);
	}else{
		Message::setMessage($result);
		header('location:index.php');
	}
}