<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/ciu/bootstrap.php');
use Ciu\Utility\Message;
use Ciu\Book\Book;

if(isset($_POST['newBookSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['newBookSubmit'] === "newBookSubmit"){
	$Book 	= new Book();
	$result = $Book->newBook($_POST, $_FILES);	
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}