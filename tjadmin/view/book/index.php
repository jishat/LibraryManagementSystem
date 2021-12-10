<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');

use App\Book\Book;
use App\Category\Category;

$Book = new Book();
$allBooks = $Book->allBooks();

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
                <li class="breadcrumb-item active">Book</li>
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
              <h3 class="card-title">All Books information</h3>
              <a href="<?= ADMINVIEW.'book/create.php'?>" class="ml-auto btn btn-sm btn-primary">Add New</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="main-top-filtering mb-4">
                <div class="row">
                  <div class="col-md-2">
                    <div
                            data-jplist-control="pagination"
                            data-group="allbooksgroup"
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
                        data-group="allbooksgroup"
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
                        <option
                                value="5"
                                data-path=".titlewriter"
                                data-order="asc"
                                data-type="text">A-Z Writer</option>
                        <option
                                value="6"
                                data-path=".titlewriter"
                                data-order="desc"
                                data-type="text">Z-A Writer</option>

                      </select>

                    </div>

                  </div>

                  <div class="col-md-4">
                    <!-- text filter control -->
                    <div class="input-group">
                      <input
                          data-jplist-control="textbox-filter"
                          data-group="allbooksgroup"
                          data-name="my-filter-1"
                          data-path=".searchstring"
                          type="text"
                          value=""
                          data-clear-btn-id="name-clear-btn"
                          placeholder="Search By Id, Name, Writer, Category"
                          class="form-control" />
                        <div class="input-group-append">
                          <button class="btn btn-default" type="button" id="name-clear-btn">Clear</button>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" data-jplist-group="allbooksgroup">
                <?php
                if(!empty($allBooks) && $allBooks != "error"){
                  $x = count($allBooks);
                  $x += 1;
                  $y = 1;
                  foreach ($allBooks as $eachBook) {
                    $x-- ; ?>
                    <div class="col-12 col-sm-6 col-md-4 eachBookData" data-jplist-item>
                      <div class="d-none likes">
                        <?php echo $x--; ?>
                      </div>
                      <div class="card bg-light">
                        <div class="card-body pt-0">
                          <table class="table table-borderless table-sm">
                            <thead>
                              <div class="my-4">
                                <img class="" width="100" src="<?= !empty($eachBook['picture']) ? IMAGESBOOK.$eachBook['picture'] : IMG.'dummybook.jpg';?>" alt="User Avatar">
                              </div>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row">No.</th>
                                <td><?php echo $y++; ?></td>
                              </tr>
                              <tr>
                                <th scope="row">Book Id.</th>
                                <td class="searchstring"><?php echo $eachBook['book_id']; ?> </td>
                              </tr>
                              <tr>
                                <th scope="row">Name.</th>
                                <td class="title searchstring"><?php echo $eachBook['book_name']; ?> </td>
                              </tr>
                              <tr>
                                <th scope="row">Writer.</th>
                                <td class="titlewriter searchstring"><?php echo $eachBook['writer']; ?> </td>
                              </tr>
                              <tr>
                                <th scope="row">Stock.</th>
                                <td><?php echo $eachBook['total_stock']; ?> </td>
                              </tr>
                              <tr>
                                <th scope="row">Borrow.</th>
                                <td><?php echo $eachBook['total_borrowed']; ?> </td>
                              </tr>
                              <tr>
                                <th scope="row">Shelf.</th>
                                <td class="searchstring"><?php echo $eachBook['book_shelf']; ?> </td>
                              </tr>
                              <tr>
                                <th scope="row" class="searchstring">Category.</th>
                                <td><div class="tj-unlink-btn">
                                <?php
                                  if(isset($eachBook['category']) && $eachBook['category'] != ""){
                                    $strRep = str_replace(',', " ", $eachBook['category']);
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
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="card-footer d-flex">
                          <div class="mr-auto">
                              <div class="custom-control custom-switch custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input bookStatus" <?php echo $eachBook['status'] == 1 ? 'checked' : '' ; ?> id="<?php echo "customSwitch".$x; ?>" data-status="<?php echo $eachBook['status']; ?>" data-id="<?php echo $eachBook['id']; ?>">
                                <label class="custom-control-label text-sm pt-1" for="<?php echo "customSwitch".$x; ?>"><?php echo $eachBook['status'] == 1 ? 'Active' : 'Deactive' ; ?></label>
                              </div>
                          </div>

                          <div class="ml-auto">
                            <button class="btn btn-danger btn-sm bookDelBtn" data-toggle="tooltip" title="Delete Book" id="bookDelBtn" data-book_info="<?php echo $eachBook['id']; ?>" name="bookDelBtn">
                                <i class="fas fa-trash">
                                </i>
                            </button>
                            <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit Book" href="<?php echo 'edit.php?book_edit='.urlencode($eachBook['slug']); ?>">
                                <i class="fas fa-pencil-alt">
                                </i>
                            </a>
                            <a class="btn btn-primary btn-sm" style="padding-right:11px; padding-left:11px;" data-toggle="tooltip" title="View Details" href="<?php echo "show.php?book_show=".urlencode($eachBook['slug']); ?>">
                                <i class="fas fa-info"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php
                  }
                } ?>
              </div>


            </div>
            <!-- /.card-body -->

            <div class="card-footer ">
              <!-- pagination control -->
              <div
                data-jplist-control="pagination"
                data-group="allbooksgroup"
                data-items-per-page="9"
                data-current-page="0"
                data-disabled-class="disabled"
                data-selected-class="active"
                data-id="page"
                data-name="pagination1"
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
