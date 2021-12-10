<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;
use App\Borrow\Borrow;

if(isset($_POST['borrowAccept']) && isset($_POST['borrow_info']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['borrowAccept'] == 'borrowAccept'){

	$Borrow = new Borrow;
	$accept = $Borrow->accept($_POST);
	echo $accept;
}else{
	header('location:'.WEBROOT.'404');
}
