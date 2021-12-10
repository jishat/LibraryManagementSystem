<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');

if(isset($_POST['brandUpdtSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
	$Brand = new Brand();

	if(isset($_FILES) && !empty($_FILES)){
		$result = $Brand->updateLogo($_FILES);
		if($result){
			Message::setMessage($result);
			header('location:index.php');
		}
	}elseif(isset($_POST['brandName'])){
		$result = $Brand->updateBrandName($_POST);
		if($result){
			Message::setMessage($result);
			header('location:index.php');
		}
	}else{
		$msg = "unsuccessfully";
		Message::setMessage($result);
		header('location:index.php');
	}
}else{
	header('location:'.WEBROOT.'404.php');
}