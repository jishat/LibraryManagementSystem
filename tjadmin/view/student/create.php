<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Faculty\Faculty;
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
              <form method="post" enctype="multipart/form-data" id="admnStdnForm">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="studentName">Name <span class="text-danger">*</span></label>
                      <input type="text" id="studentName" name="studentName" placeholder="Enter student name" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg1"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="studentId">Student ID <span class="text-danger">*</span></label>
                      <input type="text" id="studentId" name="studentId" placeholder="Enter student ID no." class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg2"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="faculty">Select Faculty <span class="text-danger">*</span></label>
                      <select name="faculty" id="faculty" class="form-control">
                        <?php
                        if(isset($allFaculty) && $allFaculty != "error"){
                          echo "<option selected disabled>Select Faculty</option>";
                          foreach($allFaculty as $eachFaculty){
                            echo '<option value="'.$eachFaculty['id'].'">'.$eachFaculty['faculty_name'].'</option>';
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
                      <input type="text" id="studentbatch" name="studentbatch" placeholder="Enter batch no." class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg4"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="gender">Select Gender <span class="text-danger">*</span></label>
                      <select name="gender" id="gender" class="form-control">
                        <option selected disabled>Select Gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Others</option>
                      </select>
                      <div class="error-msg errmsgTw" id="errmsg5"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="from-group">
                      <label for="mobile">Mobile</label>
                      <input type="number" id="mobile" name="studentMobile" placeholder="Enter student mobile number" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg6"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email <span class="text-danger">*</span></label>
                      <input type="email" id="email" name="studentEmail" placeholder="Enter your email" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg7"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="from-group">
                      <label for="password">Password <span class="text-danger">*</span></label>
                      <input type="password" id="password" name="studentPassword" placeholder="Enter student mobile number" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg8"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="from-group">
                      <label for="address">Address</label>
                      <input type="text" id="address" name="address" placeholder="Enter address" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg9"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="studentPicture">Insert Picture</label>
                      <input type="file" id="studentPicture" name="studentPicture" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg10"></div>
                    </div>
                  </div>
                  <!-- <div class="admnRegSubmitLoading"></div> -->
                </div>
                <div class="d-flex align-items-center">
                  <button name="stuRegSubmit" id="stuRegSubmit" class="btn btn-primary mr-2">Submit</button>
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
