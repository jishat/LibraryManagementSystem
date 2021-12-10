<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Category\Category;
$Category = new Category();
?>

<?php include_once(ADMINELEMENT.'head.php');?> <!-- include header section -->
<?php include_once(ADMINELEMENT.'navigation.php');?> <!-- include navigation section -->

<div class="content-wrapper" style="min-height: 225px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-12">
            <ol class="breadcrumb ml-2">
              <li class="breadcrumb-item"><a href="<?= ADMINVIEW.'category'?>">Category</a></li>
              <li class="breadcrumb-item active">Add New</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card tj-card">
            <div class="card-header tj-card-header">
              <h3 class="card-title">Create New Category</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="errmsgParant"></div>
              <form method="post" enctype="multipart/form-data" id="regCategoryForm">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Category Name <span class="text-danger">*</span></label>
                      <input type="text" id="name" name="name" placeholder="Enter category name" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg1"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="parentCategory">Parent Category <span class="text-muted">(optional)</span></label>
                        <select id="parentCategory" class="form-control" placeholder="Select parent category if has" name="parentCategory">
                          <option selected disabled>Choose Parent Category</option>
                          <?php
                            echo $Category->fetchCategory();
                          ?>
                        </select>
                      <div class="error-msg errmsgTw" id="errmsg2"></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="from-group">
                      <label for="shortDescription">Short Description <span class="text-muted">(optional)</span> <span class="font-weight-light">Max: 250 Char</span></label>
                      <textarea id="shortDescription" name="shortDescription" placeholder="Write a short Description" class="form-control mb-4" rows="4"></textarea>
                      <div class="error-msg errmsgTw" id="errmsg3"></div>
                    </div>
                  </div>
                </div>
                <div class="d-flex">
                  <button name="categoryRegSubmit" id="categoryRegSubmit" class="btn btn-primary mr-2">Submit</button>
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
