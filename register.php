<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Student\Student;
use App\Login\Login;
use App\Faculty\Faculty;
use App\Utility\Token;

Login::checkStudentLogin();

$Faculty = new Faculty();
$allFaculty = $Faculty->allFaculty();
?>

<?php include_once(ELEMENT.'head.php');?> <!-- include header section -->
<body class="hold-transition" >

  <section class="student-register-sect">
      <div class="reg-img-section">
        <img src="<?php echo IMG."reg-img.png" ?>" alt="" class="login-img">
      </div>

      <div class="register-section">
        <form method="post" enctype="multipart/form-data" id="stdnForm">
          <div class="row">
            <div class="col-12">
              <div class="reg-form-head d-flex align-items-start">
                <h2>Register Your Account</h2>
                <a href="<?= WEBROOT?>" class="ml-auto text-primary font-weight-bold">Back to login &rarr;</a>
              </div>
              <p class="text-muted mb-4 mt-1 text-sm">Note: All information should be right. Otherwise your account will be reject</p>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="studentName">Name <span class="text-danger">*</span></label>
                <input type="text" id="studentName" name="studentName" placeholder="Enter student name" class="form-control">
                <div class="error invalid-feedback errmsgFind" id="errmsg1"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="studentId">Student ID <span class="text-danger">*</span></label>
                <input type="text" id="studentId" name="studentId" placeholder="Enter student ID no." class="form-control">
                <div class="error invalid-feedback errmsgFind" id="errmsg2"></div>
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
                    echo "<option selected disabled>There has no any faculty. Please create it</option>";
                  }
                  ?>
                </select>
                <div class="error invalid-feedback errmsgFind" id="errmsg3"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="studentbatch">Batch <span class="text-danger">*</span></label>
                <input type="text" id="studentbatch" name="studentbatch" placeholder="Enter batch no." class="form-control">
                <div class="error invalid-feedback errmsgFind" id="errmsg4"></div>
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
                <div class="error invalid-feedback errmsgFind" id="errmsg5"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" id="mobile" name="studentMobile" placeholder="Enter student mobile number" class="form-control">
                <div class="error invalid-feedback errmsgFind" id="errmsg6"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">Email <span class="text-danger">*</span></label>
                <input type="email" id="email" name="studentEmail" placeholder="Enter your email" class="form-control">
                <div class="error invalid-feedback errmsgFind" id="errmsg7"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input type="password" id="password" name="studentPassword" placeholder="Enter student mobile number" class="form-control">
                <div class="error invalid-feedback errmsgFind" id="errmsg8"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder="Enter address" class="form-control">
                <div class="error invalid-feedback errmsgFind" id="errmsg9"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="studentPicture">Insert Picture</label>
                <input type="file" id="studentPicture" name="studentPicture" class="form-control">
                <div class="error invalid-feedback errmsgFind" id="errmsg10"></div>
              </div>
            </div>
            <!-- <div class="admnRegSubmitLoading"></div> -->
          </div>
          <div class="d-flex align-items-center mb-2">
            <button name="stuRegSubmit" id="stuRegSubmit" class="btn btn-primary mr-2" data-tkn_reg="<?php echo Token::regToken();?>">Submit</button>
            <div class="styleLoading"></div>
          </div>

        </form>
      </div>
  </section>


  <!-- Footer start -->
<?php include_once(ELEMENT.'script.php');?> <!-- include Footer section -->
