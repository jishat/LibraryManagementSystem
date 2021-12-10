<?php include_once($_SERVER['DOCUMENT_ROOT'].'/ciu/bootstrap.php');
use Ciu\Utility\Message;
use Ciu\Book\Book;

$id = $_GET['id'];

$Book = new Book();
$singleData = $Book->singleData($id);

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
          <a href="javascript:void(0)"><i class="fas fa-book"></i> Book </a> <span>-</span>
          <a href="index.php">Books</a> <span>-</span>
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
              <img src="<?= !empty($singleData['book_image']) ? IMAGESBOOK.$singleData['book_image'] : IMG.'avatar-man.png';?>" alt="image">
              <table>
                <tbody>
                  <tr>
                    <td>Book Name:</td>
                    <td><?= $singleData['book_name'];?></td>
                  </tr>
                  <tr>
                    <td>Writer.:</td>                    
                    <td><?= $singleData['writer'];?></td>
                  </tr>
                  <tr>
                    <td>Book ID:</td>
                    <td><?= $singleData['book_id'];?></td>
                  </tr>
                  <tr>
                    <td>Category:</td>
                    <td><?= $singleData['category'];?></td>
                  </tr>
                  <tr>
                    <td>Total Stock:</td>
                    <td><?= $singleData['total_stock'];?></td>
                  </tr>
                  <tr>
                    <td>Borrowed:</td>
                    <td><?= $singleData['total_borrowed'];?></td>
                  </tr>
                  <tr>
                    <td>Description:</td>
                    <td><?= $singleData['description'];?></td>
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
                      <form action="disable.php" method="post"><input type="hidden" name="bookId" value="<?= $singleData["id"];?>"><input type="hidden" name="link" value="show"><button class="disableButton" id="disableButton" name="bookDisableButton" onclick="return confirm('Are your sure to Disable')">Disable</button></form>
                  <?php 
                    }else{?>
                      <form action="enable.php" method="post"><input type="hidden" name="bookId" value="<?= $singleData["id"];?>"><input type="hidden" name="link" value="show"><button class="enableButton" id="enableButton" name="bookEnableButton" onclick="return confirm('Are your sure to Enable')">Enable</button></form>
                  <?php   
                    }
                  ?>

                </span>
                <!-- Delete Button -->
                <span>
                  <form action="delete.php" method="post"><input type="hidden" name="bookId" value="<?= $singleData["id"];?>"><button class="deleteButton" name="bookDeleteButton" onclick="return confirm('Are your sure to Delete')">Delete</button></form>
                </span>
              </div>
            </div>
          </div>
        </div>
        <!-- Students section End -->
        
   	  </div><!-- body content End -->  
  </div> <!-- Full body wrap ENd-->
    

<?php include_once(ADMINELEMENT.'footer.php');?> 