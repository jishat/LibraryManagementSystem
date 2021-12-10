"use strict";
$(document).ready(function(){
	var mainwebroot = "http://"+window.location.hostname+"/tjadmin/";
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
    $('#selectedavatar').attr('src', domain+'img/avatar-man.png');
  });
	$(document).on("click", ".syncNotification", function(e){
    e.preventDefault();
    // $('#allMainNotification').load(location.href+" #notifyTable");
		location.reload(true);
  });
	//-------------------------------------------------------------------
	// End: Common Js (student section)
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
			url: "show.php",
      data: {dataID:dataID, dataMethod:dataMethod, isRead:isRead},
      beforeSend: function(){
				styleLoading.html('<div class="spinner-border spinner-border-sm text-primary"></div>');
			},
      success:function(finaldata){
        console.log(finaldata);
        thisclass.prop("disabled", false);
        styleLoading.html("");
				if (finaldata == 'error') {
					toastr.error('Something Went Wrong. Please Contact with developer')
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
			url: "delete.php",
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
      	function msgFocus(selectId, inputId){
      		$('html, body').animate({
		        scrollTop: selectId.offset().top-300
			    }, 1500);
		    	inputId.focus().css({"border": "1px solid #e23e32", "box-shadow": "0rem 0.2rem 1rem rgb(255, 204, 200)"});
      	}
				console.log(finaldata);
        switch(finaldata){

					case 'success':
						toastr.success('Deleted Successfully')
						for (let [key, value] of notidicationFormData.entries()) {
						  console.log(key, ':', value);
							jplist.resetContent(function(){
			            //remove element with id = el1
			            $(".eachData"+value).remove();
			        });
						}
						// thisclass.closest(".eachData").remove();
						break;
					case 'error':
						toastr.error('Something Went Wrong')
						break;
					default:
					  toastr.error('Something Went Wrong. Please Contact with developer')
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Delete Notification (notification/index.php)
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
						toastr.success('Update account successfully.');
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
						$("#errmsgParant").html('<div class="alert alert-danger">Something Went Wrong</div>');
						break;
					default:
						$("#errmsgParant").html('<div class="alert alert-danger">Something Went Wrong. Please contact with developer</div>');
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
		alert('hello');
		let thisclass 		= $(this);
		let status 				= $(this).attr("data-status");
		let id 						= $(this).attr("data-id");
		let changesubmit 	= 'stdstatussubmit';

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
							toastr.success('Deactivate account successfully.')
						}else {
							thisclass.attr("data-status", "1");
							thisclass.next().html('Active');
							toastr.success('Activated account successfully.')
						}
						break;
					case 'error':
						toastr.error('Something Went Wrong.')
						break;
					case 'unsuccessfully':
						toastr.warning('Something Went Wrong. Please Contact with developer')
						break;
					default:
						toastr.error('Something Went Wrong 2. Please refresh and try again')
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
		if(window.confirm("Are your sure to Delete")){
			$(this).prop("disabled", true);

			let thisclass 			= $(this);
			let stdinfo 				= $(this).attr("data-std_info");
			let stdDeleteSubmit = $(this).attr("name");

			$.ajax({
				type: "POST",
				url: "delete.php",
				data: {stdinfo:stdinfo, stdDeleteSubmit:stdDeleteSubmit},
				success:function(finaldata){
					console.log(finaldata);
					thisclass.prop("disabled", false);
					switch(finaldata) {
						case 'success':
							$('.tooltip').remove();
							thisclass.closest(".eachStdData").remove();
							// $("#admnDataLoad").load(mainwebroot+"view/admin" +" #dataalladmin");
							toastr.success("Account Delete Successfully");
							break;
						case 'error':
							toastr.error("Something Went Wrong");
							break;
						case 'unsuccess':
							toastr.warning('Something Went Wrong. Please Contact with developer')
							break;
						default:
							toastr.warning('Something Went Wrong. Please Contact with developer')
					}
				}
			});
			return false;
		}else{
			return false;
		}
	});
	//-------------------------------------------------------------------
	// End: Delete Student Account (student/index.php)
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
						$("#errmsgParant").html('<div  class="alert alert-danger">Something Went Wrong</div>');
						break;
					case 'unsuccess':
						$("#errmsgParant").html('<div  class="alert alert-danger">Something Went Wrong. Please contact with developers</div>');
						break;
					default:
							$("#errmsgParant").html('<div  class="alert alert-danger">Something Went Wrong. Please contact with developers</div>');
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
						toastr.success("Edit Account Successfully");
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
						$("#errmsgParant").html('<div  class="alert alert-danger">Something Went Wrong</div>');
						break;
					case 'unsuccess':
						$("#errmsgParant").html('<div  class="alert alert-danger">Something Went Wrong. Please contact with developers</div>');
						break;
					default:
							$("#errmsgParant").html('<div  class="alert alert-danger">Something Went Wrong. Please contact with developers</div>');
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
		if(window.confirm("Are your sure to Delete")){
			$(this).prop("disabled", true);

			var thisclass = $(this);
			var facultyinfo = $(this).attr("data-faculty_info");
			var facultyDelBtn = $(this).attr("name");

			$.ajax({
				type: "POST",
				url: "delete.php",
				data: {facultyinfo:facultyinfo, facultyDelBtn:facultyDelBtn},
				success:function(finaldata){
					console.log(finaldata);
					thisclass.prop("disabled", false);
					switch(finaldata) {
						case 'success':
							thisclass.closest(".eachFacultyData").remove();
							toastr.success("Faculty Delete Successfully");
							break;
						case 'studenthas':
							toastr.warning("You can&apos;t Delete it. This faculty used in a student account.");
							break;
						case 'error':
							toastr.error("Something Went Wrong");
							break;
						case 'unsuccess':
							toastr.warning('Something Went Wrong. Please Contact with developer')
							break;
						default:
							toastr.warning('Something Went Wrong. Please Contact with developer')
					}
				}
			});
			return false;
		}else{
			return false;
		}
	});
	//-------------------------------------------------------------------
	// End: Delete Faculty(faculty/index.php)
	//-------------------------------------------------------------------

});
