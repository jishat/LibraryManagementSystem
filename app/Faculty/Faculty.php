<?php
namespace App\Faculty;
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Database\Database;
use App\Utility\Message;
use PDO;


class Faculty{
	public $conn;
	public $facultyName;
	public $shortDescription;

	public function __construct(){
		$db = new Database();
		$this->conn = $db->connection();
	}
  public function storeVariable($data){
		$this->facultyName 				= $this->filter($data['facultyName']);
		$this->shortDescription		= $this->filter($data['shortDescription']);
	}
  public function filter($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

  public function generateSlug($data){
		$strReplace = str_replace(" ", "-", $data);
		$slug 	= strtolower($strReplace);

		$searchSlug = "SELECT `slug` FROM `".PREFIX."faculty` WHERE `slug` = :slug";
		$userstmnt  = $this->conn->prepare($searchSlug);
		$userstmnt->bindParam(":slug", $slug);
		$userstmnt->execute();

		$loopSlug = $slug; //assign in new variable for loop

		$x = 0;
		// Loop for generate unique username
		while($userstmnt->rowCount() > 0){
			$slug = $loopSlug;
			$x++;
			$slug = $slug."-".$x;

			$searchSlug = "SELECT `slug` FROM `".PREFIX."faculty` WHERE `slug` = :slug";
			$userstmnt  = $this->conn->prepare($searchSlug);
			$userstmnt->bindParam(":slug", $slug);
			$userstmnt->execute();
		}
		return $slug;
	}

  public function registerFaculty($data){

		$this->storeVariable($data); //Store all data in variable sothat use in any method easily

		$dataValidation = $this->validation($data); //Validation all data
		if(isset($dataValidation)){
			return $dataValidation;
		}else{

			$slug = $this->generateSlug($this->facultyName); // Generate Slug

			$query = "INSERT INTO `".PREFIX."faculty` (`faculty_name`, `slug`, `short_description`) VALUES (:faculty_name, :slug, :short_description);";
			$statement = $this->conn->prepare($query); //prepare the sql query
			$statement->bindParam(':faculty_name', $this->facultyName);
			$statement->bindParam(':slug', $slug);
			$statement->bindParam(':short_description', $this->shortDescription);
			$result = $statement->execute();
			if($result){
				Message::setMessage("successfaculty");
				$msg = "success";
				return $msg;
			}else{
				$msg = "unsuccess";
				return $msg;
			}
		}
	}
	public function validation(){

		//Start: Faculty Name Validation
		if(!isset($this->facultyName ) || $this->facultyName == ""){ //If faculty name is empty
			$msg = "emptyfaculty";
			return $msg;
		}
		if(!preg_match("/^[a-zA-Z ]*$/", $this->facultyName)){ // If user name is not alphabet
			$msg = "facultyName";
			return $msg;
		}
		//End

		//Start: Short Description Validation
		if($this->shortDescription != "" && strlen($this->shortDescription) > 250){ //If faculty name is empty
			$msg = "shortDescription";
			return $msg;
		}
		//End
	}

	public function allFaculty(){
		$query = "SELECT * FROM `".PREFIX."faculty` ORDER BY `id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else {
			return "error";
		}
	}
	public function facultyInfo($data){
		$query = "SELECT * FROM `".PREFIX."faculty` WHERE `slug` = :slug LIMIT 1";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(":slug", $data);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else {
			return "error";
		}
	}
	public function facultyInfoById($data){
		$query = "SELECT * FROM `".PREFIX."faculty` WHERE `id` = :id LIMIT 1";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(":id", $data);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else {
			return "error";
		}
	}

	public function updateFaculty($data){

		// Validation all data
		if( isset($data['facultyId']) && $data['facultyId'] != ''){
			$id = $data['facultyId'];
			$facultyInfoById = $this->facultyInfoById($id);
			if ($facultyInfoById == 'error') {
				$msg = "error";
				return $msg;
			}else{
				$this->storeVariable($data);
				$dataValidation = $this->validation();
				if(isset($dataValidation)){
					return $dataValidation;
				}else{

					// Generate Slug
					if(strtolower(str_replace(' ','',$facultyInfoById['faculty_name'])) != strtolower(str_replace(' ','',$this->facultyName))){
						$slug = $this->generateSlug($this->facultyName);
					}else {
						$slug = trim($facultyInfoById['slug']);
					}

					date_default_timezone_set("Asia/Dhaka"); //set the timezone
					$date = date("Y:m:d H:i:s", time()); //set the time for record register time


					$query = "UPDATE `".PREFIX."faculty` SET `faculty_name` = :faculty_name, `short_description` = :short_description, `slug` = :slug, `update_at` = :update_at  WHERE `id` = :id";

					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':faculty_name', $this->facultyName);
					$statement->bindParam(':short_description', $this->shortDescription);
					$statement->bindParam(':slug', $slug);
					$statement->bindParam(':update_at', $date);
					$statement->bindParam(':id', $id);
					$result = $statement->execute();
					if($result){
						$msg = "success";
						return $msg;
					}else{
						$msg = "unsuccess";
						return $msg;
					}
				}
			}
		}else {
			return "error";
		}
	}

	public function delete($data){
		if( isset($data['facultyinfo']) && $data['facultyinfo'] != ''){
			$id = $data['facultyinfo'];
			$facultyInfoById = $this->facultyInfoById($id);
			if ($facultyInfoById == 'error') {
				$msg = "error";
				return $msg;
			}else{
				$query = "SELECT * FROM `".PREFIX."students` WHERE `faculty` = :faculty LIMIT 1";
				$statement = $this->conn->prepare($query); //prepare the sql query
				$statement->bindParam(':faculty', $id);
				$statement->execute();
				if($statement->rowCount() > 0){
					return "studenthas";
				}else {
					$query = "DELETE FROM `".PREFIX."faculty` WHERE `id` = :id";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':id', $id);
					$result = $statement->execute();
					if($result){						
						if(trim($data['cameFrom']) == "show"){
							Message::setMessage('deletefaculty');
						}
						$msg = "success";
						return $msg;
					}else{
						$msg = "unsuccess";
						return $msg;
					}
				}
			}
		}else {
			return "error";
		}
	}

}
