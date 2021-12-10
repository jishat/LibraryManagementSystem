<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Renew\Renew;
$Renew = new Renew();
$renewRequestList = $Renew->renewRequestList();;
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
                <li class="breadcrumb-item active">Renew</li>
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
              <h3 class="card-title">Renew requested</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form method="post" id="renewDelete">
                <div class="main-top-filtering mb-2">
                  <div class="row">
                    <div class="col-md-2">
                      <div class="mailbox-controls">
                        <!-- Check all button -->
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                        </button>
                        <div class="btn-group">
                          <button type="button" name="deleteRenew" class="btn btn-default btn-sm deleteRenew"><i class="far fa-trash-alt"></i></button>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4 offset-md-2">
                      <!-- text filter control -->
                      <div class="input-group">
                        <input
                            data-jplist-control="textbox-filter"
                            data-group="renewgroup"
                            data-name="my-filter-1"
                            data-path=".searchstring"
                            type="text"
                            value=""
                            data-clear-btn-id="name-clear-btn"
                            placeholder="Search anything"
                            class="form-control" />
                          <div class="input-group-append">
                              <button class="btn btn-default" type="button" id="name-clear-btn">Clear</button>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="input-group">
                        <select
                          data-jplist-control="select-sort"
                          data-group="renewgroup"
                          data-name="name1"
                          class="form-control">
                          <option
                                  value="0"
                                  data-path="default"
                                  selected>Sort by</option>
                          <option
                                  value="1"
                                  data-path=".likes"
                                  data-order="asc"
                                  data-type="number">Oldest</option>
                          <option
                                  value="2"
                                  data-path=".likes"
                                  data-order="desc"
                                  data-type="number">Newest</option>
                          <option
                                  value="3"
                                  data-path=".title"
                                  data-order="asc"
                                  data-type="text">A-Z Category Name</option>
                          <option
                                  value="4"
                                  data-path=".title"
                                  data-order="desc"
                                  data-type="text">Z-A Category Name</option>

                        </select>

                      </div>

                    </div>


                    <div class="col-md-2">
                      <div
                              data-jplist-control="pagination"
                              data-group="renewgroup"
                              data-items-per-page="10"
                              data-current-page="0"
                              data-disabled-class="disabled"
                              data-selected-class="active"
                              data-name="pagination1">
                          <!-- items per page dropdown -->
                          <div class="dropdown d-flex"
                               data-type="items-per-page-dd"
                               data-opened-class="show">
                              <button
                              data-type="panel"
                              class=" form-control dropdown-toggle"
                              type="button">
                                  Dropdown button
                              </button>
                              <div
                                  data-type="content"
                                  class="dropdown-menu"
                                  aria-labelledby="dropdownMenuButton">
                                  <a class="dropdown-item" href="#" data-value="6">6 per page</a>
                                  <a class="dropdown-item" href="#" data-value="10">10 per page</a>
                                  <a class="dropdown-item" href="#" data-value="20">20 per page</a>
                                  <a class="dropdown-item" href="#" data-value="30">30 per page</a>
                                  <a class="dropdown-item" href="#" data-value="0">View All</a>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="mailbox-messages">
                  <table id="borrowTable" class="table tj-table borrow-table">
                    <thead>
                      <tr>
                        <th class="d-none">get count</th>
                        <th>
                          <!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                          </button> -->
                        </th>
                        <th>No.</th>
                        <th>Request From</th>
                        <th>Borrow No.</th>
                        <th>Return Date</th>
                        <th>Action</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody data-jplist-group="renewgroup">
                      <?php
                      if(!empty($renewRequestList) && $renewRequestList != "error"){
                        $x = count($renewRequestList);
                        $x += 1;
                        $y = 0;
                        foreach ($renewRequestList as $eachRenewRequestList) {
                          $y++ ?>

                          <tr class="eachBorrowData" data-jplist-item id="<?php echo 'eachData'.$eachRenewRequestList['renew_id'] ?>">
                            <td class="d-none likes">
                              <?php echo $x--; ?>
                            </td>
                            <td id="<?php echo 'renewCheckedBoxParent'.$y; ?>">
                              <div id="<?php echo 'renewCheckedBoxChild'.$y; ?>">
                                <?php
                                if ($eachRenewRequestList['renew_is_accept'] == 1) { ?>
                                  <div class="icheck-primary">
                                    <input type="checkbox" value="<?php echo $eachRenewRequestList['renew_id']; ?>" name="checkedrenewrequest[]" id="<?php echo 'check'.$eachRenewRequestList['renew_id']; ?>" style="">
                                    <label for="<?php echo 'check'.$eachRenewRequestList['renew_id']; ?>"></label>
                                  </div>
                                <?php
                                }
                                ?>
                              </div>

                            </td>
                            <td>
                              <?php echo $y; ?>
                            </td>
                            <td class="searchstring title">
                              <a href="<?php echo ADMINVIEW.'student/show.php?student_show='.urlencode($eachRenewRequestList['student_slug']); ?>" class="text-bold"> <?php echo $eachRenewRequestList['student_name']; ?></a>
                            </td>
                            <td class="searchstring title">
                              <a href="<?php echo ADMINVIEW.'borrow/show.php?borrow_show='.urlencode($eachRenewRequestList['renew_borrow_id']); ?>" class="text-bold"> <?php echo $eachRenewRequestList['borrow_id']; ?></a>
                            </td>
                            <td class="searchstring"><?php echo date('d M,Y', strtotime($eachRenewRequestList['date_request']));; ?></td>
                            <td class="actionParant">
                              <div class="actionChild d-inline-block" id="<?php echo 'actionChild'.$y; ?>" data-card_count="<?php echo $y; ?>">
                                <?php
                                if ($eachRenewRequestList['renew_is_accept'] == 0) { ?>
                                  <button type="button" name="acceptRenew" data-toggle="tooltip" title="Accept request"
                                    class="btn btn-success btn-sm acceptRenew" data-renew_info="<?php echo $eachRenewRequestList['renew_id']; ?>" data-action_id="<?php echo 'dateid'.$eachRenewRequestList['renew_id'] ?>">
                                    <i class="fas fa-check"></i>
                                  </button>
                                  <button type="button" name="rejectRenew" class="btn btn-danger btn-sm rejectRenew" data-renew_info="<?php echo $eachRenewRequestList['renew_id']; ?>" data-toggle="tooltip" title="Reject"><i class="fas fa-times"></i></button>

                                <?php
                              }elseif($eachRenewRequestList['renew_is_accept'] == 1){ ?>
                                  <button type="button" class="btn btn-secondary btn-sm" disabled>Accepted</button>
                                  <!-- <button type="button" name="deleteRenew" class="btn btn-danger btn-sm deleteRenew" data-renew_info="<?php echo $eachRenewRequestList['renew_id']; ?>" data-toggle="tooltip" title="Delete"><i class="fas fa-trash">
                                  </i></button> -->
                                <?php
                                }
                                ?>
                                <a class="btn btn-info btn-sm" style="padding-right:11px; padding-left:11px;" data-toggle="tooltip" title="" href="show.php?renew_show=<?php echo  $eachRenewRequestList['renew_id']?>" data-original-title="View Details">
                                  <i class="fas fa-info"></i>
                                </a>
                              </div>

                            </td>
                            <td>
                              <?php date_default_timezone_set("Asia/Dhaka");; ?>
                              <span data-toggle="tooltip" title="<?php echo date("h:i a  |  d M, Y", strtotime($eachRenewRequestList['renew_create_at'])); ?>">
                                <?php

                                $now = date("YmdHi", time());
                                $pstTimeStamp = date("YmdHi", strtotime($eachRenewRequestList['renew_create_at']));
                                if($now == $pstTimeStamp){
                                  echo "now";
                                }elseif(date("YmdH", time()) === date("YmdH", strtotime($eachRenewRequestList['renew_create_at']))){
                                  echo date("YmdHi", time()) - date("YmdHi", strtotime($eachRenewRequestList['renew_create_at']))." minute ago";
                                }elseif (date("Ymd", time()) === date("Ymd", strtotime($eachRenewRequestList['renew_create_at']))) {
                                  echo date("YmdH", time()) - date("YmdH", strtotime($eachRenewRequestList['renew_create_at']))." hour ago";
                                }elseif ((date("Ymd", time()) - date("Ymd", strtotime($eachRenewRequestList['renew_create_at'])))  === 1){
                                  echo "yesterday";
                                }elseif (date("Ym", time()) === date("Ym", strtotime($eachRenewRequestList['renew_create_at'])) && (date("Ymd", time()) - date("Ymd", strtotime($eachRenewRequestList['renew_create_at'])))  > 1) {
                                  echo date("Ymd", time()) - date("Ymd", strtotime($eachRenewRequestList['renew_create_at']))." days ago";
                                }elseif (date("Y", time()) === date("Y", strtotime($eachRenewRequestList['renew_create_at'])) && (date("Ymd", time()) - date("Ymd", strtotime($eachRenewRequestList['renew_create_at'])))  > 30) {
                                  echo date("Ym", time()) - date("Ym", strtotime($eachRenewRequestList['renew_create_at']))." month ago";
                                }else{
                                  echo date("d M, Y", strtotime($eachRenewRequestList['renew_create_at']));
                                }

                                ?>
                              </span>
                            </td>
                          </tr>

                      <?php
                        }
                      }else {
                        // echo "No Data found";
                      } ?>



                    </tbody>
                  </table>

                  <div data-jplist-control="no-results" data-group="renewgroup" data-name="no-results" class="text-center"><div>No Results Found</div></div>

                </div>
              </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer ">
              <!-- pagination control -->
              <div
                data-jplist-control="pagination"
                data-group="renewgroup"
                data-items-per-page="10"
                data-current-page="0"
                data-disabled-class="disabled"
                data-selected-class="active"
                data-name="pagination1"
                data-id="page"
                class="d-flex align-items-start"
                id="mainPagination">

                <!-- information labels -->
                    <span data-type="info" class="badge badge-secondary p-2">
                        Page {pageNumber} of {pagesNumber}
                    </span>

                  <div class="ml-auto">
                    <!-- first and previous buttons -->
                    <ul class="pagination d-inline-flex">
                        <li class="page-item" data-type="first"><a class="page-link" href="#">First</a></li>
                        <li class="page-item" data-type="prev"><a class="page-link" href="#">Prev</a></li>
                    </ul>

                    <!-- pages buttons -->
                    <ul class="pagination d-inline-flex" data-type="pages">
                        <li class="page-item" data-type="page"><a class="page-link" href="#">{pageNumber}</a></li>
                    </ul>

                    <!-- next and last buttons -->
                    <ul class="pagination d-inline-flex">
                        <li class="page-item" data-type="next"><a class="page-link" href="#">Next</a></li>
                        <li class="page-item" data-type="last"><a class="page-link" href="#">Last</a></li>
                    </ul>
                  </div>
              </div>
            </div>


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
