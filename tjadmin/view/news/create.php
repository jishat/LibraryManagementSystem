<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;

// Prepare error message show
  switch (Message::getMessage()) {
    case 'emptyfield':
      $emptyfield = "All Field Require";
      break;
    case 'newsHeadline':
      $newsHeadline = "Illigel Charecter!";
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
          <a href="javascript:void(0)"><i class="far fa-newspaper"></i> News </a> <span>-</span>
          <a href="index.php">News</a> <span>-</span>
          <a href="create.php">Add new</a>
        </div>

        <!-- Page Link End -->

        <!-- Student Register form section start -->
        <div class="wrapper">
          <div class="single-section">
            <div class="page-heading">
              <h2> Add News</h2>
            </div>
            <!-- Get success or errror message -->
            <?php
              if(isset($emptyfield)):
                echo '<div class="error-msg"><p>'.$emptyfield.'</p></div>';
              endif;
            ?>
            <div class="form-style">
              <form action="store.php" method="post" enctype="multipart/form-data">
                <div class="input-row">
                  <div class="input-group">
                    <label for="newsHeadline">Headline</label>
                    <input type="text" id="newsHeadline" name="newsHeadline" value="<?= isset($_SESSION['newsHeadline']) ? $_SESSION['newsHeadline'] : '';?>" placeholder="Enter News Headline">
                    <?php
                      if(isset($newsHeadline)):
                        echo '<div class="error-msg"><p>'.$newsHeadline.'</p></div>';
                      endif;
                    ?>
                  </div>
                  <div class="input-group">
                    <label for="picture">Insert Picture</label>
                    <input type="file" id="picture" name="newsImage">
                  </div>
                </div>

                <div class="input-row">
                  <div class="input-group">
                    <label for="newsDescription">Description</label>
                    <textarea name="newsDescription" id="newsDescription"  rows="10" placeholder="Write description of news" ><?= isset($_SESSION['newsDescription']) ? $_SESSION['newsDescription'] : '';?></textarea>
                  </div>
                </div>
                <button name="newsSubmit">Submit</button>
              </form>
            </div>
          </div>
        </div>
        <!-- Student Register form section End -->

   	  </div><!-- body content End -->
  </div> <!-- Full body wrap ENd-->


<?php include_once(ADMINELEMENT.'footer.php');?>
