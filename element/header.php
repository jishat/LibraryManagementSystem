<?php include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
use App\Student\Student;
use App\Login\Login;
use App\Notification\Notification;
Login::checkStudentLogout();
$id = Login::loginGet('id');
$slug = Login::loginGet('slug');

$Student  = new Student();
$singleData = $Student->singleDataById($id);
if($singleData == 'error'){
  Login::logout();
  header('location:'.WEBROOT);
}
$Notification = new Notification();
$unseenStudentNotifications = $Notification->unseenStudentNotifications($id);
?>


  <!-- Menu & Banner Start -->
  <header id="slider-section" style="background-image: url(<?php echo IMG.'background.jpg'; ?>);">
      <div class="top-menu darkMenu">
        <div class="container">
          <nav class="navbar navbar-expand">
            <!-- Brand/logo -->
            <!-- <a class="navbar-brand" href="#">
              <img src="<?= IMAGESUTILITY.$showBrand['logo'];?>" alt="logo" style="width:60px;">

            </a> -->
            <a class="navbar-brand" href="#"><img src="<?php echo IMAGESUTILITY.$showBrand['logo'];?>" alt="logo" style="height:40px;"> TechJishat</a>

            <!-- Links -->
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link <?php echo BASENAME == 'book' ? 'main-active' : '';  ?> " href="book"><i class="fas fa-book"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo BASENAME == 'borrow' ? 'main-active' : '';  ?>" href="borrow"><i class="fas fa-chart-bar"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo BASENAME == 'notification' ? 'main-active' : '';  ?>" href="notification"><i class="far fa-bell"></i> <?php echo $unseenStudentNotifications != 'error' ? '<span class="badge badge-danger navbar-badge">'.count($unseenStudentNotifications).'</span>' : ''; ?> </a>
              </li>
              <li class="nav-item dropdown">
               <a class="nav-link top-right-profile-nav" data-toggle="dropdown" href="#" aria-expanded="false">
                 <div class="image">
                   <img src="<?php echo !empty($singleData['picture']) ? IMAGESUSER.$singleData['picture'] : IMG.'avatar-man.png';?>" class="img-circle" alt="User Image" width="30">
                 </div>
                 <!-- <span class="badge badge-warning navbar-badge">15</span> -->
               </a>
               <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="left: inherit; right: 0px;">
                 <!-- <span class="dropdown-item dropdown-header">15 Notifications</span>
                 <div class="dropdown-divider"></div> -->
                 <a href="profile" class="dropdown-item">
                   <i class="nav-icon fas fa-user-tie mr-2"></i> Profile
                 </a>
                 <div class="dropdown-divider"></div>
                 <a href="#" class="dropdown-item" id="logout" data-name="logout">
                   <i class="fas fa-sign-out-alt mr-2"></i> Logout
                 </a>
                 <!-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
               </div>
             </li>
            </ul>
          </nav>
        </div>

      </div>
    <div class="container">
      <div class="row slide-content">
        <div class="col-12 col-md-4 col-lg-5 order-md-1 order-12">
          <div class="content-one">
            <h2>Books Collection</h2>
          </div>
        </div>
        <div class="col-md-8 col-lg-6 offset-lg-1 order-sm-12 order-1 d-none d-md-block">
          <div class="card shadow">
            <div class="card-body p-4">
              <div class="row align-items-center">
                <div class="col-md-4">
                  <div class="avatar-img">
                    <img src="<?php echo !empty($singleData['picture']) ? IMAGESUSER.$singleData['picture'] : IMG.'avatar-man.png';?>" alt="member">
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="profile-content ml-3">
                    <h2><?php echo trim($singleData['name']); ?></h2>
                    <table>
                    	<tbody>
                    		<tr>
            	        		<td>ID:</td>
            	        		<td><?php echo trim($singleData['student_id']); ?></td>
            	        	</tr>
                    		<tr>
            	        		<td>Batch:</td>
            	        		<td><?php echo trim($singleData['batch']); ?></td>
            	        	</tr>
            	        	<tr>
            	        		<td>Faculty:</td>
            	        		<td><?php echo trim($singleData['faculty_name']); ?></td>
            	        	</tr>
                        <tr>
                          <td>Gender:</td>
                          <td><?php echo $singleData['gender'] == 1 ? 'Male' : ($singleData['gender'] == 2 ? 'Female' : 'Others') ; ?></td>
                        </tr>
                        <tr>
            	        		<td>Email:</td>
            	        		<td><?php echo trim($singleData['email']); ?></td>
            	        	</tr>
                    	</tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="graph-img">
        <img src="<?php echo IMG.'shape.png'; ?>" alt="Graph shape">
      </div>
    </div>
  </header>
  <!-- Menu & Banner Start -->
