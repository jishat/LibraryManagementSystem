<?php
namespace App\Brand;
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Database\Database;
use PDO;

class Brand{
	public $conn;

	public function __construct(){
		$db = new Database();
		$this->conn = $db->connection();
	}

	public function updateLogo($files){

		// Get the picture info if insert
		$logoName 		= $files['brandLogo']['name'];
		$pictureTmp		= $files['brandLogo']['tmp_name'];
		$pictureSize 	= $files['brandLogo']['size'];

		if(empty($pictureSize)){
			$msg = "emptyfile";
			return $msg;
		}


		$pictureExtension 	= pathinfo($logoName, PATHINFO_EXTENSION); //get the extension of a picture name
		$logoName 	= uniqid().".".$pictureExtension; //set the picture name by create unique random name

		$pictureDestination = UPLOADUTILITY.$logoName; //set the picture destination folder for store picture
		move_uploaded_file($pictureTmp, $pictureDestination); //Move the picture from tmp folder into destination folder which set previous line.

		$id = 1;
		$this->deletePrevImg($id);
		$query = "UPDATE `brand` SET `logo` = :logo WHERE `brand`.`id` = :id";
		$statement = $this->conn->prepare($query); //prepare the sql query
		$statement->bindParam(':logo', $logoName);
		$statement->bindParam(':id', $id);
		$result = $statement->execute();

		if($result){
			$msg = "logosuccessfully";
			return $msg;
		}else{
			$msg = "logounsuccessfully";
			return $msg;
		}
	}
	public function deletePrevImg($id){
		$imgQuery = "SELECT * FROM `brand` WHERE `id` = :id";
		$imgStmnt  = $this->conn->prepare($imgQuery);
		$imgStmnt->bindparam(":id", $id);
		$imgStmnt->execute();
		$deleteImg = $imgStmnt->fetch(PDO::FETCH_OBJ);
		unlink(UPLOADUTILITY.$deleteImg->logo);
	}

	public function updateBrandName($data){
		$brandName = $data['brandName'];

		if($brandName == ''){
			$msg = "brandnameempty";
			return $msg;
		}

		$id = 1;
		$query = "UPDATE `brand` SET `brand_name` = :brand_name WHERE `brand`.`id` = :id";
		$statement = $this->conn->prepare($query); //prepare the sql query
		$statement->bindParam(':brand_name', $brandName);
		$statement->bindParam(':id', $id);
		$result = $statement->execute();

		if($result){
			$msg = "brandnamesuccessfully";
			return $msg;
		}else{
			$msg = "unsuccessfully";
			return $msg;
		}
	}
	public function showBrand(){
		$id = 1;
		$query = "SELECT * FROM `brand` WHERE `brand`.`id` = :id";
		$statement = $this->conn->prepare($query); //prepare the sql query
		$statement->bindParam(':id', $id);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);

		if($result){
			return $result;
		}else{
			$msg = "unsuccessfully";
			return $msg;
		}
	}

}
