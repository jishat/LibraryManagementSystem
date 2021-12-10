<?php include_once($_SERVER['DOCUMENT_ROOT'].'/ciu/bootstrap.php');
use Ciu\Utility\Message;
use Ciu\Book\Book;

$book = new Book();
$allBooks = $book->allBooks();

// Prepare error message show
  switch (Message::getMessage()) {
    case 'successfully':
      $successfully = "Insert Book Successfully";
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
          <a href="javascript:void(0)"><i class="fas fa-book"></i> Book </a> <span>-</span>
          <a href="index.php">Books</a>
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
                <h2> Books List</h2>
              </div>
              <div class="add-new-btn">
                <a href ="create.php">Add New</a>
              </div>
            </div>
            <div class="main-table">
              <table>
                <thead>
                  <tr>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Book Id</th>
                    <th>Category</th>
                    <th>Total Stock</th>
                    <th>Total Borrowed</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($allBooks)){
                      foreach ($allBooks as $allBook) { ?>
                        <tr>
                          <td> <img src="<?= !empty($allBook['book_image']) ? IMAGESBOOK.$allBook['book_image'] : IMG.'dummybook.jpg';?>" alt="image" width="70px" height="auto"></td>
                          <td><a href="show.php?id=<?= $allBook['id'];?>"> <?= $allBook['book_name'];?></a></td>
                          <td><?= $allBook['book_id'];?></td>
                          <td><?= $allBook['category'];?></td>
                          <td><?= $allBook['total_stock'];?></td>
                          <td><?= $allBook['total_borrowed'];?></td>
                          <td>
                            <!-- Edit Button -->
                            <span><a href="edit.php?id=<?= $allBook['id'];?>" class="editButton">Edit</a></span> 
                            <!-- Disable/Enable Button -->
                            <span>
                              <?php 
                                if($allBook['is_disable'] == 'no'){?>
                                  <form action="disable.php" method="post"><input type="hidden" name="bookId" value="<?= $allBook["id"];?>"><button class="disableButton" id="disableButton" name="bookDisableButton" onclick="return confirm('Are your sure to Disable')">Disable</button></form>
                              <?php 
                                }else{?>
                                  <form action="enable.php" method="post"><input type="hidden" name="bookId" value="<?= $allBook["id"];?>"><button class="enableButton" id="enableButton" name="bookEnableButton" onclick="return confirm('Are your sure to Enable')">Enable</button></form>
                              <?php   
                                }
                              ?>
  
                            </span>
                            <!-- Delete Button -->
                            <span>
                              <form action="delete.php" method="post"><input type="hidden" name="bookId" value="<?= $allBook["id"];?>"><button class="deleteButton" name="bookDeleteButton" onclick="return confirm('Are your sure to Delete')">Delete</button></form></span>
                          </td>
                        </tr>
                      <?php
                      }
                      }else{
                        echo "<tr><td>There has no any books</td></tr>";
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