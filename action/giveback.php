<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;
use App\Borrow\Borrow;

if(isset($_POST['borrowGiveBack']) && isset($_POST['borrow_info']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('login') == true && $_POST['borrowGiveBack'] == 'borrowGiveBack'){
	$Borrow = new Borrow;
	$giveback = $Borrow->giveback($_POST);
	echo $giveback;
}else{
	header('location:'.WEBROOT.'404.php');
}
