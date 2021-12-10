"use strict";
$(document).ready(function(){
	var mainwebroot = window.location.origin+"/tjadmin/";
	var currentUrl 	= window.location.href;
	var getPath  = window.location.pathname.split( '/' );
	var getBasename = getPath.reverse();
	// console.log(getBasename[0]);
	//-------------------------------------------------------------------
	// start: Common Js (student section)
	//-------------------------------------------------------------------
	$(document).on("change", "select", function(){
		$(this).siblings(".errmsgTw").html("");
		$(this).attr("style", "");
	});
	$(document).on("keypress change", "input, textarea", function(){
		$(this).siblings(".errmsgTw").html("");
		$(this).attr("style", "");
	});
	$(document).on("click", "#deleteimg", function(e){
    e.preventDefault();
    $(this).attr('data-img_delete', '1');
    $('#selectedavatar').attr('src', mainwebroot+'assets/img/avatar-man.png');

  });
	//-------------------------------------------------------------------
	// End: Common Js (student section)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Create Student Account (student/create.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#stuRegSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2, #errmsg3, #errmsg4, #errmsg5, #errmsg6, #errmsg7, #errmsg8, #errmsg9, #errmsg10").html("");
		$("#errmsgParant").html("");
		let thisclass 		= $(this);
		let styleLoading 	= $(this).siblings(".styleLoading");
		let stuRegSubmit 	= $(this).attr("name");
		let showErrMsg 		= $(this).siblings(".showErrMsg");
		let cameFrom 			= "admin";

		styleLoading.html("");

		let admnStdnForm = $("#admnStdnForm")[0];
		let admnStdnFormData = new FormData(admnStdnForm);
		admnStdnFormData.append("stuRegSubmit", stuRegSubmit);
		admnStdnFormData.append("cameFrom", cameFrom);
		$.ajax({
			type: "POST",
			url: "store.php",
      data: admnStdnFormData,
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function(){
				styleLoading.html('<div class="spinner-border spinner-border-sm text-primary"></div>');
			},
      success:function(finaldata){
        console.log(finaldata);
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
						window.location.href = mainwebroot+"view/student/";
						break;
					case 'nameempty':
						$("#errmsg1").html('<p>Name Must Require</p>');
						msgFocus($("#errmsg1"), $("#studentName"));
						break;
					case 'studentname':
						$("#errmsg1").html('<p>Name should be Alphabet</p>')
						msgFocus($("#errmsg1"), $("#studentName"));
						break;
					case 'idempty':
						$("#errmsg2").html('<p>ID Must Require</p>');
						msgFocus($("#errmsg2"), $("#studentId"));
						break;
					case 'invalidid':
						$("#errmsg2").html('<p>Invalid ID! ID should be less than 20 char.</p>');
						msgFocus($("#errmsg2"), $("#studentId"));
						break;
					case 'facultyempty':
						$("#errmsg3").html('<p>Faculty Must Require</p>');
						msgFocus($("#errmsg3"), $("#faculty"));
						break;
					case 'faculty':
						$("#errmsg3").html('<p>Invalid Faculty</p>');
						msgFocus($("#errmsg3"), $("#faculty"));
						break;
					case 'batchempty':
						$("#errmsg4").html('<p>Batch Must Require</p>');
						msgFocus($("#errmsg4"), $("#studentbatch"));
						break;
					case 'invalibatch':
						$("#errmsg4").html('<p>Invalid Batch! Batch no should be less than 20 char.</p>');
						msgFocus($("#errmsg4"), $("#studentbatch"));
						break;
					case 'genderempty':
						$("#errmsg5").html('<p>Gender must require.</p>');
						msgFocus($("#errmsg5"), $("#gender"));
						break;
					case 'gender':
						$("#errmsg5").html('<p>Invalid Gender</p>');
						msgFocus($("#errmsg5"), $("#gender"));
						break;
					case 'mobile':
						$("#errmsg6").html('<p>Invalid mobile number.</p>');
						msgFocus($("#errmsg6"), $("#mobile"));
						break;
					case 'emailempty':
						$("#errmsg7").html('<p>Email Must Require</p>');
						msgFocus($("#errmsg7"), $("#email"));
						break;
					case 'email':
						$("#errmsg7").html('<p>Invalid Email</p>');
						msgFocus($("#errmsg7"), $("#email"));
						break;
					case 'emailalready':
						$("#errmsg7").html('<p>Email already exists. Please try new one</p>');
						msgFocus($("#errmsg7"), $("#email"));
						break;
					case 'passwordempty':
						$("#errmsg8").html('<p>Password Must Require</p>');
						msgFocus($("#errmsg8"), $("#password"));
						break;
					case 'password':
						$("#errmsg8").html('<p>Password should be greater than 7 & less than 60 charecter</p>');
						msgFocus($("#errmsg8"), $("#password"));
						break;
					case 'address':
						$("#errmsg9").html('<p>Address should be less than 60 charecter</p>');
						msgFocus($("#errmsg9"), $("#address"));
						break;
					case 'studentimg':
						$("#errmsg10").html('<p>Only "JPEG" or "PNG" or "JPG" support</p>');
						msgFocus($("#errmsg10"), $("#studentPicture"));
						break;
					case 'error':
						swal("Something Went Wrong!", {
							icon: "error",
						});
						break;
					default:
						swal("Something Went Wrong! Please contact with developer", {
							icon: "error",
						});
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Create Student Account (student/create.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Edit Student Account (student/edit.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#stuEditSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2, #errmsg3, #errmsg4, #errmsg5, #errmsg6, #errmsg7, #errmsg8, #errmsg9, #errmsg10").html("");
		$("#errmsgParant").html("");
		let thisclass 		= $(this);
		let styleLoading 	= $(this).siblings(".styleLoading");
		let stuEditSubmit = $(this).attr("name");
		let showErrMsg 		= $(this).siblings(".showErrMsg");
		let stdInfoid 		= $(this).attr("data-infoid_std");
		let dataImgDelete = $("#deleteimg").attr("data-img_delete");

		styleLoading.html("");

		let editStdnForm = $("#editStdnForm")[0];
		let editStdnFormData = new FormData(editStdnForm);
		editStdnFormData.append("stuEditSubmit", stuEditSubmit);
		editStdnFormData.append("stdInfoid", stdInfoid);
		editStdnFormData.append("dataImgDelete", dataImgDelete);
		$.ajax({
			type: "POST",
			url: "update.php",
			data: editStdnFormData,
			processData: false,
			contentType: false,
			cache: false,
			beforeSend: function(){
				styleLoading.html('<div class="spinner-border spinner-border-sm text-primary"></div>');
			},
			success:function(finaldata){
				console.log(finaldata);
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
					case 'nameempty':
						$("#errmsg1").html('<p>Name Must Require</p>');
						msgFocus($("#errmsg1"), $("#studentName"));
						break;
					case 'studentname':
						$("#errmsg1").html('<p>Name should be Alphabet</p>')
						msgFocus($("#errmsg1"), $("#studentName"));
						break;
					case 'idempty':
						$("#errmsg2").html('<p>ID Must Require</p>');
						msgFocus($("#errmsg2"), $("#studentId"));
						break;
					case 'invalidid':
						$("#errmsg2").html('<p>Invalid ID! ID should be less than 20 char.</p>');
						msgFocus($("#errmsg2"), $("#studentId"));
						break;
					case 'facultyempty':
						$("#errmsg3").html('<p>Faculty Must Require</p>');
						msgFocus($("#errmsg3"), $("#faculty"));
						break;
					case 'faculty':
						$("#errmsg3").html('<p>Invalid Faculty</p>');
						msgFocus($("#errmsg3"), $("#faculty"));
						break;
					case 'batchempty':
						$("#errmsg4").html('<p>Batch Must Require</p>');
						msgFocus($("#errmsg4"), $("#batch"));
						break;
					case 'invalibatch':
						$("#errmsg4").html('<p>Invalid Batch! Batch no should be less than 20 char.</p>');
						msgFocus($("#errmsg4"), $("#batch"));
						break;
					case 'genderempty':
						$("#errmsg5").html('<p>Gender must require.</p>');
						msgFocus($("#errmsg5"), $("#gender"));
						break;
					case 'gender':
						$("#errmsg5").html('<p>Invalid Gender</p>');
						msgFocus($("#errmsg5"), $("#gender"));
						break;
					case 'mobile':
						$("#errmsg6").html('<p>Invalid mobile number.</p>');
						msgFocus($("#errmsg6"), $("#mobile"));
						break;
					case 'emailempty':
						$("#errmsg7").html('<p>Email Must Require</p>');
						msgFocus($("#errmsg7"), $("#email"));
						break;
					case 'email':
						$("#errmsg7").html('<p>Invalid Email</p>');
						msgFocus($("#errmsg7"), $("#email"));
						break;
					case 'emailalready':
						$("#errmsg7").html('<p>Email already exists. Please try new one</p>');
						msgFocus($("#errmsg7"), $("#email"));
						break;
					case 'passwordempty':
						$("#errmsg8").html('<p>Password Must Require</p>');
						msgFocus($("#errmsg8"), $("#password"));
						break;
					case 'password':
						$("#errmsg8").html('<p>Password should be greater than 7 & less than 60 charecter</p>');
						msgFocus($("#errmsg8"), $("#password"));
						break;
					case 'address':
						$("#errmsg9").html('<p>Address should be less than 60 charecter</p>');
						msgFocus($("#errmsg9"), $("#address"));
						break;
					case 'studentimg':
						$("#errmsg10").html('<p>Only "JPEG" or "PNG" or "JPG" support</p>');
						msgFocus($("#errmsg10"), $("#studentPicture"));
						break;
					case 'error':
						swal("Something Went Wrong!", {
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
	// End: Edit Student Account (student/edit.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start:  Status Change Student Account (student/index.php)
	//-------------------------------------------------------------------
	$(document).on("change", ".studentStatus", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);

		let thisclass = $(this);
		let status = $(this).attr("data-status");
		let id = $(this).attr("data-id");
		let changesubmit = 'stdstatussubmit';

		$.ajax({
			type: "POST",
			url: "status.php",
			data: {status:status, id:id, changesubmit:changesubmit},
			success:function(finaldata){
				console.log(finaldata);
				thisclass.prop("disabled", false);
				switch(finaldata) {
					case 'success':
						if(status == 1){
							thisclass.attr("data-status", "0");
							thisclass.next().html('Deactive');
							swal("Successfully! Account has been deactivated!", {
								icon: "success",
							});
						}else {
							thisclass.attr("data-status", "1");
							thisclass.next().html('Active');
							swal("Successfully! Account has been activated!", {
								icon: "success",
							});
						}
						break;
					case 'error':
						swal("Something Went Wrong!", {
							icon: "error",
						});
						break;
					case 'unsuccessfully':
						swal("Something Went Wrong. Please Contact with developer", {
							icon: "error",
						});
						break;
					default:
						swal("Something Went Wrong. Please Contact with developer", {
							icon: "error",
						});
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Status Change Student Account (student/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Delete Student Account (student/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".stdDelete", function(e){
		e.preventDefault();


		swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this account!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {

				$(this).prop("disabled", true);

				let thisclass = $(this);
				let stdinfo = $(this).attr("data-std_info");
				let stdDeleteSubmit = $(this).attr("name");

				if(getBasename[0] == 'show.php'){
					var cameFrom = "show";
				}else {
					var cameFrom = "index";
				}

				$.ajax({
					type: "POST",
					url: "delete.php",
					data: {stdinfo:stdinfo, stdDeleteSubmit:stdDeleteSubmit, cameFrom:cameFrom},
					success:function(finaldata){
						thisclass.prop("disabled", false);
						switch(finaldata) {
							case 'success':
								if(getBasename[0] == 'show.php'){
									window.location.href = mainwebroot+"view/student/";
								}else {
									jplist.resetContent(function(){
										thisclass.closest(".eachStdData").remove();
									});
									swal("Successfully! Account has been deleted!", {
										icon: "success",
									});
								}
								break;
							case 'error':
								swal("Something Went Wrong!", {
									icon: "error",
								});
								break;
							case 'unsuccess':
								swal("Something Went Wrong. Please Contact with developer!", {
									icon: "error",
								});
								break;
							default:
								swal("Something Went Wrong. Please Contact with developer!", {
									icon: "error",
								});
						}
						$('.tooltip').remove();
					}
				});
				return false;
		  }
		});




	});
	//-------------------------------------------------------------------
	// End: Delete Student Account (student/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Reject Student Account (student/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".stdRejectBtn", function(e){
		e.preventDefault();
		if(window.confirm("Are your sure to Reject?")){
			$(this).prop("disabled", true);

			let thisclass = $(this);
			let stdinfo = $(this).attr("data-std_info");
			let stdRejectSubmit = $(this).attr("name");

			$.ajax({
				type: "POST",
				url: "reject.php",
				data: {stdinfo:stdinfo, stdRejectSubmit:stdRejectSubmit},
				success:function(finaldata){
					console.log(finaldata);
					thisclass.prop("disabled", false);
					switch(finaldata) {
						case 'success':
							if(getBasename[0] == 'show.php'){
								window.location.href = mainwebroot+"view/student/";
							}else {
								jplist.resetContent(function(){
										thisclass.closest(".eachStdData").remove();
								});
								swal("Successfully! Account has been rejected", {
									icon: "success",
								});
							}
							break;
						case 'error':
							swal("Something Went Wrong", {
								icon: "error",
							});
							break;
						case 'unsuccess':
							swal("Account Delete Successfully. But mail is not sent. Please Contact with developer", {
								icon: "warning",
							});
							break;
						default:
							swal("Something Went Wrong! Please Contact with developer", {
								icon: "error",
							});
					}
					$('.tooltip').remove();
				}
			});
			return false;
		}else{
			return false;
		}
	});
	//-------------------------------------------------------------------
	// End: Reject Student Account (student/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start:  Approve Student Account (student/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".approveBtn", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);

		let thisclass 				= $(this);
		let approveBtn 				= $(this).attr("name");
		let id 								= $(this).attr("data-std_info");
		if(getBasename[0] != 'show.php'){ //if start
			var cardActionParent 	= $(this).closest('.eachStdData');
			var cardActionChild		= cardActionParent.find('.eachStdDataChild');
			var card_count				= cardActionChild.attr('data-card_count'); //get the counter number of this card
		} //end if

		$.ajax({
			type: "POST",
			url: "approve.php",
			data: {approveBtn:approveBtn, id:id},
			success:function(finaldata){
				console.log(finaldata);
				switch(finaldata) {
					case 'success':
						if(getBasename[0] == 'show.php'){
							// location.reload(true);
							$('#userCardParent').load(location.href + " #userCardChild");
						}else {
							cardActionParent.load(location.href + " #eachStdDataChild"+card_count);
						}
						swal("Successfully! Account has been approved", {
							icon: "success",
						});

						break;
					case 'error':
						swal("Something Went Wrong!", {
							icon: "error",
						});
						break;
					case 'unsuccess':
						swal("Account Approve Successfully. But mail not sent. Please Contact with developer!", {
							icon: "warning",
						});
						break;
					default:
						swal("Something Went Wrong! Please refresh and try again", {
							icon: "error",
						});
				}
				$('.tooltip').remove();
				thisclass.prop("disabled", false);
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Approve Student Account (student/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// Start: Register Faculty (faculty/create.php)
	//-------------------------------------------------------------------

	$(document).on("click", "#facultyRegSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2").html("");
		$("#errmsgParant").html("");

		let styleLoading = $(this).siblings(".styleLoading");
		let thisclass = $(this);
		let facultyRegSubmit = $(this).attr("name");

		styleLoading.html("");

		let regFacultyForm = $("#regFacultyForm")[0];
		let regFacultyFormData = new FormData(regFacultyForm);
		regFacultyFormData.append("facultyRegSubmit", facultyRegSubmit);

		$.ajax({
			type: "POST",
			url: "store.php",
			data: regFacultyFormData,
			cache       : false,
			contentType : false,
			processData : false,
			beforeSend: function() {
				styleLoading.html('<div class="spinner-border spinner-border-sm text-primary"></div>');
			},
			success:function(finaldata){
				thisclass.prop("disabled", false);
				console.log(finaldata);
				styleLoading.html("");
				function msgFocus(selectId, inputId){
					$('html, body').animate({
						scrollTop: selectId.offset().top-300
					}, 1500);
					inputId.focus().css({"border": "1px solid #e23e32", "box-shadow": "0rem 0.2rem 1rem rgb(255, 204, 200)"});
				}
				switch(finaldata) {
					case 'success':
						window.location.href = mainwebroot+"view/faculty";
						break;
					case 'emptyfaculty':
						$("#errmsg1").html('<p>Name must require</p>');
						msgFocus($("#errmsg1"), $("#facultyName"));
						break;
					case 'facultyName':
						$("#errmsg1").html('<p>Name must be alphabet</p>');
						msgFocus($("#errmsg1"), $("#facultyName"));
						break;
					case 'shortDescription':
						$("#errmsg2").html('<p>Too Long! Short Description should be less than 250 charecter</p>');
						msgFocus($("#errmsg2"), $("#shortDescription"));
						break;
					case 'error':
						swal("Something Went Wrong!", {
							icon: "error",
						});
						break;
					case 'unsuccess':
						swal("Something Went Wrong! Please contact with developers", {
							icon: "error",
						});
						break;
					default:
						swal("Something Went Wrong! Please contact with developers", {
							icon: "error",
						});
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Register Faculty (faculty/create.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// Edit Faculty (faculty/edit.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#facultyEditSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2").html("");
		$("#errmsgParant").html("");

		let styleLoading 			= $(this).siblings(".styleLoading");
		let thisclass 				= $(this);
		let facultyEditSubmit = $(this).attr("name");
		let facultyId 				= $(this).attr("data-faculty");

		styleLoading.html("");

		let editFacultyForm 		= $("#editFacultyForm")[0];
		let editFacultyFormData = new FormData(editFacultyForm);
		editFacultyFormData.append("facultyEditSubmit", facultyEditSubmit);
		editFacultyFormData.append("facultyId", facultyId);

		$.ajax({
			type				: "POST",
			url					: "update.php",
			data				: editFacultyFormData,
			cache       : false,
			contentType : false,
			processData : false,
			beforeSend: function() {
				styleLoading.html('<div class="spinner-border spinner-border-sm text-primary"></div>');
			},
			success:function(finaldata){
				thisclass.prop("disabled", false);
				console.log(finaldata);
				styleLoading.html("");
				function msgFocus(selectId, inputId){
					$('html, body').animate({
						scrollTop: selectId.offset().top-300
					}, 1500);
					inputId.focus().css({"border": "1px solid #e23e32", "box-shadow": "0rem 0.2rem 1rem rgb(255, 204, 200)"});
				}
				switch(finaldata) {
					case 'success':
						swal("Successfully! Faculty edited!", {
							icon: "success",
						});
						break;
					case 'emptyfaculty':
						$("#errmsg1").html('<p>Name must require</p>');
						msgFocus($("#errmsg1"), $("#facultyName"));
						break;
					case 'facultyName':
						$("#errmsg1").html('<p>Name must be alphabet</p>');
						msgFocus($("#errmsg1"), $("#facultyName"));
						break;
					case 'shortDescription':
						$("#errmsg2").html('<p>Too Long! Short Description should be less than 250 charecter</p>');
						msgFocus($("#errmsg2"), $("#shortDescription"));
						break;
					case 'error':
						swal("Something Went Wrong!", {
							icon: "error",
						});
						break;
					case 'unsuccess':
						swal("Something Went Wrong. Please contact with developers!", {
							icon: "error",
						});
						break;
					default:
						swal("Something Went Wrong. Please contact with developers!", {
							icon: "error",
						});
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Edit Faculty (faculty/edit.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Delete Faculty(faculty/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#facultyDelBtn", function(e){
		e.preventDefault();

		swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
				$(this).prop("disabled", true);

				var thisclass = $(this);
				var facultyinfo = $(this).attr("data-faculty_info");
				var facultyDelBtn = $(this).attr("name");
				if(getBasename[0] == 'show.php'){ //if start
					var cameFrom 	= "show";
				}else{
					var cameFrom 	= "index";
				}

				$.ajax({
					type: "POST",
					url: "delete.php",
					data: {facultyinfo:facultyinfo, facultyDelBtn:facultyDelBtn, cameFrom:cameFrom},
					success:function(finaldata){
						console.log(finaldata);
						thisclass.prop("disabled", false);
						switch(finaldata) {
							case 'success':
								if(getBasename[0] != 'show.php'){ //if start
									jplist.resetContent(function(){
											$("#eachData"+facultyinfo).remove();
									});
									swal("Successfully! Faculty has been deleted!", {
										icon: "success",
									});
								}else{
									window.location.href = mainwebroot+"view/faculty/";
								}

								break;
							case 'studenthas':
								swal("You can't Delete it. This faculty used in a student account!", {
									icon: "error",
								});
								break;
							case 'error':
								swal("Something Went Wrong!", {
									icon: "error",
								});
								break;
							case 'unsuccess':
								swal("Something Went Wrong! Please Contact with developer.", {
									icon: "error",
								});
								break;
							default:
								swal("Something Went Wrong! Please Contact with developer.", {
									icon: "error",
								});
						}
						$('.tooltip').remove();
					}
				});
				return false;
		  }
		});

	});
	//-------------------------------------------------------------------
	// End: Delete Faculty(faculty/index.php)
	//-------------------------------------------------------------------

});
