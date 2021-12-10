<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\News\News;
use App\Utility\Message;

$id = $_GET['id'];

$News = new News();
$singleData = $News->singleData($id);

// Prepare error message show
  switch (Message::getMessage()) {
    case 'successfully':
      $successfully = "Register student account successfully";
      break;
    case 'unsuccessfully':
      $unsuccessfully = "Something Went wrong";
      break;
    case 'disable':
      $successfully = "Disable Successfully.";
      break;
    case 'enable':
      $successfully = "Enable Successfully.";
      break;
    default:
      $msg2 = "something went wrong";
      break;
  }

?>

<?php include_once(ADMINELEMENT.'head.php');?>
<?php include_once(ADMINELEMENT.'navigation.php');?> <!-- include navigation section -->
        <!-- Page Link start -->
        <div class="page-link wrapper">
          <a href="javascript:void(0)"><i class="far fa-newspaper"></i> News </a> <span>-</span>
          <a href="index.php">News</a> <span>-</span>
          <a href="show.php?id=<?= $singleData['id'];?>">Show</a>
        </div>
        <!-- Page Link End -->

        <!-- Students section start -->
        <div class="wrapper">
          <div class="single-section">
            <!-- Get success or errror message -->
            <?php

              if(isset($successfully)):
                echo '<div class="success-msg"><p>'.$successfully.'</p></div>';
              endif;

              if(isset($unsuccessfully)):
                echo '<div class="error-msg"><p>'.$unsuccessfully.'</p></div>';
              endif;
            ?>
            <div class="Student-details">
              <img src="<?= !empty($singleData['news_image']) ? IMAGESNEWS.$singleData['news_image'] : IMG.'avatar-man.png';?>" alt="image">
              <table>
                <tbody>
                  <tr>
                    <td>Headline:</td>
                    <td><?= $singleData['headline'];?></td>
                  </tr>
                  <tr>
                    <td>Time:</td>
                    <td><?= date("h:ia", strtotime($singleData['create_at'])); ?></td>
                  </tr>
                  <tr>
                    <td>Date:</td>
                    <td><?= date("d-M-Y", strtotime($singleData['create_at'])); ?></td>
                  </tr>
                  <tr>
                    <td>Description.:</td>
                    <td><?= $singleData['news_description'];?></td>
                  </tr>
                </tbody>
              </table>
              <div class="show-action-btn">
                <!-- Edit Button -->
                <span><a href="edit.php?id=<?= $singleData['id'];?>" class="editButton">Edit</a></span>
                <!-- Disable/Enable Button -->
                <span>
                  <?php
                    if($singleData['is_disable'] == 'no'){?>
                      <form action="disable.php" method="post"><input type="hidden" name="newsId" value="<?= $singleData["id"];?>"><input type="hidden" name="link" value="show"><button class="disableButton" id="disableButton" name="newsDisableButton" onclick="return confirm('Are your sure to Disable')">Disable</button></form>
                  <?php
                    }else{?>
                      <form action="enable.php" method="post"><input type="hidden" name="newsId" value="<?= $singleData["id"];?>"><input type="hidden" name="link" value="show"><button class="enableButton" id="enableButton" name="newsEnableButton" onclick="return confirm('Are your sure to Enable')">Enable</button></form>
                  <?php
                    }
                  ?>

                </span>
                <!-- Delete Button -->
                <span>
                  <form action="delete.php" method="post"><input type="hidden" name="newsId" value="<?= $singleData["id"];?>"><button class="deleteButton" name="newsDeleteButton" onclick="return confirm('Are your sure to Delete')">Delete</button></form>
                </span>
              </div>
            </div>
          </div>
        </div>
        <!-- Students section End -->

   	  </div><!-- body content End -->
  </div> <!-- Full body wrap ENd-->


<?php include_once(ADMINELEMENT.'footer.php');?>
