<?php
namespace App\Renew;
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Database\Database;
use App\Borrow\Borrow;
use App\Notification\Notification;
use App\Login\Login;
use App\Student\Student;
use App\Utility\Message;
use PDO;

class Renew extends Borrow{

	public function renewRequest($data){
		$loginID = Login::loginGet('id');

		if($data['borrow_info'] != ""){
			$borrow_id 	= $data['borrow_info'];
			$singleData = $this->singleData($borrow_id);
			date_default_timezone_set('Asia/Dhaka');

			if($singleData != 'error' && $singleData['is_accept'] == '1' & $loginID == $singleData['user_id']){
				if (date("Ymd", time()) == date("Ymd", strtotime($data['returnDate'])) || date("Ymd", time()) > date("Ymd", strtotime($data['returnDate'])) ||
				date("Ymd", strtotime($data['returnDate'])) == date("Ymd", strtotime($singleData['return_date']))) {
					return 'invaliddate';
				}else {
					$date_request = date('Y-m-d', strtotime($data['returnDate']));
					$is_accept = 0;
					$query = "INSERT INTO `".PREFIX."renew`(`borrow_id`, `date_request`, `is_accept`) VALUES (:borrow_id, :date_request, :is_accept)";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':borrow_id', $borrow_id);
					$statement->bindParam(':date_request', $date_request);
					$statement->bindParam(':is_accept', $is_accept);
					$result = $statement->execute();
					$last_id = $this->conn->lastInsertId();
					if($result){
						$Student = new Student;
						$StudentSingleDataById = $Student->singleDataById($loginID);
						$subject = "Requested for renew book";
						$comment = '<p> <a href="'.ADMINVIEW.'student/show.php?student_show='.urlencode($StudentSingleDataById['slug']).'" class="text-bold"> '.$StudentSingleDataById['name'].'</a> requested to renew a book which <a href="'.ADMINVIEW.'borrow/show.php?borrow_show='.urlencode($borrow_id).'" class="text-bold"> borrowed</a></p>
						<a href="'.ADMINVIEW.'renew/show.php?renew_show='.urlencode($last_id).'" class="btn btn-sm btn-primary">View Details</a>';
						$Notification = new Notification;
						$Notification->store($loginID, '','' ,'' ,$subject , $comment, 3);

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
	public function renewRequestList(){
		$query = "SELECT
								`t1`.`id` AS `renew_id`, `t1`.`borrow_id` AS `renew_borrow_id`, `t1`.`date_request`, `t1`.`is_accept` 	AS `renew_is_accept`, `t1`.`create_at` AS `renew_create_at` ,
								`t2`.*,
								`t3`.`book_name`, `t3`.`slug`, `t3`.`writer`, `t3`.`book_id`, `t3`.`picture`, `t3`.`category`,
								`t4`.`name` AS `student_name`, `t4`.`slug` AS `student_slug`
							FROM `".PREFIX."renew` AS `t1`
							LEFT OUTER JOIN `".PREFIX."borrow` AS `t2` ON `t2`.`id` = `t1`.`borrow_id`
							LEFT OUTER JOIN `".PREFIX."books` AS `t3` ON `t3`.`id` = `t2`.`book_id`
							LEFT OUTER JOIN `".PREFIX."students` AS `t4` ON `t4`.`id` = `t2`.`user_id`
							ORDER BY `t1`.`id` DESC";
		// $query = "SELECT * FROM `".PREFIX."borrow` WHERE `user_id` = :user_id ORDER BY `id` DESC";
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

	public function renewSingleData($id){
		$query = "SELECT
								`t1`.`id` AS `renew_id`, `t1`.`borrow_id` AS `renew_borrow_id`, `t1`.`date_request`, `t1`.`is_accept`	AS `renew_is_accept`, `t1`.`create_at` AS `renew_create_at` ,
								`t2`.*,
								`t3`.`book_name`, `t3`.`slug`, `t3`.`writer`, `t3`.`book_id`, `t3`.`picture`, `t3`.`category`,
								`t4`.`name` AS `student_name`, `t4`.`slug` AS `student_slug`
							FROM `".PREFIX."renew` AS `t1`
							LEFT OUTER JOIN `".PREFIX."borrow` AS `t2` ON `t2`.`id` = `t1`.`borrow_id`
							LEFT OUTER JOIN `".PREFIX."books` AS `t3` ON `t3`.`id` = `t2`.`book_id`
							LEFT OUTER JOIN `".PREFIX."students` AS `t4` ON `t4`.`id` = `t2`.`user_id`
							WHERE `t1`.`id`=:id LIMIT 1";
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
	public function acceptRequest($data){
		$renewId = $data['renew_info'];
		$renewSingleData = $this->renewSingleData($renewId);
		if($renewSingleData != 'error'){

			$singleData = $this->singleData($renewSingleData['renew_borrow_id']);
			date_default_timezone_set('Asia/Dhaka');

			if($singleData != 'error' && $singleData['is_accept'] == '1'){
				if (date("Ymd", time()) == date("Ymd", strtotime($renewSingleData['date_request'])) || date("Ymd", time()) > date("Ymd", strtotime($renewSingleData['date_request'])) ||
				date("Ymd", strtotime($singleData['return_date'])) == date("Ymd", strtotime($renewSingleData['date_request']))) {
					return 'invaliddate';
				}else {
					$return_date = date('Y-m-d', strtotime($renewSingleData['date_request']));

					$query = "UPDATE `".PREFIX."borrow` SET  `return_date` = :return_date WHERE `id` = :id LIMIT 1";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':id', $renewSingleData['renew_borrow_id']);
					$statement->bindParam(':return_date', $return_date);
					$result = $statement->execute();
					if($result){
						$is_accept = 1;
						$query = "UPDATE `".PREFIX."renew` SET  `is_accept` = :is_accept WHERE `id` = :id LIMIT 1";
						$statement = $this->conn->prepare($query); //prepare the sql query
						$statement->bindParam(':id', $renewId);
						$statement->bindParam(':is_accept', $is_accept);
						$statement->execute();

						$loginID = Login::loginGet('adminid');

						$subject = "Accept your request of renew book";
						$comment = '<p> your requested for renew book has been accepted </p>
												<p> Borrow no: <strong>'.$renewSingleData['borrow_id'].'</strong> </p>
												<p> Book name: <strong>'.$renewSingleData['book_name'].'</strong> </p>';
						$Notification = new Notification;
						$Notification->store('', $renewSingleData['user_id'], $loginID, '', $subject, $comment, 0);

						Message::setMessage('successRenewAccept');

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
	public function rejectRequest($data){
		$renewId = $data['renew_info'];
		$renewSingleData = $this->renewSingleData($renewId);
		if($renewSingleData != 'error'){

			$singleData = $this->singleData($renewSingleData['renew_borrow_id']);
			date_default_timezone_set('Asia/Dhaka');

			if($singleData != 'error' && $singleData['is_accept'] == '1' && $renewSingleData['renew_is_accept'] == '0'){

						$query = "DELETE FROM `".PREFIX."renew` WHERE `id` = :id LIMIT 1";
						$statement = $this->conn->prepare($query); //prepare the sql query
						$statement->bindParam(':id', $renewId);
					if($statement->execute()){
						$loginID = Login::loginGet('userid');
						$subject = "Rejected your request of renew book";
						$comment = '<p> your requested for renew book has been rejected. </p>
												<p> Borrow no: <strong>'.$renewSingleData['borrow_id'].'</strong> </p>
												<p> Book name: <strong>'.$renewSingleData['book_name'].'</strong> </p>
													';
						$Notification = new Notification;
						$Notification->store('', $renewSingleData['user_id'], $loginID, '',  $subject, $comment, 0);

						if(trim($data['cameFrom']) == "show"){
							Message::setMessage('successRenewReject');
						}
						$msg = "success";
						return $msg;
					}else {
						$msg = "unsuccess";
						return $msg;
					}
			}else {
				return 'error';
			}
		}else {
			return 'error';
		}
	}
	public function deleteRequest($data){


		$checkedrenewrequest = $data['checkedrenewrequest'];
		foreach ($checkedrenewrequest as $eachRenewReq) {
			$renewSingleData = $this->renewSingleData($eachRenewReq);
			if($renewSingleData == 'error'){
				return "error";
				exit();
			}
			if($renewSingleData['renew_is_accept'] == '0'){
				return "notpermission";
				exit();
			}
		}
		$ids = implode(",", $checkedrenewrequest);

		$query = "DELETE FROM `".PREFIX."renew` WHERE `id` IN(".$ids.")";
		$statement = $this->conn->prepare($query); //prepare the sql query
		if($statement->execute()){
			if(trim($data['cameFrom']) == "show"){
				Message::setMessage('successRenewDelete');
			}
			$msg = "success";
			return $msg;
		}else {
			$msg = "unsuccess";
			return $msg;
		}
	}
}
