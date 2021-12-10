<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');?>
<?php
use App\Book\Book;
use App\Borrow\Borrow;
use App\Category\Category;

$Book = new Book();
$allBooks = $Book->allBooksUser();

$Category = new Category;
?>
<?php include_once(ELEMENT.'head.php');?> <!-- include header section -->
<?php include_once(ELEMENT.'header.php');?> <!-- include navigation section -->

<!-- Search Section Start -->
<section id="search-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1 col-md-12">
        <div class="search-portion">
          <form>
            <div class="all-input">
              <input
              data-jplist-control="textbox-filter"
              data-group="allbooksgroup"
              data-name="my-filter-1"
              data-path=".searchstring"
              type="text"
              value=""
              data-clear-btn-id="name-clear-btn"
              placeholder="Write Book name">
            </div>
            <div class="all-input">
              <select
                data-jplist-control="select-filter"
                data-group="allbooksgroup"
                data-name="name1"
                data-clear-btn-id="name-clear-btn">

                <option
                  value="0"
                  data-path="default" selected>All Category</option>
                <?php
                  echo $Category->fetchCategoryForSearch();
                ?>
              </select>
            </div>
            <div class="all-input">
              <button
                data-jplist-control="reset"
                data-group="allbooksgroup"
                data-name="reset"
                type="button">
                  Clear
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</section>
<!-- Search Section End -->

<!-- Book Section section start -->
<section id="books-section">
  <div class="container">
    <div class="row mb-4 align-items-center">
      <div class="col-6">
        <!-- items per page select -->

        <div
              data-jplist-control="pagination"
              data-group="allbooksgroup"
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
                  data-group="allbooksgroup"
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
    <div class="row justify-content-center" data-jplist-group="allbooksgroup">

      <?php
      if(!empty($allBooks) && $allBooks != "error"){
        $x = count($allBooks);
        $x += 1;
        $y = 1;
        foreach ($allBooks as $eachBook) {
          $x-- ;
          if(isset($eachBook['category']) && $eachBook['category'] != ""){
            $strRep = str_replace(',', " ", $eachBook['category']);
            $substr = substr($strRep, 1);
            $explds  = explode(" ", $substr);

            $eachCategory = "";
            foreach ($explds as $expld) { //1
              $parentCat = '';
              $categoryInfoById = $Category->categoryInfoById($expld);

              if(isset($categoryInfoById) && $categoryInfoById != "error"){
                $sym = ["+", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "=", "?", "~"];
                $eachCategory .= str_replace($sym, "p", $categoryInfoById['slug'])." ";
                $parentCat = $categoryInfoById['parent_category']; // $parentCat = 6
                  while($parentCat != ""){
                    $categoryInfoById = $Category->categoryInfoById($parentCat);
                    $sym = ["+", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "=", "?", "~"];
                    $eachCategory .= str_replace($sym, "p", $categoryInfoById['slug'])." ";
                    $parentCat = $categoryInfoById['parent_category'];
                  }


              }
            }
          } ?>



          <div class="col-md-4 col-lg-3 col-6 mb-4" data-jplist-item>
            <div class="eachBook <?php echo $eachCategory; ?>" data-book_id="<?php echo $eachBook['id']; ?>" data-method="viewBook">
              <div class="book-container" >
                <div class="book">
                  <img src="<?php echo !empty($eachBook['picture']) ? IMAGESBOOK.$eachBook['picture'] : IMG.'dummybook.jpg';?>"/>
                  <img src="<?php echo !empty($eachBook['picture']) ? IMAGESBOOK.$eachBook['picture'] : IMG.'dummybook.jpg';?>" alt="<?php echo trim($eachBook['book_name']); ?>" class="after-img">
                </div>
              </div>
              <h2 class="searchstring"><?php echo trim($eachBook['book_name']); ?></h2>
            </div>
            <div class="eachBookOverlay">
              <div class="spinner-border spinner-border-xl text-light"></div>
            </div>
          </div>
      <?php
        } //End foreach ?>
        <!-- no results control -->
        <div data-jplist-control="no-results" data-group="allbooksgroup" data-name="no-results">No books found you are searching</div>
      <?php
      } //End if
      ?>

    </div>


    <div class="row mb-4 align-items-center">
      <div class="col-6">
        <!-- items per page select -->

        <div
                data-jplist-control="pagination"
                data-group="allbooksgroup"
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
                  data-group="allbooksgroup"
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

<div class="modal fade" id="bookModal"><div class="modal-dialog modal-xl"><div class="modal-content">
  <!-- <div class="modal-header">
    <h4 class="modal-title" id="modalSubject"></h4>
  </div> -->
  <div class="modal-body p-4" id="modalBody">
    <!-- Book collection section start -->
    <div class="container">
      <div class="row mb-5 align-items-center">
          <div class="col-lg-4 col-md-5 col-sm-8 col-10 offset-1 offset-sm-2 offset-md-0">
            <div class="book-img">
              <div class="book-container" >
                <div class="book">
                  <img src="<?php echo !empty($eachBook['picture']) ? IMAGESBOOK.$eachBook['picture'] : IMG.'dummybook.jpg';?>" alt="book" class="BookImg">
                  <img src="<?php echo !empty($eachBook['picture']) ? IMAGESBOOK.$eachBook['picture'] : IMG.'dummybook.jpg';?>" alt="book" class="after-img BookImg">
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8 col-md-7">
            <div class="book-description-content ml-3">
              <div class="mb-2"  id="isAvailable">

              </div>
              <h2 id="BookName"></h2>
              <p class="text-muted" id="bookId"></p>
              <table class="book-table-one">
              	<tbody>
              		<tr>
      	        		<td>Total Stock</td>
      	        		<td id="stock"></td>
      	        	</tr>
      	        	<tr>
      	        		<td>Total Borrow</td>
      	        		<td id="borrow"></td>
      	        	</tr>
              	</tbody>
              </table>
              <table class="book-table-two">
              	<tbody>
              		<tr>
      	        		<td>Writer Name</td>
      	        		<td id="writer"></td>
      	        	</tr>
      	        	<tr>
      	        		<td>Category</td>
      	        		<td id="category"> </td>
      	        	</tr>
              	</tbody>
              </table>
              <div class="form-group">
                <label>Booking</label> <span class="text-muted text-sm">(How many days till)</span>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control float-right" id="reservation">
                </div>
              </div>
              <div id="borrowBtn"></div>
            </div>
          </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div id="about-book-sect">

            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-description-tab" data-toggle="pill" href="#custom-tabs-three-description" role="tab" aria-controls="custom-tabs-three-description" aria-selected="true">Description</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-review-tab" data-toggle="pill" href="#custom-tabs-three-review" role="tab" aria-controls="custom-tabs-three-review" aria-selected="false">Review</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade active show" id="custom-tabs-three-description" role="tabpanel" aria-labelledby="custom-tabs-three-description-tab">
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada lacus ullamcorper dui molestie, sit amet congue quam finibus. Etiam ultricies nunc non magna feugiat commodo. Etiam odio magna, mollis auctor felis vitae, ullamcorper ornare ligula. Proin pellentesque tincidunt nisi, vitae ullamcorper felis aliquam id. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin id orci eu lectus blandit suscipit. Phasellus porta, ante et varius ornare, sem enim sollicitudin eros, at commodo leo est vitae lacus. Etiam ut porta sem. Proin porttitor porta nisl, id tempor risus rhoncus quis. In in quam a nibh cursus pulvinar non consequat neque. Mauris lacus elit, condimentum ac condimentum at, semper vitae lectus. Cras lacinia erat eget sapien porta consectetur.
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-review" role="tabpanel" aria-labelledby="custom-tabs-three-review-tab">
                     Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                  </div>
                </div>
              </div>
            <!-- /.card -->
            </div>

          </div>
        </div>
      </div>
    </div>
  <!-- Book collection section End -->
  </div>
  <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div></div></div>

<?php include_once(ELEMENT.'footer.php');?> <!-- include Footer section -->
<?php include_once(ELEMENT.'script.php');?> <!-- include Footer section -->
