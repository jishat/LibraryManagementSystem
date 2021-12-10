<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/bootstrap.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Library Management System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php
  //***************************************************************************
  // Start: Admin Menu Section Css
  //***************************************************************************
      //-----------------------------------------
      //Start: user-role/index.php
      //-----------------------------------------
      if(DIRECTORY == 'user-role' && (basename($_SERVER['REQUEST_URI'], '.php') == 'user-role' || basename($_SERVER['REQUEST_URI'], '.php') == 'index')){ ?>
        <!-- data table resposive design -->
        <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/datatables/css/datatables.min.css'; ?>">
      <?php
      }
      //-----------------------------------------
      //End: user-role/index.php
      //-----------------------------------------

      //-----------------------------------------
      //Start: user-role Menu/.....
      //-----------------------------------------
      if(DIRECTORY == 'user-role'){ ?>
      <!-- select2 -->
      <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/select2/css/select2.min.css'; ?>">
      <?php }
      //-----------------------------------------
      //End: user-role Menu/.....
      //-----------------------------------------

  //***************************************************************************
  // End: Admin Menu Section Css
  //***************************************************************************

  //***************************************************************************
  // Start: Student Menu Section Css
  //***************************************************************************
      //-----------------------------------------
      //Start: faculty/index.php
      //-----------------------------------------
      if(DIRECTORY == 'faculty' && (basename($_SERVER['REQUEST_URI'], '.php') == 'faculty' || basename($_SERVER['REQUEST_URI'], '.php') == 'index')){ ?>
        <!-- data table resposive design -->
        <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/datatables/css/datatables.min.css'; ?>">
      <?php
      }
      //-----------------------------------------
      //End: faculty/index.php
      //-----------------------------------------
  //***************************************************************************
  // End: Student Menu Section Css
  //***************************************************************************

  //***************************************************************************
  // Start: Book Menu Section Css
  //***************************************************************************
    //-----------------------------------------
    //Start: book/create.php
    //-----------------------------------------
    if(DIRECTORY == 'book' &&  (BASENAME == 'create' || BASENAME == "edit")){ ?>
      <!-- select2 -->
     <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/select2/css/select2.min.css'; ?>">
    <?php
    }
    //-----------------------------------------
    //End: book/create.php
    //-----------------------------------------
    //-----------------------------------------
    //Start: category/index.php
    //-----------------------------------------
    if(DIRECTORY == 'category' && (basename($_SERVER['REQUEST_URI'], '.php') == 'category' || basename($_SERVER['REQUEST_URI'], '.php') == 'index')){ ?>
      <!-- data table resposive design -->
      <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/datatables/css/datatables.min.css'; ?>">
    <?php
    }
    //-----------------------------------------
    //End: category/index.php
    //-----------------------------------------
  //***************************************************************************
  // End: Book Menu Section Css
  //***************************************************************************

  //***************************************************************************
  // Start: Borrow Menu Section Css
  //***************************************************************************
    //-----------------------------------------
    //Start: borrow/index.php
    //-----------------------------------------
    if(DIRECTORY == 'borrow' || BASENAME == "index" || DIRECTORY == 'renew'){ ?>
      <!-- icheck -->
     <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'; ?>">
      <!-- daterangepicker -->
     <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/daterangepicker/daterangepicker.css'; ?>">
     <!-- data table resposive design -->
     <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/datatables/css/datatables.min.css'; ?>">
     <!-- select2 -->
     <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/select2/css/select2.min.css'; ?>">


    <?php
    }
    //-----------------------------------------
    //End: borrow/index.php
    //-----------------------------------------
  //***************************************************************************
  // End: Borrow Menu Section Css
  //***************************************************************************

  //***************************************************************************
  // Start: Notification Menu Section Css
  //***************************************************************************
    //-----------------------------------------
    //Start: notification/index.php
    //-----------------------------------------
    if(DIRECTORY == 'notification' &&  (BASENAME == 'notification' || BASENAME == "index")){ ?>
      <!-- icheck bootstrap -->
      <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'; ?>">
    <?php
    }
    //-----------------------------------------
    //End: notification/index.php
    //-----------------------------------------
  //***************************************************************************
  // End: Notification Menu Section Css
  //***************************************************************************
?>


  <!--***********************************************************************-->
  <!-- Start Common Css -->
  <!--***********************************************************************-->
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'; ?>">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/fontawesome-free/css/all.min.css'; ?>">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Toastr -->
      <link rel="stylesheet" href="<?php echo ADMIN.'assets/plugins/toastr/toastr.min.css'; ?>">
      <!-- Theme style -->
      <link rel="stylesheet" href="<?php echo ADMIN.'assets/css/adminlte.min.css'; ?>">

      <link href="https://fonts.googleapis.com/css?family=Nunito:300,300i,400,600,700,800|Open+Sans:300,300i,400,600,700&display=swap" rel="stylesheet">
      <!-- Custome style -->
      <link rel="stylesheet" href="<?php echo ADMIN.'assets/css/custom.css'; ?>">
  <!--***********************************************************************-->
  <!-- End Common Css -->
  <!--***********************************************************************-->



</head>
