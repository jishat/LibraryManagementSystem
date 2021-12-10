<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Book\Book;
use App\Login\Login;

if(isset($_POST['inputname']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['inputname'] == 'bookNames'){

	$Book = new Book();
	$result = $Book->searchBook($_POST);
	echo json_encode($result);
}else{
	header('location:'.WEBROOT.'404.php');
}
