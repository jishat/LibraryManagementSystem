<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Book\Book;
use App\Borrow\Borrow;

$Borrow = new Borrow();
$getAllBorrowList = $Borrow->getAllBorrowList();
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
                <li class="breadcrumb-item active">Borrow</li>
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
            <div class="card-header tj-card-header d-flex">
              <h3 class="card-title">Manage Borrow</h3>
              <a href="<?= ADMINVIEW.'borrow/create.php'?>" class="ml-auto btn btn-sm btn-primary">Add New</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="main-top-filtering mb-4">
                <div class="row">
                  <div class="col-md-2">
                    <div
                            data-jplist-control="pagination"
                            data-group="borrowgroup"
                            data-items-per-page="10"
                            data-current-page="0"
                            data-disabled-class="disabled"
                            data-selected-class="active"
                            data-name="pagination1">
                        <!-- items per page dropdown -->
                        <div class="dropdown d-inline-flex"
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

                  <div class="col-md-2 offset-md-4">
                    <div class="input-group">
                      <select
                        data-jplist-control="select-sort"
                        data-group="borrowgroup"
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
                                data-type="text">A-Z Book Name</option>
                        <option
                                value="4"
                                data-path=".title"
                                data-order="desc"
                                data-type="text">Z-A Book Name</option>

                      </select>

                    </div>

                  </div>

                  <div class="col-md-4">
                    <!-- text filter control -->
                    <div class="input-group">
                      <input
                          data-jplist-control="textbox-filter"
                          data-group="borrowgroup"
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
                </div>
              </div>


              <div class="">
                <table id="borrowTable" class="table tj-table borrow-table">
                  <thead>
                    <tr>
                      <th class="d-none">get count</th>
                      <th>SL</th>
                      <th>Borrow No.</th>
                      <th>Image</th>
                      <th>Book ID</th>
                      <th>Book Name</th>
                      <th>Student</th>
                      <th>Return date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody data-jplist-group="borrowgroup">
                    <?php
                    if(!empty($getAllBorrowList) && $getAllBorrowList != "error"){
                      $x = count($getAllBorrowList);
                      $x += 1;
                      $y = 0;
                      foreach ($getAllBorrowList as $eachBorrow) {
                        $y++ ?>
                        <tr class="eachBorrowData" id="<?php echo "eachData".$eachBorrow['id']; ?>" data-jplist-item>
                          <td class="d-none likes">
                            <?php echo $x--; ?>
                          </td>
                          <td>
                            <?php echo $y; ?>
                          </td>
                          <td class="searchstring">
                            <?php echo $eachBorrow['borrow_id']; ?>
                          </td>
                          <td><img width="55" src="<?php echo !empty($eachBorrow['picture']) ? IMAGESBOOK.$eachBorrow['picture'] : IMG.'dummybook.jpg';?>" alt="<?php echo $eachBorrow['book_name']; ?>"></td>
                          <td class="searchstring"><?php echo $eachBorrow['book_id']; ?></td>
                          <td class="searchstring title"> <a href="<?php echo ADMINVIEW.'book/show.php?book_show='.urlencode($eachBorrow['slug']); ?>"><?php echo $eachBorrow['book_name']; ?></a> </td>
                          <td class="searchstring"> <a href="<?php echo ADMINVIEW.'student/show.php?student_show='.urlencode($eachBorrow['student_slug']); ?>"><?php echo $eachBorrow['student_name']; ?></a> </td>
                          <td class="searchstring returnDateParent">
                            <div class="returnDateChild" id="<?php echo 'returnDateChild'.$y; ?>">
                              <?php
                              if ($eachBorrow['is_accept'] == 0) { ?>
                                <span class="badge badge-warning p-2"> <?php echo date("d M, Y", strtotime($eachBorrow['return_date'])); ?></span>
                              <?php
                              }else {
                                date_default_timezone_set('Asia/Dhaka');
                                $now    = date("Y-m-d", time());
                                $expiry = date("Y-m-d", strtotime($eachBorrow['return_date']));
                                $accept = date("Y-m-d", strtotime($eachBorrow['accept_at']));

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

                                if(date("Ymd", strtotime($eachBorrow['return_date'])) < date("Ymd", time())){
                                ?>
                                <div class="progress tj_progress" data-toggle="tooltip" title="Return date has been expired at <?php echo $expiry; ?>" style="width:150px;">
                                  <div class="px-2 text-bold progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width:100%"></div>
                                  <span>Expired</span>
                                </div>
                              <?php
                                }else { ?>
                                  <div class="progress tj_progress" data-toggle="tooltip" title="<?php echo 'Total has '.$totalDays.' more days for return'; ?>" style="width:150px;">
                                    <div class="px-2 text-bold progress-bar progress-bar-striped progress-bar-animated <?php echo $totalDays > 4 ? 'bg-info' : ($totalDays <= 4 && $totalDays > 2 ? 'bg-warning' : 'bg-danger');  ?>" style="width:<?php echo $percentage.'%'; ?>"></div>
                                    <span><?php echo $totalDays.' more days'; ?></span>
                                  </div>
                              <?php
                                }
                              }
                              ?>
                            </div>
                          </td>
                          <td class="actionParant">
                            <div class="actionChild d-inline-block" id="<?php echo 'actionChild'.$y; ?>" data-card_count="<?php echo $y; ?>">
                              <?php
                              if ($eachBorrow['is_accept'] == 0) { ?>
                                <button type="button" name="borrowAccept" class="btn btn-success btn-sm borrowAccept" data-borrow_info="<?php echo $eachBorrow['id']; ?>" data-toggle="tooltip" title="Accept"><i class="fas fa-check"></i></button>
                                <button type="button" name="borrowReject" class="btn btn-danger btn-sm borrowReject" data-borrow_info="<?php echo $eachBorrow['id']; ?>" data-toggle="tooltip" title="Reject"><i class="fas fa-times"></i></button>
                              <?php
                            }else { ?>
                              <span class="dropdown-main">
                                <button type="button" name="dropdownMenu" class="btn btn-success btn-sm renewBtn" data-get_input="<?php echo 'dateid'.$eachBorrow['id'] ?>">
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
                                        <input type="text" id="<?php echo 'dateid'.$eachBorrow['id'] ?>" class="<?php echo 'dateid'.$eachBorrow['id'] ?> form-control form-control-sm float-right reservation" name="reservation" data-return_date="<?php echo date("Y m d", strtotime($eachBorrow['return_date'])); ?>">
                                      </div>
                                    </div>
                                    <button type="button" name="borrowRenewSubmit" data-toggle="popover" data-placement="bottom"  class="btn btn-primary btn-sm borrowRenewSubmit" data-borrow_info="<?php echo $eachBorrow['id']; ?>" data-action_id="<?php echo 'dateid'.$eachBorrow['id'] ?>">
                                      <span data-toggle="tooltip" title="Renew borrow date">Submit</span>
                                    </button>
                                </div>
                              </span>

                              <button type="button" name="borrowReturn" class="btn btn-danger btn-sm borrowReturn" data-borrow_info="<?php echo $eachBorrow['id']; ?>" data-toggle="tooltip" title="Return Book"><i class="fas fa-retweet"></i></button>
                            <?php
                            }
                              ?>
                              <a class="btn btn-info btn-sm" style="padding-right:11px; padding-left:11px;" data-toggle="tooltip" title="View Details" href="<?php echo 'show.php?borrow_show='.urlencode($eachBorrow['id']); ?>">
                                  <i class="fas fa-info"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                    <?php

                      }
                    } ?>



                  </tbody>
                </table>

                <div data-jplist-control="no-results" data-group="borrowgroup" data-name="no-results"><div>No Results Found</div></div>

              </div>


            </div>
            <!-- /.card-body -->
            <div class="card-footer ">
              <!-- pagination control -->
              <div
                data-jplist-control="pagination"
                data-group="borrowgroup"
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
