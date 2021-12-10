<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\News\News;
use App\Utility\Message;


if(isset($_POST['newsSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
	$News = new News();
	$result = $News->addNews($_POST, $_FILES);
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
