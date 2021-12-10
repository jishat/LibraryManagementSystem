<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Userrole\Userrole;
$Userrole = new Userrole();
$allUserRole = $Userrole->allUserRole();
?>

<?php include_once(ADMINELEMENT.'head.php');?> <!-- include header section -->
<?php include_once(ADMINELEMENT.'navigation.php');?> <!-- include navigation section -->

<div class="content-wrapper" style="min-height: 225px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-6">
            <div class="ml-2">
              <a href="javascript:history.go(-1)" data-toggle="tooltip" title="Return to the previous page" class="btn btn-primary btn-sm rounded-pill"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go Back</a>
            </div>
          </div>
          <div class="col-6">
            <div class="mr-2">
              <ol class="breadcrumb ">
                <li class="breadcrumb-item ml-auto"><a href="<?php echo ADMINVIEW.'dashboard'?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo ADMINVIEW.'user'?>">User</a></li>
                <li class="breadcrumb-item active">Create</li>
              </ol>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card tj_card">
            <div class="card-header tj-card-header">
              <h3 class="card-title">Register New Account</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="errmsgParant"></div>
              <form method="post" enctype="multipart/form-data" id="regAdmnAccForm">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="userName">Full Name <span class="text-danger">*</span></label>
                      <input type="text" id="userName" name="userName" placeholder="Enter full name" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg1"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="loginUserName">Username <span class="text-danger">*</span> <span class="text-muted text-sm text-bold">(Login usernname)</span> </label>
                      <input type="text" id="loginUserName" name="loginUserName" placeholder="Enter username" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg9"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="userRole">Select User Role <span class="text-danger">*</span></label>
                      <select name="userRole" id="userRole" class="form-control">
                        <option selected disabled>Select User Role</option>
                        <?php
                        if(isset($allUserRole) && $allUserRole != "error"){
                          foreach($allUserRole as $UserRole){
                            echo '<option value="'.$UserRole['id'].'">'.$UserRole['name'].'</option>';
                          }
                        }
                        ?>
                      </select>
                      <div class="error-msg errmsgTw" id="errmsg2"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="userGender">Select Gender <span class="text-danger">*</span></label>
                      <select name="userGender" id="userGender" class="form-control">
                        <option selected disabled>Select Gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Others</option>
                      </select>
                      <div class="error-msg errmsgTw" id="errmsg3"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="userMobile">Mobile Number <span class="text-muted">(optional)</span></label>
                      <input type="text" id="userMobile" name="userMobile" placeholder="Enter Valid Mobile Number" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg4"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="userEmail">Email <span class="text-muted">(optional)</span></label>
                      <input type="email" id="userEmail" name="userEmail" placeholder="Enter your email" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg5"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="userPassword">Password <span class="text-danger">*</span></label>
                      <input type="password" id="userPassword" name="userPassword" placeholder="Enter password" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg6"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="userAddress">Address <span class="text-muted">(optional)</span></label>
                      <input type="text" id="userAddress" name="userAddress" placeholder="Enter User Address" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg7"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="userPicture">Insert Picture <span class="text-muted">(optional)</span></label>
                      <input type="file" id="userPicture" name="userPicture" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg8"></div>
                    </div>
                  </div>
                  <!-- <div class="admnRegSubmitLoading"></div> -->
                </div>
                <div class="d-flex align-items-center">
                  <button name="admnRegSubmit" id="admnRegSubmit" class="btn btn-primary mr-2">Submit</button>
                  <div class="styleLoading"></div>
                </div>

              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<?php include_once(ADMINELEMENT.'footer.php');?>
<?php include_once(ADMINELEMENT.'script.php');?>
