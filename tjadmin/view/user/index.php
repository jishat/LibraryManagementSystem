<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');?>
<?php include_once(ADMINELEMENT.'head.php');?>
<?php include_once(ADMINELEMENT.'navigation.php');?> <!-- include navigation section -->

<?php
$allUser = $User->allUser(); //already oject created in navigation
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
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
                <li class="breadcrumb-item active">User</li>
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
              <h3 class="card-title">All user list</h3>
              <a href="<?= ADMINVIEW.'user/create.php'?>" class="ml-auto btn btn-sm btn-primary">Add New</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="main-top-filtering mb-4">
                <div class="row">
                  <div class="col-md-2">
                    <div
                            data-jplist-control="pagination"
                            data-group="alladmingroup"
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
                        data-group="alladmingroup"
                        data-path=".likes"
                        data-order="asc"
                        data-type="text">
                    </div> -->
                    <!-- select sort control -->
                    <div class="input-group">
                      <select
                        data-jplist-control="select-sort"
                        data-group="alladmingroup"
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
                          data-group="alladmingroup"
                          data-name="my-filter-1"
                          data-path=".searchstring"
                          type="text"
                          value=""
                          data-clear-btn-id="name-clear-btn"
                          placeholder="Search Anything"
                          class="form-control" />
                        <div class="input-group-append">
                            <button class="btn btn-default" type="button" id="name-clear-btn">Clear</button>
                        </div>
                    </div>
                  </div>
                </div>
              </div>

              <?php
                if(!empty($allUser) && $allUser !== "error"){ ?>
                  <div class="row" data-jplist-group="alladmingroup">
                    <?php
                    $x = 0;
                    foreach ($allUser as $user) {
                      $x++; ?>
                      <div class="col-12 col-sm-6 col-md-4 eachAdmnData" data-jplist-item>
                        <!-- Widget: user widget style 1 -->
                        <div class="card card-widget widget-user">
                          <!-- Add the bg color to the header using any of the bg-* classes -->
                          <div class="widget-user-header bg-primary">
                            <div class="d-none likes">
                              <?php echo $x; ?>
                            </div>
                            <h3 class="widget-user-username searchstring title likes"><?php echo $user['name']; ?></h3>
                            <h5 class="widget-user-desc searchstring"><?php echo  $user['userrolename']; ?></h5>
                          </div>
                          <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="<?php echo !empty($user['picture']) ? IMAGESUSER.$user['picture'] : IMG.'avatar-man.png';?>" alt="User Avatar">
                          </div>
                          <div class="widget-user-body bg-light">
                            <table class="table">
                              <tr>
                                <td>Email</td>
                                <td class="searchstring">: <?php echo $user['email']; ?></td>
                              </tr>
                              <tr>
                                <td>Gender</td>
                                <td class="searchstring">: <?php echo $user['gender'] == 1 ? 'Male' : ($user['gender'] == 2 ? 'Female' : 'Others') ; ?></td>
                              </tr>
                              <tr>
                                <td>User Role</td>
                                <td class="searchstring">: <?php echo  $user['userrolename']; ?></td>
                              </tr>
                            </table>
                          </div>
                          <div class="card-footer d-flex">
                            <?php
                            if($user['user_role'] !== "1" && $user['id'] != $loginid){ ?>
                              <div class="mr-auto">
                                  <div class="custom-control custom-switch custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input adminStatus" <?php echo $user['status'] == 1 ? 'checked' : '' ; ?> id="<?php echo "customSwitch".$x; ?>" data-status="<?php echo $user['status']; ?>" data-id="<?php echo $user['id']; ?>">
                                    <label class="custom-control-label" for="<?php echo "customSwitch".$x; ?>"><?php echo $user['status'] == 1 ? 'Active' : 'Deactive' ; ?></label>
                                  </div>
                              </div>
                            <?php
                            }
                            ?>
                            <div class="ml-auto">
                              <?php
                              if($user['user_role'] !== "1" && $user['id'] != $loginid){ //$loginid is declare in navigation section ?>
                                <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete Account" id="admnDelBtn" data-admn_info="<?php echo $user['id']; ?>" name="admnDelBtn">
                                    <i class="fas fa-trash">
                                    </i>
                                </button>
                              <?php
                              }
                              if($user['id'] != "1"){ ?>
                                <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit Profile" href="<?php echo 'edit.php?edit='.urlencode($user['slug']); ?>">
                                  <i class="fas fa-pencil-alt"></i>
                                </a>
                              <?php
                              }else {
                                if($loginid == "1"){ //$loginid is declare in navigation section ?>
                                  <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit Profile" href="<?php echo 'edit.php?edit='.urlencode($user['slug']); ?>">
                                    <i class="fas fa-pencil-alt"></i>
                                  </a>
                                <?php
                                }
                              }
                              ?>

                              <a href="<?php echo 'show.php?show='.urlencode($user['slug']); ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="View Profile">
                                <i class="fas fa-user"></i></a>
                            </div>
                          </div>

                        </div>
                        <!-- /.widget-user -->

                      </div>
                  <?php
                    } ?>
                  <!-- no results control -->
                          <div data-jplist-control="no-results" data-group="alladmingroup" data-name="no-results">No Results Found</div>
                  </div>
              <?php
                } ?>

            <!-- /.card-body -->
            </div>
            <!-- /.card-body -->

            <div class="card-footer ">


              <!-- pagination control -->
              <div
                data-jplist-control="pagination"
                data-group="alladmingroup"
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
