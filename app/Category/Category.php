<?php
namespace App\Category;
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Database\Database;
use App\Utility\Message;
use App\Book\Book;
use PDO;


class Category{
	protected $conn;
	protected $name;
	protected $shortDescription;
	protected $parentCategory;
	protected	$option;

	public function __construct(){
		$db = new Database();
		$this->conn = $db->connection();
	}
  public function storeVariable($data){
		$this->name 							= $this->filter($data['name']);
		$this->shortDescription		= $this->filter($data['shortDescription']);
		$this->parentCategory			= isset($data['parentCategory']) && $data['parentCategory'] != "" ? $this->filter($data['parentCategory']) : NULL ;
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

		$searchSlug = "SELECT `slug` FROM `".PREFIX."categories` WHERE `slug` = :slug";
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

			$searchSlug = "SELECT `slug` FROM `".PREFIX."categories` WHERE `slug` = :slug";
			$userstmnt  = $this->conn->prepare($searchSlug);
			$userstmnt->bindParam(":slug", $slug);
			$userstmnt->execute();
		}
		return $slug;
	}

  public function registerCategory($data){
		$this->storeVariable($data); //Store all data in variable sothat use in any method easily

		$dataValidation = $this->validation($data); //Validation all data
		if(isset($dataValidation)){
			return $dataValidation;
		}else{
			$slug = $this->generateSlug($this->name); // Generate Slug

			$query = "INSERT INTO `".PREFIX."categories` (`category_name`, `short_description`, `slug`, `parent_category`) VALUES (:category_name, :short_description, :slug, :parent_category);";
			$statement = $this->conn->prepare($query); //prepare the sql query
			$statement->bindParam(':category_name', $this->name);
			$statement->bindParam(':short_description', $this->shortDescription);
			$statement->bindParam(':slug', $slug);
			$statement->bindParam(':parent_category', $this->parentCategory);

			if($statement->execute()){
				Message::setMessage("successfully");
				$msg = "success";
				return $msg;
			}else{
				$msg = "unsuccess";
				return $msg;
			}
		}
	}
	public function validation(){

		//Start: Category Name Validation
		if(!isset($this->name ) || $this->name == ""){ //If category name is empty
			$msg = "emptyname";
			return $msg;
		}
		if(strlen($this->name) > 60){ // If name is geater than 60 char
			$msg = "categoryName";
			return $msg;
		}
		//End

		//Start: Parent Category Validation
		if (isset($this->parentCategory) && $this->parentCategory != "") {
			$categoryInfoById = $this->categoryInfoById($this->parentCategory);
			if($categoryInfoById == "notfound"){
				return "parentCategory";
			}
		}
		//End


		//Start: Short Description Validation
		if($this->shortDescription != "" && strlen($this->shortDescription) > 250){ //If faculty name is empty
			$msg = "shortDescription";
			return $msg;
		}
		//End

	}

	public function fetchCategoryForSearch($parent_id = NULL, $sub_mark = ''){

    $query = $this->conn->prepare("SELECT * FROM `".PREFIX."categories` WHERE `parent_category` <=> :parrent_id ORDER BY `category_name` ASC");
		$query->bindParam(":parrent_id", $parent_id);
		$query->execute();
    if($query->rowCount() > 0){
			// $row = $query->fetchAll(PDO::FETCH_ASSOC);

      while($row = $query->fetch(PDO::FETCH_ASSOC)){
				$sym = ["+", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "=", "?", "~"];
        $this->option.= '<option value="'.$row['id'].'" data-path=".'.str_replace($sym, "p", $row['slug']).'">'.$sub_mark.$row['category_name'].'</option>';
        $this->fetchCategoryForSearch($row['id'], $sub_mark.'---');
      }
    }
		return $this->option;
		// return $row;
	}
	public function fetchCategory($parent_id = NULL, $sub_mark = ''){
    $query = $this->conn->prepare("SELECT * FROM `".PREFIX."categories` WHERE `parent_category` <=> :parrent_id ORDER BY `category_name` ASC");
		$query->bindParam(":parrent_id", $parent_id);
		$query->execute();
    if($query->rowCount() > 0){
			// $row = $query->fetchAll(PDO::FETCH_ASSOC);

        while($row = $query->fetch(PDO::FETCH_ASSOC)){

            $this->option.= '<option value="'.$row['id'].'">'.$sub_mark.$row['category_name'].'</option>';
            $this->fetchCategory($row['id'], $sub_mark.'---');
        }
    }
		return $this->option;
		// return $row;
	}
	public function fetchCategoryEdited($parent_id, $sub_mark, $data){
    $query = $this->conn->prepare("SELECT * FROM `".PREFIX."categories` WHERE `parent_category` <=> :parrent_id ORDER BY `category_name` ASC");
		$query->bindParam(":parrent_id", $parent_id);
		$query->execute();
    if($query->rowCount() > 0){

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
						$selected = in_array($row['id'], $data) ? "selected" : "" ;

            $this->option.= '<option '.$selected.' value="'.$row['id'].'">'.$sub_mark.$row['category_name'].'</option>';
            $this->fetchCategoryEdited($row['id'], $sub_mark.'---', $data);
        }
    }
		return $this->option;
		// return $row;
	}
	public function fetchCategoryEditedCategory($parent_id, $sub_mark, $data){
		$query = $this->conn->prepare("SELECT * FROM `".PREFIX."categories` WHERE `parent_category` <=> :parrent_id ORDER BY `category_name` ASC");
		$query->bindParam(":parrent_id", $parent_id);
		$query->execute();
		if($query->rowCount() > 0){

				while($row = $query->fetch(PDO::FETCH_ASSOC)){
						$selected = $data ===  $row['id'] ? "selected" : "" ;

						$this->option.= '<option '.$selected.' value="'.$row['id'].'">'.$sub_mark.$row['category_name'].'</option>';
						$this->fetchCategoryEditedCategory($row['id'], $sub_mark.'---', $data);
				}
		}
		return $this->option;
		// return $row;
	}
	public function allCategory(){
		$query = "SELECT `t1`.* , `t2`.`category_name` AS `parent_name`
							FROM `".PREFIX."categories` AS `t1`
							LEFT OUTER JOIN `".PREFIX."categories` AS `t2`
							ON `t2`.`id` = `t1`.`parent_category`
							ORDER BY `t1`.`id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else {
			return "error";
		}
	}
	public function singleData($data){
		$query = "SELECT `t1`.* , `t2`.`category_name` AS `parent_name`
							FROM `".PREFIX."categories` AS `t1`
							LEFT OUTER JOIN `".PREFIX."categories` AS `t2`
							ON `t2`.`id` = `t1`.`parent_category`
							WHERE `t1`.`slug` = :slug
							LIMIT 1";
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
	public function categoryInfoById($data){
		$query = "SELECT * FROM `".PREFIX."categories` WHERE `id` = :id LIMIT 1";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(":id", $data);
		$stmnt->execute();

		if($stmnt->rowCount() > 0){
			$result = $stmnt->fetch(PDO::FETCH_ASSOC);
			return $result;
		}else {
			return "notfound";
		}
	}

	public function updateCategory($data){

		// Validation all data
		if( isset($data['cateinfo']) && $data['cateinfo'] != ''){
			$id = $data['cateinfo'];
			$categoryInfoById = $this->categoryInfoById($id);
			if ($categoryInfoById == 'notfound') {
				$msg = "notfound";
				return $msg;
			}else{
				$this->storeVariable($data);
				$dataValidation = $this->validation();
				if(isset($dataValidation)){
					return $dataValidation;
				}else{
					// Generate Slug
					if(strtolower(str_replace(' ','',$categoryInfoById['category_name'])) != strtolower(str_replace(' ','',$this->name))){
						$slug = $this->generateSlug($this->name);
					}else {
						$slug = trim($categoryInfoById['slug']);
					}


					date_default_timezone_set("Asia/Dhaka"); //set the timezone
					$date = date("Y:m:d H:i:s", time()); //set the time for record register time

					$query = "UPDATE `".PREFIX."categories` SET `category_name` = :category_name, `short_description` = :short_description, `slug` = :slug, `parent_category` = :parent_category, `update_At` = :update_At  WHERE `id` = :id";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':category_name', $this->name);
					$statement->bindParam(':short_description', $this->shortDescription);
					$statement->bindParam(':slug', $slug);
					$statement->bindParam(':parent_category', $this->parentCategory);
					$statement->bindParam(':update_At', $date);
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
		if( isset($data['catinfo']) && $data['catinfo'] != ''){
			$id = $data['catinfo'];
			$categoryInfoById = $this->categoryInfoById($id);
			if ($categoryInfoById == 'notfound') {
				$msg = "notfound";
				return $msg;
			}else{
				$Book = new Book(); //create object of book class
				$allBooks = $Book->allBooks(); //call method of all book
				foreach ($allBooks as $eachBook) {
					$strRep = str_replace(',', " ", $eachBook['category']);
					$substr = substr($strRep, 1);
					$explds  = explode(" ", $substr); //category convert into array
					if(in_array($id ,$explds)){
						return "categoryhas";
						exit();
					}
				}

				$query = "DELETE FROM `".PREFIX."categories` WHERE `id` = :id";
				$statement = $this->conn->prepare($query); //prepare the sql query
				$statement->bindParam(':id', $id);
				$result = $statement->execute();
				if($result){
					if($data['cameFrom']=="show"){
						Message::setMessage('categorydelete');
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

}
