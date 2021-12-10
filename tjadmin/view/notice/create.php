<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use Ciu\Notice\Notice;
use Ciu\Utility\Message;

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
          <a href="create.php">Add new</a>
        </div>

        <!-- Page Link End -->

        <!-- Student Register form section start -->
        <div class="wrapper">
          <div class="single-section">
            <div class="page-heading">
              <h2> Add Notice</h2>
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
                    <label for="noticeHeadline">Headline</label>
                    <input type="text" id="noticeHeadline" name="noticeHeadline" value="<?= isset($_SESSION['noticeHeadline']) ? $_SESSION['noticeHeadline'] : '';?>" placeholder="Enter Notice Headline">
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
                <button name="noticeSubmit">Submit</button>
              </form>
            </div>
          </div>
        </div>
        <!-- Student Register form section End -->

   	  </div><!-- body content End -->  
  </div> <!-- Full body wrap ENd-->
    

<?php include_once(ADMINELEMENT.'footer.php');?> 