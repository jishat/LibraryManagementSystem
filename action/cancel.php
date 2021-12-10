<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;
use App\Borrow\Borrow;

if(isset($_POST['borrowReject']) && isset($_POST['borrow_info']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('login') == true &&  $_POST['borrowReject'] == 'borrowReject'){

	$Borrow = new Borrow;
	$accept = $Borrow->reject($_POST);
	echo $accept;
}else{
	header('location:'.WEBROOT.'404.php');
}
