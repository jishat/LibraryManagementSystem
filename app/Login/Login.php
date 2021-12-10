<?php
namespace App\Login;
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');

class Login{
	public static function loginGet($key){
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		}else{
			return false;
		}
	}
	public static function loginSet($key, $value){
		$_SESSION[$key] = $value;
	}

	public static function logout(){
		session_unset();
		session_destroy();
	}
	public static function checkLogin(){
		if(self::loginGet('userlogin') == true){
			header('location:'.ADMINVIEW.'dashboard');
		}
	}
	public static function checkStudentLogin(){
		if(self::loginGet('login') == true){
			header('location:'.WEBROOT.'book.php');
		}
	}
	public static function checkLogOut(){
		if(self::loginGet('userlogin') == false){
			self::logout();
			header('location:'.ADMIN);
		}
	}
	public static function checkStudentLogout(){
		if(self::loginGet('login') == false){
			self::logout();
			header('location:'.WEBROOT);
		}
	}
}
