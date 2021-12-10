<?php

namespace App\Utility;


class Token
{
	public static function tokenGet($key){
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		}else{
			return false;
		}
	}
	public static function logToken(){
		$_SESSION['logtoken'] = bin2hex(random_bytes(32));
		if (array_key_exists('logtoken', $_SESSION) && !empty($_SESSION['logtoken'])){
				$logtoken = $_SESSION['logtoken'];
				return $logtoken;
		}
	}
	public static function regToken(){
		$_SESSION['regtoken'] = bin2hex(random_bytes(32));
		if (array_key_exists('regtoken', $_SESSION) && !empty($_SESSION['regtoken'])){
				$regtoken = $_SESSION['regtoken'];
				return $regtoken;
		}
	}
	public static function genToken(){
		$_SESSION['gentoken'] = bin2hex(random_bytes(32));
		if (array_key_exists('gentoken', $_SESSION) && !empty($_SESSION['gentoken'])){
				$gentoken = $_SESSION['gentoken'];
				return $gentoken;
		}
	}

	public static function subsToken(){
		$_SESSION['substoken'] = bin2hex(random_bytes(32));
		if (array_key_exists('substoken', $_SESSION) && !empty($_SESSION['substoken'])){
				$substoken = $_SESSION['substoken'];
				return $substoken;
		}
	}
	public static function subsTokenTwo(){
		$_SESSION['substokentwo'] = bin2hex(random_bytes(32));
		if (array_key_exists('substokentwo', $_SESSION) && !empty($_SESSION['substokentwo'])){
				$substokentwo = $_SESSION['substokentwo'];
				return $substokentwo;
		}
	}

}
