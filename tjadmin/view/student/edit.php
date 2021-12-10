<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Student\Student;
use App\Faculty\Faculty;

$msg = Message::getMessage();

if(isset($_GET['student_edit'])){
  $slug = $_GET['student_edit'];
}else{
  header('location:'.ADMIN.'404.php');
  exit();
}

$Student = new Student();
$singleData = $Student->singleData($slug);

if($singleData == "error"){
  header('location:'.ADMIN.'404.php');
  exit();
}
$Faculty = new Faculty();
$allFaculty = $Faculty->allFaculty();
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
              <a href="javascript:history.go(-1)" title="Return to the previous page" class="btn btn-primary btn-sm rounded-pill"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go Back</a>
            </div>
          </div>
          <div class="col-6">
            <div class="mr-2">
              <ol class="breadcrumb ">
                <li class="breadcrumb-item ml-auto"><a href="<?php echo ADMINVIEW.'dashboard'?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo ADMINVIEW.'student'?>">Student</a></li>
                <li class="breadcrumb-item active"><?php echo $singleData['name']; ?></li>
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
              <h3 class="card-title">Information of <strong> <?php echo $singleData['name']; ?> </strong><span class="badge badge-primary"><a href="<?php echo 'show.php?student_show='.urlencode($singleData['slug']); ?>" class="text-light" data-toggle="tooltip" title="View Profile">
                View Profile</a></span></h3>
              <?php if(isset($singleData['update_at']) && $singleData['update_at'] != ""){ ?>
                <span class="ml-auto text-muted text-sm ">Last Update: <span class="font-weight-bold"> <?php echo date("h:i a  |  d M, Y", strtotime($singleData['update_at'])); ?></span></span>
              <?php
              } ?>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="errmsgParant"></div>
              <form method="post" enctype="multipart/form-data" id="editStdnForm">
                <div class="row">
                  <div class="col-md-12 mb-5">
                    <div class="ImgEdit mt-2">
                      <img src="<?php echo !empty($singleData['picture']) ? IMAGESUSER.$singleData['picture'] : IMG.'avatar-man.png';?>" alt="<?php echo $singleData['name']; ?>" class="selectedavatar" id="selectedavatar">
                      <span id="uploadimg"><i class="fas fa-camera"></i></span>
                      <span id="deleteimg" data-img_delete="0"><i class="far fa-trash-alt"></i></span>
                      <input type="file" class="ImgInput" id="ImgInput" name="studentPicture">
                      <div class="error-msg errmsgTw" id="errmsg10"></div>
                    </div>
                  </div>
                  <!-- <div class="col-md-6">
                    <div class="form-group">
                      <label for="studentPicture">Insert Picture</label>
                      <input type="file" id="studentPicture" name="studentPicture" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg10"></div>
                    </div>
                  </div> -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="studentName">Name <span class="text-danger">*</span></label>
                      <input type="text" id="studentName" value="<?php echo $singleData['name']; ?>" name="studentName" placeholder="Enter student name" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg1"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="studentId">Student ID <span class="text-danger">*</span></label>
                      <input type="text" id="studentId" value="<?php echo $singleData['student_id']; ?>" name="studentId" placeholder="Enter student ID no." class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg2"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="faculty">Select Faculty <span class="text-danger">*</span></label>
                      <select name="faculty" id="faculty" class="form-control">
                        <?php
                        if(isset($allFaculty) && $allFaculty != "error"){
                          echo "<option disabled>Select Faculty</option>";
                          foreach($allFaculty as $eachFaculty){ ?>
                            <option <?php echo $eachFaculty['id'] == $singleData['faculty'] ? "selected" : ""; ?> value="<?php echo $eachFaculty['id'] ?>"><?php echo $eachFaculty['faculty_name'];  ?></option>
                        <?php
                          }
                        }else{
                          echo "<option selected disabled>There has any faculty. Please create it</option>";
                        }
                        ?>
                      </select>
                      <div class="error-msg errmsgTw" id="errmsg3"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="studentbatch">Batch <span class="text-danger">*</span></label>
                      <input type="text" id="studentbatch" value="<?php echo $singleData['batch']; ?>" name="studentbatch" placeholder="Enter batch no." class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg4"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="gender">Select Gender <span class="text-danger">*</span></label>
                      <select name="gender" id="gender" class="form-control">
                        <option disabled>Select Gender</option>
                        <option <?php echo 1 == $singleData['gender'] ? "selected" : ""; ?> value="1">Male</option>
                        <option <?php echo 2 == $singleData['gender'] ? "selected" : ""; ?> value="2">Female</option>
                        <option <?php echo 3 == $singleData['gender'] ? "selected" : ""; ?> value="3">Others</option>
                      </select>
                      <div class="error-msg errmsgTw" id="errmsg5"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="from-group">
                      <label for="mobile">Mobile</label>
                      <input type="text" id="mobile" value="<?php echo $singleData['mobile']; ?>" name="studentMobile" placeholder="Enter student mobile number" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg6"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email <span class="text-danger">*</span></label>
                      <input type="email" id="email" value="<?php echo $singleData['email']; ?>" name="studentEmail" placeholder="Enter your email" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg7"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="from-group">
                      <label for="password">Password <span class="text-danger">*</span></label>
                      <input type="password" id="password" value="<?php echo $singleData['password']; ?>" name="studentPassword" placeholder="Enter student mobile number" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg8"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="from-group">
                      <label for="address">Address</label>
                      <input type="text" id="address" value="<?php echo $singleData['address']; ?>" name="address" placeholder="Enter address" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg9"></div>
                    </div>
                  </div>
                </div>
                <div class="d-flex align-items-center mt-4">
                  <button name="stuEditSubmit" data-infoid_std="<?php echo $singleData['id']; ?>" id="stuEditSubmit" class="btn btn-primary mr-2">Submit</button>
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



</div> <!-- Full body wrap ENd-->


<?php include_once(ADMINELEMENT.'script.php');?>
<?php include_once(ADMINELEMENT.'footer.php');?>
