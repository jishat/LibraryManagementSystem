<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Userrole\Userrole;
use App\Login\Login;

if(isset($_POST['usrlDelBtn']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['usrlDelBtn'] == 'usrlDelBtn'){
	$Userrole = new Userrole();
	$result = $Userrole->delete($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
