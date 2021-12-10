<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Student\Student;
use App\Book\Book;
use App\User\User;
use App\Borrow\Borrow;

$Student = new Student;
$allStudents = $Student->allStudents();

$Book = new Book;
$allBooks = $Book->allBooks();

$User = new User;
$allUser = $User->allUser();

$Borrow = new Borrow;
$getAllBorrowList = $Borrow->getAllBorrowList();

include_once(ADMINELEMENT.'head.php');
include_once(ADMINELEMENT.'navigation.php');
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Dashboard v2</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v2</li>
              </ol>
            </div>
          </div>
        </div>
      </div> -->
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content mt-5 pt-5">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php echo count($allStudents); ?></h3>

                  <p>Total Student</p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-graduate"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?php echo count($allBooks); ?></h3>

                  <p>Total Book</p>
                </div>
                <div class="icon">
                  <i class="fas fa-book"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
              <!-- small box -->
              <div class="small-box bg-primary">
                <div class="inner">
                  <h3><?php echo count($allUser); ?></h3>

                  <p>Total User</p>
                </div>
                <div class="icon">
                  <i class="fas fa-users"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
          <!-- /.row -->
        </div><!--/. container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

<?php include_once(ADMINELEMENT.'footer.php');?>
<?php include_once(ADMINELEMENT.'script.php');?>
