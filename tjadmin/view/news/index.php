<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\News\News;
use App\Utility\Message;

$News = new News();
$allNews = $News->allNews();

// Prepare error message show
  switch (Message::getMessage()) {
    case 'successfully':
      $successfully = "Insert News Successfully";
      break;
    case 'unsuccessfully':
      $unsuccessfully = "Something Went wrong un";
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
          <a href="javascript:void(0)"><i class="far fa-newspaper"></i> News </a> <span>-</span>
          <a href="index.php">News</a>
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
                echo '<div class="error-msg errmsgParant"><p>'.$unsuccessfully.'</p></div>';
              endif;
            ?>

            <div class="section-heading">
              <div class="heading-text">
                <h2> All News</h2>
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
                    <th>Picture</th>
                    <th>Headline</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                      if(!empty($allNews)){
                        $x = 0;
                        foreach ($allNews as $news) { ?>
                          <tr>
                            <td><?= ++$x;?></td>
                            <td> <img src="<?= !empty($news['news_image']) ? IMAGESNEWS.$news['news_image'] : IMG.'avatar-man.png';?>" alt="image" width="70px" height="auto"></td>
                            <td><a href="show.php?id=<?= $news['id'];?>"> <?= $news['headline'];?></a></td>
                            <td><?= date("h:ia", strtotime($news['create_at'])); ?></td>
                            <td><?= date("d-M-Y", strtotime($news['create_at'])); ?></td>
                            <td>
                              <!-- Edit Button -->
                              <span><a href="edit.php?id=<?= $news['id'];?>" class="editButton">Edit</a></span>
                              <!-- Disable/Enable Button -->
                              <span>
                                <?php
                                  if($news['is_disable'] == 'no'){?>
                                    <form action="disable.php" method="post"><input type="hidden" name="newsId" value="<?= $news["id"];?>"><button class="disableButton" id="disableButton" name="newsDisableButton" onclick="return confirm('Are your sure to Disable')">Disable</button></form>
                                <?php
                                  }else{?>
                                    <form action="enable.php" method="post"><input type="hidden" name="newsId" value="<?= $news["id"];?>"><button class="enableButton" id="enableButton" name="newsEnableButton" onclick="return confirm('Are your sure to Enable')">Enable</button></form>
                                <?php
                                  }
                                ?>

                              </span>
                              <!-- Delete Button -->
                              <span>
                                <form action="delete.php" method="post"><input type="hidden" name="newsId" value="<?= $news["id"];?>"><button class="deleteButton" name="newsDeleteButton" onclick="return confirm('Are your sure to Delete')">Delete</button></form></span>
                            </td>
                          </tr>
                        <?php
                        }
                      }else{
                        echo "<tr><td>There has no any news yet</td></tr>";
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
