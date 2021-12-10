<?php
namespace App\Student;
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Database\Database;
use App\Login\Login;
use App\Utility\Message;
use App\Faculty\Faculty;
use App\Notification\Notification;
use PDO;
 // import the Intervention Image Manager Class
use Intervention\Image\ImageManager;

//import phpmailer class
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Student{
	protected $conn;
	protected $studentName;
	protected $userName;
	protected $studentId;
	protected $faculty;
	protected $gender;
	protected $studentbatch;
	protected $studentMobile;
	protected $studentEmail;
	protected $studentPassword;
	protected $address;

	public function __construct(){
		$db = new Database();
		$this->conn = $db->connection();
	}

	public function storeVariable($data){
		$this->studentName 			= $this->filter($data['studentName']);
		$this->studentId 				= $this->filter($data['studentId']);
		$this->faculty 					= $this->filter(!isset($data['faculty']) ? "" : $data['faculty']);
		$this->gender 					= $this->filter(!isset($data['gender']) ? '' : $data['gender']);
		$this->studentbatch 		= $this->filter($data['studentbatch']);
		$this->studentMobile 		= $this->filter($data['studentMobile']);
		$this->studentEmail 		= $this->filter($data['studentEmail']);
		$this->studentPassword	= $this->filter($data['studentPassword']);
		$this->address					= $this->filter($data['address']);
	}

	public function registerStudent($data, $files){

		// asign all the data in a variable with validation & validation did in another method
		$this->storeVariable($data);

		// Validation all data
		$dataValidation = $this->dataValidation("register");
		if(isset($dataValidation)){
			return $dataValidation;
		}else{
			// Get the picture info if insert
			if(isset($files['studentPicture']['size']) && $files['studentPicture']['size'] != ""){
				$studentPicture = $files['studentPicture']['name'];
				$pictureTmp			= $files['studentPicture']['tmp_name'];
				$pictureSize 		= $files['studentPicture']['size'];
				$pictureType 		= $files['studentPicture']['type'];


				if($pictureType === 'image/jpeg' || $pictureType === 'image/png' || $pictureType === 'image/jpg'){
					$pictureExtension = pathinfo($studentPicture, PATHINFO_EXTENSION); //get the extension of a picture name
					$studentPicture 	= uniqid().".".$pictureExtension; //set the picture name by create unique random name

					$pictureDestination = UPLOADUSER.$studentPicture; //set the picture destination folder for store picture
					move_uploaded_file($pictureTmp, $pictureDestination); //Move the picture from tmp folder into destination folder which set previous line.

					// create an image manager instance with favored gd library
					$manager = new ImageManager(array('driver' => 'gd'));

					// to finally create image instances
					$image = $manager->make($pictureDestination)->fit(300, 300, function ($constraint) {
					                    $constraint->upsize();
					                  });
					$image->save($pictureDestination);
				}else{
					$msg = "studentimg";
					return $msg;
					exit();
				}
			}else {
				$studentPicture = "";
			}

			// Generate Slug
			$slug 	= $this->generateSlug($this->studentName);
			$status = 1; //Declar '1' by default in `status` row in table

			if(isset($data['cameFrom']) && $data['cameFrom'] === 'admin'){
				$adminVerified = 1; //Declar '1' by default in `verified` row in table
				$emailVerified = 1;
				$e_verify_code = NULL;
				$e_verify_code_exp = NULL;
			}elseif (isset($data['cameFrom']) && $data['cameFrom'] === 'front') {
				$adminVerified = 0; //Declar '1' by default in `verified` row in table
				$emailVerified = 0;

				$uniqid = uniqid(); //generate uniqid
				$e_verify_code =  substr(strrev($uniqid), 0, 6); //put only 6 charecter

				date_default_timezone_set("Asia/Dhaka"); //set the timezone
				$startdate = date("Y-m-d H:i:s", time()); //set the time for start datetime
				$strtotime = strtotime('+15 minutes', strtotime($startdate));
				$e_verify_code_exp = date('Y-m-d H:i:s', $strtotime);

				// date_default_timezone_set("Asia/Dhaka"); //set the timezone
				// $startdate = date("Y:m:d, H:i:s", time()); //set the time for start datetime
				// $e_verify_code_exp = $startdate + 1500; //add 15 minute for expire datatime of email verification code
			}else {
				return "error";
				exit();
			}

			$this->studentPassword = password_hash($this->studentPassword, PASSWORD_DEFAULT);

			$query = "INSERT INTO `".PREFIX."students` (`name`, `slug`, `student_id`, `picture`, `faculty`, `batch`, `gender`, `mobile`, `address`, `email`, `password`, `status`, `admin_verified`, `email_verified`, `e_verify_code`, `e_verify_code_exp`) VALUES (:name, :slug, :student_id, :picture, :faculty, :batch, :gender, :mobile, :address, :email, :password, :status, :admin_verified, :email_verified, :e_verify_code, :e_verify_code_exp)";
			$statement = $this->conn->prepare($query); //prepare the sql query
			$statement->bindParam(':name', $this->studentName);
			$statement->bindParam(':slug', $slug);
			$statement->bindParam(':student_id', $this->studentId);
			$statement->bindParam(':picture', $studentPicture);
			$statement->bindParam(':faculty', $this->faculty);
			$statement->bindParam(':batch', $this->studentbatch);
			$statement->bindParam(':gender', $this->gender);
			$statement->bindParam(':mobile', $this->studentMobile);
			$statement->bindParam(':address', $this->address);
			$statement->bindParam(':email', $this->studentEmail);
			$statement->bindParam(':password', $this->studentPassword);
			$statement->bindParam(':status', $status);
			$statement->bindParam(':admin_verified', $adminVerified);
			$statement->bindParam(':email_verified', $emailVerified);
			$statement->bindParam(':e_verify_code', $e_verify_code);
			$statement->bindParam(':e_verify_code_exp', $e_verify_code_exp);
			$result = $statement->execute();
			$last_id = $this->conn->lastInsertId();

			if($result){
				if (isset($data['cameFrom']) && $data['cameFrom'] === 'front') {
					$sendMail = $this->sendMail($this->studentEmail, $this->studentName, $e_verify_code);


					if($sendMail == 'success'){
						$subject = "Requested for approve new account";
						$comment = '<p>A student registered an account. Verify the account for approve</p>
					  <a href="'.ADMINVIEW.'student/show.php?student_show='.urlencode($slug).'" class="btn btn-sm btn-primary">Verify Now</a>';
						$page_permission = 2;
						$Notification = new Notification;
						$Notification->store($last_id, "", "", "", $subject, $comment, $page_permission);

						Login::loginSet('slug', $slug);
						Login::loginSet('email', $this->studentEmail);
						Login::loginSet('action', 'verify');
						Login::loginSet('session_expire', $e_verify_code_exp);
						$msg = "success";
						return $msg;
					}else {
						return "error";
					}
				}else {
					Message::setMessage('success');
					return 'success';
				}

			}else{
				$msg = "error";
				return $msg;
			}
		}
	}
	public function generateSlug($data){
		$strReplace = str_replace(" ", "-", $data);
		$userName 	= strtolower($strReplace);


		$searchUser = "SELECT `slug` FROM `".PREFIX."students` WHERE `slug` = :slug";
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

			$searchUser = "SELECT `slug` FROM `".PREFIX."students` WHERE `slug` = :slug";
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
	public function dataValidation($method){
		// Start: Validation name
		if($this->studentName == ""){ // If name is empty
			$msg = "nameempty";
			return $msg;
		}
		if(!preg_match("/^[a-zA-Z ]*$/", $this->studentName)){ // If name is not alphabet
			$msg = "studentname";
			return $msg;
		}
		//End

		// Start: Validation Student Id
		if($this->studentId == ""){  // If student id is empty
			$msg = "idempty";
			return $msg;
		}
		if(strlen($this->studentId) > 20){  // If student id is more than 20
			$msg = "invalidid";
			return $msg;
		}
		//End

		// Start: Validation Student Faculty
		if($this->faculty == ""){
			$msg = "facultyempty";
			return $msg;
		}
		$Faculty = new Faculty();
		$allFaculty = $Faculty->allFaculty();
		$allFacultyId = array();
		foreach ($allFaculty as $eachFaculty) {
			array_push($allFacultyId, $eachFaculty['id']);
		}
		if(!in_array($this->faculty, $allFacultyId)){
			return  "faculty";
		}
		//End

		//Start: Student Batch validation
		if($this->studentbatch == ""){  // If student id is empty
			$msg = "batchempty";
			return $msg;
		}
		if(strlen($this->studentbatch) > 20){  // If student id is more than 20
			$msg = "invalibatch";
			return $msg;
		}
		//End

		//Start: Validation gender
		if($this->gender == ""){  // If gender is empty
			$msg = "genderempty";
			return $msg;
		}
		if(!preg_match("/^[123]$/", $this->gender)){ //if gender value is between 1 2 3
			$msg = "gender";
			return $msg;
		}

		// ENd

		//Start: Validation Mobile Number
		if(isset($this->studentMobile) && $this->studentMobile !== ""){
			if(!preg_match("/^(?:\+?88)?01[15-9]\d{8}$/", $this->studentMobile)){
			  return "mobile";
			}
		}
		//End

		//start Validation Email
		if($this->studentEmail == ""){
			$msg = "emailempty";
			return $msg;
		}
		if(filter_var($this->studentEmail, FILTER_VALIDATE_EMAIL) === false){ // If Email id format is invalid
			$msg = "email";
			return $msg;
		}
		if($method == "register"){
			$searchEmail = $this->searchEmail($this->studentEmail); // If Email address already exists
			if($searchEmail == true){
				$msg = "emailalready";
				return $msg;
			}
		}
		//End

		//Start: Validatipon Password
		if($this->studentPassword == ""){
			$msg = "passwordempty";
			return $msg;
		}
		if(strlen($this->studentPassword) > 60 || strlen($this->studentPassword) < 8){
			$msg = "password";
			return $msg;
		}
		//End

		// Validation Address
		if(isset($this->address) && $this->address !== ""){
			if(strlen($this->address) > 60){
				$msg = "address";
				return $msg;
			}
		}
		//End
	}
	public function sendMail($recipient_mail, $recipient_name, $security_code){
		$mail = new PHPMailer(true);
		try {
				//Server settings
				$mail->SMTPDebug = 0;                      // Enable verbose debug output
				$mail->isSMTP();                                            // Send using SMTP
				$mail->Host       = 'smtp.gmail.com';                    		// Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = 'techjishat@gmail.com';          // SMTP username
				$mail->Password   = 'stjARJtjastj94';                        	// SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
				$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

				//Recipients
				$mail->setFrom('techjishat@gmail.com', 'Library Management System');
				$mail->addAddress($recipient_mail, $recipient_name);     // Add a recipient
				// $mail->addAddress('ellen@example.com');               // Name is optional
				$mail->addReplyTo('techjishat@gmail.com', 'Information');
				// $mail->addCC('cc@example.com');
				// $mail->addBCC('bcc@example.com');

				// Attachments
				// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
				// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

				// Content
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = 'Verify your email address';
				$mail->Body    = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
														<html xmlns="http://www.w3.org/1999/xhtml">
														<head>
														  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
														  <meta name="viewport" content="width=device-width, initial-scale=1" />
														  <title>Library Management</title>

														  <style type="text/css">img{max-width:600px;outline:0;text-decoration:none;-ms-interpolation-mode:bicubic}a img{border:none}table{border-collapse:collapse!important}#outlook a{padding:0}.ReadMsgBody{width:100%}.ExternalClass{width:100%}.backgroundTable{margin:0 auto;padding:0;width:100%!important}table td{border-collapse:collapse}.ExternalClass *{line-height:115%}.container-for-gmail-android{min-width:600px}*{font-family:Helvetica,Arial,sans-serif}body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;margin:0!important;height:100%;color:#676767}td{font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#777;text-align:center;line-height:21px}a{color:#676767;text-decoration:none!important}.pull-left{text-align:left}.pull-right{text-align:right}.header-lg,.header-md,.header-sm{font-size:32px;font-weight:700;line-height:normal;padding:35px 0 0;color:#4d4d4d}.header-md{font-size:24px}.header-sm{padding:5px 0;font-size:18px;line-height:1.3}.content-padding{padding:20px 0 0}.mobile-header-padding-right{width:290px;text-align:right;padding-left:10px}.mobile-header-padding-left{width:290px;text-align:left;padding-left:10px}.free-text{width:100%!important;padding:10px 60px 0}.block-rounded{border-radius:5px;border:1px solid #e5e5e5;vertical-align:top}.button{padding:55px 0 0}.button a{background-color:#007bff; border:1px solid #007bff; border-radius:5px;color:#ffffff;display:inline-block;font-family:"Cabin", Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;}.info-block{padding:0 20px;width:260px}.mini-block-container{padding:30px 50px;width:500px}.mini-block{background-color:#fff;width:498px;border:1px solid #ccc;border-radius:5px;padding:60px 75px}.block-rounded{width:260px}.info-img{width:258px;border-radius:5px 5px 0 0}.force-width-img{width:480px;height:1px!important}.force-width-full{width:600px;height:1px!important}.user-img img{width:82px;border-radius:5px;border:1px solid #ccc}.user-img{width:92px;text-align:left}.user-msg{width:236px;font-size:14px;text-align:left;font-style:italic}.code-block{padding:10px 0;border:1px solid #ccc;color:#4d4d4d;font-weight:700;font-size:18px;text-align:center}.force-width-gmail{min-width:600px;height:0!important;line-height:1px!important;font-size:1px!important}.button-width{width:228px}</style>
														  <style type="text/css" media="screen">
														    @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
														  </style>
														  <style type="text/css" media="screen">
														    @media screen {
														      * {
														        font-family: "Oxygen", "Helvetica Neue", "Arial", "sans-serif" !important;
														      }
														    }
														  </style>
														  <style type="text/css" media="only screen and (max-width: 480px)">@media only screen and (max-width:480px){table[class*=container-for-gmail-android]{min-width:290px!important;width:100%!important}table[class=w320]{width:320px!important}img[class=force-width-gmail]{display:none!important;width:0!important;height:0!important}a[class=button-mobile],a[class=button-width]{width:248px!important}td[class*=mobile-header-padding-left]{width:160px!important;padding-left:0!important}td[class*=mobile-header-padding-right]{width:160px!important;padding-right:0!important}td[class=header-lg]{font-size:24px!important;padding-bottom:5px!important}td[class=header-md]{font-size:18px!important;padding-bottom:5px!important}td[class=content-padding]{padding:5px 0!important}td[class=button]{padding:15px 0 5px!important}td[class*=free-text]{padding:10px 18px 30px!important}img[class=force-width-full],img[class=force-width-img]{display:none!important}td[class=info-block]{display:block!important;width:280px!important;padding-bottom:40px!important}img[class=info-img],td[class=info-img]{width:278px!important}td[class=mini-block-container]{padding:8px 20px!important;width:280px!important}td[class=mini-block]{padding:20px!important}td[class=user-img]{display:block!important;text-align:center!important;width:100%!important;padding-bottom:10px}td[class=user-msg]{display:block!important;padding-bottom:20px!important}}</style>
														</head>
														<body bgcolor="#f7f7f7">
														<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
														  <tr>
														    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
														      <center>
														        <table cellspacing="0" cellpadding="0" width="600" class="w320">
														          <tr>
														            <td class="header-lg">
														              Verify your email address
														            </td>
														          </tr>
														          <tr>
														            <td class="free-text">
														              To register your account, we just need to make sure this email address is yours.
														            </td>
														          </tr>
														          <tr>
														            <td class="mini-block-container">
														              <table cellspacing="0" cellpadding="0" width="100%"  style="border-collapse:separate !important;">
														                <tr>
														                  <td class="mini-block">
														                    <table cellpadding="0" cellspacing="0" width="100%">
														                      <tr>
														                        <td style="padding-bottom: 30px;">
														                          To verify your email address use this security code:
																				            </td>
														                      </tr>
														                      <tr>
														                        <td class="code-block">
														                          '.$security_code.'
														                        </td>
														                      </tr>
														                      <tr>
														                        <td class="button">
														                          <div><!--[if mso]>
														                            <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="'.WEBROOT.'verify.php" style="height:45px;v-text-anchor:middle;width:155px;" arcsize="15%" strokecolor="#ffffff" fillcolor="#ff6f6f">
														                              <w:anchorlock/>
														                              <center style="color:#ffffff;font-family:Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;">Shop Now</center>
														                            </v:roundrect>
														                          <![endif]-->
																				                 <a class="button-mobile" href="'.WEBROOT.'verify.php"
														                             class="actionBtn"> Verify Now </a></div>
														                        </td>
														                      </tr>
														                    </table>
														                  </td>
														                </tr>
														              </table>
														            </td>
														          </tr>
														        </table>
														      </center>
														    </td>
														  </tr>
														  <tr>
														    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7; height: 100px;">
														      <center>
														        <table cellspacing="0" cellpadding="0" width="600" class="w320">
														          <tr>
														            <td style="padding: 25px 0 25px">
																		<strong>Thanks</strong><br />
																		Library Management System
														            </td>
														          </tr>
														        </table>
														      </center>
														    </td>
														  </tr>
														</table>
														</body>
														</html>';
				// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				$mail->send();
				return 'success';
		} catch (Exception $e) {
				return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
	public function sendMailForAccountConfirmation($recipient_mail, $recipient_name, $subject, $msg){
		$mail = new PHPMailer(true);
		try {
				//Server settings
				$mail->SMTPDebug = 0;                      // Enable verbose debug output
				$mail->isSMTP();                                            // Send using SMTP
				$mail->Host       = 'smtp.gmail.com';                    		// Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = 'techjishat@gmail.com';          // SMTP username
				$mail->Password   = 'stjARJtjastj94';                        	// SMTP password

				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
				$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

				//Recipients
				$mail->setFrom('techjishat@gmail.com', 'Library Management System');
				$mail->addAddress($recipient_mail, $recipient_name);     // Add a recipient
				// $mail->addAddress('ellen@example.com');               // Name is optional
				$mail->addReplyTo('techjishat@gmail.com', 'Information');
				// $mail->addCC('cc@example.com');
				// $mail->addBCC('bcc@example.com');

				// Attachments
				// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
				// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

				// Content
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = $subject;
				$mail->Body    = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
														<html xmlns="http://www.w3.org/1999/xhtml">
														<head>
														  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
														  <meta name="viewport" content="width=device-width, initial-scale=1" />
														  <title>Library Management</title>

														  <style type="text/css">img{max-width:600px;outline:0;text-decoration:none;-ms-interpolation-mode:bicubic}a img{border:none}table{border-collapse:collapse!important}#outlook a{padding:0}.ReadMsgBody{width:100%}.ExternalClass{width:100%}.backgroundTable{margin:0 auto;padding:0;width:100%!important}table td{border-collapse:collapse}.ExternalClass *{line-height:115%}.container-for-gmail-android{min-width:600px}*{font-family:Helvetica,Arial,sans-serif}body{-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;width:100%!important;margin:0!important;height:100%;color:#676767}td{font-family:Helvetica,Arial,sans-serif;font-size:14px;color:#777;text-align:center;line-height:21px}a{color:#676767;text-decoration:none!important}.pull-left{text-align:left}.pull-right{text-align:right}.header-lg,.header-md,.header-sm{font-size:32px;font-weight:700;line-height:normal;padding:35px 0 0;color:#4d4d4d}.header-md{font-size:24px}.header-sm{padding:5px 0;font-size:18px;line-height:1.3}.content-padding{padding:20px 0 0}.mobile-header-padding-right{width:290px;text-align:right;padding-left:10px}.mobile-header-padding-left{width:290px;text-align:left;padding-left:10px}.free-text{width:100%!important;padding:10px 60px 0}.block-rounded{border-radius:5px;border:1px solid #e5e5e5;vertical-align:top}.button{padding:55px 0 0}.button a{background-color:#007bff; border:1px solid #007bff; border-radius:5px;color:#ffffff;display:inline-block;font-family:"Cabin", Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all;}.info-block{padding:0 20px;width:260px}.mini-block-container{padding:30px 50px;width:500px}.mini-block{background-color:#fff;width:498px;border:1px solid #ccc;border-radius:5px;padding:60px 75px}.block-rounded{width:260px}.info-img{width:258px;border-radius:5px 5px 0 0}.force-width-img{width:480px;height:1px!important}.force-width-full{width:600px;height:1px!important}.user-img img{width:82px;border-radius:5px;border:1px solid #ccc}.user-img{width:92px;text-align:left}.user-msg{width:236px;font-size:14px;text-align:left;font-style:italic}.code-block{padding:10px 0;border:1px solid #ccc;color:#4d4d4d;font-weight:700;font-size:18px;text-align:center}.force-width-gmail{min-width:600px;height:0!important;line-height:1px!important;font-size:1px!important}.button-width{width:228px}</style>
														  <style type="text/css" media="screen">
														    @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
														  </style>
														  <style type="text/css" media="screen">
														    @media screen {
														      * {
														        font-family: "Oxygen", "Helvetica Neue", "Arial", "sans-serif" !important;
														      }
														    }
														  </style>
														  <style type="text/css" media="only screen and (max-width: 480px)">@media only screen and (max-width:480px){table[class*=container-for-gmail-android]{min-width:290px!important;width:100%!important}table[class=w320]{width:320px!important}img[class=force-width-gmail]{display:none!important;width:0!important;height:0!important}a[class=button-mobile],a[class=button-width]{width:248px!important}td[class*=mobile-header-padding-left]{width:160px!important;padding-left:0!important}td[class*=mobile-header-padding-right]{width:160px!important;padding-right:0!important}td[class=header-lg]{font-size:24px!important;padding-bottom:5px!important}td[class=header-md]{font-size:18px!important;padding-bottom:5px!important}td[class=content-padding]{padding:5px 0!important}td[class=button]{padding:15px 0 5px!important}td[class*=free-text]{padding:10px 18px 30px!important}img[class=force-width-full],img[class=force-width-img]{display:none!important}td[class=info-block]{display:block!important;width:280px!important;padding-bottom:40px!important}img[class=info-img],td[class=info-img]{width:278px!important}td[class=mini-block-container]{padding:8px 20px!important;width:280px!important}td[class=mini-block]{padding:20px!important}td[class=user-img]{display:block!important;text-align:center!important;width:100%!important;padding-bottom:10px}td[class=user-msg]{display:block!important;padding-bottom:20px!important}}</style>
														</head>
														<body bgcolor="#f7f7f7">
														<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
														  <tr>
														    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
														      <center>
														        <table cellspacing="0" cellpadding="0" width="600" class="w320">
														          <tr>
														            <td class="header-lg">
														              '.$subject.'
														            </td>
														          </tr>
														          <tr>
														            <td class="free-text">
														              Hey <strong>'.$recipient_name.'</strong>, '.$msg.'
														            </td>
														          </tr>
														        </table>
														      </center>
														    </td>
														  </tr>
														  <tr>
														    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7; height: 100px;">
														      <center>
														        <table cellspacing="0" cellpadding="0" width="600" class="w320">
														          <tr>
														            <td style="padding: 25px 0 25px">
																		<strong>Thanks</strong><br />
																		Library Management System
														            </td>
														          </tr>
														        </table>
														      </center>
														    </td>
														  </tr>
														</table>
														</body>
														</html>';
				// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				$mail->send();
				return 'success';
		} catch (Exception $e) {
				return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
	public function resendVerifyCode(){
		$slug = Login::loginGet('slug');
		$email = Login::loginGet('email');
		$singleData = $this->singleData($slug);
		if($singleData != 'error'){
			$uniqid = uniqid(); //generate uniqid
			$e_verify_code =  substr(strrev($uniqid), 0, 6); //put only 6 charecter

			date_default_timezone_set("Asia/Dhaka"); //set the timezone
			$startdate = date("Y-m-d H:i:s", time()); //set the time for start datetime
			$strtotime = strtotime('+15 minutes', strtotime($startdate));
			$e_verify_code_exp = date('Y-m-d H:i:s', $strtotime);

			$query = "UPDATE `".PREFIX."students`
			SET `e_verify_code` = :e_verify_code, `e_verify_code_exp` = :e_verify_code_exp
			WHERE `slug` = :slug";
			$statement = $this->conn->prepare($query); //prepare the sql query
			$statement->bindParam(':e_verify_code', $e_verify_code);
			$statement->bindParam(':e_verify_code_exp', $e_verify_code_exp);
			$statement->bindParam(':slug', $slug);
			$result = $statement->execute();
			if($result){
				$sendMail = $this->sendMail($email, $singleData['name'], $e_verify_code);
				if($sendMail == 'success'){
					Login::loginSet('session_expire', $e_verify_code_exp);
					$msg = "success";
					return $msg;
				}else {
					return "error";
				}
			}else{
				return 'error';
			}
		}else{
			return 'error';
		}
	}
	public function verifyEmail($data){
		$slug 					= Login::loginGet('slug');
		$email 					= Login::loginGet('email');

		$securityCode 	= $data['securityCode'];
		$singleData 		= $this->singleData($slug);

		if($singleData != 'error'){
			$getExpiryTime  = date('YmdHis', strtotime($singleData['e_verify_code_exp']));
		  $timeNow        = date('YmdHis', time());
		  if($timeNow >=  $getExpiryTime){
		    return 'expire';
		  }else{
				if($singleData['e_verify_code'] === $securityCode){
					if(Login::loginGet('action_from') && Login::loginGet('action_from') == 'profile_update'){
						$e_verify_code = NULL;
						$e_verify_code_exp = NULL;
						$query = "UPDATE `".PREFIX."students`
						SET `e_verify_code` = :e_verify_code, `e_verify_code_exp` = :e_verify_code_exp, `email` = :email
						WHERE `slug` = :slug LIMIT 1";
						$statement = $this->conn->prepare($query); //prepare the sql query
						$statement->bindParam(':e_verify_code', $e_verify_code);
						$statement->bindParam(':e_verify_code_exp', $e_verify_code_exp);
						$statement->bindParam(':email', $email);
						$statement->bindParam(':slug', $slug);
						$result = $statement->execute();
						if($result){
							$msg = "successverify";
							return $msg;
						}else{
							return 'error';
						}

					}else {
						$email_verified = 1;
						$e_verify_code = NULL;
						$e_verify_code_exp = NULL;
						$query = "UPDATE `".PREFIX."students`
						SET `email_verified` = :email_verified, `e_verify_code` = :e_verify_code, `e_verify_code_exp` = :e_verify_code_exp
						WHERE `slug` = :slug AND `email` = :email";
						$statement = $this->conn->prepare($query); //prepare the sql query
						$statement->bindParam(':email_verified', $email_verified);
						$statement->bindParam(':e_verify_code', $e_verify_code);
						$statement->bindParam(':e_verify_code_exp', $e_verify_code_exp);
						$statement->bindParam(':slug', $slug);
						$statement->bindParam(':email', $email);
						$result = $statement->execute();
						if($result){
							Login::loginSet('action', 'success');
							$msg = "success";
							return $msg;
						}else{
							return 'error';
						}
					}


				}else{
					return "notmatch";
				}
			}
		}else{
			return 'error';
		}
	}
	public function searchEmail($data){ //Helper function for search email from database
		$query = "SELECT `email` FROM `".PREFIX."students` WHERE `email` = :email LIMIT 1";
		$stmnt  = $this->conn->prepare($query);
		$stmnt->bindParam(':email', $data);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);
		if($result){
			return true;
		}else{
			return false;
		}
	}
	public function searchPassword(){ //Helper function for search password from database for login
		$query = "SELECT `student_password` FROM `students` WHERE `student_password` = :password AND `student_email` = :email";
		$stmnt  = $this->conn->prepare($query);
		$stmnt->bindParam(':password', md5($this->studentPassword));
		$stmnt->bindParam(':email', $this->studentEmail);
		$stmnt->execute();
		$result = $stmnt->fetch(PDO::FETCH_ASSOC);

		if($result){
			return true;
		}else{
			return false;
		}
	}
	public function allStudents(){
		// $query = "SELECT * FROM `".PREFIX."students` ORDER BY `id` DESC";
		$query = "SELECT `allstudent`.*, `allfaculty`.`faculty_name`
							FROM `".PREFIX."students` as `allstudent`
							LEFT JOIN `".PREFIX."faculty` as `allfaculty`
							ON `allstudent`.`faculty` = `allfaculty`.`id` ORDER BY `id` DESC";
		$stmnt = $this->conn->prepare($query);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return "error";
		}
	}
	public function limitedStudents($start_from, $per_page){
		$query = "SELECT * FROM `students` ORDER BY `id` DESC  LIMIT $start_from, $per_page ";
		$stmnt = $this->conn->prepare($query);
		//$stmnt->bindParam(':start_from', $start_from);
		//$stmnt->bindParam(':per_page', $per_page);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	public function singleData($slug){
		$query = "SELECT `allstudent`.*, `allfaculty`.`faculty_name`
							FROM `".PREFIX."students` as `allstudent`
							LEFT JOIN `".PREFIX."faculty` as `allfaculty`
							ON `allstudent`.`faculty` = `allfaculty`.`id` WHERE `allstudent`.`slug` = :slug LIMIT 1";
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
	public function singleDataById($id){
		$query = "SELECT `allstudent`.*, `allfaculty`.`faculty_name`
							FROM `".PREFIX."students` as `allstudent`
							LEFT JOIN `".PREFIX."faculty` as `allfaculty`
							ON `allstudent`.`faculty` = `allfaculty`.`id` WHERE `allstudent`.`id` = :id LIMIT 1";
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
	public function updateStuInfo($data, $files){

		if( isset($data['stdInfoid']) && $data['stdInfoid'] != ''){
			$id = $data['stdInfoid'];
			$singleData = $this->singleDataById($id);
			if($singleData == "error"){
				return "error";
			}else {
				$this->storeVariable($data); // asign all the data in a variable with validation & validation did in another method
				$method = "update";
				$dataValidation = $this->dataValidation($method); // Validation all data
				if(isset($dataValidation)){
					return $dataValidation;
				}else{

					// check email address if input new
					if($singleData['email'] != $this->studentEmail){
						// If Email address already exists
						$searchEmail = $this->searchEmail($this->studentEmail);
						if($searchEmail == true){
							$msg = "emailalready";
							return $msg;
						}
					}

					// restore password again in a variable
					$getPassword = $this->studentPassword;

					// check Password if input new
					if($singleData['password'] != $getPassword){
						$getPassword = password_hash($getPassword, PASSWORD_DEFAULT);
					}
					$studentPicture 	= $singleData['picture'];// Get the picture name which already stored in database
					if(trim($data['dataImgDelete']) == "1"){
						$studentPicture = "";
					}else{
						if(!empty($files['studentPicture']['name']) && $files['studentPicture']['size'] > 0){

							// Get the new picture info
							$pictureTmp		= $files['studentPicture']['tmp_name'];
							$pictureSize 	= $files['studentPicture']['size'];
							$pictureType 	= $files['studentPicture']['type'];

							if($pictureType === 'image/jpeg' || $pictureType === 'image/png' || $pictureType === 'image/jpg'){
								if(isset($studentPicture) && $studentPicture != ""){
									unlink(UPLOADUSER.$studentPicture); // Delete previous image
								}
								$studentPicture 	= $files['studentPicture']['name']; //Restore new image name in variable
								$pictureExtension = pathinfo($studentPicture, PATHINFO_EXTENSION); //get the extension of a picture name

								$studentPicture 	= uniqid().strtotime("now").".".$pictureExtension; //set the picture name by create unique random name

								$pictureDestination = UPLOADUSER.$studentPicture; //set the picture destination folder for store picture
								move_uploaded_file($pictureTmp, $pictureDestination); //Move the picture from tmp folder into destination folder which set previous line.

								// create an image manager instance with favored gd library
								$manager = new ImageManager(array('driver' => 'gd'));

								// to finally create image instances
								$image = $manager->make($pictureDestination)->fit(300, 300, function ($constraint) {
								                    $constraint->upsize();
								                  });

								$image->save($pictureDestination);
							}else{
								$msg = "studentimg";
								return $msg;
							}
						}
					}

					// Generate Slug
					if(strtolower(str_replace(' ','',$singleData['name'])) != strtolower(str_replace(' ','',$this->studentName))){
						$slug = $this->generateSlug($this->studentName);
					}else {
						$slug = trim($singleData['slug']);
					}

					date_default_timezone_set("Asia/Dhaka"); //set the timezone
					$date = date("Y:m:d H:i:s", time()); //set the time for record update time

					$query = "UPDATE `".PREFIX."students`
					SET `name` = :name, `slug` = :slug, `student_id` = :student_id, `picture` = :picture, `faculty` = :faculty, `batch` = :batch, `gender` = :gender, `mobile` = :mobile, `address` = :address, `email` = :email, `password` = :password, `update_at` = :update_at
					WHERE `id` = :id";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':name', $this->studentName);
					$statement->bindParam(':slug', $slug);
					$statement->bindParam(':student_id', $this->studentId);
					$statement->bindParam(':picture', $studentPicture);
					$statement->bindParam(':faculty', $this->faculty);
					$statement->bindParam(':batch', $this->studentbatch);
					$statement->bindParam(':gender', $this->gender);
					$statement->bindParam(':mobile', $this->studentMobile);
					$statement->bindParam(':address', $this->address);
					$statement->bindParam(':email', $this->studentEmail);
					$statement->bindParam(':password', $getPassword);
					$statement->bindParam(':update_at', $date);
					$statement->bindParam(':id', $id);
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
					$query 	= "UPDATE `".PREFIX."students` SET `status` = :status WHERE `id` = :id";
					$statement = $this->conn->prepare($query); //prepare the sql query
					$statement->bindParam(':status', $input_status);
					$statement->bindParam(':id', $id);
					$result = $statement->execute();
					if($result){
						$msg = "success";
						return $msg;
					}else{
						$msg = "error";
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
	public function approve($data){
		if( isset($data['id']) && $data['id'] != ''){
			$id 		= $data['id'];
			$singleData = $this->singleDataById($id);
			if ($singleData == 'error') {
				$msg = "error";
				return $msg;
			}else{
				$admin_verified = 1;
				$query 	= "UPDATE `".PREFIX."students` SET `admin_verified` = :admin_verified WHERE `id` = :id";
				$statement = $this->conn->prepare($query); //prepare the sql query
				$statement->bindParam(':admin_verified', $admin_verified);
				$statement->bindParam(':id', $id);
				$result = $statement->execute();
				if($result){
					$Notification = new Notification;
					$Notification->deleteNotificationByUser($id); //delete the notification.

					$subject = 'Approved your account';
					$message = 'Congrates! your account has been approved. Now, you can login.';
					$sendMail = $this->sendMailForAccountConfirmation($singleData['email'], $singleData['name'], $subject, $message);
					if($sendMail == 'success'){
						$msg = "success";
						return $msg;
					}else{
						$msg = "unsuccess";
						return $msg;
					}
				}else{
					$msg = "error";
					return $msg;
				}
			}
		}else{
			$msg = "error";
			return $msg;
		}
	}
	public function delete($data){
		if(!empty($data['stdinfo']) && !empty($data['stdDeleteSubmit'])){
			$userId 		= $data['stdinfo'];
			$singleData = $this->singleDataById($userId);
			if($singleData !== "error"){
				$query = "DELETE FROM `".PREFIX."students` WHERE `".PREFIX."students`.`id` = :id";
				$statement = $this->conn->prepare($query); //prepare the sql query
				$statement->bindParam(':id', $userId);
				$result = $statement->execute();
				if($result){
					if(!empty($singleData['picture'])){
						unlink(UPLOADUSER.$singleData['picture']);
					}
					if($data['cameFrom']=="show"){
						Message::setMessage('deletesuccess');
					}
					$msg = "success";
					return $msg;
				}else{
					$msg = "error";
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
	public function reject($data){
		if(!empty($data['stdinfo']) && !empty($data['stdRejectSubmit'])){
			$userId 		= $data['stdinfo'];
			$singleData = $this->singleDataById($userId);
			if($singleData !== "error"){
				$query = "DELETE FROM `".PREFIX."students` WHERE `".PREFIX."students`.`id` = :id";
				$statement = $this->conn->prepare($query); //prepare the sql query
				$statement->bindParam(':id', $userId);
				$result = $statement->execute();
				if($result){
					if(!empty($singleData['picture'])){
						unlink(UPLOADUSER.$singleData['picture']);
					}
					$Notification = new Notification;
					$Notification->deleteNotificationByUser($userId); //delete the notification.

					$subject 	= 'Rejected your account';
					$message 	= 'Unfortunately your account has been rejected for given wrong information. Please register again with correct information.';
					$sendMail = $this->sendMailForAccountConfirmation($singleData['email'], $singleData['name'], $subject, $message);
					if($sendMail == 'success'){
						$msg = "success";
						return $msg;
					}else{
						$msg = "unsuccess";
						return $msg;
					}
				}else{
					$msg = "error";
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
	public function studentLogin($data){
		$this->studentEmail 		= $this->filter($data['email']);
		$this->studentPassword	= $this->filter($data['password']);

		if($this->studentEmail == "" || $this->studentPassword == ""){
			$msg = "empty";
			return $msg;
		}else{
			if(filter_var($this->studentEmail, FILTER_VALIDATE_EMAIL) === false){
				$msg = "invalid";
				return $msg;
			}

			$checkEmail = $this->searchEmail($this->studentEmail);
			if($checkEmail == false){
				$msg = "invalid";
				return $msg;
			}else{
				$query = "SELECT * FROM `".PREFIX."students` WHERE `email` = :email LIMIT 1";
				$stmnt = $this->conn->prepare($query);
				$stmnt->bindParam(':email', $this->studentEmail);
				$stmnt->execute();
				$result = $stmnt->fetch(PDO::FETCH_ASSOC);
				if($result){
					$getStudentPass = $result['password'];
					if(password_verify($this->studentPassword, $getStudentPass)){
						if($result['status'] == 1){
							if ($result['admin_verified'] == 1) {
								Login::loginSet('login', true);
								Login::loginSet('id', $result['id']);
								Login::loginSet('slug', $result['slug']);
								Message::setMessage('successfully');
								$msg = "success";
								return $msg;
							}else{
								$msg = "notverify";
								return $msg;
							}
						}else{
							$msg = "disable";
							return $msg;
						}
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
	public function searchStudent($data){
		$live = '%'.$data['searchdata'].'%';
		$query = "SELECT * FROM `".PREFIX."students` WHERE `name` LIKE :name OR `student_id` LIKE :student_id";
		$stmnt  = $this->conn->prepare($query);
		$stmnt->bindParam(':name', $live);
		$stmnt->bindParam(':student_id', $live);
		// $stmnt->bindParam(':student_id', $data['searchdata']);
		$stmnt->execute();
		$result = $stmnt->fetchAll(PDO::FETCH_ASSOC);
		if($result){
			return $result;
		}else{
			return 'notfound';
		}
	}
	public function updateProfile($data, $files){
		$this->studentEmail 		= $this->filter($data['studentEmail']);
		$this->studentPassword	= $this->filter($data['studentPassword']);
		$this->address					= $this->filter($data['address']);
		$this->studentMobile 		= $this->filter($data['studentMobile']);

		if( isset($this->studentEmail) && $this->studentEmail != ""){
			if (isset($this->studentPassword) && $this->studentPassword != "") {

				if(strlen($this->studentPassword) > 60 || strlen($this->studentPassword) < 8){
					$msg = "password";
					return $msg;
				}

				//Start: Validation Mobile Number
				if(isset($this->studentMobile) && $this->studentMobile != ""){
					if(!preg_match("/^(?:\+?88)?01[15-9]\d{8}$/", $this->studentMobile)){
					  return "mobile";
					}
				}
				//End

				// Validation Address
				if(isset($this->address) && $this->address !== ""){
					if(strlen($this->address) > 60){
						$msg = "address";
						return $msg;
					}
				}
				//End
				$id = Login::loginGet('id');
				$singleData = $this->singleDataById($id);
				if($singleData == "error"){
					return "error";
				}else {
						// restore password again in a variable
						$getPassword = $this->studentPassword;

						// check Password if input new
						if($singleData['password'] != $getPassword){
							$getPassword = password_hash($getPassword, PASSWORD_DEFAULT);
						}
						$studentPicture 	= $singleData['picture'];// Get the picture name which already stored in database
						if(trim($data['dataImgDelete']) == "1"){
							$studentPicture = "";
						}else{
							if(!empty($files['studentPicture']['name']) && $files['studentPicture']['size'] > 0){

								// Get the new picture info
								$pictureTmp		= $files['studentPicture']['tmp_name'];
								$pictureSize 	= $files['studentPicture']['size'];
								$pictureType 	= $files['studentPicture']['type'];

								if($pictureType === 'image/jpeg' || $pictureType === 'image/png' || $pictureType === 'image/jpg'){
									if(isset($studentPicture) && $studentPicture != ""){
										unlink(UPLOADUSER.$studentPicture); // Delete previous image
									}
									$studentPicture 	= $files['studentPicture']['name']; //Restore new image name in variable
									$pictureExtension = pathinfo($studentPicture, PATHINFO_EXTENSION); //get the extension of a picture name

									$studentPicture 	= uniqid().strtotime("now").".".$pictureExtension; //set the picture name by create unique random name

									$pictureDestination = UPLOADUSER.$studentPicture; //set the picture destination folder for store picture
									move_uploaded_file($pictureTmp, $pictureDestination); //Move the picture from tmp folder into destination folder which set previous line.

									// create an image manager instance with favored gd library
									$manager = new ImageManager(array('driver' => 'gd'));

									// to finally create image instances
									$image = $manager->make($pictureDestination)->fit(300, 300, function ($constraint) {
																			$constraint->upsize();
																		});

									$image->save($pictureDestination);
								}else{
									$msg = "studentimg";
									return $msg;
								}
							}
						}

						if(filter_var($this->studentEmail, FILTER_VALIDATE_EMAIL) === false){ // If Email id format is invalid
							$msg = "email";
							return $msg;
						}
						$e_verify_code = NULL;
						$e_verify_code_exp = NULL;

						// check email address if input new
						if(trim($singleData['email']) != trim($this->studentEmail)){
							// If Email address already exists
							$searchEmail = $this->searchEmail($this->studentEmail);
							if($searchEmail == true){
								$msg = "emailalready";
								return $msg;
							}else {
								$uniqid = uniqid(); //generate uniqid
								$e_verify_code =  substr(strrev($uniqid), 0, 6); //put only 6 charecter

								date_default_timezone_set("Asia/Dhaka"); //set the timezone
								$startdate = date("Y-m-d H:i:s", time()); //set the time for start datetime
								$strtotime = strtotime('+15 minutes', strtotime($startdate));
								$e_verify_code_exp = date('Y-m-d H:i:s', $strtotime);

								$sendMail = $this->sendMail($this->studentEmail, $singleData['name'], $e_verify_code);


								if($sendMail == 'success'){
									Login::loginSet('email', $this->studentEmail);
									Login::loginSet('action', 'verify');
									Login::loginSet('session_expire', $e_verify_code_exp);
									Login::loginSet('action_from', 'profile_update');
									$this->studentEmail = $singleData['email'];
									$msg = "succesmail";
								}else {
									return "error";
									exit();
								}


							}
						}

						date_default_timezone_set("Asia/Dhaka"); //set the timezone
						$date = date("Y:m:d H:i:s", time()); //set the time for record update time

						$query = "UPDATE `".PREFIX."students`
						SET `picture` = :picture, `mobile` = :mobile, `address` = :address, `email` = :email, `password` = :password, `e_verify_code` = :e_verify_code, `e_verify_code_exp` = :e_verify_code_exp, `update_at` = :update_at
						WHERE `id` = :id";
						$statement = $this->conn->prepare($query); //prepare the sql query

						$statement->bindParam(':picture', $studentPicture);
						$statement->bindParam(':mobile', $this->studentMobile);
						$statement->bindParam(':address', $this->address);
						$statement->bindParam(':email', $this->studentEmail);
						$statement->bindParam(':password', $getPassword);
						$statement->bindParam(':e_verify_code', $e_verify_code);
						$statement->bindParam(':e_verify_code_exp', $e_verify_code_exp);
						$statement->bindParam(':update_at', $date);
						$statement->bindParam(':id', $id);
						$result = $statement->execute();

						if($result){
							if(isset($msg) && $msg == "succesmail"){
								$msg = "succesmail";
								return $msg;
							}else {
								$msg = "success";
								return $msg;
							}
						}else{
							$msg = "unsuccess";
							return $msg;
						}
				}

			}else {
				return "passwordempty";
			}
		}else {
			return "emailempty";
		}
	}
}
