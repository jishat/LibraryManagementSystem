<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Renew\Renew;

if(isset($_GET['renew_show'])){
  $id = $_GET['renew_show'];
}else{
  header('location:'.ADMIN.'404.php');
  exit();
}

$Renew = new Renew();
$renewSingleData = $Renew->renewSingleData($id);

if($renewSingleData== "error"){
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
              <a href="javascript:history.go(-1)" title="Return to the previous page" class="btn btn-primary btn-sm rounded-pill"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go Back</a>
            </div>
          </div>
          <div class="col-6">
            <div class="mr-2">
              <ol class="breadcrumb ">
                <li class="breadcrumb-item ml-auto"><a href="<?php echo ADMINVIEW.'dashboard'?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo ADMINVIEW.'renew'?>">Renew</a></li>
                <li class="breadcrumb-item active"><?php echo $renewSingleData['borrow_id']; ?></li>
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
            <div class="card-header tj-card-header d-flex">
              <h3 class="card-title">Request for renew a book </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="">
                <tbody>
                  <tr>
                    <td class="text-muted py-2 pr-4 pl-2 text-nowrap">Borrow No:</td>
                    <td class="p-2"><strong><a href="<?php echo ADMINVIEW.'borrow/show.php?borrow_show='.urlencode($renewSingleData['renew_borrow_id']); ?>" class="text-bold"> <?php echo $renewSingleData['borrow_id']; ?></a></strong></td>
                  </tr>
                  <tr>
                    <td class="text-muted py-2 pr-4 pl-2 text-nowrap">Request renew date:</td>
                    <td class="p-2"><strong><?php echo date('Y-m-d', strtotime($renewSingleData['date_request']));; ?></strong></td>
                  </tr>
                  <tr>
                    <td class="text-muted py-2 pr-4 pl-2 text-nowrap">Request From:</td>
                    <td class="p-2"> <strong> <a href="<?php echo ADMINVIEW.'student/show.php?student_show='.urlencode($renewSingleData['student_slug']); ?>"><?php echo $renewSingleData['student_name']; ?></a> </strong></td>
                  </tr>
                  <tr>
                    <td class="text-muted py-2 pr-4 pl-2 text-nowrap">Action:</td>
                    <td class="p-2" id="actionParant">
                      <div id="actionChild">
                        <?php
                        if ($renewSingleData['renew_is_accept'] == 0) { ?>
                          <button type="button" name="acceptRenew" data-toggle="tooltip" title="Accept request"
                            class="btn btn-success btn-sm acceptRenew" data-renew_info="<?php echo $renewSingleData['renew_id']; ?>" data-action_id="<?php echo 'dateid'.$renewSingleData['renew_id'] ?>">
                            <i class="fas fa-check"></i>
                          </button>
                          <button type="button" name="rejectRenew" class="btn btn-danger btn-sm rejectRenew" data-renew_info="<?php echo $renewSingleData['renew_id']; ?>" data-toggle="tooltip" title="Reject"><i class="fas fa-times"></i></button>
                        <?php
                        }elseif($renewSingleData['renew_is_accept'] == 1){ ?>
                          <form id="renewDelete" method="post">
                            <button type="button" class="btn btn-secondary btn-sm" disabled>Accepted</button>
                            <input type="text" name="checkedrenewrequest[]" value="<?php echo $renewSingleData['renew_id']; ?>" class="d-none">
                            <button type="button" name="deleteRenew" class="btn btn-danger btn-sm deleteRenew" data-toggle="tooltip" title="Delete"><i class="fas fa-trash">
                            </i></button>
                          </form>

                        <?php
                        }
                        ?>
                      </div>
                    </td>
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
