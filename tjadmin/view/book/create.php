<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
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
          <div class="col-6">
            <div class="ml-2">
              <a href="javascript:history.go(-1)" title="Return to the previous page" class="btn btn-primary btn-sm rounded-pill"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go Back</a>
            </div>
          </div>
          <div class="col-6">
            <div class="mr-2">
              <ol class="breadcrumb ">
                <li class="breadcrumb-item ml-auto"><a href="<?php echo ADMINVIEW.'dashboard'?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo ADMINVIEW.'book'?>">Book</a></li>
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
              <h3 class="card-title">Register New Book</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="errmsgParant"></div>
              <form method="post" enctype="multipart/form-data" id="bookRegForm">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Name <span class="text-danger">*</span></label>
                      <input type="text" id="name" name="name" placeholder="Enter book name" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg1"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="writer">Writer name</label>
                      <input type="text" id="writer" name="writer" placeholder="Enter student ID no." class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg2"></div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="category">Category <span class="text-danger">*</span></label>
                        <select id="category" class="select2 form-control" multiple="multiple" data-placeholder="Select category" name="category[]">
                          <?php
                            echo $Category->fetchCategory();
                          ?>
                        </select>
                      <div class="error-msg errmsgTw" id="errmsg3"></div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="stock">Total Stock <span class="text-danger">*</span></label>
                      <input type="text" id="stock" name="stock" placeholder="Enter total stock of book." class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg4"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="shelf">Book Shelf No.</label>
                      <input type="text" id="shelf" name="shelf" placeholder="Enter book shelf no." class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg5"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="picture">Insert Picture</label>
                      <input type="file" id="picture" name="picture" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg6"></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="from-group">
                      <label for="description">Desciption</label>
                      <textarea id="description"></textarea>
                      <div class="error-msg errmsgTw" id="errmsg7"></div>
                    </div>
                  </div>
                </div>
                <div class="d-flex align-items-center mt-5">
                  <button name="bookRegSubmit"  class="btn btn-primary mr-2" id="bookRegSubmit">Submit</button>

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

<?php include_once(ADMINELEMENT.'footer.php');?>
<?php include_once(ADMINELEMENT.'script.php');?>
