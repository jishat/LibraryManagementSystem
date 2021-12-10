<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Category\Category;

$Category = new Category();
$allCategory = $Category->allCategory();;

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
                <li class="breadcrumb-item active">Category</li>
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
              <h3 class="card-title">All Category</h3>
              <a href="<?php echo ADMINVIEW.'category/create.php'?>" class="ml-auto btn btn-sm btn-primary">Add New</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="main-top-filtering mb-4">
                <div class="row">
                  <div class="col-md-2">
                    <div
                            data-jplist-control="pagination"
                            data-group="categorygroup"
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
                        data-group="categorygroup"
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

                  <div class="col-md-4">
                    <!-- text filter control -->
                    <div class="input-group">
                      <div class="input-group">
                        <input
                            data-jplist-control="textbox-filter"
                            data-group="categorygroup"
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
              </div>


              <div>
                <table id="categoryTable" class="table tj-table borrow-table">
                  <thead>
                    <tr>
                      <th class="d-none">get count</th>
                      <th>SL</th>
                      <th>Category Name</th>
                      <th>Short Description</th>
                      <th>Parent Category</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody data-jplist-group="categorygroup">
                    <?php
                    if(!empty($allCategory) && $allCategory != "error"){
                      $x = count($allCategory);
                      $x += 1;
                      $y = 0;
                      foreach ($allCategory as $eachCategory) {
                        $y++ ?>

                        <tr class="eachCategoryData" id="<?php echo 'eachData'.$eachCategory['id']; ?>" data-jplist-item>
                          <td class="d-none likes">
                            <?php echo $x--; ?>
                          </td>
                          <td>
                            <?php echo $y; ?>
                          </td>

                          <td class="searchstring title"><?php echo $eachCategory['category_name']; ?> </td>
                          <td class="searchstring"><?php echo trim_word($eachCategory['short_description'], 5); ?></td>
                          <td class="searchstring"><?php echo $eachCategory['parent_name']; ?> </td>
                          <td>
                            <a class="btn btn-primary btn-sm" style="padding-right:11px; padding-left:11px;" data-toggle="tooltip" title="View Details" href="<?php echo 'show.php?category_show='.urlencode($eachCategory['slug']); ?>">
                                <i class="fas fa-info"></i>
                            </a>
                            <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit Category" href="<?php echo 'edit.php?category_edit='.urlencode($eachCategory['slug']); ?>">
                              <i class="fas fa-pencil-alt">
                              </i>
                            </a>
                            <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete Category" id="categoryDelBtn" data-cat_info="<?php echo $eachCategory['id']; ?>" name="categoryDelBtn">
                                <i class="fas fa-trash">
                                </i>
                            </button>
                          </td>
                        </tr>

                    <?php
                      }
                    } ?>



                  </tbody>
                </table>

                <div data-jplist-control="no-results" data-group="categorygroup" data-name="no-results"><div>No Results Found</div></div>

              </div>


            </div>
            <!-- /.card-body -->
            <div class="card-footer ">
              <!-- pagination control -->
              <div
                data-jplist-control="pagination"
                data-group="categorygroup"
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
