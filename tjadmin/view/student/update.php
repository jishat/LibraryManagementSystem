<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Student\Student;
use App\Login\Login;


if(isset($_POST['stuEditSubmit']) && $_SERVER['REQUEST_METHOD'] == 'POST'  && Login::loginGet('userlogin') == true && $_POST['stuEditSubmit'] == 'stuEditSubmit'){

  $Student = new Student();
  $result = $Student->updateStuInfo($_POST, $_FILES);
  echo $result;
}else{
	header('location:'.WEBROOT.'404.php');
}
