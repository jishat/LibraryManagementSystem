<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Book\Book;
use App\Login\Login;

if(isset($_POST['bookRegSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['bookRegSubmit'] == 'bookRegSubmit'){
	$Book = new Book();
	$result = $Book->newBook($_POST, $_FILES);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
