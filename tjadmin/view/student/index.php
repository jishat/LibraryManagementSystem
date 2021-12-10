<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Student\Student;

$student = new Student();
$allStudents = $student->allStudents();
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
                <li class="breadcrumb-item active">Student</li>
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
              <h3 class="card-title">All student information</h3>
              <a href="<?= ADMINVIEW.'student/create.php'?>" class="ml-auto btn btn-sm btn-primary">Add New</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <?php
                if(!empty($allStudents) && $allStudents !== "error"){ ?>
              <div class="main-top-filtering mb-4">
                <div class="row">
                  <div class="col-md-2">
                    <div
                      data-jplist-control="pagination"
                      data-group="allstudentgroup"
                      data-items-per-page="9"
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
                              <a class="dropdown-item" href="#" data-value="9">9 per page</a>
                              <a class="dropdown-item" href="#" data-value="20">20 per page</a>
                              <a class="dropdown-item" href="#" data-value="30">30 per page</a>
                              <a class="dropdown-item" href="#" data-value="0">View All</a>
                          </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-2 offset-md-4">
                    <!-- hidden sort control -->
                    <!-- <div
                        style="display: none"
                        data-jplist-control="hidden-sort"
                        data-group="allstudentgroup"
                        data-path=".likes"
                        data-order="asc"
                        data-type="text">
                    </div> -->
                    <!-- select sort control -->
                    <div class="input-group">
                      <select
                        data-jplist-control="select-sort"
                        data-group="allstudentgroup"
                        data-name="name1"
                        class="form-control">
                        <option
                                value="0"
                                data-path="default"
                                selected>Sort by</option>
                        <option
                                value="1"
                                data-path=".title"
                                data-order="asc"
                                data-type="text">A-Z</option>
                        <option
                                value="2"
                                data-path=".title"
                                data-order="desc"
                                data-type="text">Z-A</option>
                        <option
                                value="3"
                                data-path=".likes"
                                data-order="asc"
                                data-type="number">Ascending</option>
                        <option
                                value="4"
                                data-path=".likes"
                                data-order="desc"
                                data-type="number">Descending</option>
                      </select>

                    </div>

                  </div>

                  <div class="col-md-4">
                    <!-- text filter control -->
                    <div class="input-group">
                      <input
                          data-jplist-control="textbox-filter"
                          data-group="allstudentgroup"
                          data-name="my-filter-1"
                          data-path=".searchstring"
                          type="text"
                          value=""
                          data-clear-btn-id="name-clear-btn"
                          placeholder="Search Anything"
                          class="form-control"/>
                        <div class="input-group-append">
                            <button class="btn btn-default" type="button" id="name-clear-btn">Clear</button>
                        </div>
                    </div>
                  </div>
                </div>
              </div>

                  <div class="row" data-jplist-group="allstudentgroup">
                    <?php
                    $x = count($allStudents);
                    $x += 1;
                    foreach ($allStudents as $allStudent) {
                      $x--; ?>
                      <div class="col-12 col-sm-6 col-md-4 eachStdData" data-jplist-item>
                        <!-- Widget: user widget style 1 -->
                        <div class="card card-widget widget-user eachStdDataChild" id="<?php echo 'eachStdDataChild'.$x; ?>" data-card_count="<?php echo $x; ?>">

                          <?php
                          if ($allStudent['email_verified'] == 0) { ?>
                            <div class="ribbon-wrapper ribbon-xl">
                              <div class="ribbon bg-danger">
                                Email Unverified
                              </div>
                            </div>
                          <?php
                        }elseif ($allStudent['email_verified'] == 1 && $allStudent['admin_verified'] == 0) { ?>
                          <div class="ribbon-wrapper ribbon-xl">
                            <div class="ribbon bg-danger">
                              Unverified
                            </div>
                          </div>
                        <?php
                        }
                          ?>


                          <div class="widget-user-header bg-primary">
                            <div class="d-none likes">
                              <?php echo $x; ?>
                            </div>
                            <h3 class="widget-user-username searchstring title"><?php echo $allStudent['name']; ?></h3>
                            <h5 class="widget-user-desc searchstring"><?php echo $allStudent['faculty_name'] ; ?></h5>
                          </div>
                          <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="<?= !empty($allStudent['picture']) ? IMAGESUSER.$allStudent['picture'] : IMG.'avatar-man.png';?>" alt="User Avatar">
                          </div>
                          <div class="widget-user-body bg-light">
                            <table class="table">
                              <tr>
                                <td>ID No.</td>
                                <td class="searchstring">: <?php echo $allStudent['student_id']; ?></td>
                              </tr>
                              <tr>
                                <td>Batch No.</td>
                                <td class="searchstring">: <?php echo $allStudent['batch']; ?></td>
                              </tr>
                              <tr>
                                <td>Gender</td>
                                <td class="searchstring">: <?php echo $allStudent['gender'] == 1 ? 'Male' : ($allStudent['gender'] == 2 ? 'Female' : 'Others') ; ?></td>
                              </tr>
                              <tr>
                                <td>Email</td>
                                <td class="searchstring">: <?php echo $allStudent['email']; ?></td>
                              </tr>
                            </table>
                          </div>

                          <div class="card-footer stdnt-card-action-main">
                            <div class="d-flex stdnt-card-action">
                            <?php
                            if($allStudent['admin_verified'] == 0 && $allStudent['email_verified'] == 1){
                              echo '<div class="m-auto"><button class="btn btn-sm btn-success mr-2 approveBtn" data-toggle="tooltip" title="Approve Account"  data-std_info="'.$allStudent['id'].'" name="approveBtn">Approve</button>
                              <button class="btn btn-danger btn-sm mr-2 stdRejectBtn" data-toggle="tooltip" title="Reject Account"  data-std_info="'.$allStudent['id'].'" name="stdRejectBtn">Reject</button><a href="show.php?student_show='.urlencode($allStudent['slug']).'" class="btn btn-sm btn-primary" data-toggle="tooltip" title="View Profile">
                                <i class="fas fa-user"></i></a></div>';
                            }else if($allStudent['email_verified'] == 0){ ?>
                              <div class="m-auto">
                                  <button class="btn btn-danger btn-sm stdDelete" data-toggle="tooltip" title="Delete Account"  data-std_info="<?php echo $allStudent['id']; ?>" name="stdDelBtn">
                                      <i class="fas fa-trash"></i>
                                  </button>
                                <a href="<?php echo 'show.php?student_show='.urlencode($allStudent['slug']); ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="View Profile">
                                  <i class="fas fa-user"></i></a>
                              </div>
                            <?php
                            }else{
                            ?>
                            <div class="mr-auto">
                                <div class="custom-control custom-switch custom-switch-on-success">
                                  <input type="checkbox" class="custom-control-input studentStatus" <?php echo $allStudent['status'] == 1 ? 'checked' : '' ; ?> id="<?php echo "customSwitch".$x; ?>" data-status="<?php echo $allStudent['status']; ?>" data-id="<?php echo $allStudent['id']; ?>">
                                  <label class="custom-control-label" for="<?php echo "customSwitch".$x; ?>"><?php echo $allStudent['status'] == 1 ? 'Active' : 'Deactive' ; ?></label>
                                </div>
                            </div>
                            <div class="ml-auto">
                                <button class="btn btn-danger btn-sm stdDelete" data-toggle="tooltip" title="Delete Account"  data-std_info="<?php echo $allStudent['id']; ?>" name="stdDelBtn">
                                    <i class="fas fa-trash">
                                    </i>
                                </button>
                              <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit Profile" href="<?php echo 'edit.php?student_edit='.urlencode($allStudent['slug']); ?>">
                                  <i class="fas fa-pencil-alt">
                                  </i>
                              </a>
                              <a href="<?php echo 'show.php?student_show='.urlencode($allStudent['slug']); ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="View Profile">
                                <i class="fas fa-user"></i></a>
                            </div>
                            <?php } ?>
                            </div>
                          </div>

                        </div>
                        <!-- /.widget-user -->

                      </div>
                  <?php
                    } ?>
                  <!-- no results control -->
                  <div data-jplist-control="no-results" data-group="allstudentgroup" data-name="no-results">No Results Found</div>
                  </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card-body -->

            <div class="card-footer ">
              <!-- pagination control -->
              <div
                data-jplist-control="pagination"
                data-group="allstudentgroup"
                data-items-per-page="9"
                data-current-page="0"
                data-disabled-class="disabled"
                data-selected-class="active"
                data-name="pagination1"
                data-id="page"
                class="d-flex align-items-start">

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
            <!-- /.card-footer -->

            <?php
          }else{
            echo "<p>There has no any student account</p>";
          } ?>
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
