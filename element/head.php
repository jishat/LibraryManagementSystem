<?php
use App\Brand\Brand;

$Brand = new Brand();
$showBrand = $Brand->showBrand();
?>
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8">
  <title>Chittagong Independent University</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <!-- Favicon Link -->
  <link rel="icon" href="<?php echo IMG.'ChittagongIndependentUniversitylogo.png';?>">
  <link rel="apple-touch-icon" href="<?php echo IMG.'ChittagongIndependentUniversitylogo.png';?>">

  <?php
  if(BASENAME == 'book' || BASENAME == 'borrow' || BASENAME == 'notification'){ //if book start ?>
    <link rel="stylesheet" href="<?php echo ASSETS.'plugins/daterangepicker/daterangepicker.css'; ?>">
    <link rel="stylesheet" href="<?php echo ASSETS.'plugins/icheck-bootstrap/icheck-bootstrap.min.css'; ?>">
    <!-- data table resposive design -->
    <link rel="stylesheet" href="<?php echo ASSETS.'plugins/datatables/css/datatables.min.css'; ?>">
  <?php
  }
  ?>

  <!--***********************************************************************-->
  <!-- Start Common Css -->
  <!--***********************************************************************-->
  <link rel="stylesheet" href="<?php echo ASSETS.'css/normalize.css'; ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo ASSETS.'plugins/fontawesome-free/css/all.min.css'; ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo ASSETS.'plugins/toastr/toastr.min.css'; ?>">

  <link rel="stylesheet" href="<?php echo ASSETS.'css/main.min.css' ?>">
  <!-- Main css link -->

  <link rel="stylesheet" href="<?php echo ASSETS.'css/main.css'; ?>">
  <!--***********************************************************************-->
  <!-- End Common Css -->
  <!--***********************************************************************-->

</head>
<body>
  <div class="overlay">
  	<div class="loader loader-41">
  		<div class="loader-container">
  			<p class='loader-title-double'>Loading</p>
  			<p class='loader-title'>Loading</p>
  		</div>
  	</div>
  </div>
