<?php
namespace App\Utility;
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');

use App\Database\Database;
use PDO;

class Adminpages{
  public $conn;
	public function __construct(){
		$db = new Database();
		$this->conn = $db->connection();
	}
	public function allPages(){
		$query = "SELECT * FROM  `".PREFIX."admin_pages`";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($result){
      return $result;
    }else {
      return 'error';
    }
	}
  public function singlePage($id){
		$query = "SELECT * FROM  `".PREFIX."admin_pages` WHERE `id`= :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
      return $result;
    }else {
      return 'error';
    }
	}
  public function allPagesID(){
    $query = "SELECT `id` FROM  `".PREFIX."admin_pages`";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($result){
      return $result;
    }else {
      return 'error';
    }
  }
}
