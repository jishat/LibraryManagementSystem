<!--***********************************************************************-->
<!-- Start Common JS -->
<!--***********************************************************************-->

<script src="<?php echo ADMIN.'assets/plugins/jquery/jquery.min.js'; ?>"></script>
<!-- Bootstrap -->
<script src="<?php echo ADMIN.'assets/plugins/bootstrap/js/bootstrap.bundle.min.js'; ?>"></script>

<script src="<?php echo ADMIN.'assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'; ?>"></script>
<!-- Toastr -->
<script src="<?php echo ADMIN.'assets/plugins/toastr/toastr.min.js'; ?>"></script>
<!-- sweetalert -->
<script src="<?php echo ADMIN.'assets/plugins/sweetalert/sweetalert.min.js'; ?>"></script>

<!-- Custome Js -->
<script src="<?php echo ADMIN.'assets/js/adminlte.min.js'; ?>"></script>
<script src="<?php echo ADMIN.'assets/js/custom.js'; ?>"></script>
<script type="text/javascript">
//   $(document).on('click', 'body', function(){
//     swal({
//   title: "Are you sure?",
//   text: "Once deleted, you will not be able to recover this imaginary file!",
//   icon: "warning",
//   buttons: true,
//   dangerMode: true,
// })
// .then((willDelete) => {
//   if (willDelete) {
//     swal("Poof! Your imaginary file has been deleted!", {
//       icon: "success",
//     });
//   } else {
//     swal("Your imaginary file is safe!");
//   }
// });
//
//   });

</script>

<!--***********************************************************************-->
<!-- End Common JS -->
<!--***********************************************************************-->

<?php
//***************************************************************************
// Start: Admin Login Script
//***************************************************************************

  if(DIRECTORY == ADMINFOLDER){ //if Login start ?>
    <script src="<?php echo ADMIN.'assets/js/pages/login.js'; ?>"></script>
  <?php
  } //if Login End

//***************************************************************************
// End: Admin Login Script
//***************************************************************************
?>
<?php
//***************************************************************************
// Start: Admin Logout Script
//***************************************************************************

  if(DIRECTORY != ADMINFOLDER){ //if Login start ?>
    <script src="<?php echo ADMIN.'assets/js/pages/logout.js'; ?>"></script>
  <?php
  } //if Login End

//***************************************************************************
// End: Admin Logout Script
//***************************************************************************

//***************************************************************************
// Start: User Menu Section Script
//***************************************************************************

    //--------------------------------------------------
    //Start: user/index.php
    //--------------------------------------------------
    if(DIRECTORY == 'user' && (BASENAME == 'user' || BASENAME == 'index')){ ?>
      <script src="<?php echo ADMIN.'assets/js/jplist.min.js'; ?>"></script>

      <script>
        jplist.init({
          deepLinking: true
        });
      </script>

      <?php
      if(isset($msg) && trim($msg) == 'success'){ ?>
        <script type="text/javascript">
          swal("Successfully! Account has been registered!", {
            icon: "success",
          });
        </script>
      <?php
      }
      if(isset($msg) && trim($msg) == 'userdelete'){ ?>
        <script type="text/javascript">
        swal("Successfully! Account has been deleted!", {
          icon: "success",
        });
        </script>
      <?php
      }
    }
    //--------------------------------------------------
    //End: user/index.php
    //--------------------------------------------------

    //--------------------------------------------------
    //Start: user-role menu/.....
    //--------------------------------------------------
    if (DIRECTORY == 'user-role') { //if user-role menu start ?>
      <!-- Select2 -->
      <script src="<?php echo ADMIN.'assets/plugins/select2/js/select2.full.min.js'; ?>"></script>
      <script type="text/javascript">
        $('#permissionPages').select2()
      </script>
    <?php
    }
    //--------------------------------------------------
    //End: user-role menu/.....
    //--------------------------------------------------

    //--------------------------------------------------
    //Start: user-role/index.php
    //--------------------------------------------------
    if(DIRECTORY == 'user-role' && ( BASENAME == 'user-role'
    || BASENAME == 'index')){  ?>
      <!-- DataTables -->
      <script type="text/javascript" src="<?php echo ADMIN.'assets/plugins/datatables/js/datatables.min.js'; ?>"></script>
      <script>
        $(function () {
          $('#userRoleTable').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "language": {
              "zeroRecords": " ",
            }
          });
        });
      </script>

      <script src="<?php echo ADMIN.'assets/js/jplist.min.js'; ?>"></script>

      <script>
        $(document).ready(function(){
          jplist.init({
            deepLinking: true
          });

          <?php
          if(isset($msg) && trim($msg) == 'successuserrole'){ ?>
            swal("Successfully! User Role has been registered!", {
              icon: "success",
            });
          <?php
          }

          if(isset($msg) && trim($msg) == 'deleteuserrole'){ ?>
            swal("Successfully! User Role has been deleted!", {
              icon: "success",
            });
          <?php
          }
          ?>

        }); //document ready End
      </script>
    <?php
    }
    //--------------------------------------------------
    //End: user-role/index.php
    //--------------------------------------------------

    //--------------------------------------------------
    //Start: user Menu/......
    //--------------------------------------------------
      if(DIRECTORY == 'user' || DIRECTORY == 'user-role'){ ?>
        <script src="<?php echo ADMIN.'assets/js/pages/user.js'; ?>"></script>
      <?php
      }
    //--------------------------------------------------
    //End: user Menu/.....
    //--------------------------------------------------

//***************************************************************************
// End: User Menu Section Script
//***************************************************************************


//***************************************************************************
// Start: Student Menu Section Script
//***************************************************************************


    //--------------------------------------------------
    //Start: student/index.php
    //--------------------------------------------------
    if (DIRECTORY == 'student' && ( BASENAME == 'student'
    || BASENAME == 'index')) { ?>
      <script src="<?php echo ADMIN.'assets/js/jplist.min.js'; ?>"></script>
      <script type="text/javascript">
        $(document).ready(function () {
          jplist.init({
            deepLinking: true
          });
        });
      </script>

      <?php
      if(isset($msg) && trim($msg) == 'success'){ ?>
        <script>
          swal("Successfully! Account has been registered!", {
            icon: "success",
          });
        </script>
      <?php
      }
      ?>

      <?php
      if(isset($msg) && trim($msg) == 'deletesuccess'){ ?>

        <script>
          swal("Successfully! Account has been deleted!", {
            icon: "success",
          });
        </script>
      <?php
      }
      ?>
    <?php
    }
    //--------------------------------------------------
    //End: student/index.php
    //--------------------------------------------------

    //--------------------------------------------------
    //Start: faculty/index.php
    //--------------------------------------------------
    if(DIRECTORY == 'faculty' && ( BASENAME == 'faculty'
    || BASENAME == 'index')){  ?>
      <!-- DataTables -->
      <script type="text/javascript" src="<?php echo ADMIN.'assets/plugins/datatables/js/datatables.min.js'; ?>"></script>
      <script>
        $(function () {
          $('#facultyTable').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "language": {
              "zeroRecords": " ",
            }
          });
        });
      </script>

      <script src="<?php echo ADMIN.'assets/js/jplist.min.js'; ?>"></script>

      <script>
        $(document).ready(function(){
          jplist.init({
            deepLinking: true
          });
        });
      </script>

      <?php
      if(isset($msg) && trim($msg) == 'deletefaculty'){ ?>
        <script>
          swal("Successfully! Faculty has been deleted!", {
            icon: "success",
          });
        </script>
      <?php
      }
      if(isset($msg) && trim($msg) == 'successfaculty'){ ?>
        <script>
          swal("Successfully! Faculty has been registered!", {
            icon: "success",
          });
        </script>
      <?php
      }
      ?>
    <?php
    }
    //--------------------------------------------------
    //End: faculty/index.php
    //--------------------------------------------------

    //--------------------------------------------------
    //Start: student menu/.....
    //--------------------------------------------------
    if (DIRECTORY == 'student' || DIRECTORY == 'faculty') { //if only student page start ?>
        <script src="<?php echo ADMIN.'assets/js/pages/student.js'; ?>"></script>
    <?php
    }
    //--------------------------------------------------
    //End: student menu/.....
    //--------------------------------------------------

//***************************************************************************
// End: Student Menu Section Script
//***************************************************************************

//***************************************************************************
// Start: Book Menu Section Script
//***************************************************************************

  //--------------------------------------------------
  //Start: book/index.php
  //--------------------------------------------------
  if(DIRECTORY == 'book' && ( BASENAME == 'book'
  || BASENAME == 'index')){  ?>
    <script src="<?php echo ADMIN.'assets/js/jplist.min.js'; ?>"></script>

    <script>
      $(document).ready(function(){
        jplist.init({
          deepLinking: true
        });
        <?php
        if( isset($msg) && trim($msg) == 'successbook' ){ ?>
          swal("Successfully! Book has been registered!", {
            icon: "success",
          });
        <?php
        }
        ?>

        <?php
        if( isset($msg) && trim($msg) == 'bookdelete' ){ ?>
          swal("Successfully! Book has been deleted!", {
            icon: "success",
          });
        <?php
        }
        ?>
      });
    </script>
  <?php
  }
  //--------------------------------------------------
  //End: book/index.php
  //--------------------------------------------------

  //--------------------------------------------------
  //Start: book/create.php
  //--------------------------------------------------
  if(DIRECTORY == 'book' && (BASENAME == 'create' || BASENAME == 'edit')){  ?>
    <!-- Editor -->
    <script src="<?php echo ADMIN.'assets/js/ckeditor.js'; ?>"></script>
    <!-- Select2 -->
    <script src="<?php echo ADMIN.'assets/plugins/select2/js/select2.full.min.js'; ?>"></script>
    <script type="text/javascript">
      $('#category').select2()
    </script>
    <script type="text/javascript">
      ClassicEditor
        .create( document.querySelector( '#description' ), {
          toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'indent', 'outdent', '|', 'blockQuote', 'insertTable', '|', 'undo', 'redo']
        } )
        .then( editor => {
          window.editor = editor;
          // console.log( Array.from( editor.ui.componentFactory.names() ) );
        } )
        .catch( err => {
          console.error( err.stack );
        } );


    </script>

  <?php
  }
  //--------------------------------------------------
  //End: book/create.php
  //--------------------------------------------------



  //--------------------------------------------------
  //Start: category/index.php
  //--------------------------------------------------
  if(DIRECTORY == 'category' && ( BASENAME == 'category'
  || BASENAME == 'index')){  ?>
    <!-- DataTables -->
    <script type="text/javascript" src="<?php echo ADMIN.'assets/plugins/datatables/js/datatables.min.js'; ?>"></script>
    <script>
      $(function () {
        $('#categoryTable').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "responsive": true,
          "language": {
            "zeroRecords": " ",
          }
        });
      });
    </script>
    <script src="<?php echo ADMIN.'assets/js/jplist.min.js'; ?>"></script>

    <script>
      $(document).ready(function(){
        jplist.init({
          deepLinking: true
        });
        <?php
        if( isset($msg) && trim($msg) == 'successfully' ){ ?>
          swal("Successfully! Category has been registered!", {
            icon: "success",
          });
        <?php
        }
        if( isset($msg) && trim($msg) == 'categorydelete' ){ ?>
          swal("Successfully! Category has been deleted!", {
            icon: "success",
          });
        <?php
        }
        ?>
      });
    </script>
  <?php
  }
  //--------------------------------------------------
  //End: category/index.php
  //--------------------------------------------------

  //--------------------------------------------------
  //Start: book menu/.....
  //--------------------------------------------------
  if (DIRECTORY == 'book' || DIRECTORY == 'category') { //if only student page start ?>
      <script src="<?php echo ADMIN.'assets/js/pages/book.js'; ?>"></script>
  <?php
  }
  //--------------------------------------------------
  //End: book menu/.....
  //--------------------------------------------------
//***************************************************************************
// End: Book Menu Section Script
//***************************************************************************
?>

<?php
//***************************************************************************
// Start: Borrow Menu Section Script
//***************************************************************************

  //--------------------------------------------------
  //Start: borrow/index.php
  //--------------------------------------------------
  if( (DIRECTORY == 'borrow' && ( BASENAME == 'borrow'
  || BASENAME == 'index')) || DIRECTORY == 'renew' && ( BASENAME == 'renew'
  || BASENAME == 'index')    ){  ?>
    <script type="text/javascript" src="<?php echo ADMIN.'assets/plugins/datatables/js/datatables.min.js'; ?>"></script>
    <script>
      $(function () {
        $('#borrowTable').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "responsive": true,
          "language": {
            "zeroRecords": " ",
          }
        });
      });
    </script>

    <script src="<?php echo ADMIN.'assets/js/jplist.min.js'; ?>"></script>

    <script>
      $(document).ready(function(){
        jplist.init({
          deepLinking: true
        });

      });
    </script>
  <?php
  }
  //--------------------------------------------------
  //End: borrow/index.php
  //--------------------------------------------------

  //--------------------------------------------------
  //Start: borrow menu/.....
  //--------------------------------------------------
  if (DIRECTORY == 'borrow' || DIRECTORY == 'renew') { //if only borrow page start ?>


    <script src="<?php echo ADMIN.'assets/plugins/moment/moment.min.js'; ?>"></script>
    <script src="<?php echo ADMIN.'assets/plugins/daterangepicker/daterangepicker.js'; ?>"></script>
    <!-- Select2 -->
    <script src="<?php echo ADMIN.'assets/plugins/select2/js/select2.full.min.js'; ?>"></script>

      <script type="text/javascript">
  			$(document).ready(function(){

          $(document).on("click", ".renewBtn", function(e){
            let dropdownMenu =  $(this).siblings('.dropdown-menu-tj');
            dropdownMenu.fadeToggle("slow");

            var get_input = $(this).attr('data-get_input');
            var return_date = $('#'+get_input).attr('data-return_date');
            var nowDate = new Date(return_date);


            $('.'+get_input).daterangepicker({
    					singleDatePicker: true,
    					"minDate": nowDate,
    					"locale": {
    				    format: 'DD MMM YYYY',
    				  }
    		    })
          });

          var nowTime = new Date();
  				var today = new Date(nowTime.getFullYear(), nowTime.getMonth(), nowTime.getDate(), 0, 0, 0, 0);
  				//Date range picker
  		    //Date range picker with time picker
  		    $('#reservation').daterangepicker({
  					singleDatePicker: true,
  					"minDate": today,
  					"locale": {
  				    format: 'DD MMM YYYY',
  				  }
  		    })

          //Enable check and uncheck all functionality
          $(document).on('click','.checkbox-toggle',function(){
            var clicks = $(this).data('clicks')
            if (clicks) {
              //Uncheck all checkboxes
              $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
              $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
            } else {
              //Check all checkboxes
              $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
              $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
            }
            $(this).data('clicks', !clicks)
          })

          <?php
          if(isset($msg) && trim($msg) == 'successreturn'){ //$msg  var declared in navigation section in element folder  ?>
            swal("Successfully! Book has been returned.", {
              icon: "success",
            });
          <?php
          }
          ?>

          <?php
          if(isset($msg) && trim($msg) == 'successreject'){ //$msg  var declared in navigation section in element folder  ?>
            swal("Successfully! Borrow request has been rejected.", {
              icon: "success",
            });
          <?php
          }
          ?>

          <?php
          if(isset($msg) && trim($msg) == 'successRenewReject'){ //$msg  var declared in navigation section in element folder  ?>
            swal("Successfully! Renew request has been rejected.", {
              icon: "success",
            });
          <?php
          }
          ?>

          <?php
          if(isset($msg) && trim($msg) == 'successRenewDelete'){ //$msg  var declared in navigation section in element folder  ?>
            swal("Successfully! Item has been deleted.", {
              icon: "success",
            });
          <?php
          }
          if(isset($msg) && trim($msg) == 'successborrow'){ //$msg  var declared in navigation section in element folder  ?>
            swal("Borrow request sent successfully. Please check in the manage borrow for accept", {
              icon: "success",
            });
          <?php
          }
          ?>

        });


  		</script>
      <script src="<?php echo ADMIN.'assets/js/pages/borrow.js'; ?>"></script>

  <?php
  }
  //--------------------------------------------------
  //End: borrow menu/.....
  //--------------------------------------------------

//***************************************************************************
// End: Borrow Menu Section Script
//***************************************************************************


?>

<?php
//-------------------------------------------------------------------------
// Start: Dashboard Section Script
//--------------------------------------------------------------------------
if(DIRECTORY == 'dashboard'){ //if dashboard start ?>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="<?php echo ADMIN.'assets/plugins/jquery-mousewheel/jquery.mousewheel.js'; ?>"></script>
  <script src="<?php echo ADMIN.'assets/plugins/raphael/raphael.min.js'; ?>"></script>
  <script src="<?php echo ADMIN.'assets/plugins/jquery-mapael/jquery.mapael.min.js'; ?>"></script>
  <script src="<?php echo ADMIN.'assets/plugins/jquery-mapael/maps/usa_states.min.js'; ?>"></script>
  <!-- ChartJS -->
  <script src="<?php echo ADMIN.'assets/plugins/chart.js/Chart.min.js'; ?>"></script>

  <!-- PAGE SCRIPTS -->
  <script src="<?php echo ADMIN.'assets/js/pages/dashboard.js'; ?>"></script>
<?php
} //if dashboard End
//-------------------------------------------------------------------------
// End: Dashboard Section Script
//--------------------------------------------------------------------------

//-------------------------------------------------------------------------
// Start: Notification Section Script
//--------------------------------------------------------------------------
if(DIRECTORY == 'notification'){ //if Notification start ?>
  <script src="<?php echo ADMIN.'assets/js/polyfill.min.js'; ?>"></script>
  <script src="<?php echo ADMIN.'assets/js/jplist.min.js'; ?>"></script>

  <script>
    $(document).ready(function(){
      jplist.init({
        deepLinking: true
      });
    });
  </script>

  <!-- Page Script -->
<script>
  $(function () {
    //Enable check and uncheck all functionality
    $('.checkbox-toggle').click(function () {
      var clicks = $(this).data('clicks')
      if (clicks) {
        //Uncheck all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
        $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
      } else {
        //Check all checkboxes
        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
        $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
      }
      $(this).data('clicks', !clicks)
    })
  })
</script>

  <!-- PAGE SCRIPTS -->
  <script src="<?php echo ADMIN.'assets/js/pages/notification.js'; ?>"></script>
<?php
} //if Notification End
//-------------------------------------------------------------------------
// End: Notification Section Script
//--------------------------------------------------------------------------

//-------------------------------------------------------------------------
// Start: Profile Section Script
//--------------------------------------------------------------------------
if(DIRECTORY == 'profile'){ //if Notification start ?>
  <!-- PAGE SCRIPTS -->
  <script src="<?php echo ADMIN.'assets/js/pages/profile.js'; ?>"></script>
<?php
} //if Notification End
//-------------------------------------------------------------------------
// End: Profile Section Script
//--------------------------------------------------------------------------
?>

</body>
</html>
