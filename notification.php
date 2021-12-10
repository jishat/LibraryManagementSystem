<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');?>
<?php
use App\Login\Login;
use App\Notification\Notification;

$student_to = Login::loginGet('id');
$Notification = new Notification();
$allNotifications = $Notification->allStudentNotifications($student_to);
$unseenStudentNotifications = $Notification->unseenStudentNotifications($student_to);
?>
<?php include_once(ELEMENT.'head.php');?> <!-- include header section -->
<?php include_once(ELEMENT.'header.php');?> <!-- include navigation section -->

<!-- Content Wrapper. Contains page content -->
<section id="notification-section">


  <!-- Main content -->
  <div class="container">
    <div class="row">
      <!-- /.col -->
      <div class="col-md-12">
        <form method="post" id="notidicationDelete">
          <div class="card card-primary card-outline" id="notifyCard">
            <div class="card-header">
              <h3 class="card-title d-none d-sm-block">All Notification</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm">
                  <input
                      data-jplist-control="textbox-filter"
                      data-group="allnotificationgroup"
                      data-name="my-filter-1"
                      data-path=".searchstring"
                      type="text"
                      value=""
                      data-clear-btn-id="name-clear-btn"
                      placeholder="Search Anything"
                      class="form-control" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="name-clear-btn">Clear</button>
                    </div>
                </div>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
                <div class="btn-group">
                  <button type="button" name="notifyDeleteBtn" class="btn btn-default btn-sm notifyDeleteBtn"><i class="far fa-trash-alt"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm syncNotification"><i class="fas fa-sync-alt"></i></button>
                <div class="float-right">
                  <!-- 1-50/200 -->
                  <div class="btn-group">
                    <!-- pagination control -->
                    <div
                            data-jplist-control="pagination"
                            data-group="allnotificationgroup"
                            data-items-per-page="10"
                            data-current-page="0"
                            data-name="pagination1">
                        <span data-type="info" class="p-2">
                            Page {pageNumber} of {pagesNumber}
                        </span>
                        <button type="button" class="btn btn-default btn-sm" data-type="prev"><i class="fas fa-chevron-left"></i></button>
                        <!-- pages buttons -->
                        <ul class="pagination d-none" data-type="pages">
                            <li class="page-item" data-type="page"><a class="page-link" href="#">{pageNumber}</a></li>
                        </ul>
                        <button type="button" class="btn btn-default btn-sm" data-type="next"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <!-- <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-right"></i></button> -->
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover">
                  <tbody  data-jplist-group="allnotificationgroup">
                  <?php
                  if(!empty($allNotifications) && $allNotifications !== "error"){
                    $x = 0;
                    foreach ($allNotifications as $eachNotification) {
                      $x++;
                    ?>
                    <tr data-jplist-item class="eachData <?php echo 'eachData'.$eachNotification['id']; ?> <?php echo $eachNotification['is_read'] == 1 ? 'bg-light' : ''; ?>">
                      <td>
                        <div class="icheck-primary">
                          <input type="checkbox" value="<?php echo $eachNotification['id']; ?>" name="checkednotification[]" id="<?php echo 'check'.$x; ?>">
                          <label for="<?php echo 'check'.$x; ?>"></label>
                        </div>
                      </td>
                      <!-- data-toggle="modal" data-target="#modal-md" -->
                      <td class="mailbox-name searchstring">
                        <span class="styleLoading"></span>
                        <a href="javascript:void(0)"  class="<?php echo $eachNotification['is_read'] == 0 ? 'text-bold' : ''; ?> readNotification" data-notify_id="<?php echo $eachNotification['id']; ?>" data-method="readNotification"  data-is_read="<?php echo $eachNotification['is_read']; ?>">
                          <?php echo 'Admin' ?></a>
                      </td>
                      <td class="mailbox-subject searchstring <?php echo $eachNotification['is_read'] == 0 ? 'text-bold' : ''; ?>"><?php echo trim($eachNotification['subject']); ?>
                      </td>
                      <td class="mailbox-date"><?php date_default_timezone_set("Asia/Dhaka");
                        $now = date("YmdHi", time());
                        $pstTimeStamp = date("YmdHi", strtotime($eachNotification['notify_at']));
                        if($now == $pstTimeStamp){
                          echo "now";
                        }elseif(date("YmdH", time()) === date("YmdH", strtotime($eachNotification['notify_at']))){
                          echo date("YmdHi", time()) - date("YmdHi", strtotime($eachNotification['notify_at']))." minute ago";
                        }elseif (date("Ymd", time()) === date("Ymd", strtotime($eachNotification['notify_at']))) {
                          echo date("YmdH", time()) - date("YmdH", strtotime($eachNotification['notify_at']))." hour ago";
                        }elseif ((date("Ymd", time()) - date("Ymd", strtotime($eachNotification['notify_at'])))  === 1){
                          echo "yesterday";
                        }else{
                          echo date("d M, Y", strtotime($eachNotification['notify_at']));
                        }

                        ?></td>
                    </tr>
                  <?php
                    }
                  } ?>
                  </tbody>
                </table>
                <!-- /.table -->
                <!-- no results control -->
                <div data-jplist-control="no-results" data-group="allnotificationgroup" data-name="no-results" class="px-2 py-3">No Results Found</div>
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0 border-top">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
                <div class="btn-group">
                  <button type="button" name="notifyDeleteBtn" class="btn btn-default btn-sm notifyDeleteBtn"><i class="far fa-trash-alt"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm syncNotification"><i class="fas fa-sync-alt"></i></button>
                <div class="float-right">
                  <!-- 1-50/200 -->
                  <div class="btn-group">
                    <!-- pagination control -->
                    <div
                            data-jplist-control="pagination"
                            data-group="allnotificationgroup"
                            data-items-per-page="10"
                            data-current-page="0"
                            data-id="page"
                            data-name="pagination1">
                        <span data-type="info" class="p-2">
                            Page {pageNumber} of {pagesNumber}
                        </span>
                        <button type="button" class="btn btn-default btn-sm" data-type="prev"><i class="fas fa-chevron-left"></i></button>
                        <!-- pages buttons -->
                        <ul class="pagination d-none" data-type="pages">
                            <li class="page-item" data-type="page"><a class="page-link" href="#">{pageNumber}</a></li>
                        </ul>
                        <button type="button" class="btn btn-default btn-sm" data-type="next"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <!-- <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-right"></i></button> -->
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
            </div>
          </div>
          <!-- /.card -->
        </form>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.content -->
</section>
<!-- /.content-wrapper -->


<div class="modal fade" id="notificationModal"><div class="modal-dialog modal-md"><div class="modal-content" id="modalContent">
  <div class="modal-header">
    <h4 class="modal-title" id="modalSubject"></h4>
  </div>
  <div class="modal-body" id="modalComment">
  </div>
  <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div></div></div>

<?php include_once(ELEMENT.'footer.php');?> <!-- include Footer section -->
<?php include_once(ELEMENT.'script.php');?> <!-- include Footer section -->
