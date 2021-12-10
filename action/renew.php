<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;
use App\Renew\Renew;

if(isset($_POST['borrowRenewSubmit']) && isset($_POST['borrow_info']) && isset($_POST['comeFrom']) && $_POST['comeFrom'] =='student' && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('login') == true && $_POST['borrowRenewSubmit'] == 'borrowRenewSubmit'){
	// var_dump($_POST);
	// die();
	$Renew = new Renew;
	$result = $Renew->renewRequest($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
