<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Book\Book;
use App\Login\Login;

if(isset($_POST['bookEditSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['bookEditSubmit'] == 'bookEditSubmit'){


  $Book = new Book();
  $result = $Book->updateBook($_POST, $_FILES);
  echo $result;
}else{
	header('location:'.WEBROOT.'404');
}
