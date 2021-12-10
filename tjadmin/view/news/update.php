<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\News\News;
use App\Utility\Message;


if(isset($_POST['newsEditSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

  $News = new News();
  $result = $News->updateNews($_POST, $_FILES);
  if($result){
    Message::setMessage($result);
    header('location:edit.php?id='.$_POST['newsId']);
  }
}else{
	header('location:'.WEBROOT.'404.php');
}
