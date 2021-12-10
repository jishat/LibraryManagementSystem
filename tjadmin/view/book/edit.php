<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Category\Category;
use App\Book\Book;

$msg = Message::getMessage();

if(isset($_GET['book_edit'])){
  $slug = $_GET['book_edit'];
}else{
  header('location:'.WEBROOT.'404');
  exit();
}

$Book = new Book();
$singleData = $Book->singleData($slug);

if($singleData == "error"){
  header('location:'.ADMIN.'404.php');
  exit();
}
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
                <li class="breadcrumb-item active"><?php echo $singleData['book_name']; ?></li>
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
              <h3 class="card-title">Information of <strong> <?php echo $singleData['book_name']; ?> </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div id="errmsgParant"></div>
              <form method="post" enctype="multipart/form-data" id="editBookForm">
                <div class="row">
                  <div class="col-md-12 mb-5">
                    <div class="ImgEdit mt-2">
                      <img src="<?php echo !empty($singleData['picture']) ? IMAGESBOOK.$singleData['picture'] : IMG.'dummybook.jpg';?>" alt="<?php echo $singleData['name']; ?>" class="selectedavatar" id="selectedavatar">
                      <span id="uploadimg"><i class="fas fa-camera"></i></span>
                      <span id="deleteimg" data-img_delete="0"><i class="far fa-trash-alt"></i></span>
                      <input type="file" class="ImgInput" id="ImgInput" name="picture">
                      <div class="error-msg errmsgTw" id="errmsg6"></div>
                    </div>
                  </div>
                  <!-- <div class="col-md-6">
                    <div class="form-group">
                      <label for="studentPicture">Insert Picture</label>
                      <input type="file" id="studentPicture" name="studentPicture" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg10"></div>
                    </div>
                  </div> -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Name <span class="text-danger">*</span></label>
                      <input type="text" id="name" name="name" placeholder="Enter book name" value="<?php echo $singleData['book_name']; ?>" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg1"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="writer">Writer name</label>
                      <input type="text" id="writer" name="writer" placeholder="Enter student ID no." value="<?php echo $singleData['writer']; ?>" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg2"></div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="category">Category <span class="text-danger">*</span></label>
                        <select id="category" class="select2 form-control" multiple="multiple" data-placeholder="Select category" name="category[]">
                          <?php
                          if(isset($singleData['category']) && $singleData['category'] != ""){
                            $strRep = str_replace(',', " ", $singleData['category']);
                            $substr = substr($strRep, 1);
                            $explds  = explode(" ", $substr);
                            $Category = new Category();
                            echo $Category->fetchCategoryEdited($parent_id = NULL, $sub_mark = '', $explds);
                          }
                          ?>
                        </select>
                      <div class="error-msg errmsgTw" id="errmsg3"></div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="stock">Total Stock <span class="text-danger">*</span></label>
                      <input type="text" id="stock" name="stock" placeholder="Enter total stock of book." value="<?php echo $singleData['total_stock']; ?>" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg4"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="shelf">Book Shelf No.</label>
                      <input type="text" id="shelf" name="shelf" placeholder="Enter book shelf no." value="<?php echo $singleData['book_shelf']; ?>" class="form-control">
                      <div class="error-msg errmsgTw" id="errmsg5"></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="from-group">
                      <?php $description = str_replace( '&', '&amp;', $singleData['description'] ); ?>
                      <label for="description">Desciption</label>
                      <textarea id="description"><?php echo $description; ?></textarea>
                      <div class="error-msg errmsgTw" id="errmsg7"></div>
                    </div>
                  </div>
                </div>
                <div class="d-flex align-items-center mt-4">
                  <button name="bookEditSubmit" data-infoid_book="<?php echo $singleData['id']; ?>" id="bookEditSubmit" class="btn btn-primary mr-2">Submit</button>
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
