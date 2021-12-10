<?php
namespace App\User;
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Database\Database;
use App\Login\Login;
use App\Utility\Message;
use App\Utility\Adminpages;
use App\Userrole\Userrole;
use PDO;
 // import the Intervention Image Manager Class
use Intervention\Image\ImageManager;


class User{
	protected $conn;
	protected $userName;
	protected $loginUserName;
	protected $userRole;
	protected $userGender;
	protected $userMobile;
	protected $userEmail;
	protected $userPassword;
	protected $userAddress;

	public function __construct(){
		$db = new Database();
		$this->conn = $db->connection();
	}

	public function storeVariable($data){
		$this->userName 			= $this->filter($data['userName']);
		$this->userRole 			= $this->filter(!isset($data['userRole']) ? '' : $data['userRole']);
		$this->userGender 		= $this->filter(!isset($data['userGender']) ? '' : $data['userGender']);
		$this->userEmail 			= $this->filter($data['userEmail']);
		$this->loginUserName	= $this->filter(strtolower($data['loginUserName']));
		$this->userMobile 		= $this->filter($data['userMobile']);
		$this->userPassword		= $this->filter($data['userPassword']);
		$this->userAddress		= $this->filter($data['userAddress']);
	}
	public function registerUser($data, $files){

		// asign all the data in a variable with validation & validation did in another method
		$this->storeVariable($data);

		// Validation all data
		$dataValidation = $this->dataValidation("register");
		if(isset($dataValidation)){
			return $dataValidation;
		}else{
			if(!empty($files['userPicture']['name'])){
				// Get the picture info if insert
				$userPicture 		= $files['userPicture']['name'];
				$pictureTmp			= $files['userPicture']['tmp_name'];
				$pictureSize 		= $files['userPicture']['size'];
				$pictureType 		= $files['userPicture']['type'];
				if($pictureType === 'image/jpeg' || $pictureType === 'image/png' || $pictureType === 'image/jpg'){
					$pictureExtension 	= pathinfo($userPicture, PATHINFO_EXTENSION); //get the extension of a picture name
					$userPicture 	= uniqid().strtotime("now").".".$pictureExtension; //set the picture name by create unique random name

					$pictureDestination = UPLOADUSER.$userPicture; //set the picture destination folder for store picture
					move_uploaded_file($pictureTmp, $pictureDestination); //Move the picture from tmp folder into destination folder which set previous line.

					// create an image manager instance with favored gd library
					$manager = new ImageManager(array('driver' => 'gd'));

					// to finally create image instances
					$image = $manager->make($pictureDestination)->fit(300, 300, function ($constraint) {
					                    $constraint->upsize();
					                  });

					$image->save($pictureDestination);
				}else{
					$msg = "adminimg";
					return $msg;
					exit();
				}
			}

			$slug = $this->generateSlug($this->userName); // Generate Slug

			$status = 1; //Declar 1 by default in `status` row in table

			$this->userPassword = password_hash($this->userPassword, PASSWORD_DEFAULT);

			$query = "INSERT INTO `".PREFIX."users` (`name`, `username`, `slug`, `picture`, `email`, `password`, `user_role`, `gender`, `mobile`, `address`, `status`) VALUES (:name, :username, :slug, :picture, :email, :password, :user_role, :gender, :mobile, :address, :status);";
			$statement = $this->conn->prepare($query); //prepare the sql query
			$statement->bindParam(':name', $this->userName);
			$statement->bindParam(':username', $this->loginUserName);
			$statement->bindParam(':slug', $slug);
			$statement->bindParam(':picture', $userPicture);
			$statement->bindParam(':email', $this->userEmail);
			$statement->bindParam(':password', $this->userPassword);
			$statement->bindParam(':user_role', $this->userRole);
			$statement->bindParam(':gender', $this->userGender);
			$statement->bindParam(':mobile', $this->userMobile);
			$statement->bindParam(':address', $this->userAddress);
			$statement->bindParam(':status', $status);
			// $statement->bindParam(':create_at', $date);
			$result = $statement->execute();
			if($result){
				Message::setMessage("success");
				$msg = "success";
				return $msg;
			}else{
				$msg = "error";
				return $msg;
			}
				if(!empty($files['userPicture']['name'])){
					// Get the picture info if insert
					$userPicture 		= $files['userPicture']['name'];
					$pictureTmp			= $files['userPicture']['tmp_name'];
					$pictureSize 		= $files['userPicture']['size'];
					$pictureType 		= $files['userPicture']['type'];
					if($pictureType === 'image/jpeg' || $pictureType === 'image/png' || $pictureType === 'image/jpg'){
						$pictureExtension 	= pathinfo($userPicture, PATHINFO_EXTENSION); //get the extension of a picture name
						$userPicture 	= uniqid().strtotime("now").".".$pictureExtension; //set the picture name by create unique random name

						$pictureDestination = UPLOADUSER.$userPicture; //set the picture destination folder for store picture
						move_uploaded_file($pictureTmp, $pictureDestination); //Move the picture from tmp folder into destination folder which set previous line.

						// create an image manager instance with favored gd library
						$manager = new ImageManager(array('driver' => 'gd'));

						// to finally create image instances
						$image = $manager->make($pictureDestination)->fit(300, 300, function ($constraint) {
						                    $constraint->upsize();
						                  });

						$image->save($pictureDestination);
					}else{
						$msg = "adminimg";
						return $msg;
						exit();
					}
				}

				$slug = $this->generateSlug($this->userName); // Generate Slug

				$status = 1; //Declar 1 by default in `status` row in table

				$this->userPassword = password_hash($this->userPassword, PASSWORD_DEFAULT);

				$query = "INSERT INTO `".PREFIX."users` (`name`, `picture`, `email`, `password`, `user_role`, `gender`, `mobile`, `address`, `status`, `slug`) VALUES (:name, :picture, :email, :password, :user_role, :gender, :mobile, :address, :status, :slug);";
				$statement = $this->conn->prepare($query); //prepare the sql query
				$statement->bindParam(':name', $this->userName);
				$statement->bindParam(':picture', $userPicture);
				$statement->bindParam(':email', $this->userEmail);
				$statement->bindParam(':password', $this->userPassword);
				$statement->bindParam(':user_role', $this->userRole);
				$statement->bindParam(':gender', $this->userGender);
				$statement->bindParam(':mobile', $this->userMobile);
				$statement->bindParam(':address', $this->userAddress);
				$statement->bindParam(':status', $status);
				$statement->bindParam(':slug', $slug);
				// $statement->bindParam(':create_at', $date);
				$result = $statement->execute();
				if($result){
					Message::setMessage("success");
					$msg = "success";
					return $msg;
				}else{
					$msg = "error";
					return $msg;
				}
		}
	}
	public function filter($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	public function dataValidation($method){
		// Validation User name
		if($this->userName == ""){
			$msg = "emptyusername";
			return $msg;
		}
		// If user name is not alphabet
		if(!preg_match("/^[a-zA-Z ]*$/", $this->userName) || strlen($this->userName) > 60){
			$msg = "userName";
			return $msg;
		}
		// End

		// Validation Login Username
		if($this->loginUserName == ""){
			$msg = "emptyloginUserName";
			return $msg;
		}
		// If user name is not alphabet or numeric
		if(!preg_match("/^[a-zA-Z0-9 _\-\.]+$/", $this->loginUserName) || strlen($this->loginUserName) > 60){
			$msg = "loginUserName";
			return $msg;
		}
		if (preg_match("/\\s/", $this->loginUserName)) {
			$msg = "loginUserNameSpace";
		 	return $msg;
		}
		if($method == "register"){
			$loginUserName = $this->searchLoginUserName($this->loginUserName);
			if($loginUserName == true){
				$msg = "loginUserNameAlready";
				return $msg;
			}
		}
		// End

		// Validation User Role
		if ($method != "admin"){ // If data come not from admin update
			// If user role is not Alphabet
			if($this->userRole == ""){
				$msg = "emptyuserrole";
				return $msg;
			}
			$Userrole = new Userrole();
			$allUserRole = $Userrole->allUserRole();;
		  $allUserId = array();
		  foreach ($allUserRole as $UserRole) {
		    array_push($allUserId, $UserRole['id']);
		  }
	    if(!in_array($this->userRole, $allUserId)){
	      return  "userRole";
	    }
		}
		//End

		// Validation User Gender
		if($this->userGender == ""){
			$msg = "emptyusergender";
			return $msg;
		}
		if(!preg_match("/^[123]$/", $this->userGender)){
			$msg = "usergender";
			return $msg;
		}
		//End

		// Validation Mobile Number
		if(isset($this->userMobile) && $this->userMobile !== ""){
			if(!preg_match("/^(?:\+?88)?01[15-9]\d{8}$/", $this->userMobile)){
			  return "usermobile";
			}
		}
		//End

		// Validation Email
		if(isset($this->userEmail) && $this->userEmail != ''){
			if(filter_var($this->userEmail, FILTER_VALIDATE_EMAIL) === false){
				$msg = "userEmail";
				return $msg;
			}
			// If Email address already exists
			if($method == "register"){
				$searchEmail = $this->searchEmail($this->userEmail);
				if($searchEmail == true){
					$msg = "useremailalready";
					return $msg;
				}
			}
		}
		//End

		// Validation Password
		if($this->userPassword == ""){
			$msg = "emptyuserpass";
			return $msg;
		}

		if(strlen($this->userPassword) > 60 || strlen($this->userPassword) < 8){
			$msg = "userPassword";
			return $msg;
		}
		//End

		// Validation Address
		if(isset($this->userAddress) && $this->userAddress !== ""){
			if(strlen($this->userAddress) > 60){
				$msg = "userAddress";
				return $msg;
			}
		}
		//End
	}
	public function generateSlug($data){
		$strReplace = str_replace(" ", "-", $data);
		$userName 	= strtolower($strReplace);


		$searchUser = "SELECT `slug` FROM `".PREFIX."users` WHERE `slug` = :slug";
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

			$searchUser = "SELECT `slug` FROM `".PREFIX."users` WHERE `slug` = :slug";
			$userstmnt  = $this->conn->prepare($searchUser);
			$userstmnt->bindParam(":slug", $userName);
			$userstmnt->execute();
		}
		return $userName;
	}
	public function searchEmail($data){ //Helper function for search email from database
		$query = "SELECT `email` FROM `".PREFIX."users` WHERE `email` = :email";
		$stmnt  = $this->conn->prepare($query);
		$stmnt->bindParam(':email',$data);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);

		if($result){
			return true;
		}else{
			return false;
		}
	}
	public function searchPassword(){ //Helper function for search password from database for login
		$query = "SELECT `password` FROM `admin` WHERE `password` = :password AND `email` = :email";
		$stmnt  = $this->conn->prepare($query);
		$stmnt->bindParam(':password', md5($this->userPassword));
		$stmnt->bindParam(':email', $this->userEmail);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);

		if($result){
			return true;
		}else{
			return false;
		}
	}
	public function searchLoginUserName($data){ //Helper function for search email from database
		$query = "SELECT `username` FROM `".PREFIX."users` WHERE `username` = :username LIMIT 1";
		$stmnt  = $this->conn->prepare($query);
		$stmnt->bindParam(':username',$data);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	public function allUser(){
		$query = "SELECT `users`.*, `userrole`.`name` as `userrolename`
							FROM `".PREFIX."users` as `users`
							LEFT JOIN `".PREFIX."user_roles` as `userrole`
							ON `users`.`user_role` = `userrole`.`id` ORDER BY `id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return "error";
		}

	}
	public function singleData($id){
		$query = "SELECT * FROM `".PREFIX."users` WHERE `id` = :id";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(':id', $id);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return "error";
		}
	}
	public function singleUserInfo($data){
		$query = "SELECT `users`.*, `userrole`.`name` as `userrolename`
							FROM `".PREFIX."users` as `users`
							LEFT JOIN `".PREFIX."user_roles` as `userrole`
							ON `users`.`user_role` = `userrole`.`id` WHERE `users`.`slug` = :slug LIMIT 1";
		// $query = "SELECT * FROM `".PREFIX."admin` WHERE `slug` = :slug LIMIT 1";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(':slug', $data);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			$msg = "error";
			return $msg;
		}
	}
	public function updateUserInfo($data, $files){
		if( isset($data['adminInfoid']) && $data['adminInfoid'] != ''){
			$userId = $data['adminInfoid'];
			$singleData = $this->singleData($userId);
			if($singleData == "error"){
				return "error";
			}else {
				$this->storeVariable($data); // asign all the data in a variable with validation & validation did in another method
				$method = "update";
				if($userId == 1){
					$method = "admin";
					$this->userRole = "1";
				}
				if($userId == Login::loginGet('userid')){
					$method = "admin";
					$this->userRole = Login::loginGet('userrole');
				}

				$dataValidation = $this->dataValidation($method); // Validation all data
				if(isset($dataValidation)){
					return $dataValidation;
				}else{
					// check email address if input new
					if($this->userEmail != '' && $singleData['email'] != $this->userEmail){
						// If Email address already exists
						$searchEmail = $this->searchEmail($this->userEmail);
						if($searchEmail == true){
							$msg = "useremailalready";
							return $msg;
						}
					}

					if($singleData['username'] != $this->loginUserName){
						$loginUserName = $this->searchLoginUserName($this->loginUserName);
						if($loginUserName == true){
							$msg = "loginUserNameAlready";
							return $msg;
						}
					}

					// restore password again in a variable
					$getPassword = $this->userPassword;

					// check Password if input new
					if($singleData['password'] != $getPassword){
						$getPassword = password_hash($getPassword, PASSWORD_DEFAULT);
					}
					$userPicture 	= $singleData['picture'];// Get the picture name which already stored in database
					if(trim($data['dataImgDelete']) == "1"){
						$userPicture = "";
					}else{
						if(!empty($files['userPicture']['name']) && $files['userPicture']['size'] > 0){

							// Get the new picture info
							$pictureTmp			= $files['userPicture']['tmp_name'];
							$pictureSize 		= $files['userPicture']['size'];
							$pictureType 		= $files['userPicture']['type'];

							if($pictureType === 'image/jpeg' || $pictureType === 'image/png' || $pictureType === 'image/jpg'){
								if(isset($userPicture) && $userPicture != ""){
									unlink(UPLOADUSER.$userPicture); // Delete previous image
								}
								$userPicture = $files['userPicture']['name']; //Restore new image name in variable
								$pictureExtension 	= pathinfo($userPicture, PATHINFO_EXTENSION); //get the extension of a picture name
								$userPicture 	= uniqid().strtotime("now").".".$pictureExtension; //set the picture name by create unique random name

								$pictureDestination = UPLOADUSER.$userPicture; //set the picture destination folder for store picture
								move_uploaded_file($pictureTmp, $pictureDestination); //Move the picture from tmp folder into destination folder which set previous line.

								// create an image manager instance with favored gd library
								$manager = new ImageManager(array('driver' => 'gd'));

								// to finally create image instances
								$image = $manager->make($pictureDestination)->fit(300, 300, function ($constraint) {
								                    $constraint->upsize();
								                  });

								$image->save($pictureDestination);
							}else{
								$msg = "adminimg";
								return $msg;
							}
						}
					}

					// Generate Slug
					if(strtolower(str_replace(' ','',$singleData['name'])) != strtolower(str_replace(' ','',$this->userName))){
						$slug = $this->generateSlug($this->userName);
					}else {
						$slug = trim($singleData['slug']);
					}


					date_default_timezone_set("Asia/Dhaka"); //set the timezone
					$date = date("Y:m:d H:i:s", time()); //set the time for record register time

					$query = "UPDATE `".PREFIX."users` SET `name` = :name, `username` = :username, `slug` = :slug, `picture` = :picture, `email` = :email, `password` = :password, `user_role` = :user_role, `gender` = :gender, `mobile` = :mobile, `address` = :address, `update_at` = :update_at WHERE `id` = :id";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':id', $userId);
					$statement->bindParam(':name', $this->userName);
					$statement->bindParam(':username', $this->loginUserName);
					$statement->bindParam(':slug', $slug);
					$statement->bindParam(':picture', $userPicture);
					$statement->bindParam(':email', $this->userEmail);
					$statement->bindParam(':password', $getPassword);
					$statement->bindParam(':user_role', $this->userRole);
					$statement->bindParam(':gender', $this->userGender);
					$statement->bindParam(':mobile', $this->userMobile);
					$statement->bindParam(':address', $this->userAddress);
					$statement->bindParam(':update_at', $date);
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
	public function status($data){

		if( isset($data['id']) && $data['id'] != '' && isset($data['status']) && $data['status'] != '' ){
			$id 		= $data['id'];
			$status = $data['status'];
			$singleData = $this->singleData($id);
			if ($singleData == 'error') {
				$msg = "error";
				return $msg;
			}else{
				if($status == $singleData['status']){
					if($status == 0){
						$input_status = 1 ;
					}else {
						$input_status = 0 ;
					}
					$query 	= "UPDATE `".PREFIX."users` SET `status` = :status WHERE `id` = :id AND `user_role` != 'ADMIN'";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':status', $input_status);
					$statement->bindParam(':id', $id);
					$result = $statement->execute();
					if($result){
						$msg = "success";
						return $msg;
					}else{
						$msg = "unsuccessfully";
						return $msg;
					}
				}else {
					return "error";
				}

			}

		}else{
			$msg = "error";
			return $msg;
		}

	}
	public function delete($data){
		if( isset($data['admninfo']) && $data['admninfo'] != ''){
			$id = $data['admninfo'];

			$singleData = $this->singleData($id);
			if ($singleData == 'error') {
				$msg = "error";
				return $msg;
			}else{
				$query = "DELETE FROM `".PREFIX."users` WHERE `id` = :id AND `user_role` != 'ADMIN'";
				$statement = $this->conn->prepare($query); //prepare the sql query
				$statement->bindParam(':id', $id);
				$result = $statement->execute();
				if($result){
					if(isset($singleData['picture']) && $singleData['picture'] != ""){
						unlink(UPLOADUSER.$singleData['picture']); // Delete previous image
					}
					if($data['cameFrom']=="show"){
						Message::setMessage('userdelete');
					}
					$msg = "success";
					return $msg;
				}else{
					$msg = "unsuccess";
					return $msg;
				}
			}
		}else {
			return "error";
		}
	}
	public function userLogin($data){
		$this->loginUserName 	= $this->filter(strtolower($data['userName']));
		$this->userPassword		= $data['userPassword'];

		if($this->loginUserName == "" || $this->userPassword == ""){
			$msg = "empty";
			return $msg;
		}else{
			$checkUsername = $this->searchLoginUserName($this->loginUserName);
			if($checkUsername == false){
				$msg = "invalid";
				return $msg;
			}else{
				$query = "SELECT * FROM `".PREFIX."users` WHERE `username` = :username LIMIT 1";
				$stmnt = $this->conn->prepare($query);
				$stmnt->bindParam(':username', $this->loginUserName);
				$stmnt->execute();
				$result = $stmnt->fetch(PDO::FETCH_ASSOC);
				if($result){
					$getUserPass = $result['password'];

					if(password_verify($this->userPassword, $getUserPass)){
						Login::loginSet('userlogin', true);
						Login::loginSet('userid', $result['id']);
						Login::loginSet('userslug', $result['slug']);
						Login::loginSet('userrole', $result['user_role']);
						Message::setMessage('successfully');
						$msg = "success";
						return $msg;
					}else{
						$msg = "invalid";
						return $msg;
					}
				}else{
					$msg = "error";
					return $msg;
				}
			}
		}
	}
	public function userData($id){
		$query = "SELECT * FROM `".PREFIX."users` WHERE `id` = :id";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(':id', $id);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return "something went wromg";
		}
	}

}
