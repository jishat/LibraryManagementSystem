<?php
namespace App\Database;
use PDO;

class Database{
	private $dbuser = 'jishatco_jishatco';
	private $dbpass = 'Bk66X6RDdy)5[p';

	public function connection(){
		try {
			$conn = new PDO("mysql:host=localhost;dbname=jishatco_lms", $this->dbuser, $this->dbpass);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		} catch (PDOException $e) {
			echo "Connection Failed:".$e->getMessage();
		}
	}
}
