

<!--***********************************************************************-->
<!-- Start Common JS -->
<!--***********************************************************************-->

<script src="<?php echo ASSETS.'plugins/jquery/jquery.min.js'; ?>"></script>
<script src="<?php echo ASSETS.'js/modernizr-3.11.2.min.js'; ?>"></script>

<!-- Bootstrap -->
<script src="<?php echo ASSETS.'plugins/bootstrap/js/bootstrap.bundle.min.js'; ?>"></script>
<!-- Place any jQuery/helper plugins in here. -->
<script src="<?php echo ASSETS.'js/plugins.js'; ?>"></script>
<!-- Toastr -->
<script src="<?php echo ASSETS.'plugins/toastr/toastr.min.js'; ?>"></script>
<!-- sweetalert -->
<script src="<?php echo ASSETS.'plugins/sweetalert/sweetalert.min.js'; ?>"></script>
<!-- Page loader -->
<!-- <script src="<?php echo ASSETS.'plugins/pageloader/jajaxloader.js'; ?>"></script> -->
<!-- Custome Js -->
<script src="<?php echo ASSETS.'js/adminlte.min.js';?>"></script>


<script type="text/javascript">
	$(window).on('load', function(){
		$('.overlay').fadeOut('slow');
	});

	$(window).on('scroll', function(){
		if($(window).scrollTop()){
			$('.top-menu').addClass('bg-light');
			$('.top-menu').addClass('navbar-light');
			$('.top-menu').addClass('shadow');
			$('.top-menu').addClass('scrollMenu');
			$('.top-menu').removeClass('darkMenu');
		}else{
			$('.top-menu').removeClass('bg-light');
			$('.top-menu').removeClass('navbar-light');
			$('.top-menu').removeClass('shadow');
			$('.top-menu').removeClass('scrollMenu');
			$('.top-menu').addClass('darkMenu');
		}
	});
</script>

<!--***********************************************************************-->
<!-- End Common JS -->
<!--***********************************************************************-->

<?php
//***************************************************************************
// Start: Student Register/login/verify Script
//***************************************************************************

  if(BASENAME == 'register' || BASENAME == ''){ //if Register start ?>
    <script src="<?php echo ASSETS.'js/pages/signin.js'; ?>"></script>
  <?php
  } //if Register End
  if(BASENAME == 'verify'){ //if verify start ?>
    <script src="<?php echo ASSETS.'js/pages/verify.js'; ?>"></script>
  <?php
  } //if verify End
//***************************************************************************
// End: Student Register/login/verify Script
//***************************************************************************

//***************************************************************************
// Start: Student Script
//***************************************************************************

  if(BASENAME == 'book' || BASENAME == 'borrow' || BASENAME == 'notification'){ //if book/borrow/notification start ?>

    <script src="<?php echo ASSETS.'plugins/moment/moment.min.js'; ?>"></script>
    <script src="<?php echo ASSETS.'plugins/daterangepicker/daterangepicker.js'; ?>"></script>
    <script src="<?php echo ASSETS.'js/polyfill.min.js'; ?>"></script>
		<!-- DataTables -->
		<script type="text/javascript" src="<?php echo ASSETS.'plugins/datatables/js/datatables.min.js'; ?>"></script>
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
    <script src="<?php echo ASSETS.'js/jplist.min.js'; ?>"></script>


		<script type="text/javascript">
			$(document).ready(function(){
				var nowDate = new Date();
				var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
				//Date range picker
		    //Date range picker with time picker
		    $('#reservation').daterangepicker({
					singleDatePicker: true,
					"minDate": today,
					"locale": {
				    format: 'DD MMM YYYY',
				  }
		    })
        jplist.init({
	        deepLinking: true
	      });

  			$('[data-toggle="tooltip"]').tooltip();

			    //Enable check and uncheck all functionality
		    $(document).on('click', '.checkbox-toggle',function (e) {
					e.preventDefault();
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
					return false;
		    })

      });
		</script>
		<script src="<?php echo ASSETS.'js/pages/user.js'; ?>"></script>
  <?php
} //if book End
if (BASENAME == 'profile') { ?>
	<script src="<?php echo ASSETS.'js/pages/user.js'; ?>"></script>
<?php
}
//***************************************************************************
// End: Student Script
//***************************************************************************
?>

</body>

</html>
