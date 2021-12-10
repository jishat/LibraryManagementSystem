<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\User\User;
use App\Login\Login;


if(isset($_POST['adminEditSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['adminEditSubmit'] == 'adminEditSubmit'){

  if($_POST['adminInfoid'] == "1" && Login::loginGet('userid') != 1){
    echo "error";
  }else {
    $User = new User();
    $result = $User->updateUserInfo($_POST, $_FILES);
    echo $result;
  }

}else{
	header('location:'.WEBROOT.'404.php');
}
