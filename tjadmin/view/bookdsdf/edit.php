<?php include_once($_SERVER['DOCUMENT_ROOT'].'/ciu/bootstrap.php');
use Ciu\Utility\Message;
use Ciu\Book\Book;

$id = $_GET['id'];


$Book = new Book();
$singleData = $Book->singleData($id);

// Prepare error message show
  switch (Message::getMessage()) {
    case 'emptyfield':
      $emptyfield = "All Field Require";
      break;
    case 'bookName':
      $bookName = "Invalid! Name should be only alphabet";
      break;
    case 'writerName':
      $writerName = "Invalid! Writer name should be only alphabet";
      break;
    case 'category':
      $category = "Invalid category";
      break;
    case 'totalStock':
      $totalStock = "Total Stock should be only numeric";
      break;
    case 'bookDescription':
      $bookDescription = "Description should be less than 250 words";
      break;
    case 'successfully':
      $successfully = "Update info successfully";
      break;
    case 'unsuccessfully':
      $unsuccessfully = "Something Went wrong";
      break; 
    default:
      $msg2 = "something went wrong";
      break;
  }

?>



<?php include_once(ADMINELEMENT.'head.php');?> <!-- include header section -->
<?php include_once(ADMINELEMENT.'navigation.php');?> <!-- include navigation section -->
        <!-- Page Link start -->
        <div class="page-link wrapper">
          <a href="javascript:void(0)"><i class="fas fa-book"></i> Book </a> <span>-</span>
          <a href="index.php">Books</a> <span>-</span>
          <a href="show.php?id=<?= $singleData['id'];?>">Show</a> <span>-</span>
          <a href="edit.php?id=<?= $singleData['id'];?>">Edit</a>
        </div>

        <!-- Page Link End -->

        <!-- Student Register form section start -->
        <div class="wrapper">
          <div class="single-section">
            <div class="page-heading">
              <h2> Edit Details</h2>
            </div>
            <!-- Get success or errror message -->
            <?php

              if(isset($successfully)):
                echo '<div class="success-msg"><p>'.$successfully.'</p></div>';
              endif;

              if(isset($unsuccessfully)):
                echo '<div class="error-msg"><p>'.$unsuccessfully.'</p></div>';
              endif;
            ?>
            <?php
              if(isset($emptyfield)):
                echo '<div class="error-msg"><p>'.$emptyfield.'</p></div>';
              endif;
            ?>
            <div class="form-style">
              <form action="update.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="bookId" value="<?= $singleData['id'];?>">
                <div class="input-row">
                  <div class="input-group">
                    <label for="Name">Book Name</label>
                    <input type="text" id="Name" name="bookName" value="<?= $singleData['book_name'];?>" placeholder="Enter Book name">
                    <?php
                      if(isset($bookName)):
                        echo '<div class="error-msg"><p>'.$bookName.'</p></div>';
                      endif;
                    ?>
                  </div>
                  <div class="input-group">
                    <label for="writerName">Writer Name</label>
                    <input type="text" id="writerName" name="writerName" value="<?= $singleData['writer'];?>" placeholder="Enter Writer name.">
                    <?php
                      if(isset($writerName)):
                        echo '<div class="error-msg"><p>'.$writerName.'</p></div>';
                      endif;
                    ?>
                  </div>
                </div>
                <div class="input-row">
                  <div class="input-group">
                    <label for="category">Select Category</label>
                    <select name="category" id="category">
                      <option selected disabled>Select Category</option>
                      <option <?=   $singleData['category']  == 'CSE'  ? 'selected' : '';?> >CSE</option>
                      <option <?= $singleData['category']  == 'EEE'  ? 'selected' : '';?>>EEE</option>
                      <option <?= $singleData['category']  == 'BBA'  ? 'selected' : '';?>>BBA</option>
                      <option <?= $singleData['category']  == 'LAW'  ? 'selected' : '';?>>LAW</option>
                      <option <?= $singleData['category']  == 'JOURNALISM'  ? 'selected' : '';?>>JOURNALISM</option>
                      <option <?= $singleData['category']  == 'ENGLISH'  ? 'selected' : '';?>>ENGLISH</option>
                    </select>
                    <?php
                      if(isset($category)):
                        echo '<div class="error-msg"><p>'.$category.'</p></div>';
                      endif;
                    ?>
                  </div>
                  <div class="input-group">
                    <label for="totalStock">Total Stock</label>
                    <input type="number" id="totalStock" name="totalStock" value="<?= $singleData['total_stock'];?>" placeholder="Enter Total Stock.">
                    <?php
                      if(isset($totalStock)):
                        echo '<div class="error-msg"><p>'.$totalStock.'</p></div>';
                      endif;
                    ?>
                  </div>
                </div>
                <div class="input-row">
                  <div class="input-group">
                    <label for="description">Description</label>
                    <textarea name="bookDescription" id="description"  rows="10" placeholder="Write about this Book"><?= $singleData['description'];?></textarea>                    
                    <?php
                      if(isset($bookDescription)):
                        echo '<div class="error-msg"><p>'.$bookDescription.'</p></div>';
                      endif;
                    ?>
                  </div>                  
                  <div class="input-group">
                    <label for="picture">Insert Picture (width:750, Height:900)</label>
                    <input type="file" id="picture" name="bookImage">
                  </div>
                </div>
                <button name="bookEditSubmit">Submit</button>
              </form>
            </div>
          </div>
        </div>
        <!-- Student Register form section End -->

   	  </div><!-- body content End -->  
  </div> <!-- Full body wrap ENd-->
    

<?php include_once(ADMINELEMENT.'footer.php');?> 