<?php
namespace App\Notification;
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Database\Database;
use App\Userrole\Userrole;
use App\Login\Login;
use PDO;

class Notification{
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

	public function store($studentFrom, $studentTo, $userFrom, $userTo, $subject, $comment, $page_permission){

		date_default_timezone_set("Asia/Dhaka"); //set the timezone
		$date = date("Y:m:d H:i:s", time()); //set the time for record register time
		$numdays	= 8;
		$tomorrow 	= mktime(0,0,0,date("m"),date("d")+$numdays,date("Y"));
		$expiredate = date("Y-m-d", $tomorrow);

		$isRead = 0; //Declar 'no' by default in `is_disable` row in table

		$query = "INSERT INTO `".PREFIX."notifications` (`student_from`, `student_to`, `user_from`, `user_to`, `subject`, `comment`, `page_permission`, `is_read`, `expire_date`) VALUES (:student_from, :student_to, :user_from, :user_to, :subject, :comment, :page_permission, :is_read, :expire_date);";
		$statement = $this->conn->prepare($query); //prepare the sql query
		$statement->bindParam(':student_from', $studentFrom);
		$statement->bindParam(':student_to', $studentTo);
		$statement->bindParam(':user_from', $userFrom);
		$statement->bindParam(':user_to', $userTo);
		$statement->bindParam(':subject', $subject);
		$statement->bindParam(':comment', $comment);
		$statement->bindParam(':page_permission', $page_permission);
		$statement->bindParam(':is_read', $isRead);
		$statement->bindParam(':expire_date', $expiredate);
		$result = $statement->execute();
		if($result){
			$msg = "success";
			return $msg;
		}else{
			$msg = "error";
			return $msg;
		}
	}
	public function validation($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	public function dataValidation(){
		// if input empty
		if($this->username == "" || $this->bookId == ""){
			$msg = "error";
			return $msg;
		}

		// If student mobile number is not Numeric
		if(!preg_match("/^[0-9]{0,15}$/", $this->bookId)){
			$msg = "error";
			return $msg;
		}

		// // If student name is not alphabet
		// if(!preg_match("/^[a-zA-Z ]*$/", $this->Name)){
		// 	$msg = "studentname";
		// 	return $msg;
		// }
	}
	public function searchEmail($data){ //Helper function for search email from database
		$query = "SELECT `student_email` FROM `students` WHERE `student_email` = :student_email";
		$stmnt  = $this->conn->prepare($query);
		$stmnt->bindParam(':student_email', $data);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);

		if($result){
			return true;
		}else{
			return false;
		}
	}
	public function allNotifications(){
		// $query = "SELECT * FROM `".PREFIX."students` ORDER BY `id` DESC";
		$query = "SELECT `allnotifications`.*, `allstudents`.`name`
							FROM `".PREFIX."notifications` as `allnotifications`
							LEFT JOIN `".PREFIX."students` as `allstudents`
							ON `allnotifications`.`student_from` = `allstudents`.`id`
							WHERE `student_to` = ''
							ORDER BY `id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return "error";
		}
	}
	public function allStudentNotifications($student_to){
		$query = "SELECT `allnotifications`.*, `allstudents`.`name`
							FROM `".PREFIX."notifications` as `allnotifications`
							LEFT JOIN `".PREFIX."students` as `allstudents`
							ON `allnotifications`.`student_to` = `allstudents`.`id`
							WHERE `student_to` = :student_to
							ORDER BY `id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(":student_to", $student_to);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return "error";
		}
	}
	public function unseenStudentNotifications($student_to){
		$isRead = 0;
		$query = "SELECT * FROM `".PREFIX."notifications`
							WHERE `student_to` = :student_to
							AND `is_read` = :is_read
							ORDER BY `id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(":student_to", $student_to);
		$stmnt->bindParam('is_read', $isRead);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return "error";
		}
	}
	public function allUserNotifications(){
		$userrole = Login::loginGet('userrole');
		if($userrole == 1){
			return $this->allNotifications();
		}else {
			$Userrole = new Userrole;
			$userRoleInfoById = $Userrole->userRoleInfoById($userrole);
			if($userRoleInfoById != 'error'){
				// $admin_pages_ids = implode(",", $userRoleInfoById['admin_pages_id']);
				$admin_pages_ids = substr($userRoleInfoById['admin_pages_id'], 1);
				$query = "SELECT `allnotifications`.*, `allstudents`.`name`
									FROM `".PREFIX."notifications` as `allnotifications`
									LEFT JOIN `".PREFIX."students` as `allstudents`
									ON `allnotifications`.`student_from` = `allstudents`.`id`
									WHERE `allnotifications`.`student_to` = ''
	                AND `allnotifications`.`page_permission` IN (".$admin_pages_ids.")
									ORDER BY `id` DESC";
				$stmnt = $this->conn->prepare($query);
				$stmnt->execute();
				$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
				if($result){
					return $result;
				}else{
					return "error";
				}
			}
		}
	}
	public function unseenNotification(){
		$isRead = 0;
		$userrole = Login::loginGet('userrole');
		if($userrole == 1 && Login::loginGet('userid') == 1){
			$query = "SELECT * FROM `".PREFIX."notifications` WHERE `is_read` = :is_read ORDER BY `id` DESC";
			$stmnt = $this->conn->prepare($query);
			$stmnt->bindParam('is_read', $isRead);
			$stmnt->execute();
			$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
			if($result){
				return $result;
			}else {
				return 'notfound';
			}
		}else {
			$Userrole = new Userrole;
			$userRoleInfoById = $Userrole->userRoleInfoById($userrole);
			if($userRoleInfoById != 'error'){
				// $admin_pages_ids = implode(",", $userRoleInfoById['admin_pages_id']);
				$admin_pages_ids = substr($userRoleInfoById['admin_pages_id'], 1);
				$query = "SELECT * FROM `".PREFIX."notifications`
									WHERE `student_to` = ''
	                AND `page_permission` IN (".$admin_pages_ids.")
									AND  `is_read` = $isRead
									ORDER BY `id` DESC";
				$stmnt = $this->conn->prepare($query);
				$stmnt->execute();
				$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
				if($result){
					return $result;
				}else{
					return "error";
				}
			}
		}
	}
	public function lastUnseenNotification(){
		$isRead = 'no';
		$query = "SELECT * FROM `notification` WHERE `is_read` = :is_read ORDER BY `id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam('is_read', $isRead);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			$msg = "unsuccessfully";
			Message::setMessage($msg);
		}
	}
	public function show($data){
		$dataID = $data['dataID'];
		$isRead = $data['isRead'];
		$singleData = $this->singleData($dataID);
		if($singleData != 'error'){
			if($isRead == $singleData['is_read']){
				if($isRead == 0){
					$isRead = 1;
					$query = "UPDATE `".PREFIX."notifications` SET `is_read` = :is_read
										WHERE `id`= :id LIMIT 1";
					$stmnt = $this->conn->prepare($query);
					$stmnt->bindParam(':id', $dataID);
					$stmnt->bindParam(':is_read', $isRead);
					$stmnt->execute();
				}
				$query = "SELECT `allnotifications`.*, `allstudents`.*
									FROM `".PREFIX."notifications` as `allnotifications`
									LEFT JOIN `".PREFIX."students` as `allstudents`
									ON `allnotifications`.`student_from` = `allstudents`.`id`
									WHERE `allnotifications`.`id`= :id LIMIT 1";
				$stmnt = $this->conn->prepare($query);
				$stmnt->bindParam(':id', $dataID);
				$stmnt->execute();
				$result = $stmnt->fetch(PDO::FETCH_ASSOC);
				if($result){
					// $finalData = '<div class="modal-header"><h4 class="modal-title">Requested for approve new account</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p>A student registered an account. Verify the account for approve</p><a href="'.ADMINVIEW.'student/show.php?student_show='.urlencode($result['slug']).'" class="btn btn-sm btn-primary">Verify Now</a></div><div class="modal-footer justify-content-end"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button> </div>';
					return $result;
				}else{
					return "error";
				}
			}else {
				return "error";
			}
		}else{
			return "error";
		}
	}
	public function singleData($data){
		$query = "SELECT * FROM `".PREFIX."notifications` WHERE `id` = :id LIMIT 1";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(':id', $data);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return "error";
		}
	}
	public function showNotificationByUserId($data){
		$query = "SELECT * FROM `".PREFIX."notifications` WHERE `user_from` = :user_from LIMIT 1";
		$stmnt = $this->conn->prepare($query);
		$stmnt->bindParam(':user_from', $data);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return "error";
		}
	}
	public function delete($data){
		$checkednotification = $data['checkednotification'];
		foreach ($checkednotification as $eachNotify) {
			$singleData = $this->singleData($eachNotify);
			if($singleData == 'error'){
				return "error";
				exit();
			}
		}
		$ids = implode(",", $checkednotification);

		$query = "DELETE FROM `".PREFIX."notifications` WHERE `id` IN(".$ids.")";
		$statement = $this->conn->prepare($query); //prepare the sql query
		// $statement->bindParam(':id', $ids);
		$result = $statement->execute();
		if($result){
			$msg = "success";
			return $msg;
		}else{
			$msg = "unsuccessfully";
			return $msg;
		}
	}
	public function deleteNotificationByUser($data){
		$showNotificationByUserId = $this->showNotificationByUserId($data);

		if($showNotificationByUserId != 'error'){
			$query = "DELETE FROM `".PREFIX."notifications` WHERE `user_from` = :user_from";
			$statement = $this->conn->prepare($query); //prepare the sql query
			$statement->bindParam(':user_from', $data);
			$result = $statement->execute();
			if($result){
				$msg = "success";
				return $msg;
			}else{
				$msg = "error";
				return $msg;
			}
		}
	}
}
