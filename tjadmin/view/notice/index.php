<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php'); 
use Ciu\Notice\Notice;
use Ciu\Utility\Message;

$Notice = new Notice();
$allNotice = $Notice->allNotice();

// Prepare error message show
  switch (Message::getMessage()) {
    case 'successfully':
      $successfully = "Insert Notice Successfully";
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
    case 'delete':
      $successfully = "Delete Successfully.";
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
          <a href="javascript:void(0)"><i class="far fa-file-alt"></i> Notice </a> <span>-</span>
          <a href="index.php">Notice</a>
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

            <div class="section-heading">
              <div class="heading-text">
                <h2> All Notice</h2>
              </div>
              <div class="add-new-btn">
                <a href ="create.php">Add New</a>
              </div>
            </div>
            <div class="main-table">
              <table>
                <thead>
                  <tr>
                    <th>SL.</th>
                    <th>Headline</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                      $x = 0;
                      foreach ($allNotice as $notice) { ?>
                        <tr>
                          <td><?= ++$x;?></td>
                          <td><a href="show.php?id=<?= $notice['id'];?>"> <?= $notice['notice_headline'];?></a></td>
                          <td><?= date("h:ia", strtotime($notice['create_at'])); ?></td>
                          <td><?= date("d-M-Y", strtotime($notice['create_at'])); ?></td>
                          <td>
                            <!-- Edit Button -->
                            <span><a href="edit.php?id=<?= $notice['id'];?>" class="editButton">Edit</a></span> 
                            <!-- Disable/Enable Button -->
                            <span>
                              <?php 
                                if($notice['is_disable'] == 'no'){?>
                                  <form action="disable.php" method="post"><input type="hidden" name="noticeId" value="<?= $notice["id"];?>"><button class="disableButton" id="disableButton" name="noticeDisableButton" onclick="return confirm('Are your sure to Disable')">Disable</button></form>
                              <?php 
                                }else{?>
                                  <form action="enable.php" method="post"><input type="hidden" name="noticeId" value="<?= $notice["id"];?>"><button class="enableButton" id="enableButton" name="noticeEnableButton" onclick="return confirm('Are your sure to Enable')">Enable</button></form>
                              <?php   
                                }
                              ?>
  
                            </span>
                            <!-- Delete Button -->
                            <span>
                              <form action="delete.php" method="post"><input type="hidden" name="noticeId" value="<?= $notice["id"];?>"><button class="deleteButton" name="noticeDeleteButton" onclick="return confirm('Are your sure to Delete')">Delete</button></form></span>
                          </td>
                        </tr>
                      <?php
                      }
                    ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Students section End -->
        
   	  </div><!-- body content End -->  
  </div> <!-- Full body wrap ENd-->
    

<?php include_once(ADMINELEMENT.'footer.php');?> 