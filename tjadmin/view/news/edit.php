<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\News\News;
use App\Utility\Message;

$id = $_GET['id'];


$News = new News();
$singleData = $News->singleData($id);

// Prepare error message show
  switch (Message::getMessage()) {
    case 'emptyfield':
      $emptyfield = "All Field Require";
      break;
    case 'newsHeadline':
      $newsHeadline = "Illigel Charecter!";
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
          <a href="javascript:void(0)"><i class="far fa-newspaper"></i> News </a> <span>-</span>
          <a href="index.php">News</a> <span>-</span>
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
                <input type="hidden" name="newsId" value="<?= $singleData['id'];?>">
                <div class="input-row">
                  <div class="input-group">
                    <label for="newsHeadline">Headline</label>
                    <input type="text" id="newsHeadline" name="newsHeadline" value="<?= $singleData['headline'];?>" placeholder="Enter News Headline">
                    <?php
                      if(isset($newsHeadline)):
                        echo '<div class="error-msg"><p>'.$newsHeadline.'</p></div>';
                      endif;
                    ?>
                  </div>
                  <div class="input-group">
                    <label for="picture">Insert Picture (width:350, Height:250)</label>
                    <input type="file" id="picture" name="newsImage">
                  </div>
                </div>
                <div class="input-row">
                  <div class="input-group">
                    <label for="newsDescription">Description</label>
                    <textarea name="newsDescription" id="newsDescription"  rows="10" placeholder="Write description of news" ><?= $singleData['news_description'];?></textarea>
                  </div>
                </div>
                <button name="newsEditSubmit">Submit</button>
              </form>
            </div>
          </div>
        </div>
        <!-- Student Register form section End -->

   	  </div><!-- body content End -->
  </div> <!-- Full body wrap ENd-->


<?php include_once(ADMINELEMENT.'footer.php');?>
