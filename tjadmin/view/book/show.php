<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Book\Book;
use App\Category\Category;

$msg = Message::getMessage();
if(isset($_GET['book_show'])){
  $slug = $_GET['book_show'];
}else{
  header('location:'.WEBROOT.'404');
  exit();
}
$Book = new Book();
$singleData = $Book->singleData($slug);

if($singleData == "error"){
  header('location:'.ADMIN.'404');
  exit();
}
?>
<?php include_once(ADMINELEMENT.'head.php');?>
<?php include_once(ADMINELEMENT.'navigation.php');?> <!-- include navigation section -->

<?php
// $allAdmin = $Admin->allAdmin(); //already oject created in navigation
?>
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
                <li class="breadcrumb-item"><a href="<?php echo ADMINVIEW.'book'?>">Book</a></li>
                <li class="breadcrumb-item active"><?php echo $singleData['book_name']; ?></li>
              </ol>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline tj-card">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="img-fluid"
                       src="<?php echo !empty($singleData['picture']) ? IMAGESBOOK.$singleData['picture'] : IMG.'dummybook.jpg';?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center mt-3"><?php echo $singleData['book_name']; ?></h3>

                <p class="text-muted text-center"><?php echo $singleData['writer']; ?></p>

                <div class="d-flex">
                  <div class="mr-auto">
                      <div class="custom-control custom-switch custom-switch-on-success">
                        <input type="checkbox" class="custom-control-input bookStatus" <?php echo $singleData['status'] == 1 ? 'checked' : '' ; ?> id="customSwitch" data-status="<?php echo $singleData['status']; ?>" data-id="<?php echo $singleData['id']; ?>">
                        <label class="custom-control-label text-sm pt-1" for="customSwitch"><?php echo $singleData['status'] == 1 ? 'Active' : 'Deactive' ; ?></label>
                      </div>
                  </div>

                  <div class="ml-auto">
                    <button class="btn btn-danger btn-sm bookDelBtn" data-toggle="tooltip" title="Delete Book" id="bookDelBtn" data-book_info="<?php echo $singleData['id']; ?>" name="bookDelBtn">
                        <i class="fas fa-trash">
                        </i>
                    </button>
                    <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit Book" href="<?php echo 'edit.php?book_edit='.urlencode($singleData['slug']); ?>">
                        <i class="fas fa-pencil-alt">
                        </i>
                    </a>
                  </div>
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card tj-card">
              <div class="card-header tj-card-header p-3 d-flex">
                  <h3 class="card-title">About <strong><?php echo $singleData['book_name']; ?></strong> </h3>
                  <?php if(isset($singleData['update_at']) && $singleData['update_at'] != ""){ ?>
                    <span class="ml-auto text-muted text-sm ">Last Update: <span class="font-weight-bold"> <?php echo date("h:i a  |  d M, Y", strtotime($singleData['update_at'])); ?></span></span>
                  <?php
                  } ?>

              </div><!-- /.card-header -->
              <div class="card-body">
                <strong>Book ID:</strong>
                <p class="text-muted">
                  <?php echo $singleData['book_id']; ?>
                </p>
                <hr>
                <strong>Name:</strong>
                <p class="text-muted">
                  <?php echo $singleData['book_name']; ?>
                </p>
                <hr>
                <strong>Writer:</strong>
                <p class="text-muted">
                  <?php echo $singleData['writer']; ?>
                </p>
                <hr>
                <strong>Total Stock:</strong>
                <p class="text-muted">
                  <?php echo $singleData['total_stock']; ?>
                </p>
                <hr>
                <strong>Total Borrowed:</strong>
                <p class="text-muted">
                  <?php echo $singleData['total_borrowed']; ?>
                </p>
                <hr>
                <strong>Book Shelf:</strong>
                <p class="text-muted">
                  <?php echo $singleData['book_shelf']; ?>
                </p>
                <hr>
                <strong>Category:</strong>
                <div class="tj-unlink-btn mt-2">
                <?php

                  if(isset($singleData['category']) && $singleData['category'] != ""){
                    $strRep = str_replace(',', " ", $singleData['category']);
                    $substr = substr($strRep, 1);
                    $explds  = explode(" ", $substr);

                    $Category = new Category();
                    foreach ($explds as $expld) {
                      $categoryInfoById = $Category->categoryInfoById($expld);
                      if(isset($categoryInfoById) && $categoryInfoById != "error"){
                        echo'<span class="mb-2">'.$categoryInfoById['category_name'].'</span>';
                      }
                    }
                  }
                 ?>
                 </div>
                <hr>

                <strong>Description:</strong>
                <div class="mt-3">
                  <?php echo $singleData['description']; ?>
                </div>


              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->





<?php include_once(ADMINELEMENT.'footer.php');?>
<?php include_once(ADMINELEMENT.'script.php');?>
