<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ciu/bootstrap.php');
use Ciu\Utility\Message;
use Ciu\Book\Book;


if(isset($_POST['bookDisableButton']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
	$Book = new Book();
	$result = $Book->disable($_POST);
	if(isset($_POST['link'])){
		Message::setMessage($result);
		header('location:show.php?id='.$_POST['bookId']);
	}else{
		Message::setMessage($result);
		header('location:index.php');
	}
}else{
	header('location:'.WEBROOT.'404');
}