<?php
namespace App\Utility;

class Message{
	public static function setMessage($value){
		$_SESSION['message'] = $value;
	}
	public static function getMessage(){
		if(array_key_exists('message', $_SESSION) && !empty($_SESSION['message'])){
				$message = $_SESSION['message'];
				$_SESSION['message'] = '';
				return $message;
		}
	}
}
