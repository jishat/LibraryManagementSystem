<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Faculty\Faculty;
$msg = Message::getMessage();
if(isset($_GET['edit'])){
  $slug = $_GET['edit'];
}else{
  header('location:'.ADMIN.'404.php');
  exit();
}
$Faculty = new Faculty();
$facultyInfo = $Faculty->facultyInfo($slug);

if($facultyInfo == "error"){
  header('location:'.ADMIN.'404.php');
  exit();
}
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
              <li class="breadcrumb-item"><a href="<?php echo ADMINVIEW.'faculty'?>">Faculty</a></li>
              <li class="breadcrumb-item active"><?php echo $facultyInfo['faculty_name']; ?></li>
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
        <div class="card tj-card">
          <div class="card-header tj-card-header d-flex">
            <h3 class="card-title">Information of <a href="<?php echo 'show.php?show='.urldecode($facultyInfo['slug']); ?>" data-toggle="tooltip" title="View Details" class="text-bold brand-text-color"><?php echo $facultyInfo['faculty_name']; ?></a></h3>
            <?php if(isset($facultyInfo['update_at']) && $facultyInfo['update_at'] != ""){ ?>
              <span class="ml-auto text-muted text-sm ">Last Update: <span class="font-weight-bold"> <?php echo date("h:i a  |  d M, Y", strtotime($facultyInfo['update_at'])); ?></span></span>
            <?php
            } ?>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div id="errmsgParant"></div>
            <form method="post" enctype="multipart/form-data" id="editFacultyForm">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="facultyName">Name <span class="text-danger">*</span></label>
                    <input type="text" id="facultyName" name="facultyName" value="<?php echo $facultyInfo['faculty_name']; ?>" placeholder="Enter faculty name" class="form-control">
                    <div class="error-msg errmsgTw" id="errmsg1"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="from-group">
                    <label for="shortDescription">Short Description <span class="text-muted">(optional)</span> <span class="font-weight-light">Max: 250 Char</span></label>
                    <textarea id="shortDescription" name="shortDescription" placeholder="Write a short Description" class="form-control mb-4" rows="4"><?php echo $facultyInfo['short_description']; ?></textarea>
                    <div class="error-msg errmsgTw" id="errmsg2"></div>
                  </div>
                </div>
              </div>
              <div class="d-flex">
                <button name="facultyEditSubmit" id="facultyEditSubmit" data-faculty="<?php echo $facultyInfo['id'] ?>" class="btn btn-primary mr-2">Submit</button>
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
