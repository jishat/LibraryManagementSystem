<?php
namespace App\Book;

include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');

use App\Database\Database;
use App\Utility\Message;
use App\Category\Category;
use App\Student\Student;
use App\Login\Login;
use PDO;
 // import the Intervention Image Manager Class
use Intervention\Image\ImageManager;

class Book{
	protected $conn;
	protected $name;
	protected $writer;
	protected $category;
	protected $stock;
	protected $shelf;
	protected $description;

	public function __construct(){
		$db = new Database();
		$this->conn = $db->connection();
	}

	public function storeVariable($data){
		$this->name 				= $this->filter($data['name']);
		$this->writer 			= $this->filter($data['writer']);
		$this->category 		= isset($data['category']) ? $data['category'] : "";
		$this->stock 				= $this->filter($data['stock']);
		$this->shelf 				= $this->filter($data['shelf']);
		$this->description 	= $data['description'];
	}

	public function newBook($data, $files){

		// asign all the data in a variable with validation & validation did in another method
		$this->storeVariable($data);

		// Validation all data
		$dataValidation = $this->validation();
		if(isset($dataValidation)){
			return $dataValidation;
		}else{
			if(!empty($files['picture']['name'])){
				// Get the picture info if insert
				$bookImage 		= $files['picture']['name'];
				$pictureTmp		= $files['picture']['tmp_name'];
				$pictureSize 	= $files['picture']['size'];
				$pictureType 	= $files['picture']['type'];

				if($pictureType === 'image/jpeg' || $pictureType === 'image/png' || $pictureType === 'image/jpg'){
					$pictureExtension 	= pathinfo($bookImage, PATHINFO_EXTENSION); //get the extension of a picture name
					$bookImage 					= uniqid().".".$pictureExtension; //set the picture name by create unique random name

					$pictureDestination = UPLOADBOOK.$bookImage; //set the picture destination folder for store picture
					move_uploaded_file($pictureTmp, $pictureDestination); //Move the picture from tmp folder into destination folder which set previous line.

					// create an image manager instance with favored gd library
					$manager = new ImageManager(array('driver' => 'gd'));

					// to finally create image instances
					$image = $manager->make($pictureDestination)->fit(750, 900, function ($constraint) {
					                    $constraint->upsize();
					                  });

					$image->save($pictureDestination);
				}else{
					return "bookImg";
					exit();
				}
			}else {
				$bookImage = "";
			}

			$bookId = $this->generatebookId(); // Generate Book Id

			$category_id ="";
			foreach($this->category as $eachcategory){
				$category_id .= ",".$eachcategory;
			}

			$slug = $this->generateSlug($this->name); // Generate Slug

			$status = 1; //Declar 1 by default in `status` row in table
			$borrow = 0; //Declar 0 by default in `total_borrowed` row in table

			$query = "INSERT INTO `".PREFIX."books` (`book_name`, `slug`, `writer`, `book_id`, `picture`, `category`, `total_stock`, `description`, `book_shelf`, `total_borrowed`, `status`) VALUES (:book_name, :slug, :writer, :book_id, :picture, :category, :total_stock, :description, :book_shelf, :total_borrowed, :status)";
			$statement = $this->conn->prepare($query); //prepare the sql query
			$statement->bindParam(':book_name', $this->name);
			$statement->bindParam(':slug', $slug);
			$statement->bindParam(':writer', $this->writer);
			$statement->bindParam(':book_id', $bookId);
			$statement->bindParam(':picture', $bookImage);
			$statement->bindParam(':category', $category_id);
			$statement->bindParam(':total_stock', $this->stock);
			$statement->bindParam(':description', $this->description);
			$statement->bindParam(':book_shelf', $this->shelf);
			$statement->bindParam(':total_borrowed', $borrow);
			$statement->bindParam(':status', $status);
			$result = $statement->execute();

			if($result){
				Message::setMessage("successbook");
				$msg = "success";
				return $msg;
			}else{
				$msg = "unsuccess";
				return $msg;
			}
		}
	}

	public function validation(){

		// name validation
		if($this->name == ""){
			$msg = "emptybookname";
			return $msg;
		}
		if(strlen($this->name) > 255){ // If writer name is not alphabet
			$msg = "bookName";
			return $msg;
		}
		//End

		//----------------------------------------------------
		// writer validation
		if(isset($this->writer) && $this->writer != ""){

			if(strlen($this->writer) > 255){ // If writer name is not alphabet
				$msg = "writerName";
				return $msg;
			}
		}
		//End
		//----------------------------------------------------

		//----------------------------------------------------
		// category validation
		if (isset($this->category) && $this->category != "" ) { //check isset category input data
			$Category = new Category(); //create object from Category Class
			$allCategory = $Category->allCategory();
			$allCategoryId = array();

			if(isset($allCategory) && $allCategory != "" && $allCategory != "error"){ //check isset category in category table
				foreach ($allCategory as $eachCategory) {
					array_push($allCategoryId, $eachCategory['id']);
				}
				foreach ($this->category as $eachCat) {
					if(!in_array($eachCat, $allCategoryId)){
						return  "invalidcat";
					}
				}
			}else {
				return "categorynotfound";
			}
		}else{
			$msg = "emptyCat";
			return $msg;
		}
		//End
		//----------------------------------------------------

		//----------------------------------------------------
		// Stock validation
		if($this->stock == ""){ //if stock is empty
			$msg = "emptystock";
			return $msg;
		}

		if(!preg_match("/^[0-9]{0,19}$/", $this->stock)){ // is stock numeric
			$msg = "stock";
			return $msg;
		}
		//End
		//----------------------------------------------------

		//----------------------------------------------------
		// shelf validation
		if(isset($this->shelf)){
			if(strlen($this->shelf) > 10){ // is shelf numeric
				$msg = "shelf";
				return $msg;
			}
		}
		//End
		//----------------------------------------------------

		//----------------------------------------------------
		// shelf validation
		if(strlen($this->description) > 5000){ // description length should be less that 500 charecter
			$msg = "description";
			return $msg;
		}
		//End

	}

	public function generatebookId(){
		$digits = 6;
		$randomInt = '#'.mt_rand(pow(10, $digits-1), pow(10, $digits)-1);;

		$searchBookId = "SELECT `book_id` FROM `".PREFIX."books` WHERE `book_id` = :book_id";
		$stmnt  = $this->conn->prepare($searchBookId);
		$stmnt->bindParam(":book_id", $randomInt);
		$stmnt->execute();

		$loopBookId = $randomInt; //assign in new variable for loop

		$x = 0;
		// Loop for generate unique random key
		while($stmnt->rowCount() > 0){
			$randomInt = $loopBookId;
			$x++;
			$randomInt = $randomInt.$x;

			$searchBookId = "SELECT `book_id` FROM `".PREFIX."books` WHERE `book_id` = :book_id";
			$stmnt  = $this->conn->prepare($searchBookId);
			$stmnt->bindParam(":book_id", $randomInt);
			$stmnt->execute();
		}
		return $randomInt;
	}

	public function generateSlug($data){
		$strReplace = str_replace(" ", "-", $data);
		$userName 	= strtolower($strReplace);

		$searchUser = "SELECT `slug` FROM `".PREFIX."books` WHERE `slug` = :slug";
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

			$searchUser = "SELECT `slug` FROM `".PREFIX."books` WHERE `slug` = :slug";
			$userstmnt  = $this->conn->prepare($searchUser);
			$userstmnt->bindParam(":slug", $userName);
			$userstmnt->execute();
		}
		return $userName;
	}

	public function filter($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	public function allBooks(){
		$query = "SELECT * FROM `".PREFIX."books` ORDER BY `id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return "error";
		}
	}
	public function allBooksUser(){
		$status = 1;
		$query = "SELECT * FROM `".PREFIX."books` WHERE `status`=:status  ORDER BY `id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(":status", $status);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return "error";
		}
	}

	public function categoryBooks($category){
		$isDisable = "no";
		$query = "SELECT * FROM `books` WHERE `category` = :category AND `is_disable` = :is_disable ORDER BY `id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(":category", $category);
		$stmnt->bindParam(":is_disable", $isDisable);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			$msg = "unsuccessfully";
			Message::setMessage($msg);
		}
	}
	public function singleDataById($id){
		$query = "SELECT * FROM `".PREFIX."books` WHERE `id` = :id LIMIT 1";
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
	public function singleData($slug){
		$query = "SELECT * FROM `".PREFIX."books` WHERE `slug` = :slug";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(':slug', $slug);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return "error";
		}
	}
	public function updateBook($data, $files){

		if( isset($data['bookInfoid']) && $data['bookInfoid'] != ''){
			$id = $data['bookInfoid'];
			$singleData = $this->singleDataById($id);
			if($singleData == "error"){
				return "error";
			}else {
				$this->storeVariable($data); // asign all the data in a variable with validation & validation did in another method

				$dataValidation = $this->validation(); // Validation all data
				if(isset($dataValidation)){
					return $dataValidation;
				}else{

					$picture 	= $singleData['picture'];// Get the picture name which already stored in database
					if(trim($data['dataImgDelete']) == "1"){
						$picture = "";
					}else{
						if(!empty($files['picture']['name']) && $files['picture']['size'] > 0){

							// Get the new picture info
							$pictureTmp		= $files['picture']['tmp_name'];
							$pictureSize 	= $files['picture']['size'];
							$pictureType 	= $files['picture']['type'];

							if($pictureType === 'image/jpeg' || $pictureType === 'image/png' || $pictureType === 'image/jpg'){
								if(isset($picture) && $picture != ""){
									unlink(UPLOADBOOK.$picture); // Delete previous image
								}
								$picture = $files['picture']['name']; //Restore new image name in variable
								$pictureExtension 	= pathinfo($picture, PATHINFO_EXTENSION); //get the extension of a picture name
								$picture 	= uniqid().strtotime("now").".".$pictureExtension; //set the picture name by create unique random name

								$pictureDestination = UPLOADBOOK.$picture; //set the picture destination folder for store picture
								move_uploaded_file($pictureTmp, $pictureDestination); //Move the picture from tmp folder into destination folder which set previous line.

								// create an image manager instance with favored gd library
								$manager = new ImageManager(array('driver' => 'gd'));

								// to finally create image instances
								$image = $manager->make($pictureDestination)->fit(750, 900, function ($constraint) {
																		$constraint->upsize();
																	});

								$image->save($pictureDestination);
							}else{
								$msg = "bookImg";
								return $msg;
							}
						}
					}
					// Generate Slug
					if(strtolower(str_replace(' ','',$singleData['book_name'])) != strtolower(str_replace(' ','',$this->name))){
						$slug = $this->generateSlug($this->name);
					}else {
						$slug = trim($singleData['slug']);
					}



					date_default_timezone_set("Asia/Dhaka"); //set the timezone
					$date = date("Y:m:d H:i:s", time()); //set the time for record update time

					$category_id ="";
					foreach($this->category as $eachcategory){
						$category_id .= ",".$eachcategory;
					}

					$query = "UPDATE `".PREFIX."books`
					SET `book_name` = :book_name, `slug` = :slug, `writer` = :writer, `picture` = :picture, `category` = :category, `total_stock` = :total_stock, `description` = :description, `book_shelf` = :book_shelf, `update_at` = :update_at
					WHERE `id` = :id";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':book_name', $this->name);
					$statement->bindParam(':slug', $slug);
					$statement->bindParam(':writer', $this->writer);
					$statement->bindParam(':picture', $picture);
					$statement->bindParam(':category', $category_id);
					$statement->bindParam(':total_stock', $this->stock);
					$statement->bindParam(':description', $this->description);
					$statement->bindParam(':book_shelf', $this->shelf);
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

	public function status($data){

		if( isset($data['id']) && $data['id'] != '' && isset($data['status']) && $data['status'] != '' ){
			$id 		= $data['id'];
			$status = $data['status'];
			$singleData = $this->singleDataById($id);
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
					$query 	= "UPDATE `".PREFIX."books` SET `status` = :status WHERE `id` = :id";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':status', $input_status);
					$statement->bindParam(':id', $id);
					$result = $statement->execute();
					if($result){
						$msg = "success";
						return $msg;
					}else{
						$msg = "unsuccess";
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
		if(isset($data['bookInfo']) && !empty($data['bookInfo'])){
			$id 				= $data['bookInfo'];
			$singleData = $this->singleDataById($id);
			if($singleData !== "error"){
				$query = "DELETE FROM `".PREFIX."books` WHERE `id` = :id";
				$statement = $this->conn->prepare($query); //prepare the sql query
				$statement->bindParam(':id', $id);
				$result = $statement->execute();
				if($result){
					if(!empty($singleData['picture'])){
						unlink(UPLOADBOOK.$singleData['picture']);
					}
					if($data['cameFrom']=="show"){
						Message::setMessage('bookdelete');
					}
					$msg = "success";
					return $msg;
				}else{
					$msg = "unsuccess";
					return $msg;
				}
			}else{
				return "error";
			}
		}else{
			$msg = "error";
			return $msg;
		}
	}
	public function searchBook($data){
		$live = '%'.$data['searchdata'].'%';
		$query = "SELECT * FROM `".PREFIX."books` WHERE `book_name` LIKE :book_name OR `writer` LIKE :writer OR `book_id` LIKE :book_id";
		$stmnt  = $this->conn->prepare($query);
		$stmnt->bindParam(':book_name', $live);
		$stmnt->bindParam(':writer', $live);
		$stmnt->bindParam(':book_id', $live);
		// $stmnt->bindParam(':student_id', $data['searchdata']);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return 'notfound';
		}
	}
}
