<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Borrow\Borrow;
use App\Category\Category;

if(isset($_GET['borrow_show'])){
  $id = $_GET['borrow_show'];
}else{
  header('location:'.ADMIN.'404');
  exit();
}
$Borrow= new Borrow();
$singleData = $Borrow->singleData($id);

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
                <li class="breadcrumb-item"><a href="<?php echo ADMINVIEW.'borrow'?>">Borrow</a></li>
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

            <!-- Book Image -->
            <div class="card card-primary  tj-card mb-4">
              <div class="card-header">
                <h3 class="card-title">Book Requested</h3>
              </div>
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="img-fluid"
                       src="<?= !empty($singleData['picture']) ? IMAGESBOOK.$singleData['picture'] : IMG.'avatar-man.png';?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center mt-3"><?php echo $singleData['book_name']; ?></h3>

                <p class="text-muted text-center"><?php echo $singleData['writer']; ?></p>


                <a href="<?php echo ADMINVIEW.'book/show.php?book_show='.urlencode($singleData['slug']); ?>" class="btn btn-success btn-block"><b>Book Details</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-primary tj-card" id="userCardChild">
              <div class="card-header">
                <h3 class="card-title">Who Requested</h3>
              </div>
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="http://localhost/ciu/upload/user/5edbccd58c7a61591463125.jpg" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">Azizur Rahman Jishat</h3>

                <p class="text-muted text-center">EEE</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>ID</b> <a class="float-right">34343</a>
                  </li>
                  <li class="list-group-item">
                    <b>Batch</b> <a class="float-right">34</a>
                  </li>
                  <li class="list-group-item">
                    <b>Gender</b> <a class="float-right">Male</a>
                  </li>
                </ul>
                <a href="<?php echo 'edit.php?book_edit='.urlencode($singleData['slug']); ?>" class="btn btn-success btn-block"><b>View Details</b></a>
              </div>
              <!-- /.card-body -->
            </div>

            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card tj-card">
              <div class="card-header tj-card-header p-3 d-flex">
                  <h3 class="card-title">Borrow No. <strong><?php echo $singleData['borrow_id']; ?></strong> </h3>
                  <?php if(isset($singleData['update_at']) && $singleData['update_at'] != ""){ ?>
                    <span class="ml-auto text-muted text-sm ">Last Update: <span class="font-weight-bold"> <?php echo date("h:i a  |  d M, Y", strtotime($singleData['update_at'])); ?></span></span>
                  <?php
                  } ?>

              </div><!-- /.card-header -->
              <div class="card-body">
                <strong>Book ID:</strong>
                <p class="text-muted">
                  <?php echo $singleData['book_no']; ?>
                </p>
                <hr>
                <strong>Book Name:</strong>
                <p class="text-muted">
                  <?php echo $singleData['book_name']; ?>
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

                <strong>Return date:</strong>
                <div class="searchstring returnDateParent mt-2" id="returnDateParent">
                  <div class="returnDateChild d-flex align-items-center" id="returnDateChild">

                    <?php
                    if ($singleData['is_accept'] == 0) { ?>
                      <span class="badge badge-warning p-2"> <?php echo date("d M, Y", strtotime($singleData['return_date'])); ?></span>
                    <?php
                    }else {
                      date_default_timezone_set('Asia/Dhaka');
                      $now    = date("Y-m-d", time());
                      $expiry = date("Y-m-d", strtotime($singleData['return_date']));
                      $accept = date("Y-m-d", strtotime($singleData['accept_at']));

                      $getNow   = new DateTime($now);
                      $getExpiry = new DateTime($expiry);
                      $difference  = $getNow->diff($getExpiry);
                      $totalDays = $difference->days;

                      $accept_at = new DateTime($accept);
                      $difference2  = $accept_at->diff($getExpiry);

                      $totalDaysArchive = $difference2->days;
                      $remainingDays = $totalDaysArchive - $totalDays;

                      // print_r($difference);
                      $percentage = 100 / $totalDaysArchive * $remainingDays;

                      if(date("Ymd", strtotime($singleData['return_date'])) < date("Ymd", time())){
                      ?>

                      <div class="progress tj_progress" data-toggle="tooltip" title="Return date has been expired at <?php echo $expiry; ?>" style="width:150px;">
                        <div class="px-2 text-bold progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width:100%"></div>
                        <span>Expired</span>
                      </div>
                      <p class="text-muted text-bold text-sm ml-2 mb-0"> <?php echo date("d M, Y", strtotime($singleData['return_date'])); ?></p>
                    <?php
                      }else { ?>
                        <div class="progress tj_progress" data-toggle="tooltip" title="<?php echo 'Total has '.$totalDays.' more days for return book'; ?>" style="width:150px;">
                          <div class="px-2 text-bold progress-bar progress-bar-striped progress-bar-animated <?php echo $totalDays > 4 ? 'bg-info' : ($totalDays <= 4 && $totalDays > 2 ? 'bg-warning' : 'bg-danger');  ?>" style="width:<?php echo $percentage.'%'; ?>"></div>
                          <span><?php echo $totalDays.' more days'; ?></span>
                        </div>
                        <p class="text-muted text-bold  text-sm ml-2 mb-0"> <?php echo date("d M, Y", strtotime($singleData['return_date'])); ?></p>
                    <?php
                      }
                    }
                    ?>
                  </div>
                </div>
                <hr>
                <strong>Action:</strong>
                <div class="actionParant mt-2" id="actionParant">
                  <div class="actionChild d-inline-block" id="actionChild" data-card_count="<?php echo $y; ?>">
                    <?php
                    if ($singleData['is_accept'] == 0) { ?>
                      <button type="button" name="borrowAccept" class="btn btn-success btn-sm borrowAccept" data-borrow_info="<?php echo $singleData['id']; ?>" data-toggle="tooltip" title="Accept"><i class="fas fa-check"></i></button>
                      <button type="button" name="borrowReject" class="btn btn-danger btn-sm borrowReject" data-borrow_info="<?php echo $singleData['id']; ?>" data-toggle="tooltip" title="Reject"><i class="fas fa-times"></i></button>
                    <?php
                    }else { ?>
                      <span class="dropdown-main">
                        <button type="button" name="dropdownMenu" class="btn btn-success btn-sm renewBtn" data-get_input="<?php echo 'dateid'.$singleData['id'] ?>">
                          <span data-toggle="tooltip" title="Renew borrow date"><i class="fas fa-sync-alt"></i></span>
                        </button>
                        <div class="dropdown-menu-tj px-2 text-center">
                            <div class="form-group">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                  </span>
                                </div>
                                <input type="text" id="<?php echo 'dateid'.$singleData['id'] ?>" class="<?php echo 'dateid'.$singleData['id'] ?> form-control form-control-sm float-right reservation" name="reservation" data-return_date="<?php echo date("Y m d", strtotime($singleData['return_date'])); ?>">
                              </div>
                            </div>
                            <button type="button" name="borrowRenewSubmit" data-toggle="popover" data-placement="bottom"  class="btn btn-primary btn-sm borrowRenewSubmit" data-borrow_info="<?php echo $singleData['id']; ?>" data-action_id="<?php echo 'dateid'.$singleData['id'] ?>">
                              <span data-toggle="tooltip" title="Renew borrow date">Submit</span>
                            </button>
                        </div>
                      </span>

                      <button type="button" name="borrowReturn" class="btn btn-danger btn-sm borrowReturn" data-borrow_info="<?php echo $singleData['id']; ?>" data-toggle="tooltip" title="Return Book"><i class="fas fa-retweet"></i></button>


                    <?php
                    }
                    ?>
                  </div>

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
