<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');?>
<?php
use App\Login\Login;
use App\Notification\Notification;

$student_to = Login::loginGet('id');
$Notification = new Notification();
$allNotifications = $Notification->allStudentNotifications($student_to);
?>
<?php include_once(ELEMENT.'head.php');?> <!-- include header section -->
<?php include_once(ELEMENT.'header.php');?> <!-- include navigation section -->

<!-- Content Wrapper. Contains page content -->
<section id="notification-section">


  <!-- Main content -->

    <div class="container">
      <div class="row">
        <div class="col-md-4" id="userCardParent">

          <!-- Profile Image -->
          <div class="card card-primary card-outline tj-card" id="userCardChild">
            <?php
            if ($singleData['email_verified'] == 0) { ?>
              <div class="ribbon-wrapper ribbon-xl">
                <div class="ribbon bg-danger">
                  Email Unverified
                </div>
              </div>
            <?php
          }elseif ($singleData['email_verified'] == 1 && $singleData['admin_verified'] == 0) { ?>
            <div class="ribbon-wrapper ribbon-xl">
              <div class="ribbon bg-danger">
                Unverified
              </div>
            </div>
          <?php
          }
            ?>
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="<?= !empty($singleData['picture']) ? IMAGESUSER.$singleData['picture'] : IMG.'avatar-man.png';?>"
                     alt="User profile picture">
              </div>

              <h3 class="profile-username text-center"><?php echo $singleData['name']; ?></h3>

              <p class="text-muted text-center"><?php echo $singleData['faculty_name']; ?></p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>ID</b> <a class="float-right"><?php echo $singleData['student_id']; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Batch</b> <a class="float-right"><?php echo $singleData['batch']; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Gender</b> <a class="float-right"><?php echo $singleData['gender'] == 1 ? 'Male' : ($singleData['gender'] == 2 ? 'Female' : 'Others') ; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Faculty</b> <a class="float-right"><?php echo $singleData['faculty_name']; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Gmail</b> <a class="float-right"><?php echo $singleData['email']; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Mobile</b> <a class="float-right"><?php echo $singleData['mobile']; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Address</b> <a class="float-right"><?php echo $singleData['address']; ?></a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="card tj_card">
            <div class="card-header tj-card-header d-flex">
              <h3 class="card-title">Information of <strong> <?php echo $singleData['name']; ?> </strong></h3>
              <?php if(isset($singleData['update_at']) && $singleData['update_at'] != ""){ ?>
                <span class="ml-auto text-muted text-sm ">Last Update: <span class="font-weight-bold"> <?php echo date("h:i a  |  d M, Y", strtotime($singleData['update_at'])); ?></span></span>
              <?php
              } ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form method="post" enctype="multipart/form-data" id="editStdnForm">
                <div class="row">
                  <div class="col-md-12 mb-5">
                    <div class="ImgEdit mt-2">
                      <img src="<?php echo !empty($singleData['picture']) ? IMAGESUSER.$singleData['picture'] : IMG.'avatar-man.png';?>" alt="<?php echo $singleData['name']; ?>" class="selectedavatar" id="selectedavatar">
                      <span id="uploadimg"><i class="fas fa-camera"></i></span>
                      <span id="deleteimg" data-img_delete="0"><i class="far fa-trash-alt"></i></span>
                      <input type="file" class="ImgInput" id="ImgInput" name="studentPicture">
                      <div class="error-msg errmsgTw" id="errmsg1"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email <span class="text-danger">*</span></label>
                      <input type="email" id="email" value="<?php echo $singleData['email']; ?>" name="studentEmail" placeholder="Enter your email" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg2"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="from-group">
                      <label for="password">Password <span class="text-danger">*</span></label>
                      <input type="password" id="password" value="<?php echo $singleData['password']; ?>" name="studentPassword" placeholder="Enter student mobile number" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg3"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="from-group">
                      <label for="mobile">Mobile</label>
                      <input type="text" id="mobile" value="<?php echo $singleData['mobile']; ?>" name="studentMobile" placeholder="Enter student mobile number" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg4"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="from-group">
                      <label for="address">Address</label>
                      <input type="text" id="address" value="<?php echo $singleData['address']; ?>" name="address" placeholder="Enter address" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg5"></div>
                    </div>
                  </div>
                </div>
                <div class="d-flex align-items-center mt-4">
                  <button name="stuEditSubmit" id="stuEditSubmit" class="btn btn-primary mr-2">Submit</button>
                  <div class="styleLoading"></div>
                </div>

              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    <!-- /.row -->

  <!-- /.content -->
</section>
<!-- /.content-wrapper -->

<?php include_once(ELEMENT.'footer.php');?> <!-- include Footer section -->
<?php include_once(ELEMENT.'script.php');?> <!-- include Footer section -->
