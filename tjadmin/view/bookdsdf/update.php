<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/ciu/bootstrap.php');
use Ciu\Utility\Message;
use Ciu\Book\Book;

if(isset($_POST['bookEditSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

  $Book = new Book();
  $result = $Book->updateBookInfo($_POST, $_FILES);
  if($result){
    Message::setMessage($result);
    header('location:edit.php?id='.$_POST['bookId']);
  }
}else{
	header('location:'.WEBROOT.'404.php');
}