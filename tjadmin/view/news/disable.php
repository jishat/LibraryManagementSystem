<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\News\News;
use App\Utility\Message;


if(isset($_POST['newsDisableButton']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
	$News = new News();
	$result = $News->disable($_POST);
	if(isset($_POST['link'])){
		Message::setMessage($result);
		header('location:show.php?id='.$_POST['newsId']);
	}else{
		Message::setMessage($result);
		header('location:index.php');
	}
}else{
	header('location:'.WEBROOT.'404.php');
}
