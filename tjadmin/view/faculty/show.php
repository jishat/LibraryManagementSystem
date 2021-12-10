<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Faculty\Faculty;

if(isset($_GET['show'])){
  $slug = $_GET['show'];
}else{
  header('location:'.ADMIN.'404.php');
  exit();
}

$Faculty = new Faculty();
$facultyInfo = $Faculty->facultyInfo($slug);

if($facultyInfo== "error"){
  header('location:'.ADMIN.'404.php');
  exit();
}
?>
<?php include_once(ADMINELEMENT.'head.php');?>
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
              <h3 class="card-title">Information of <strong class="brand-text-color"><?php echo $facultyInfo['faculty_name']; ?> </strong> </h3>


              <a href="<?php echo 'edit.php?edit='.urlencode($facultyInfo['slug']); ?>" data-toggle="tooltip" title="Edit" class="ml-auto mr-1 btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i></a>
              <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" id="facultyDelBtn" data-faculty_info="<?php echo $facultyInfo['id']; ?>" name="facultyDelBtn">
                  <i class="fas fa-trash">
                  </i>
              </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="">
                <tbody>
                  <tr>
                    <td class="text-muted py-2 pr-4 pl-2 text-nowrap">Faculy Name:</td>
                    <td class="p-2"><strong><?php echo $facultyInfo['faculty_name']; ?></strong></td>
                  </tr>
                  <tr>
                    <td class="text-muted py-2 pr-4 pl-2 text-nowrap">Slug:</td>
                    <td class="p-2"><strong><?php echo $facultyInfo['slug']; ?></strong></td>
                  </tr>
                  <tr>
                    <td class="text-muted py-2 pr-4 pl-2 text-nowrap">Short Description:</td>
                    <td class="p-2"><?php echo $facultyInfo['short_description']; ?></td>
                  </tr>
                  <tr>
                    <td class="text-muted py-2 pr-4 pl-2 text-nowrap">Last Update:</td>
                    <td class="p-2"><?php if(isset($facultyInfo['update_at']) && $facultyInfo['update_at'] != ""){ ?>
                      <span class="ml-auto text-muted text-sm "><span class="font-weight-bold"> <?php echo date("h:i a  |  d M, Y", strtotime($facultyInfo['update_at'])) ?></span></span>
                    <?php
                  }else{
                    echo '<span class="ml-auto text-muted text-sm">N/A</span>';
                  } ?></td>
                  </tr>
                  <tr>
                    <td class="text-muted py-2 pr-4 pl-2 text-nowrap">Created:</td>
                    <td class="p-2"><?php if(isset($facultyInfo['create_at']) && $facultyInfo['create_at'] != ""){ ?>
                      <span class="ml-auto text-muted text-sm "><span class="font-weight-bold"> <?php echo date("h:i a  |  d M, Y", strtotime($facultyInfo['create_at'])) ?></span></span>
                    <?php
                  }else{
                    echo '<span class="ml-auto text-muted text-sm">N/A</span>';
                  } ?></td>
                  </tr>
              </tbody>
              </table>
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
