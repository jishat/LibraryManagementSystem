<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');

if(isset($_POST['socLinkSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
	$Social = new Social();
	$result = $Social->updateSocialLink($_POST);
	if($result){
		Message::setMessage($result);
		header('location:index.php');
	}
}else{
	header('location:'.WEBROOT.'404.php');
}