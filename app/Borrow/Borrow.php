<?php
namespace App\Borrow;
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Database\Database;
use App\Login\Login;
use App\Notification\Notification;
use App\Book\Book;
use App\Student\Student;
use App\Utility\Message;
use PDO;

class Borrow{
	public $conn;
	public $username;
	public $bookId;

	public function __construct(){
		$db = new Database();
		$this->conn = $db->connection();
	}

	public function storeVariable($data){
		$this->username 	= $this->validation($data['username']);
		$this->bookId 		= $this->validation($data['bookId']);
	}

	public function borrow($data){
		if(isset($data['dataID']) && !empty($data['dataID'])){
			if($data['booking'] != ""){
				date_default_timezone_set("Asia/Dhaka"); //set the timezone
				if ( date("Ymd", time()) == date("Ymd", strtotime($data['booking'])) || date("Ymd", time()) > date("Ymd", strtotime($data['booking'])) ) {
					return "invaliddate";
				}else {
					$id = $data['dataID'];

					$Book = new Book;
					$BookSingleDataById = $Book->singleDataById($id);

					if($BookSingleDataById !== "error"){
						$loginID = Login::loginGet('id');

						$Student = new Student;
						$StudentSingleDataById = $Student->singleDataById($loginID);

						if($StudentSingleDataById != 'error'){
							$checkBorrow = $this->checkBorrow($id, $loginID);
							if($checkBorrow == false){
								$generateBorrowId = $this->generateBorrowId();
								$expiredate = date("Y-m-d", strtotime($data['booking']));
								$is_accept = 0;
								$query = "INSERT INTO `".PREFIX."borrow`(`borrow_id`, `user_id`, `book_id`,`return_date`, `is_accept`) VALUES (:borrow_id, :user_id, :book_id, :return_date, :is_accept)";
								$statement = $this->conn->prepare($query); //prepare the sql query
								$statement->bindParam(':borrow_id', $generateBorrowId);
								$statement->bindParam(':user_id', $loginID);
								$statement->bindParam(':book_id', $id);
								$statement->bindParam(':return_date', $expiredate);
								$statement->bindParam(':is_accept', $is_accept);
								$result = $statement->execute();
								$last_id = $this->conn->lastInsertId();
								if($result){
									$page_permission = 3;
									$subject = "Requested for borrow book";
									$comment = '<p> <a href="'.ADMINVIEW.'student/show.php?student_show='.urlencode($StudentSingleDataById['slug']).'" class="text-bold"> '.$StudentSingleDataById['name'].'</a> requested a book for borrow</p>
								  <a href="'.ADMINVIEW.'borrow/show.php?borrow_show='.urlencode($last_id).'" class="btn btn-sm btn-primary">View Details</a>';
									$Notification = new Notification;
									$Notification->store($loginID, '', '', '', $subject, $comment, $page_permission);
									$msg = "success";
									return $msg;
								}else{
									$msg = "unsuccess";
									return $msg;
								}
							}else {
								return 'error';
							}


						}else {
							return 'error';
						}
					}else{
						return "error";
					}
				}
			}else {
				return "empty";
			}
		}else{
			$msg = "error";
			return $msg;
		}
	}
	public function borrowManually($data){
		if(isset($data['stdnID']) && $data['stdnID'] != ""){
			if(isset($data['dataID']) && $data['dataID'] != ""){
				if(isset($data['booking']) && $data['booking'] != ""){
					date_default_timezone_set("Asia/Dhaka"); //set the timezone
					if ( date("Ymd", time()) == date("Ymd", strtotime($data['booking'])) || date("Ymd", time()) > date("Ymd", strtotime($data['booking'])) ) {
						return "invaliddate";
					}else {
						$id = $data['dataID'];

						$Book = new Book;
						$BookSingleDataById = $Book->singleDataById($id);

						if($BookSingleDataById !== "error"){
							$loginID = $data['stdnID'];

							$Student = new Student;
							$StudentSingleDataById = $Student->singleDataById($loginID);

							if($StudentSingleDataById != 'error'){
								$checkBorrow = $this->checkBorrow($id, $loginID);
								if($checkBorrow == false){
									$generateBorrowId = $this->generateBorrowId();
									$expiredate = date("Y-m-d", strtotime($data['booking']));
									$is_accept = 0;
									$query = "INSERT INTO `".PREFIX."borrow`(`borrow_id`, `user_id`, `book_id`,`return_date`, `is_accept`) VALUES (:borrow_id, :user_id, :book_id, :return_date, :is_accept)";
									$statement = $this->conn->prepare($query); //prepare the sql query
									$statement->bindParam(':borrow_id', $generateBorrowId);
									$statement->bindParam(':user_id', $loginID);
									$statement->bindParam(':book_id', $id);
									$statement->bindParam(':return_date', $expiredate);
									$statement->bindParam(':is_accept', $is_accept);
									$result = $statement->execute();
									if($result){
										Message::setMessage('successborrow');
										$msg = "success";
										return $msg;
									}else{
										$msg = "unsuccess";
										return $msg;
									}
								}else {
									return 'alreadyborrow';
								}


							}else {
								return 'error';
							}
						}else{
							return "error";
						}
					}
				}else {
					return "emptyreturn";
				}
			}else {
				return 'emptybook';
			}
		}else{
			$msg = "emptystudent";
			return $msg;
		}
	}
	public function validation($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	public function checkBorrow($book_id, $loginID){ //Helper function for search email from database

		$query = "SELECT * FROM `".PREFIX."borrow` WHERE `book_id` = :book_id AND `user_id` = :user_id LIMIT 1";
		$stmnt  = $this->conn->prepare($query);
		$stmnt->bindParam(':book_id', $book_id);
		$stmnt->bindParam(':user_id', $loginID);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return false;
		}
	}
	public function borrowList(){
		$loginID = Login::loginGet('id');
		$query = "SELECT `t1`.* , `t2`.`book_name`, `t2`.`slug`, `t2`.`writer`, `t2`.`book_id`, `t2`.`picture`, `t2`.`category`
							FROM `".PREFIX."borrow` AS `t1`
							LEFT OUTER JOIN `".PREFIX."books` AS `t2`
							ON `t2`.`id` = `t1`.`book_id`
							WHERE `t1`.`user_id` = :user_id
							ORDER BY `t1`.`id` DESC";
		// $query = "SELECT * FROM `".PREFIX."borrow` WHERE `user_id` = :user_id ORDER BY `id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(":user_id", $loginID);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			$msg = "error";
			return $msg;
		}
	}
	public function getAllBorrowList(){
		$query = "SELECT `t1`.* ,
										`t2`.`book_name`, `t2`.`slug`, `t2`.`writer`, `t2`.`book_id`, `t2`.`picture`, `t2`.`category`,
										`t3`.`name` AS `student_name`, `t3`.`slug` AS `student_slug`
							FROM `".PREFIX."borrow` AS `t1`
							LEFT OUTER JOIN `".PREFIX."books` AS `t2` ON `t2`.`id` = `t1`.`book_id`
							LEFT OUTER JOIN `".PREFIX."students` AS `t3` ON `t3`.`id` = `t1`.`user_id`
							ORDER BY `t1`.`id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			$msg = "error";
			return $msg;
		}
	}
	public function singleData($id){
		$query = "SELECT `t1`.* ,
										`t2`.`book_name`, `t2`.`slug`, `t2`.`writer`, `t2`.`book_id` as `book_no`, `t2`.`picture`, `t2`.`category`, `t2`.`total_stock`, `t2`.`book_shelf`, `t2`.`total_borrowed`,
										`t3`.`name` AS `student_name`, `t3`.`slug` AS `student_slug`
							FROM `".PREFIX."borrow` AS `t1`
							LEFT OUTER JOIN `".PREFIX."books` AS `t2` ON `t2`.`id` = `t1`.`book_id`
							LEFT OUTER JOIN `".PREFIX."students` AS `t3` ON `t3`.`id` = `t1`.`user_id`
							WHERE `t1`.`id`=:id";
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
	public function totalBorrowSingleBook($id){ //for search how many borrow a book
		$is_accept = 1;
		$query = "SELECT * FROM `".PREFIX."borrow` WHERE `book_id`= :book_id AND `is_accept`= :is_accept";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(':book_id', $id);
		$stmnt->bindParam(':is_accept', $is_accept);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return 0;
		}
	}
	public function generateBorrowId(){
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
	public function accept($data){
		if($data['borrow_info'] != ""){
			$borrow_id 	= $data['borrow_info'];
			$singleData = $this->singleData($borrow_id);

			if($singleData != 'error' && $singleData['is_accept'] == '0'){

				$totalBorrowSingleBook = $this->totalBorrowSingleBook($singleData['book_id']);
				$totalBorrow =  $totalBorrowSingleBook == 0 ? $totalBorrowSingleBook : count($totalBorrowSingleBook);

				if($totalBorrow < $singleData['total_stock']){
					$is_accept = 1;
					date_default_timezone_set('Asia/Dhaka');
					$accept_at = date('Y-m-d', time());

					$query = "UPDATE `".PREFIX."borrow` SET  `is_accept` = :is_accept, `accept_at` = :accept_at WHERE `id` = :id LIMIT 1";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':id', $borrow_id);
					$statement->bindParam(':is_accept', $is_accept);
					$statement->bindParam(':accept_at', $accept_at);
					$result = $statement->execute();
					if($result){
						$totalBorrowSingleBook = $this->totalBorrowSingleBook($singleData['book_id']);
						$totalBorrow =  $totalBorrowSingleBook == 0 ? $totalBorrowSingleBook : count($totalBorrowSingleBook);

						$query = "UPDATE `".PREFIX."books` SET  `total_borrowed` = :total_borrowed WHERE `id` = :id LIMIT 1";
						$statement = $this->conn->prepare($query); //prepare the sql query
						$statement->bindParam(':id', $singleData['book_id']);
						$statement->bindParam(':total_borrowed', $totalBorrow);
						$result = $statement->execute();
						if($result){
							$loginID = Login::loginGet('adminid');
							$subject = "Accepted your request to borrow book";
							$comment = '<p>Your requested for borrow <strong>'.$singleData['book_name'].'</strong> book has been accepted. </p>';
							$Notification = new Notification;
							$Notification->store('', $singleData['user_id'], $loginID, '',  $subject, $comment, 0);

							$msg = "success";
							return $msg;
						}else {
							$msg = "booknotfound";
							return $msg;
						}
					}else {
						$msg = "unsuccess";
						return $msg;
					}

				}else {
					return 'stockout';
				}

			}else {
				return 'error';
			}
		}else {
			return 'error';
		}
	}
	public function reject($data){
		if($data['borrow_info'] != ""){
			$borrow_id 	= $data['borrow_info'];
			$singleData = $this->singleData($borrow_id);

			if($singleData != 'error' && $singleData['is_accept'] == '0'){
					if(isset($data['cameFrom']) && trim($data['cameFrom']) == 'student'){
						if(trim($singleData['user_id']) != Login::loginGet('id')){
							return 'error';
						}
					}

					$query = "DELETE FROM `".PREFIX."borrow` WHERE `id` = :id LIMIT 1";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':id', $borrow_id);
					$result = $statement->execute();
					if($result){
						if(trim($data['cameFrom']) != 'student'){
							$loginID = Login::loginGet('userid');
							$subject = "Rejected your request to borrow book";
							$comment = '<p>Your requested for borrow <strong>'.$singleData['book_name'].'</strong> book has been rejected. </p>';
							$Notification = new Notification;
							$Notification->store('', $singleData['user_id'], $loginID, '',  $subject, $comment, 0);

							if(trim($data['cameFrom']) == "show"){
								Message::setMessage('successreject');
							}
						}


						$msg = "success";

						return $msg;
					}else {
						$msg = "error3";
						return $msg;
					}
			}else {
				return 'error2';
			}
		}else {
			return 'error1';
		}
	}
	public function return($data){
		if($data['borrow_info'] != ""){
			$borrow_id 	= $data['borrow_info'];
			$singleData = $this->singleData($borrow_id);

			if($singleData != 'error' && $singleData['is_accept'] == '1'){
					$query = "DELETE FROM `".PREFIX."borrow` WHERE `id` = :id LIMIT 1";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':id', $borrow_id);
					$result = $statement->execute();
					if($result){
						$totalBorrowSingleBook = $this->totalBorrowSingleBook($singleData['book_id']);
						$totalBorrow =  $totalBorrowSingleBook == 0 ? $totalBorrowSingleBook : count($totalBorrowSingleBook);

						$query = "UPDATE `".PREFIX."books` SET  `total_borrowed` = :total_borrowed WHERE `id` = :id LIMIT 1";
						$statement = $this->conn->prepare($query); //prepare the sql query
						$statement->bindParam(':id', $singleData['book_id']);
						$statement->bindParam(':total_borrowed', $totalBorrow);
						$result = $statement->execute();
						if($result){
							if(trim($data['cameFrom']) == "show"){
								Message::setMessage('successreturn');
							}

							$msg = "success";
							return $msg;
						}else {
							$msg = "error";
							return $msg;
						}
					}else {
						$msg = "error";
						return $msg;
					}

			}else {
				return 'error';
			}
		}else {
			return 'error';
		}
	}
	public function renew($data){
		if($data['borrow_info'] != ""){
			$borrow_id 	= $data['borrow_info'];
			$singleData = $this->singleData($borrow_id);
			date_default_timezone_set('Asia/Dhaka');

			if($singleData != 'error' && $singleData['is_accept'] == '1'){
				if (date("Ymd", time()) == date("Ymd", strtotime($data['returnDate'])) || date("Ymd", time()) > date("Ymd", strtotime($data['returnDate'])) ||
				date("Ymd", strtotime($data['returnDate'])) == date("Ymd", strtotime($singleData['return_date']))) {
					return 'invaliddate';
				}else {
					$return_date = date('Y-m-d', strtotime($data['returnDate']));

					$query = "UPDATE `".PREFIX."borrow` SET  `return_date` = :return_date WHERE `id` = :id LIMIT 1";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':id', $borrow_id);
					$statement->bindParam(':return_date', $return_date);
					$result = $statement->execute();
					if($result){
						$msg = "success";
						return $msg;
					}else {
						$msg = "unsuccess";
						return $msg;
					}
				}
			}else {
				return 'error';
			}
		}else {
			return 'error';
		}
	}


}
