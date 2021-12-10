<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Login\Login;

$loginGet = Login::loginGet('action');
if($loginGet != false && $loginGet == 'verify'){
  date_default_timezone_set('Asia/Dhaka');
  $email          = Login::loginGet('email');
  $slug           = Login::loginGet('slug');
  $session_expire = Login::loginGet('session_expire');
  $getExpiryTime  = date('YmdHis', strtotime($session_expire));
  $timeNow        = date('YmdHis', time());
  if($timeNow >=  $getExpiryTime){
    Login::logout();
    header('location:'.WEBROOT.'');
  }
}else {
  header('location:'.WEBROOT.'404.php');
  exit();
}

?>

<?php include_once(ELEMENT.'head.php');?> <!-- include header section -->
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"> <strong>Verify Email</strong> </a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Please check your email. We have sent a security code for verify your email address. This code will be expire after 15 minutes </p>
      <div id="showErroMsg"></div>
      <form action="" method="post" id="verifyForm">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Security code" name="securityCode">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" id="verifySumbit" name="verifySumbit">Verify Now</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <div class="row mt-3">
        <!-- /.col -->
        <div class="col-7 col-md-6 pt-1">
          <span>Did&apos;t get code? </span>
        </div>
        <div class="col-5 col-md-6 text-right">
          <button  id="resendCodeSubmit" class="btn btn-outline-primary btn-sm" name="resendCodeSubmit">Resend New Code</button>
        </div>

      </div>
      <!-- <p class="mt-3 mb-1 text-center">
        <span class="px-1 py-3">Did&apos;t get code?</span> <button  id="resendCodeSubmit" class="btn" name="resendCodeSubmit">Resend New</button>

      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- Footer start -->
<?php include_once(ELEMENT.'script.php');?> <!-- include Footer section -->
