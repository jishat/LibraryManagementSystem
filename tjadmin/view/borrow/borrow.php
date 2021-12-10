<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Borrow\Borrow;
use App\Login\Login;

if(isset($_POST['borrowNow']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['borrowNow'] == 'borrowNow'){
	$Borrow = new Borrow();
	$result = $Borrow->borrowManually($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
