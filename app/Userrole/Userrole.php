<?php
namespace App\Userrole;
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Database\Database;
use App\Utility\Message;
use App\Utility\Adminpages;
use PDO;


class Userrole{
	public $conn;
	public $userRoleName;
	public $permissionPages;
	public $shortDescription;

	public function __construct(){
		$db = new Database();
		$this->conn = $db->connection();
	}
  public function storeVariable($data){
		$this->userRoleName 			= $this->filter($data['userRoleName']);
		$this->permissionPages 		= isset($data['permissionPages']) ? $data['permissionPages'] : "";
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
		$userName 	= strtolower($strReplace);

		$searchUser = "SELECT `slug` FROM `".PREFIX."user_roles` WHERE `slug` = :slug";
		$userstmnt  = $this->conn->prepare($searchUser);
		$userstmnt->bindParam(":slug", $userName);
		$userstmnt->execute();

		$loopUserName = $userName; //assign in new variable for loop

		$x = 0;
		// Loop for generate unique username
		while($userstmnt->rowCount() > 0){
			$userName = $loopUserName;
			$x++;
			$userName = $userName."-".$x;

			$searchUser = "SELECT `slug` FROM `".PREFIX."user_roles` WHERE `slug` = :slug";
			$userstmnt  = $this->conn->prepare($searchUser);
			$userstmnt->bindParam(":slug", $userName);
			$userstmnt->execute();
		}
		return $userName;
	}
  public function registerUserRole($data){

		$this->storeVariable($data); //Store all the data in variable
		$dataValidation = $this->validation($data); // Validation all data
		if(isset($dataValidation)){
			return $dataValidation;
		}else{
			$admin_pages_id="";
			foreach($this->permissionPages as $permissionPage){
				$admin_pages_id .= ",".$permissionPage;
			}
			$slug = $this->generateSlug($this->userRoleName); // Generate Slug

			$query = "INSERT INTO `".PREFIX."user_roles` (`name`, `slug`, `short_description`, `admin_pages_id`) VALUES (:name, :slug, :short_description, :admin_pages_id);";
			$statement = $this->conn->prepare($query); //prepare the sql query
			$statement->bindParam(':name', $this->userRoleName);
			$statement->bindParam(':slug', $slug);
			$statement->bindParam(':short_description', $this->shortDescription);
			$statement->bindParam(':admin_pages_id', $admin_pages_id);
			$result = $statement->execute();
			if($result){
				Message::setMessage("successuserrole");
				$msg = "success";
				return $msg;
			}else{
				$msg = "unsuccess";
				return $msg;
			}
		}
	}
	public function validation(){
		//Start: User Role Name Validation
		if(!isset($this->userRoleName) || $this->userRoleName == ""){
			$msg = "emptyuserrole";
			return $msg;
		}

		if(!preg_match("/^[a-zA-Z ]*$/", $this->userRoleName)){ // If user name is not alphabet
			$msg = "userRoleName";
			return $msg;
		}

		$strReplace = str_replace(" ", "-", $this->userRoleName);
		$strng 	= strtolower($strReplace);
		if(trim(strtolower($this->userRoleName)) == "super admin" || $strng == "super-admin" || trim(strtolower($this->userRoleName)) == "super-admin" || trim(strtolower($this->userRoleName)) == "superadmin"){ // If user role name is super admin
			$msg = "userRoleNameAdmin";
			return $msg;
		}
		// End

		// If user role is not Valid
		if (isset($this->permissionPages) && $this->permissionPages != "" ) {
			$Adminpages = new Adminpages();
		  $allPages = $Adminpages->allPages();
		  $allPageId = array();
		  foreach ($allPages as $allPage) {
		    array_push($allPageId, $allPage['id']);
		  }
		  foreach ($this->permissionPages as $permissionPage) {
		    if(!in_array($permissionPage, $allPageId)){
		      return  "permissionPage";
		    }
		  }
		}else{
			$msg = "emptyPagePermission";
			return $msg;
		}

		//Start: Short Description Validation
		if($this->shortDescription != "" && strlen($this->shortDescription) > 250){ //If faculty name is empty
			$msg = "shortDescription";
			return $msg;
		}
		//End
	}
	public function allUserRole(){
		$slug = "super-admin";
		$query = "SELECT * FROM `".PREFIX."user_roles` WHERE `id` != 1 OR `slug` != :slug ORDER BY `id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(':slug', $slug);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else {
			return "error";
		}
	}
	public function userRoleInfo($data){
		$query = "SELECT * FROM `".PREFIX."user_roles` WHERE `slug` = :slug LIMIT 1";
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
	public function userRoleInfoById($data){
		$query = "SELECT * FROM `".PREFIX."user_roles` WHERE `id` = :id LIMIT 1";
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
	public function updateUserRole($data){

		if( isset($data['userRoleId']) && $data['userRoleId'] != ''){

			$userRoleInfoById = $this->userRoleInfoById($data['userRoleId']);
			if ($userRoleInfoById == 'error') {
				$msg = "error";
				return $msg;
			}else{
				$this->storeVariable($data);
				$dataValidation = $this->validation();
				if(isset($dataValidation)){
					return $dataValidation;
				}else{

					$admin_pages_id="";
					$usr_role_id = $data['userRoleId'];
					foreach($this->permissionPages as $permissionPage){
						$admin_pages_id .= ",".$permissionPage;
					}
					if(strtolower(str_replace(' ','',$this->userRoleName)) != strtolower(str_replace(' ','',$userRoleInfoById['name']))){
						$slug = $this->generateSlug($this->userRoleName);
					}else {
						$slug = trim($userRoleInfoById['slug']);
					}


					date_default_timezone_set("Asia/Dhaka"); //set the timezone
					$date = date("Y:m:d H:i:s", time()); //set the time for record register time

					$query = "UPDATE `".PREFIX."user_roles` SET `name` = :name, `slug` = :slug, `short_description` = :short_description, `admin_pages_id` = :admin_pages_id, `update_at` = :update_at  WHERE `id` = :id";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':name', $this->userRoleName);
					$statement->bindParam(':slug', $slug);
					$statement->bindParam(':short_description', $this->shortDescription);
					$statement->bindParam(':admin_pages_id', $admin_pages_id);
					$statement->bindParam(':update_at', $date);
					$statement->bindParam(':id', $usr_role_id);
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
		if( isset($data['usrlinfo']) && $data['usrlinfo'] != ''){
			$id = $data['usrlinfo'];

			$userRoleInfoById = $this->userRoleInfoById($id);
			if ($userRoleInfoById == 'error') {
				$msg = "error";
				return $msg;
			}else{
				$query = "SELECT * FROM `".PREFIX."users` WHERE `user_role` = :user_role LIMIT 1";
				$statement = $this->conn->prepare($query); //prepare the sql query
				$statement->bindParam(':user_role', $id);
				$statement->execute();
				if($statement->rowCount() > 0){
					return "adminhas";
				}else {
					$query = "DELETE FROM `".PREFIX."user_roles` WHERE `id` = :id";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':id', $id);
					$result = $statement->execute();
					if($result){
						if(trim($data['cameFrom']) == "show"){
							Message::setMessage('deleteuserrole');
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
