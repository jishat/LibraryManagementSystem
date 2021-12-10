<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ciu/bootstrap.php');
use Ciu\Utility\Message;
use Ciu\Book\Book;


if(isset($_POST['bookDeleteButton']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
	$Book = new Book();
	$result = $Book->delete($_POST);
	if($result){
		Message::setMessage($result);
		header('location:index.php');
	}
}else{
	header('location:'.WEBROOT.'404');
}