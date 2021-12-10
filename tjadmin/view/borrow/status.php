<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Book\Book;
use App\Login\Login;

if(isset($_POST['changesubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['changesubmit'] == 'bookstatussubmit'){

	$Book 	= new Book();
	$result = $Book->status($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
