<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\News\News;
use App\Utility\Message;


if(isset($_POST['newsDeleteButton']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
	$News = new News();
	$result = $News->delete($_POST);
	if($result){
		Message::setMessage($result);
		header('location:index.php');
	}
}else{
	header('location:'.WEBROOT.'404.php');
}
