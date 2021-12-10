<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php'); ?>
<?php
use App\Book\Book;
use App\Borrow\Borrow;
use App\Category\Category;
use App\Setting\Setting;

$Borrow = new Borrow();
$borrowList = $Borrow->borrowList();

$Category = new Category;
$Setting = new Setting;
?>
<?php include_once(ELEMENT.'head.php');?> <!-- include header section -->
<?php include_once(ELEMENT.'header.php');?> <!-- include navigation section -->
<section id="search-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1 col-md-12">
        <div class="search-portion">
          <form>
            <div class="all-input">
              <input
                  data-jplist-control="textbox-filter"
                  data-group="allborrowgroup"
                  data-name="my-filter-1"
                  data-path=".searchstring"
                  type="text"
                  value=""
                  data-clear-btn-id="name-clear-btn"
                  placeholder="Search anything"
                  class="form-control"
                  placeholder="Search anything"/>
            </div>
            <div class="all-input">
              <select
                data-jplist-control="select-sort"
                data-group="allborrowgroup"
                data-name="name1"
                data-clear-btn-id="name-clear-btn">
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
            <div class="all-input">
              <button data-jplist-control="reset" data-group="allborrowgroup" data-name="reset" type="button">
                  Clear
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</section>
<!-- Book Section section start -->
<section id="borrow-section">
  <div class="container">
    <div class="row mb-4 align-items-center">
      <div class="col-6">
        <!-- items per page select -->

        <div
          data-jplist-control="pagination"
          data-group="allborrowgroup"
          data-items-per-page="8"
          data-current-page="8"
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
                  <a class="dropdown-item" href="#" data-value="8">8 per page</a>
                  <a class="dropdown-item" href="#" data-value="16">16 per page</a>
                  <a class="dropdown-item" href="#" data-value="30">30 per page</a>
                  <a class="dropdown-item" href="#" data-value="0">View All</a>
              </div>
          </div>
        </div>

      </div>
      <div class="col-6 text-right">
        <!-- pagination control -->
        <div class="btn-group">
          <!-- pagination control -->
          <div
            data-jplist-control="pagination"
            data-group="allborrowgroup"
            data-items-per-page="8"
            data-current-page="8"
            data-name="pagination1">
              <span data-type="info" class="p-2">
                  Page {pageNumber} of {pagesNumber}
              </span>
              <button type="button" class="btn btn-primary btn-sm" data-type="prev"><i class="fas fa-chevron-left"></i></button>
              <!-- pages buttons -->
              <ul class="pagination d-none" data-type="pages">
                  <li class="page-item" data-type="page"><a class="page-link" href="#">{pageNumber}</a></li>
              </ul>
              <button type="button" class="btn btn-primary btn-sm" data-type="next"><i class="fas fa-chevron-right"></i></button>
          </div>
          <!-- <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-left"></i></button>
          <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-right"></i></button> -->
        </div>
      </div>
    </div>


    <div>
      <table class="table borrow-table" id="borrowTable">
        <thead class="bg-primary">
          <tr>
            <th class="d-none">get count</th>
            <th>SL</th>
            <th>Borrow No.</th>
            <th>Image</th>
            <th>Book ID</th>
            <th>Book Name</th>
            <th style="min-width:200px">Expire</th>
            <th style="min-width:200px">Action</th>
          </tr>
        </thead>
        <tbody data-jplist-group="allborrowgroup">
          <?php
          if(!empty($borrowList) && $borrowList != "error"){
            $x = count($borrowList);
            $x += 1;
            $y = 0;
            foreach ($borrowList as $eachBorrow) {
              $y++;
              ?>

              <tr data-jplist-item id="<?php echo 'eachData'.$eachBorrow['id']; ?>" class="eachBorrowData">
                <td class="d-none likes">
                  <?php echo $x--; ?>
                </td>
                <td> <?php echo $y; ?> </td>
                <td class="searchstring"> <?php echo $eachBorrow['borrow_id']; ?> </td>
                <td>
                  <img width="70" src="<?php echo !empty($eachBorrow['picture']) ? IMAGESBOOK.$eachBorrow['picture'] : IMG.'dummybook.jpg';?>" alt="<?php echo $eachBorrow['book_name']; ?>">
                </td>
                <td class="searchstring"><?php echo $eachBorrow['book_id']; ?></td>
                <td class="searchstring title"><?php echo $eachBorrow['book_name']; ?></td>
                <td class="expiryDateParent">
                  <div class="expiryDateChild" id="<?php echo 'expiryDateChild'.$y; ?>">
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
                      <div class="progress tj_progress" data-toggle="tooltip" title="Give back date has been expired at <?php echo $expiry; ?>" style="width:150px;">
                        <div class="px-2 text-bold progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width:100%"></div>
                        <span>Expired</span>
                      </div>
                    <?php
                      }else { ?>
                        <div class="progress tj_progress" data-toggle="tooltip" title="<?php echo 'Total has '.$totalDays.' more days for give back'; ?>" style="width:150px;">
                          <div class="px-2 text-bold progress-bar progress-bar-striped progress-bar-animated <?php echo $totalDays > 4 ? 'bg-info' : ($totalDays <= 4 && $totalDays > 2 ? 'bg-warning' : 'bg-danger');  ?>" style="width:<?php echo $percentage.'%'; ?>"></div>
                          <span><?php echo $totalDays.' more days'; ?></span>
                        </div>
                    <?php
                      }
                    }
                    ?>
                  </div>
                </td>
                <td>
                  <?php
                  if($eachBorrow['is_accept'] == 0) { ?>
                    <div class="d-flex">
                      <button class="btn btn-sm bg-light-gray mr-2" disabled>Request Sent</button>
                      <button type="button" name="borrowReject" class="btn btn-danger btn-sm borrowReject" data-borrow_info="<?php echo $eachBorrow['id']; ?>" data-toggle="tooltip" title="" data-original-title="Reject"><i class="fas fa-times"></i></button>
                    </div>

                  <?php
                  }else{ ?>


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
                  <?php
                  }
                  ?>

                </td>
              </tr>
            <?php
            }
          }
          ?>
        </tbody>
      </table>
      <div data-jplist-control="no-results" data-group="allborrowgroup" data-name="no-results" class="py-3 text-center"><div>No Results Found</div></div>
    </div>




    <div class="row mb-4 align-items-center">
      <div class="col-6">
        <!-- items per page select -->

        <div
                data-jplist-control="pagination"
                data-group="allborrowgroup"
                data-items-per-page="8"
                data-current-page="8"
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
                    <a class="dropdown-item" href="#" data-value="8">8 per page</a>
                    <a class="dropdown-item" href="#" data-value="16">16 per page</a>
                    <a class="dropdown-item" href="#" data-value="30">30 per page</a>
                    <a class="dropdown-item" href="#" data-value="0">View All</a>
                </div>
            </div>
        </div>

      </div>
      <div class="col-6 text-right">
        <!-- pagination control -->
        <div class="btn-group">
          <!-- pagination control -->
          <div
                  data-jplist-control="pagination"
                  data-group="allborrowgroup"
                  data-items-per-page="8"
                  data-current-page="0"
                  data-id="page"
                  data-name="pagination1">
              <span data-type="info" class="p-2">
                  Page {pageNumber} of {pagesNumber}
              </span>
              <button type="button" class="btn btn-primary btn-sm" data-type="prev"><i class="fas fa-chevron-left"></i></button>
              <!-- pages buttons -->
              <ul class="pagination d-none" data-type="pages">
                  <li class="page-item" data-type="page"><a class="page-link" href="#">{pageNumber}</a></li>
              </ul>
              <button type="button" class="btn btn-primary btn-sm" data-type="next"><i class="fas fa-chevron-right"></i></button>
          </div>
          <!-- <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-left"></i></button>
          <button type="button" class="btn btn-default btn-sm"><i class="fas fa-chevron-right"></i></button> -->
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Book Section section End -->


<?php include_once(ELEMENT.'footer.php');?> <!-- include Footer section -->
<?php include_once(ELEMENT.'script.php');?> <!-- include Footer section -->
