<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\User\User;
use App\Login\Login;

if(isset($_POST['changesubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['changesubmit'] == 'changesubmit'){
	if(($_POST['id'] == "1" && Login::loginGet('userid') != 1) || Login::loginGet('userid') == $_POST['id']){
    echo "error";
  }else {
		$User 	= new User();
		$result = $User->status($_POST);
		echo $result;
  }

}else{
	header('location:'.WEBROOT.'404.php');
}
