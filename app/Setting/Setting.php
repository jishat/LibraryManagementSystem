<?php
namespace App\Setting;
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');

use App\Database\Database;
use PDO;


class Setting{
	public $conn;

	public function __construct(){
		$db = new Database();
		$this->conn = $db->connection();
	}
	public function optionName($option){
		$query = "SELECT `option_value` FROM `".PREFIX."settings` WHERE `option_name` = :option_name LIMIT 1";
		$statement = $this->conn->prepare($query); //prepare the sql query
		$statement->bindParam(':option_name', $option);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result['option_value'];
		}else {
			return 'error';
		}
	}
}
