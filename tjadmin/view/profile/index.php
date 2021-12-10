<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\User\User;
use App\Login\Login;

$loginid = Login::loginGet('userslug');
$User = new User();
$singleData = $User->singleUserInfo($loginid);

if($singleData == "error"){
  header('location:'.ADMIN.'404.php');
  exit();
}
include_once(ADMINELEMENT.'head.php');
include_once(ADMINELEMENT.'navigation.php');
?>


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
                <li class="breadcrumb-item active">Profile</li>
              </ol>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
      <div>
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline tj-card">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?= !empty($singleData['picture']) ? IMAGESUSER.$singleData['picture'] : IMG.'avatar-man.png';?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo $singleData['name']; ?></h3>

                <p class="text-muted text-center"><?php echo $singleData['user_role'] == "super-admin" ? "Super Admin" : $singleData['userrolename']; ?></p>

                <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                    <b>Username</b> <a class="float-right"><?php echo $singleData['username']; ?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Gender</b> <a class="float-right"><?php echo $singleData['gender'] == 1 ? 'Male' : ($singleData['gender'] == 2 ? 'Female' : 'Others') ; ?></a>
                  </li>
                </ul>
                <a class="btn btn-primary btn-block" data-toggle="tooltip" title="Edit Profile" href="<?php echo 'edit.php?edit='.urlencode($singleData['slug']); ?>">
                  <i class="fas fa-pencil-alt mr-1"></i> Edit Profile
                </a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card tj-card">
              <div class="card-header tj-card-header p-3 d-flex">
                  <h3 class="card-title">About <strong><?php echo $singleData['name']; ?></strong> </h3>
                  <?php if(isset($singleData['update_at']) && $singleData['update_at'] != ""){ ?>
                    <span class="ml-auto text-muted text-sm ">Last Update: <span class="font-weight-bold"> <?php echo date("h:i a  |  d M, Y", strtotime($singleData['update_at'])) ?></span></span>
                  <?php
                  } ?>
              </div><!-- /.card-header -->
              <div class="card-body">
                <strong>Name:</strong>
                <p class="text-muted">
                  <?php echo $singleData['name']; ?>
                </p>
                <hr>

                <strong>Gender:</strong>
                <p class="text-muted">
                  <?php echo $singleData['gender'] == 1 ? 'Male' : ($singleData['gender'] == 2 ? 'Female' : 'Others') ; ?>
                </p>
                <hr>
                <strong>Mobile:</strong>
                <p class="text-muted">
                  <?php echo $singleData['mobile']; ?>
                </p>
                <hr>
                <strong>Address:</strong>
                <p class="text-muted">
                  <?php echo $singleData['address']; ?>
                </p>
                <hr>

                <strong>Email:</strong>
                <p class="text-muted">
                  <?php echo $singleData['email']; ?>
                </p>
                <hr>
                <strong>User Role:</strong>
                <p class="text-muted">
                  <?php echo $singleData['userrolename']; ?>
                </p>
                <strong>Account Created:</strong>
                <p class="text-muted">
                  <?php echo date("h:i a  |  d M, Y", strtotime($singleData['create_at'])) ?></span>
                </p>
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->





<?php include_once(ADMINELEMENT.'footer.php');?>
<?php include_once(ADMINELEMENT.'script.php');?>
