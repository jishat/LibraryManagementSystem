<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Category\Category;
use App\Student\Student;
$Category = new Category();
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
                <li class="breadcrumb-item"><a href="<?php echo ADMINVIEW.'borrow'?>">Borrow</a></li>
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
              <h3 class="card-title">Add New Borrow manually</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="errmsgParant"></div>
              <form method="post" enctype="multipart/form-data" id="bookRegForm">
                <div class="row">
                  <div class="col-md-6 searchDropdownMain" id="searchStudentName">
                    <div class="form-group searchStudentNameInput searchDropdownInput">
                      <label for="studentNames">Student Name <span class="text-danger">*</span></label>
                      <input type="text" placeholder="Search student name or id" name="studentNames" data-std_id="" id="studentNames" class="form-control">
                      <div class="error invalid-feedback errmsgFind" id="errmsg1"></div>
                    </div>
                    <div class="searchStudentNameDropDown searchDropDown" id="searchStudentNameDropDown">
                   </div>
                  </div>
                  <div class="col-md-6 searchDropdownMain" id="searchBookName">
                    <div class="form-group searchBookNameInput searchDropdownInput">
                      <label for="bookNames">Book Name <span class="text-danger">*</span></label>
                      <input type="text" placeholder="Search book name or id" name="bookNames" data-book_id="" id="bookNames" class="form-control">
                      <div class="error invalid-feedback errmsgFind" id="errmsg2"></div>
                    </div>
                    <div class="searchBookNameDropDown searchDropDown" id="searchBookNameDropDown">
                   </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label>Return Date</label> <span class="text-muted text-sm">(How many days till)</span>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control float-right" id="reservation">
                        <div class="error invalid-feedback errmsgFind" id="errmsg3"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <blockquote class="blockquote bg-light ml-0">
                      <p class=" text-sm text-bold">Note: Accept the borrow request <span class="text-muted">(in Manage Borrow)</span> after register this borrow manually</p>
                    </blockquote>
                  </div>


                </div>
                <div class="d-flex align-items-center mt-3">
                  <button name="borrowNow"  class="btn btn-primary mr-2" id="borrowNow">Submit</button>
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
