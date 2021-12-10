<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Utility\Adminpages;
$Adminpages = new Adminpages();
$allPages = $Adminpages->allPages();
$allPageId=array();

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
              <a href="javascript:history.go(-1)" data-toggle="tooltip" title="Return to the previous page" class="btn btn-primary btn-sm rounded-pill"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go Back</a>
            </div>
          </div>
          <div class="col-6">
            <div class="mr-2">
              <ol class="breadcrumb ">
                <li class="breadcrumb-item ml-auto"><a href="<?php echo ADMINVIEW.'dashboard'?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo ADMINVIEW.'user-role'?>">User Role</a></li>
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
          <div class="card tj-card">
            <div class="card-header tj-card-header">
              <h3 class="card-title">Create New User Role</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="errmsgParant"></div>
              <form method="post" enctype="multipart/form-data" id="regUserRoleForm">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="userRoleName">Name <span class="text-danger">*</span></label>
                      <input type="text" id="userRoleName" name="userRoleName" placeholder="Enter full name" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg1"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <?php if(isset($allPages) && $allPages !== "error" && !empty($allPages)){ ?>
                        <label for="permissionPages">Permision Pages <span class="text-danger">*</span></label>
                        <select id="permissionPages" class="select2 form-control" multiple="multiple" data-placeholder="Select a State" name="permissionPages[]">
                          <?php
                            foreach($allPages as $allPage){
                              echo '<option value="'.$allPage['id'].'">'.$allPage['name'].'</option>';
                            }
                          ?>
                        </select>
                      <?php
                      }else{
                        echo "<p>Something went wrong. Please contact with developer.</p>";
                      } ?>
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
                  <button name="userRoleRegSubmit" id="userRoleRegSubmit" class="btn btn-primary mr-2">Submit</button>
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
