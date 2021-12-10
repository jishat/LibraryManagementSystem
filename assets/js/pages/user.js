"use strict";
$(document).ready(function(){
	let mainwebroot = window.location.origin+"/";
	let IMAGESBOOK = mainwebroot+"upload/book/";
	let IMG = mainwebroot+"assets/img/";
	//-------------------------------------------------------------------
	// start: commom js (register.php)
	//-------------------------------------------------------------------
	$(document).on("change", "select", function(){
		$(this).siblings(".errmsgTw").html("");
		$(this).attr("style", "");
	});
	$(document).on("keypress change", "input, textarea", function(){
		$(this).siblings(".errmsgTw").html("");
		$(this).attr("style", "");
	});
	function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#selectedavatar').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $(document).on("click", "#uploadimg", function(e){
    e.preventDefault();
    $(this).next().attr('data-img_delete', '0');
    $("#ImgInput").click();
      $("#ImgInput").change(function() {
        readURL(this);
      });
  });
	$(document).on("click", "#deleteimg", function(e){
    e.preventDefault();
    $(this).attr('data-img_delete', '1');
    $('#selectedavatar').attr('src', mainwebroot+'assets/img/avatar-man.png');
	});
	//-------------------------------------------------------------------
	// start: commom js (register.php)
	//-------------------------------------------------------------------

  //-------------------------------------------------------------------
	// start: Read Book Details (book.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".eachBook", function(e){
		e.preventDefault();
		let thisclass = $(this);
		thisclass.prop("disabled", false);
		let dataID 				= $(this).attr('data-book_id');
		let dataMethod 		= $(this).attr('data-method');
		let styleLoading 	= $(this).siblings(".eachBookOverlay");
		let eachData 			= $(this).closest('.eachData');
		let mainSubject		= eachData.find('.mailbox-subject');

		$.ajax({
			type: "POST",
			url: "show.php",
      data: {dataID:dataID, dataMethod:dataMethod},
      beforeSend: function(){
				styleLoading.css('display', 'flex');
			},
      success:function(finaldata){
        thisclass.prop("disabled", false);
        styleLoading.css('display', 'none');
				if (finaldata == 'error') {
					toastr.error('Something Went Wrong. Please Contact with developer')
				}else {
					var data = JSON.parse(finaldata);
					$('#bookModal').modal('show');
					if(typeof(data['book_name']) != "undefined") {
						var getPic = '';
						if(data['picture'] == ''){
							getPic = IMG+'dummybook.jpg';
						}else {
							getPic = IMAGESBOOK+data['picture'];
						}

						$('.BookImg').attr('src', getPic);

						if(data['total_stock'] == data['total_borrowed']){
							$('#isAvailable').html('<span class="badge badge-danger">Not Available</span>');
						}else {
							$('#isAvailable').html('<span class="badge badge-success">Available</span>');
						}

						$('#BookName').text(data['book_name']);
						$('#bookId').text(data['book_id']);
						$('#stock').text(data['total_stock']);
						$('#borrow').text(data['total_borrowed']);
						$('#writer').text(data['writer']);
						$('#category').html(data['allCategory']);
						$('#custom-tabs-three-description').html(data['description']);

						$('#borrowBtn').html(data['borrowBtn']);


					}else {
						$('#modalBody').text('404 Not Found');
					}

				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Read Book Details (book.php)
	//-------------------------------------------------------------------

  //-------------------------------------------------------------------
	// start: Borrow Book (book.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#borrowNow", function(e){
		e.preventDefault();

		swal({
		   title: "Are you sure?",
		   text: "to renew this book!",
		   icon: "warning",
		   buttons: true,
		   dangerMode: true,
		 })
		 .then((willDelete) => {
		   if (willDelete) {
				 let thisclass = $(this);
				 thisclass.prop("disabled", false);

				 let dataID 				= $(this).attr('data-book_id');
				 let borrowbook 		= $(this).attr('name');
				 let booking 			= $('#reservation').val();
				 // let mainSubject		= eachData.find('.mailbox-subject');

				 $.ajax({
					 type: "POST",
					 url: mainwebroot+"action/borrow.php",
					 data: {dataID:dataID, borrowbook:borrowbook, booking:booking},
					 beforeSend: function(){
						 thisclass.html('Borrow Now <span class="spinner-border spinner-border-sm ml-2"></span>');
					 },
					 success:function(finaldata){
						 thisclass.html('Borrow Now');
						 thisclass.prop("disabled", false);
						 switch(finaldata){
							 case 'success':
									swal("Borrow request sent successfully. Please collect the book from library ASAP!", {
										icon: "success",
									});
								 $('#borrowBtn').html('<button class="btn btn-sm bg-light-gray mb-5" disabled>Request Sent</button>');
								 break;
							 case 'empty':
								 swal("Date must require. Select the date!", {
									 icon: "error",
								 });
								 break;
							 case 'invaliddate':
									swal("Date must more than today!", {
										icon: "error",
									});
								 break;
							 case 'error':
								 swal("Something Went Wrong!", {
									 icon: "error",
								 });
								 break;
							 case 'unsuccess':
									swal("Something Went Wrong! Please Contact with developer", {
										icon: "error",
									});
								 break;
							 case 'unsuccess2':
								 swal("Something Went Wrong! Please Contact with developer", {
									 icon: "error",
								 });
								 break;
							 default:
								 swal("Something Went Wrong! Please Contact with developer", {
									 icon: "error",
								 });
						 }
					 }
				 });
				 return false;
		   }
		 });




	});
	//-------------------------------------------------------------------
	// End: Borrow Book (book.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Cancel Borrow request (borrow.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".borrowReject", function(e){
		e.preventDefault();
		swal({
			title: "Are you sure?",
			text: "to Cancel this request!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$(this).prop("disabled", true);

				let thisClass 		= $(this);
				let borrow_info 	= $(this).attr('data-borrow_info');
				let borrowReject 	= $(this).attr('name');
				let cameFrom 			= 'student';

				// console.log();
				$.ajax({
					type: "POST",
					url: mainwebroot+"action/cancel.php",
					data: {borrow_info:borrow_info, borrowReject:borrowReject, cameFrom:cameFrom},
					success:function(finaldata){
						console.log(finaldata);
						switch(finaldata){
							case 'success':
								jplist.resetContent(function(){
										$("#eachData"+borrow_info).remove();
								});
								swal("Successfully! Borrow request has been cancel.", {
									icon: "success",
								});
								break;
							case 'error':
								swal("Something went wrong!", {
									icon: "error",
								});
								break;
							default:
								swal("Something went wrong! Please contact with developer.", {
									icon: "error",
								});
						}
						$('.tooltip').remove();
						thisClass.prop("disabled", false);
					}
				});

				return false;
			}
		});
	});
	//-------------------------------------------------------------------
	// End: Cancel Borrow request (borrow.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Renew Button (borrow.php)
	//-------------------------------------------------------------------
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
	//-------------------------------------------------------------------
	// End: Renew Button (borrow.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Renew (borrow.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".borrowRenewSubmit", function(e){
		e.preventDefault();
		swal({
		  title: "Are you sure?",
		  text: "to renew this book!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
				$(this).prop("disabled", true);

				let thisClass 					= $(this);
				let borrow_info 				= $(this).attr('data-borrow_info');
				let action_id 					= $(this).attr('data-action_id');
				let borrowRenewSubmit 	= $(this).attr('name');
				let returnDate 					= $('#'+action_id).val();
				let comeFrom 						= 'student';

				// console.log();
				$.ajax({
					type: "POST",
					url: mainwebroot+"action/renew.php",
		      data: {borrow_info:borrow_info, borrowRenewSubmit:borrowRenewSubmit, returnDate:returnDate, comeFrom:comeFrom},
		      success:function(finaldata){
						console.log(finaldata);
		        switch(finaldata){
							case 'success':
								swal("Renew date requested successfully.", {
									icon: "success",
								});
								break;
							case 'unsuccess':
								swal("Something went wrong. Please contact with developer.", {
									icon: "error",
								});
								break;
							case 'invaliddate':
								swal("Please select a date which more than present return date.", {
									icon: "error",
								});
								break;
							case 'error':
								swal("Something went wrong!", {
									icon: "error",
								});
								break;
							default:
								swal("Something went wrong! Please contact with developer", {
									icon: "error",
								});
						}
						$('.tooltip').remove();
						thisClass.prop("disabled", false);
					}
				});
				return false;
		  }
		});
	});
	//-------------------------------------------------------------------
	// End: Renew (borrow.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Read Notification (notification/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".readNotification", function(e){
		e.preventDefault();
		let thisclass = $(this);
		thisclass.prop("disabled", false);
		let dataID 				= $(this).attr('data-notify_id');
		let dataMethod 		= $(this).attr('data-method');
		let isRead 				= $(this).attr('data-is_read');
		let styleLoading 	= $(this).siblings(".styleLoading");
		let eachData 			= $(this).closest('.eachData');
		let mainSubject		= eachData.find('.mailbox-subject');

		$.ajax({
			type: "POST",
			url: mainwebroot+"action/notification.php",
      data: {dataID:dataID, dataMethod:dataMethod, isRead:isRead},
      beforeSend: function(){
				styleLoading.html('<div class="spinner-border spinner-border-sm text-primary"></div>');
			},
      success:function(finaldata){
        console.log(finaldata);
        thisclass.prop("disabled", false);
        styleLoading.html("");
				if (finaldata == 'error') {
					swal("Something went wrong! Please contact with developer", {
						icon: "error",
					});
				}else {
					var data = JSON.parse(finaldata);
					$('#notificationModal').modal('show');
					$('#modalSubject').html(data['subject']);
					$('#modalComment').html(data['comment']);
					if(isRead == 0){
						eachData.addClass('bg-light');
						mainSubject.removeClass('text-bold');
						thisclass.removeClass('text-bold');
						thisclass.attr('data-is_read', 1);
					}
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Read Notification (notification/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Delete Notification (notification/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".notifyDeleteBtn", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		let thisclass 		= $(this);
		let styleLoading 	= $(this).siblings(".styleLoading");
		let notifyDeleteSubmit 	= $(this).attr("name");

		styleLoading.html("");

		let notidicationDelete = $("#notidicationDelete")[0];
		let notidicationFormData = new FormData(notidicationDelete);
		notidicationFormData.append("notifyDeleteSubmit", notifyDeleteSubmit);
		$.ajax({
			type: "POST",
			url: mainwebroot+"action/deletenotification.php",
			data: notidicationFormData,
			processData: false,
			contentType: false,
			cache: false,
			beforeSend: function(){
				styleLoading.html('<div class="spinner-border spinner-border-sm text-primary"></div>');
			},
			success:function(finaldata){

				thisclass.prop("disabled", false);
				styleLoading.html("");
				switch(finaldata){
					case 'success':
						for (let [key, value] of notidicationFormData.entries()) {
							// console.log(key, ':', value);

							jplist.resetContent(function(){
			            //remove element with id = el1
			            $(".eachData"+value).remove();
			        });
						}
						swal("Deleted Successfully", {
							icon: "success",
						});
						// thisclass.closest(".eachData").remove();
						break;
					case 'error':
						swal("Something Went Wrong!", {
							icon: "error",
						});
						break;
					default:
						swal("Something Went Wrong! Please Contact with developer", {
							icon: "error",
						});
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Delete Notification (notification/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Edit Student Account (profile.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#stuEditSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2, #errmsg3, #errmsg4, #errmsg5").html("");
		$("#errmsgParant").html("");
		let thisclass 		= $(this);
		let styleLoading 	= $(this).siblings(".styleLoading");
		let stuEditSubmit = $(this).attr("name");
		let showErrMsg 		= $(this).siblings(".showErrMsg");
		let dataImgDelete = $("#deleteimg").attr("data-img_delete");

		styleLoading.html("");

		let editStdnForm = $("#editStdnForm")[0];
		let editStdnFormData = new FormData(editStdnForm);
		editStdnFormData.append("stuEditSubmit", stuEditSubmit);
		editStdnFormData.append("dataImgDelete", dataImgDelete);
		$.ajax({
			type: "POST",
			url: mainwebroot+"action/update.php",
			data: editStdnFormData,
			processData: false,
			contentType: false,
			cache: false,
			beforeSend: function(){
				styleLoading.html('<div class="spinner-border spinner-border-sm text-primary"></div>');
			},
			success:function(finaldata){
				thisclass.prop("disabled", false);
				styleLoading.html("");
				function msgFocus(selectId, inputId){
					$('html, body').animate({
						scrollTop: selectId.offset().top-300
					}, 1500);
					inputId.focus().css({"border": "1px solid #e23e32", "box-shadow": "0rem 0.2rem 1rem rgb(255, 204, 200)"});
				}
				switch(finaldata){
					case 'success':
						swal("Successfully! Profile edited!", {
							icon: "success",
						});
						break;
					case 'succesmail':
						window.location.href = mainwebroot+"verify.php";
						break;
					case 'mobile':
						$("#errmsg4").html('<p>Invalid mobile number.</p>');
						msgFocus($("#errmsg4"), $("#mobile"));
						break;
					case 'emailempty':
						$("#errmsg2").html('<p>Email Must Require</p>');
						msgFocus($("#errmsg2"), $("#email"));
						break;
					case 'email':
						$("#errmsg2").html('<p>Invalid Email</p>');
						msgFocus($("#errmsg2"), $("#email"));
						break;
					case 'emailalready':
						$("#errmsg2").html('<p>Email already exists. Please try new one</p>');
						msgFocus($("#errmsg2"), $("#email"));
						break;
					case 'passwordempty':
						$("#errmsg3").html('<p>Password Must Require</p>');
						msgFocus($("#errmsg3"), $("#password"));
						break;
					case 'password':
						$("#errmsg3").html('<p>Password should be greater than 7 & less than 60 charecter</p>');
						msgFocus($("#errmsg3"), $("#password"));
						break;
					case 'address':
						$("#errmsg5").html('<p>Address should be less than 60 charecter</p>');
						msgFocus($("#errmsg5"), $("#address"));
						break;
					case 'studentimg':
						$("#errmsg1").html('<p>Only "JPEG" or "PNG" or "JPG" support</p>');
						msgFocus($("#errmsg1"), $("#studentPicture"));
						break;
					case 'error':
						swal("Something Went Wrong!", {
							icon: "error",
						});
						break;
					case 'unsuccess':
						swal("Something Went Wrong! Please contact with developer!", {
							icon: "error",
						});
						break;
					default:
						swal("Something Went Wrong. Please contact with developer!", {
							icon: "error",
						});
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Edit Student Account (profile.php)
	//-------------------------------------------------------------------
	//-------------------------------------------------------------------
	// Start: Logout Account
	//-------------------------------------------------------------------
	$(document).on("click", "#logout", function(e){
	  e.preventDefault();
	  $(this).prop("disabled", true);

	  var thisclass = $(this);
	  var stdnLogout = $(this).attr("data-name");

	  $.ajax({
	    type: "POST",
	    url: mainwebroot+"action/logout.php",
	    data: {stdnLogout:stdnLogout},
	    success:function(finaldata){
	      console.log(finaldata);
	      thisclass.prop("disabled", false);
	      switch(finaldata) {
	        case 'success':
	          window.location.href = mainwebroot;
	          break;
	        default:
	          toastr.warning('Something Went Wrong. Please Contact with developer')
	      }
	    }
	  });
	  return false;
	});
	//-------------------------------------------------------------------
	// Start: Logout Account
	//-------------------------------------------------------------------

});
