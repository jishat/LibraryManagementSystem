<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Category\Category;
if(isset($_GET['category_edit'])){
  $slug = $_GET['category_edit'];
}else{
  header('location:'.ADMIN.'404.php');
  exit();
}
$Category = new Category();
$singleData = $Category->singleData($slug);

if($singleData == "error"){
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
            <a href="javascript:history.go(-1)" title="Return to the previous page" class="btn btn-primary btn-sm rounded-pill"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go Back</a>
          </div>
        </div>
        <div class="col-6">
          <div class="mr-2">
            <ol class="breadcrumb ">
              <li class="breadcrumb-item ml-auto"><a href="<?php echo ADMINVIEW.'dashboard'?>">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="<?php echo ADMINVIEW.'category'?>">Category</a></li>
              <li class="breadcrumb-item active"> <?php echo $singleData['category_name']; ?> </li>
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
            <h3 class="card-title">Information of <strong class="brand-text-color"><?php echo $singleData['category_name']; ?></strong></h3>
            <?php if(isset($singleData['update_at']) && $singleData['update_at'] != ""){ ?>
              <span class="ml-auto text-muted text-sm ">Last Update: <span class="font-weight-bold"> <?php echo date("h:i a  |  d M, Y", strtotime($singleData['update_at'])); ?></span></span>
            <?php
            } ?>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div id="errmsgParant"></div>
            <form method="post" enctype="multipart/form-data" id="editCategoryForm">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Category Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" placeholder="Enter category name" value="<?php echo $singleData['category_name']; ?>" class="form-control">
                    <div class="error-msg errmsgTw" id="errmsg1"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="parentCategory">Parent Category <span class="text-muted">(optional)</span></label>
                      <select id="parentCategory" class="form-control" placeholder="Select parent category if has" name="parentCategory">
                        <option value="">Choose Parent Category</option>
                        <?php
                          echo $Category->fetchCategoryEditedCategory($parent_id = NULL, $sub_mark = '', $singleData['parent_category']);
                        ?>
                      </select>
                    <div class="error-msg errmsgTw" id="errmsg2"></div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="from-group">
                    <label for="shortDescription">Short Description <span class="text-muted">(optional)</span> <span class="font-weight-light">Max: 250 Char</span></label>
                    <textarea id="shortDescription" name="shortDescription" placeholder="Write a short Description" class="form-control mb-4" rows="4"><?php echo $singleData['short_description']; ?></textarea>
                    <div class="error-msg errmsgTw" id="errmsg3"></div>
                  </div>
                </div>
              </div>
              <div class="d-flex">
                <button name="categoryEditSubmit" id="categoryEditSubmit" data-cateinfo="<?php echo $singleData['id']; ?>" class="btn btn-primary mr-2">Submit</button>
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
