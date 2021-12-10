<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use Ciu\Notice\Notice;
use Ciu\Utility\Message;

$id = $_GET['id'];


$Notice = new Notice();
$singleData = $Notice->singleData($id);

// Prepare error message show
  switch (Message::getMessage()) {
    case 'emptyfield':
      $emptyfield = "All Field Require";
      break;
    case 'noticeHeadline':
      $noticeHeadline = "illegal Charecter! You can use - _ ,";
      break;
    case 'fileType':
      $fileType = "File type should be 'PDF' or 'JPEG' or 'PNG'";
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
          <a href="javascript:void(0)"><i class="far fa-file-alt"></i> Notice </a> <span>-</span>
          <a href="index.php">Notice</a> <span>-</span>
          <a href="show.php?id=<?= $singleData['id'];?>">Show</a> <span>-</span>
          <a href="edit.php?id=<?= $singleData['id'];?>">Edit</a>
        </div>

        <!-- Page Link End -->

        <!-- Student Register form section start -->
        <div class="wrapper">
          <div class="single-section">
            <div class="page-heading">
              <h2> Edit Notice</h2>
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
                <input type="hidden" name="noticeId" value="<?= $singleData['id'];?>">
                <div class="input-row">
                  <div class="input-group">
                    <label for="noticeHeadline">Headline</label>
                    <input type="text" id="noticeHeadline" name="noticeHeadline" value="<?= $singleData['notice_headline'];?>" placeholder="Enter Notice Headline">
                    <?php
                      if(isset($noticeHeadline)):
                        echo '<div class="error-msg"><p>'.$noticeHeadline.'</p></div>';
                      endif;
                    ?>
                  </div>
                  <div class="input-group">
                    <label for="picture">Insert PDF/Image</label>
                    <input type="file" id="picture" name="noticeFile">
                    <?php
                      if(isset($fileType)):
                        echo '<div class="error-msg"><p>'.$fileType.'</p></div>';
                      endif;
                    ?>
                  </div>
                </div>
                <button name="noticeEditSubmit">Submit</button>
              </form>
            </div>
          </div>
        </div>
        <!-- Student Register form section End -->

   	  </div><!-- body content End -->  
  </div> <!-- Full body wrap ENd-->
    

<?php include_once(ADMINELEMENT.'footer.php');?> 