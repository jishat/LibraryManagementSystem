<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Book\Book;
use App\Login\Login;

if(isset($_POST['bookDelBtn']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['bookDelBtn'] == 'bookDelBtn'){

	$Book = new Book();
	$result = $Book->delete($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404');
}
