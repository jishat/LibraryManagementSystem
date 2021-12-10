<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use Ciu\Notice\Notice;
use Ciu\Utility\Message;

if(isset($_POST['noticeEditSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){

  $Notice = new Notice();
  $result = $Notice->updateNotice($_POST, $_FILES);
  if($result){
    Message::setMessage($result);
    header('location:edit.php?id='.$_POST['noticeId']);
  }
}else{
	header('location:'.WEBROOT.'404.php');
}