<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;

$loginGet = Login::loginGet('action');
if($loginGet != 'success'){
  header('location:'.WEBROOT.'404.php');
  exit();
}
?>

<?php include_once(ELEMENT.'head.php');?> <!-- include header section -->

<body class="jumbotron">
  <div class="text-center mt-4">
    <div class="display-1 text-primary">
      <i class="fas fa-check-circle"></i>
    </div>
    <h1 class="display-3">Congratulation!</h1>
    <p class="lead"><strong>Your account has been registered successfully.</strong> </p>
    <p>Please wait for admin verification. You will get email once admin approve your account.</p>

    <blockquote class="blockquote mb-5">
      <p class="text-mute">Remember: Your account will be reject, If your all information are incorrect</p>
    </blockquote>
    <!-- <p >
      Having trouble? <a href="">Contact us</a>
    </p> -->
    <p class="lead">
      <a class="btn btn-primary btn-sm" href="#" role="button">Continue to homepage</a>
    </p>
  </div>

<!-- Footer script -->
<?php include_once(ELEMENT.'script.php');?> <!-- include Footer section -->
