<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;
use App\Borrow\Borrow;

if(isset($_POST['borrowRenewSubmit']) && isset($_POST['borrow_info']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['borrowRenewSubmit'] == 'borrowRenewSubmit'){

	// var_dump($_POST);
	// die();
	$Borrow = new Borrow;
	$renew = $Borrow->renew($_POST);
	echo $renew;
}else{
	header('location:'.WEBROOT.'404.php');
}
