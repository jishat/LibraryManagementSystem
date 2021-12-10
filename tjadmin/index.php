<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Login\Login;
Login::checkLogin();
include_once(ADMINELEMENT.'head.php');

?>

<body class="hold-transition">
  <section class="logn-main-section">
      <div class="login-section">
        <div class="login-box">
          <!-- /.login-logo -->
              <div class="login-logo">
                <a href="https://librarymanagement.jishat.com/tjadmin/"><img src="<?php echo ADMIN.'assets/img/techjishat.png';?>" alt="logo"></a>
                <!-- <a href="index.html"><b>Library Management</b></a> -->
              </div>
              <h3 class="login-heading">A Complete Library Management System</h3>
              <p class="login-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry  has been </p>
              <!-- Get success or errror message -->
              <?php

                if(isset($successfully)):
                  echo '<div class="alert-success">'.$successfully.'</div>';
                endif;

                if(isset($unsuccessfully)):
                  echo '<div class="error-msg">'.$unsuccessfully.'</div>';
                endif;
              ?>
              <div id="loginErroMSg"></div>
              <form method="post" id="userLogForm">
                <div class="input-group mb-3">
                  <input type="email" class="form-control" placeholder="Enter username" id="email" name="userName">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" id="password" name="userPassword" placeholder="Enter password">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <!-- /.col -->
                  <div class="col-5 col-md-4">
                    <button type="submit" class="btn btn-tj" name="userLogSubmit" id="userLogSubmit">Login</button>
                  </div>
                  <div class="col-7 col-md-8">
                    <p class="mt-2 text-right">
                      <!-- <a href="forgot-password.html" class="forgot-pass">Forgot Password?</a> -->
                    </p>
                  </div>

                </div>
              </form>

              <!-- /.social-auth-links -->


            <!-- /.login-card-body -->
        </div>
        <!-- /.login-box -->
      </div>

      <div class="login-img-section">
          <img src="<?php echo ADMIN."assets/img/login-background.svg" ?>" alt="" class="login-img">
      </div>
  </section>
<?php include_once(ADMINELEMENT.'script.php');?>
