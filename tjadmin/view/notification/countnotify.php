<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php'); 
use Ciu\Notification\Notification;
?>

<?php 
$Notification = new Notification();
$unseenNotification = $Notification->unseenNotification();

date_default_timezone_set("Asia/Dhaka"); //set the timezone
$now = date("d-M-Y, H:i:s", time());
$totalnow = date("Ymdhis", time());

$time = date("d-M-Y, H:i:s", strtotime($unseenNotification[0]["notify_at"]));

$notitotal = date("Ymdhis", strtotime($unseenNotification[0]["notify_at"]))  ;
$notitotal += 1;

    if($totalnow <= $notitotal){
	      echo '<embed src="'.IMG.'tone.mp3" hidden="true" loop="false" autoplay="true">';
	   }
	if(!empty($unseenNotification)){
	   echo "<span>".count($unseenNotification)."</span>"; 
	}


?>
