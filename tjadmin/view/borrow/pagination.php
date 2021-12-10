<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;

if(isset($_POST['method']) && isset($_POST['pageNo']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['method'] == 'pagination'){
	$_SESSION['borrow_pag'] = $_POST['pageNo'];
	echo 'success';
}else{
	header('location:'.WEBROOT.'404.php');
}
