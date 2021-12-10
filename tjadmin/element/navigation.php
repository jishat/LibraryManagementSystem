<?php
use App\Login\Login;
use App\User\User;
use App\Userrole\Userrole;
use App\Notification\Notification;
use App\Utility\Message;

Login::checkLogOut();

$loginid = Login::loginGet('userid');
$loginUsrRole = Login::loginGet('userrole');

$getMenuName = trim(strtolower($urlPath[0]));
if($getMenuName == 'user'){
  $menuId = 1;
}elseif ($getMenuName == 'student' || $getMenuName == 'faculty') {
  $menuId = 2;
}elseif ($getMenuName == 'borrow' || $getMenuName == 'renew') {
  $menuId = 3;
}elseif ($getMenuName == 'book' || $getMenuName == 'category') {
  $menuId = 4;
}else {
  $menuId = 0;
}
$Userrole = new Userrole;
$userRoleInfoById = $Userrole->userRoleInfoById($loginUsrRole);

$admin_pages_ids = explode(",", substr($userRoleInfoById['admin_pages_id'], 1));

if($menuId != 0){
  if(!in_array($menuId, $admin_pages_ids)){
    header('location:'.ADMIN.'404');
    exit();
  }
}

$msg = Message::getMessage(); //assign the session message which use in every page as needed

$User = new User();
$userData = $User->userData($loginid);
$Notification = new Notification;
$unseenNotification = $Notification->unseenNotification();
?>

 <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
   <!--[if IE]>
     <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
   <![endif]-->

 <!-- Add site or application content here -->
 <div class="overlay">
  <div class="loader loader-41">
    <div class="loader-container">
      <p class='loader-title-double'>Loading</p>
      <p class='loader-title'>Loading</p>
    </div>
  </div>
 </div>
 <div class="wrapper">
   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
       <li class="nav-item">
         <a class="sidebar-toggle-btn" data-widget="pushmenu" href="#" role="button"><i class="fas fa-align-left"></i></a>
       </li>
     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto top-right-side-nav">
       <!-- Notifications Dropdown Menu -->
       <li class="nav-item">
         <a class="nav-link top-right-side-nav"  href="<?php echo ADMINVIEW.'notification'?>">
           <i class="far fa-bell"></i>
           <?php echo $unseenNotification != 'error' ? '<span class="badge badge-warning navbar-badge">'. count($unseenNotification).'</span>' :''; ?>
         </a>
       </li>
       <!-- Profile Dropdown Menu -->
       <li class="nav-item dropdown">
         <a class="nav-link top-right-profile-nav" data-toggle="dropdown" href="#">
           <div class="image">
             <img src="<?php echo IMAGESUSER.$userData['picture']; ?>" width="30" class="img-circle" alt="User Image">
           </div>
           <!-- <span class="badge badge-warning navbar-badge">15</span> -->
         </a>
         <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
           <!-- <span class="dropdown-item dropdown-header">15 Notifications</span>
           <div class="dropdown-divider"></div> -->
           <a href="<?php echo ADMINVIEW.'profile'?>" class="dropdown-item">
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
   <!-- /.navbar -->

   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="index3.html" class="brand-link">
       <img src="<?php echo ADMIN.'assets/img/techjishat.png'; ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
       <span class="brand-text font-weight-light">Tech Jishat</span>
     </a>


     <!-- Sidebar -->
     <div class="sidebar">
       <!-- Sidebar user panel (optional) -->
       <div class="user-panel mt-3 pb-3 mb-3 d-flex">
         <div class="image">
           <img src="<?php echo !empty($userData['picture']) ? IMAGESUSER.$userData['picture'] : IMG.'avatar-man.png';?>" class="img-circle elevation-2" alt="User Image">
         </div>
         <div class="info">
           <a href="javascript:void(0)" class="d-block"><?php echo trim_word($userData['name'], 2); ?></a>
         </div>
       </div>

       <!-- Sidebar Menu -->
       <nav class="mt-2">
         <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-flat" data-widget="treeview" role="menu" data-accordion="false">
           <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
           <li class="nav-item has-treeview"> <!-- dashboard start -->
             <a href="<?= ADMINVIEW.'dashboard'?>" class="nav-link <?php echo DIRECTORY == 'dashboard' ? 'active' : ' '; ?>">
               <i class="nav-icon fas fa-tachometer-alt"></i>
               <p>
                 Dashboard
               </p>
             </a>
           </li> <!-- dashboard end -->

           <?php
            if(in_array(2, $admin_pages_ids)){
            ?>

           <li class="nav-item has-treeview <?php echo DIRECTORY == 'student' || DIRECTORY == 'faculty' ? 'menu-open' : ' '; ?>">
             <a href="#" class="nav-link <?php echo DIRECTORY == 'student' || DIRECTORY == 'faculty' ? 'active' : ' '; ?>">
               <i class="nav-icon fas fa-user-graduate"></i>
               <p>
                 Student
                 <i class="fas fa-angle-left right"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'student'?>" class="nav-link <?php echo DIRECTORY == 'student' && (basename($_SERVER['REQUEST_URI'], '.php') == 'index' || basename($_SERVER['REQUEST_URI']) == 'student') ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">All Student</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'student/create'?>" class="nav-link <?php echo DIRECTORY == 'student' && basename($_SERVER['REQUEST_URI'], '.php') == 'create' ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">Add New</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'faculty'?>" class="nav-link <?php echo DIRECTORY == 'faculty' && (basename($_SERVER['REQUEST_URI'], '.php') == 'index' || basename($_SERVER['REQUEST_URI']) == 'faculty') ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">Faculty</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'faculty/create'?>" class="nav-link <?php echo DIRECTORY == 'faculty' && basename($_SERVER['REQUEST_URI'], '.php') == 'create' ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">Add Faculty</p>
                 </a>
               </li>

             </ul>
           </li>
           <?php
            }
            if(in_array(4, $admin_pages_ids)){
           ?>
           <li class="nav-item has-treeview <?php echo DIRECTORY == 'book' || DIRECTORY == 'category' ? 'menu-open' : ' '; ?>">
             <a href="#" class="nav-link <?php echo DIRECTORY == 'book' || DIRECTORY == 'category' ? 'active' : ' '; ?>">
               <i class="nav-icon fas fa-book"></i>
               <p>
                 Book
                 <i class="fas fa-angle-left right"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'book'?>" class="nav-link <?php echo DIRECTORY == 'book' && (basename($_SERVER['REQUEST_URI'], '.php') == 'index' || basename($_SERVER['REQUEST_URI']) == 'book') ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">All Books</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'book/create'?>" class="nav-link <?php echo DIRECTORY == 'book' && basename($_SERVER['REQUEST_URI'], '.php') == 'create' ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">Add New</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'category'?>" class="nav-link <?php echo DIRECTORY == 'category' && (basename($_SERVER['REQUEST_URI'], '.php') == 'index' || basename($_SERVER['REQUEST_URI']) == 'category') ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">Category</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'category/create'?>" class="nav-link <?php echo DIRECTORY == 'category' && basename($_SERVER['REQUEST_URI'], '.php') == 'create' ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">Add Category</p>
                 </a>
               </li>

             </ul>
           </li>
           <?php
            }
            if(in_array(3, $admin_pages_ids)){
           ?>
           <li class="nav-item has-treeview <?php echo DIRECTORY == 'borrow' || DIRECTORY == 'renew' ? 'menu-open' : ' '; ?>">
             <a href="#" class="nav-link <?php echo DIRECTORY == 'borrow' || DIRECTORY == 'renew' ? 'active' : ' '; ?>">
               <i class="nav-icon fas fa-book"></i>
               <p>
                 Borrow
                 <i class="fas fa-angle-left right"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'borrow'?>" class="nav-link <?php echo DIRECTORY == 'borrow' && (basename($_SERVER['REQUEST_URI'], '.php') == 'index' || basename($_SERVER['REQUEST_URI']) == 'borrow') ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">All Borrow</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'borrow/create'?>" class="nav-link <?php echo DIRECTORY == 'borrow' && basename($_SERVER['REQUEST_URI'], '.php') == 'create' ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">Add New Manually</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'renew'?>" class="nav-link <?php echo DIRECTORY == 'renew' && (basename($_SERVER['REQUEST_URI'], '.php') == 'index' || basename($_SERVER['REQUEST_URI']) == 'renew') ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">Renew Requested</p>
                 </a>
               </li>

             </ul>
           </li>
           <?php
            }
           ?>
           <li class="nav-item has-treeview">
             <a href="<?php echo ADMINVIEW.'notification'?>" class="nav-link <?php echo DIRECTORY == 'notification' ? 'active' : ' '; ?>">
               <i class="nav-icon far fa-bell"></i>
               <p>
                 Notification
               </p>
               <?php
               if($unseenNotification != 'error'){
                 echo '<span class="badge badge-warning right">'.count($unseenNotification).'</span>';
               }
               ?>

             </a>
           </li>
           <li class="nav-header py-2" style="background:#272b2f;">Account Settings</li>
           <?php
            if(in_array(1, $admin_pages_ids)){
           ?>
           <li class="nav-item has-treeview <?php echo DIRECTORY == 'user' || DIRECTORY == 'user-role' ? 'menu-open' : ' '; ?>">
             <a href="#" class="nav-link <?php echo DIRECTORY == 'user' || DIRECTORY == 'user-role' ? 'active' : ' '; ?>">
               <i class="nav-icon fas fa-users"></i>
               <p>
                 User
                 <i class="fas fa-angle-left right"></i>
               </p>
             </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'user'?>" class="nav-link <?php echo DIRECTORY == 'user' && (basename($_SERVER['REQUEST_URI'], '.php') == 'index' || basename($_SERVER['REQUEST_URI']) == 'user') ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">All User</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'user/create'?>" class="nav-link <?php echo DIRECTORY == 'user' && basename($_SERVER['REQUEST_URI'], '.php') == 'create' ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">Add New</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'user-role'?>" class="nav-link <?php echo DIRECTORY == 'user-role' && (basename($_SERVER['REQUEST_URI'], '.php') == 'index' || basename($_SERVER['REQUEST_URI']) == 'user-role') ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">User Role</p>
                 </a>
               </li>
               <li class="nav-item">
                 <a href="<?= ADMINVIEW.'user-role/create'?>" class="nav-link <?php echo DIRECTORY == 'user-role' && basename($_SERVER['REQUEST_URI'], '.php') == 'create' ? 'active' : ' '; ?>">
                   <!-- <i class="fas fa-caret-right nav-icon ml-1"></i> -->
                   <p class="sub-drop-menu">Add User Role</p>
                 </a>
               </li>

             </ul>
           </li>
           <?php
            }
           ?>
           <li class="nav-item has-treeview">
             <a href="<?php echo ADMINVIEW.'profile'?>" class="nav-link <?php echo DIRECTORY == 'profile' ? 'active' : ' '; ?>">
               <i class="nav-icon fas fa-user-alt"></i>
               <p>
                 Profile
               </p>

             </a>
           </li>

         </ul>
       </nav>
       <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
   </aside>
