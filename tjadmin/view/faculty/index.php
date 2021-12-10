<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Adminpages;
use App\Faculty\Faculty;
$Adminpages = new Adminpages();
$allPages = $Adminpages->allPages();
$Faculty = new Faculty();
$allFaculty = $Faculty->allFaculty();

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
              <a href="javascript:history.go(-1)" data-toggle="tooltip" title="Return to the previous page" class="btn btn-primary btn-sm rounded-pill"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go Back</a>
            </div>
          </div>
          <div class="col-6">
            <div class="mr-2">
              <ol class="breadcrumb ">
                <li class="breadcrumb-item ml-auto"><a href="<?php echo ADMINVIEW.'dashboard'?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Faculty</li>
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
              <h3 class="card-title">All Borrow List</h3>
              <a href="<?= ADMINVIEW.'faculty/create.php'?>" class="ml-auto btn btn-sm btn-primary">Add New</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="main-top-filtering mb-4">
                <div class="row">
                  <div class="col-md-2">
                    <div
                            data-jplist-control="pagination"
                            data-group="facultygroup"
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
                        data-group="facultygroup"
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
                          data-type="text">A-Z Faculty</option>
                        <option
                          value="4"
                          data-path=".title"
                          data-order="desc"
                          data-type="text">Z-A Faculty</option>

                      </select>

                    </div>

                  </div>

                  <div class="col-md-4">
                    <!-- text filter control -->
                    <div class="input-group">
                      <input
                          data-jplist-control="textbox-filter"
                          data-group="facultygroup"
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


              <div>
                <table id="facultyTable" class="table tj-table borrow-table">
                  <thead>
                    <tr>
                      <th class="d-none">get count</th>
                      <th>SL</th>
                      <th>Faculty Name</th>
                      <th>Short Description</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody data-jplist-group="facultygroup">
                    <?php
                    if(!empty($allFaculty) && $allFaculty != "error"){
                      $x = count($allFaculty);
                      $x += 1;
                      $y = 0;
                      foreach ($allFaculty as $eachFaculty) {
                        $y++ ?>

                        <tr class="eachBorrowData" id="<?php echo 'eachData'.$eachFaculty['id']; ?>" data-jplist-item>
                          <td class="d-none likes">
                            <?php echo $x--; ?>
                          </td>
                          <td>
                            <?php echo $y; ?>
                          </td>

                          <td class="searchstring title">
                            <?php echo $eachFaculty['faculty_name']; ?>
                          </td>

                          <td class="searchstring"><?php echo trim_word($eachFaculty['short_description'], 5); ?></td>

                          <td class="actionParant">
                            <div class="actionChild d-inline-block" id="<?php echo 'actionChild'.$y; ?>" data-card_count="<?php echo $y; ?>">

                              <a class="btn btn-primary btn-sm" data-toggle="tooltip" title="Edit" href="<?php echo 'edit.php?edit='.urlencode($eachFaculty['slug']); ?>">
                                  <i class="fas fa-pencil-alt">
                                  </i>
                              </a>

                              <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" id="facultyDelBtn" data-faculty_info="<?php echo $eachFaculty['id']; ?>" name="facultyDelBtn">
                                  <i class="fas fa-trash">
                                  </i>
                              </button>

                              <a class="btn btn-info btn-sm" style="padding-right:11px; padding-left:11px;" data-toggle="tooltip" title="View Details" href="<?php echo 'show.php?show='.urlencode($eachFaculty['slug']); ?>">
                                  <i class="fas fa-info"></i>
                              </a>

                            </div>

                          </td>
                        </tr>

                    <?php
                      }
                    }else {
                      echo "No Data found";
                    } ?>



                  </tbody>
                </table>

                <div data-jplist-control="no-results" data-group="facultygroup" data-name="no-results"><div>No Results Found</div></div>

              </div>


            </div>
            <!-- /.card-body -->
            <div class="card-footer ">
              <!-- pagination control -->
              <div
                data-jplist-control="pagination"
                data-group="facultygroup"
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
