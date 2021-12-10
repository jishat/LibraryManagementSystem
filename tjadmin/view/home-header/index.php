<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Utility\Message;
use App\Brand\Brand;
use App\Social\Social;

$Brand      = new Brand();
$showBrand  = $Brand->showBrand();

$Social         = new Social();
$showSocialLink = $Social->showSocialLink();

// Prepare error message show
  switch (Message::getMessage()) {
    case 'successfully':
      $successfully = "Update successfully";
      break;
    case 'unsuccessfully':
      $unsuccessfully = "Something Went wrong";
      break;
    case 'logosuccessfully':
      $logosuccessfully = "Logo Update Successfully";
      break;
    case 'emptyfile':
      $emptyfile = "Insert Logo before update";
      break;
    case 'brandnameempty':
      $brandnameempty = "Write brand name before update";
      break;
    case 'brandnamesuccessfully':
      $brandnamesuccessfully = "Brand Name Update Successfully";
      break;
    case 'socialsuccessfully':
      $socialsuccessfully = "Social Link Update Successfully";
      break;
    case 'socialunsuccessfully':
      $socialunsuccessfully = "Error! Something went wrong";
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
          <a href="javascript:void(0)"><i class="fas fa-home"></i> Home page </a> <span>-</span>
          <a href="index.php">Home-Header</a>
        </div>
        <!-- Page Link End -->

        <!-- Students section start -->
        <div class="wrapper">
          <!-- Input Logo Section -->
          <div class="single-section">
            <!-- Get success or errror message -->
            <?php

              if(isset($logosuccessfully)):
                echo '<div class="success-msg"><p>'.$logosuccessfully.'</p></div>';
              endif;

              if(isset($emptyfile)):
                echo '<div class="error-msg"><p>'.$emptyfile.'</p></div>';
              endif;
              if(isset($unsuccessfully)):
                echo '<div class="error-msg"><p>'.$unsuccessfully.'</p></div>';
              endif;
            ?>

            <div class="section-heading">
              <div class="heading-text">
                <h2> Logo</h2>
              </div>
            </div>
            <div class="main-table">
              <table>
                <thead>
                  <tr>
                    <th>Logo</th>
                    <th>Input File</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <img src="<?= IMAGESUTILITY.$showBrand['logo'];?>" alt="image" width="70px" height="auto">
                    </td>
                    <form action="update.php" method="post" enctype="multipart/form-data">
                    <td>
                      <div class="input-group">
                        <label for="logo">Input Logo from update</label>
                        <input type="file" id="logo" name="brandLogo">
                      </div>
                    </td>
                    <td>
                      <button name="brandUpdtSubmit" onclick="return confirm('Are your sure to Update')">Update</button>
                    </td>
                    </form>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Input brand name section -->
          <div class="single-section">
            <!-- Get success or errror message -->
            <?php

              if(isset($brandnamesuccessfully)):
                echo '<div class="success-msg"><p>'.$brandnamesuccessfully.'</p></div>';
              endif;

              if(isset($brandnameempty)):
                echo '<div class="error-msg"><p>'.$brandnameempty.'</p></div>';
              endif;
            ?>

            <div class="section-heading">
              <div class="heading-text">
                <h2> Brand Name</h2>
              </div>
            </div>
            <div class="main-table">
              <table>
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <form action="update.php" method="post">
                    <td>
                      <div class="input-group">
                        <label for="brandName"> Update Name</label>
                        <input type="text" id="brandName" name="brandName" value="<?= $showBrand['brand_name'];?>">
                      </div>
                    </td>
                    <td>
                      <button name="brandUpdtSubmit" onclick="return confirm('Are your sure to Update')">Update</button>
                    </td>
                    </form>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Input Social Link section -->
          <div class="single-section">
            <!-- Get success or errror message -->
            <?php

              if(isset($socialsuccessfully)):
                echo '<div class="success-msg"><p>'.$socialsuccessfully.'</p></div>';
              endif;

              if(isset($socialunsuccessfully)):
                echo '<div class="error-msg"><p>'.$socialunsuccessfully.'</p></div>';
              endif;
            ?>

            <div class="section-heading">
              <div class="heading-text">
                <h2> Social Link</h2>
              </div>
            </div>
            <div class="main-table">
              <table>
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Link</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- facebook Link -->
                  <tr>
                    <td><span class="fIcon"><i class="fab fa-facebook-f"></i></span></td>
                    <form action="social-update.php" method="post">
                    <td>
                      <div class="input-group">
                        <label for="fLink"> Input Facebook Link</label>
                        <input type="url" id="fLink" name="facebook" value="<?= $showSocialLink['facebook'];?>">
                      </div>
                    </td>
                    <td>
                      <button name="socLinkSubmit" onclick="return confirm('Are your sure to Update')">Update</button>
                    </td>
                    </form>
                  </tr>
                  <!-- Twitter Link -->
                  <tr>
                    <td><span class="tIcon"><i class="fab fa-twitter"></i></span></td>
                    <form action="social-update.php" method="post">
                    <td>
                      <div class="input-group">
                        <label for="tLink"> Input Twiiter Link</label>
                        <input type="url" id="tLink" name="twitter" value="<?= $showSocialLink['twitter'];?>">

                      </div>
                    </td>
                    <td>
                      <button name="socLinkSubmit" onclick="return confirm('Are your sure to Update')">Update</button>
                    </td>
                    </form>
                  </tr>

                  <!-- Youtube Link -->
                  <tr>
                    <td><span class="yIcon"><i class="fab fa-youtube"></i></span></td>
                    <form action="social-update.php" method="post">
                    <td>
                      <div class="input-group">
                        <label for="youtubeLink"> Input youtube Link</label>
                        <input type="url" id="youtubeLink" name="youtube" value="<?= $showSocialLink['youtube'];?>">
                      </div>
                    </td>
                    <td>
                      <button name="socLinkSubmit" onclick="return confirm('Are your sure to Update')">Update</button>
                    </td>
                    </form>
                  </tr>


                   <!-- Linkdin Link -->
                  <tr>
                    <td><span class="lIcon"><i class="fab fa-linkedin"></i></span></td>
                    <form action="social-update.php" method="post">
                    <td>
                      <div class="input-group">
                        <label for="linkdinLink"> Input Linkdin Link</label>
                        <input type="url" id="linkdinLink" name="linkdin" value="<?= $showSocialLink['linkdin'];?>">
                      </div>
                    </td>
                    <td>
                      <button name="socLinkSubmit" onclick="return confirm('Are your sure to Update')">Update</button>
                    </td>
                    </form>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- Students section End -->

   	  </div><!-- body content End -->
  </div> <!-- Full body wrap ENd-->


<?php include_once(ADMINELEMENT.'footer.php');?>
