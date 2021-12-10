<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Login\Login;
use App\Utility\Token;
Login::checkStudentLogin();
include_once(ELEMENT.'head.php');
?>

<body class="hold-transition">
  <section class="logn-main-section">
      <div class="login-section">
        <div class="login-box">
          <!-- /.login-logo -->
              <div class="login-logo">
                <a href="https://librarymanagement.jishat.com"><img src="<?= ADMIN.'assets/img/techjishat.png';?>" alt="logo"></a>
                <!-- <a href="index.html"><b>Library Management</b></a> -->
              </div>
              <h3 class="login-heading">A Complete Library Management System</h3>
              <p class="login-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry  has been </p>

              <div id="loginErroMSg"></div> <!-- Get success or errror message -->
              <form method="post" id="userLogForm">
                <div class="input-group mb-3">
                  <input type="email" class="form-control" placeholder="Enter Your Email" id="email" name="email">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <!-- /.col -->
                  <div class="col-5 col-md-4">
                    <button type="submit" class="btn btn-tj" name="userLogSubmit" id="userLogSubmit" data-tkn_log="<?php echo Token::logToken();?>">Login</button>
                  </div>
                  <div class="col-7 col-md-8">
                    <p class="mt-2 text-right">
                      <!-- <a href="forgot-password.html" class="forgot-pass">Forgot Password?</a> -->
                    </p>
                  </div>
                </div>
              </form>
              <div class="mb-4 mt-3">
                <span class="forgot-pass">Or</span>
                <a href="register" class="forgot-pass font-weight-bold">Register a new account</a>
              </div>

              <!-- /.social-auth-links -->


            <!-- /.login-card-body -->
        </div>
        <!-- /.login-box -->
      </div>

      <div class="login-img-section">
          <img src="<?php echo IMG."front-login.png" ?>" alt="" class="login-img">
      </div>
  </section>
<?php include_once(ELEMENT.'script.php');?>
