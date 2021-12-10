<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\User\User;
use App\Userrole\Userrole;
use App\Login\Login;

if(isset($_GET['edit'])){
  $id = $_GET['edit'];
}else{
  header('location:'.ADMIN.'404.php');
  exit();
}
$User = new User();
$singleData = $User->singleUserInfo($id);

if($singleData == "error"){
  header('location:'.ADMIN.'404.php');
  exit();
}
if($singleData['id'] != Login::loginGet('userid')){
  header('location:'.ADMIN.'404.php');
  exit();
}
$Userrole = new Userrole();
$allUserRole = $Userrole->allUserRole();
?>
<?php include_once(ADMINELEMENT.'head.php');?> <!-- include header section -->
<?php include_once(ADMINELEMENT.'navigation.php');?> <!-- include navigation section -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
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
              <li class="breadcrumb-item"><a href="<?php echo 'show.php?show='.urlencode($singleData['slug']); ?>"><?php echo $singleData['name']; ?></a></li>
              <li class="breadcrumb-item active">Edit</li>
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
          <div class="card-header tj-card-header d-flex">
            <h3 class="card-title">Information of <strong class="brand-text-color"><?php echo $singleData['name']; ?></strong></h3>
            <?php if(isset($singleData['update_at']) && $singleData['update_at'] != ""){ ?>
              <span class="ml-auto text-muted text-sm ">Last Update: <span class="font-weight-bold"> <?php echo date("h:i a  |  d M, Y", strtotime($singleData['update_at'])) ?></span></span>
            <?php
            } ?>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div id="errmsgParant"></div>
            <form id="editAdmnAccForm" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-12 mb-5">
                  <div class="ImgEdit mt-2">
                    <img src="<?php echo !empty($singleData['picture']) ? IMAGESUSER.$singleData['picture'] : IMG.'avatar-man.png';?>" alt="<?php echo $singleData['name']; ?>" class="selectedavatar" id="selectedavatar">
                    <span id="uploadimg"><i class="fas fa-camera"></i></span>
                    <span id="deleteimg" data-img_delete="0"><i class="far fa-trash-alt"></i></span>
                    <input type="file" class="ImgInput" id="ImgInput" name="userPicture">
                    <div class="error-msg errmsgTw" id="errmsg8"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="userName">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="userName" name="userName" value="<?= $singleData['name']; ?>">
                    <div class="error-msg errmsgTw" id="errmsg1"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="loginUserName">Username <span class="text-danger">*</span> <span class="text-muted text-sm text-bold">(Login usernname)</span> </label>
                    <input type="text" id="loginUserName" value="<?php echo $singleData['username']; ?>" name="loginUserName" placeholder="Enter username" class="form-control">
                    <div class="error-msg errmsgTw" id="errmsg9"></div>
                  </div>
                </div>

                <?php if($singleData['id']  != Login::loginGet('userid')){ ?>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="userRole">Select User Role <span class="text-danger">*</span></label>
                      <select name="userRole" id="userRole" class="form-control">
                        <option disabled>Select User Role</option>
                        <?php
                        if(isset($allUserRole) && $allUserRole != "error"){
                          foreach($allUserRole as $UserRole){ ?>
                            <option <?php echo $UserRole['id'] == $singleData['user_role'] ? 'selected' : ''; ?> value="<?php echo $UserRole['id']; ?>"><?php echo $UserRole['name']; ?></option>
                          <?php
                          }
                        }
                        ?>
                      </select>
                      <div class="error-msg errmsgTw" id="errmsg2"></div>
                    </div>
                  </div>
                <?php }?>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="userGender">Select Gender <span class="text-danger">*</span></label>
                    <select name="userGender" id="userGender" class="form-control">
                      <option disabled>Select Gender</option>
                      <option <?php echo $singleData['gender'] == 1 ? 'selected' : ''; ?> value="1">Male</option>
                      <option <?php echo $singleData['gender'] == 2 ? 'selected' : ''; ?> value="2">Female</option>
                      <option <?php echo $singleData['gender'] == 3 ? 'selected' : ''; ?> value="3">Others</option>
                    </select>
                    <div class="error-msg errmsgTw" id="errmsg3"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="from-group">
                    <label for="userMobile">Mobile Number <span class="text-muted">(optional)</span></label>
                    <input type="text" id="userMobile" name="userMobile" placeholder="Enter Valid Mobile Number" class="form-control" value="<?php echo $singleData['mobile']; ?>">
                    <div class="error-msg errmsgTw" id="errmsg4"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="userEmail">Email <span class="text-muted">(optional)</span></label>
                    <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?= $singleData['email'];?>">
                    <div class="error-msg errmsgTw" id="errmsg5"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="userPassword">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="userPassword" name="userPassword" value="<?= $singleData['password'];?>">
                    <div class="error-msg errmsgTw" id="errmsg6"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="from-group">
                    <label for="userAddress">Address <span class="text-muted">(optional)</span></label>
                    <input type="text" id="userAddress" name="userAddress" placeholder="Enter User Address" class="form-control" value="<?= $singleData['address'];?>">
                    <div class="error-msg errmsgTw" id="errmsg7"></div>
                  </div>
                </div>

              </div>

              <div class="d-flex align-items-center mt-4">
                <button name="adminEditSubmit" data-infoid="<?php echo $singleData['id']; ?>" id="adminEditSubmit" class="btn btn-primary mr-2">Save info</button>
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
<!-- /.content-wrapper -->





<?php include_once(ADMINELEMENT.'footer.php');?>
<?php include_once(ADMINELEMENT.'script.php');?>
