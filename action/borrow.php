<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Student\Student;
use App\Login\Login;
use App\Borrow\Borrow;
if(isset($_POST['borrowbook']) && isset($_POST['dataID']) && isset($_POST['booking']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && $_POST['borrowbook'] == "borrowbook" && Login::loginGet('login') == true){
	$Borrow = new Borrow();
	$result = $Borrow->borrow($_POST);
	echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
