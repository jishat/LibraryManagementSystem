"use strict";
$(document).ready(function(){
	var mainwebroot = window.location.origin+"/tjadmin/";
	var currentUrl 	= window.location.href;
	var getPath  = window.location.pathname.split( '/' );
	var getBasename = getPath.reverse();
	console.log(getBasename[0]);

	//-------------------------------------------------------------------
	// start: Common Js (admin section)
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
	// End: Common Js (admin section)
	//-------------------------------------------------------------------


	//-------------------------------------------------------------------
	// start: Register User Account (user/create.php)
	//-------------------------------------------------------------------

	$(document).on("click", "#admnRegSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2, #errmsg3, #errmsg4, #errmsg5, #errmsg6, #errmsg7").html("");
		$("#errmsgParant").html("");

		let styleLoading = $(this).siblings(".styleLoading");
		let thisclass = $(this);
		let admnRegSubmit = $(this).attr("name");

		styleLoading.html("");

		let regAdmnAccForm = $("#regAdmnAccForm")[0];
		let regAdmnAccFormData = new FormData(regAdmnAccForm);
		regAdmnAccFormData.append("admnRegSubmit", admnRegSubmit);

		$.ajax({
			type: "POST",
			url: "store.php",
			data: regAdmnAccFormData,
			processData: false,
			contentType: false,
			cache: false,
			beforeSend: function() {
				styleLoading.html('<div class="spinner-border spinner-border-sm text-primary"></div>');
			},
			success:function(finaldata){
				console.log(finaldata);
				thisclass.prop("disabled", false);
				styleLoading.html("");
				function msgFocus(selectId, inputId){
					$('html, body').animate({
						scrollTop: selectId.offset().top-300
					}, 1000);
					inputId.focus().css({"border": "1px solid #e23e32", "box-shadow": "0rem 0.2rem 1rem rgb(255, 204, 200)"});
				}
				switch(finaldata) {

					case 'success':
						window.location.href = mainwebroot+"view/user/";
						break;
					case 'emptyusername':
						$("#errmsg1").html('<p>Name must require</p>');
						msgFocus($("#errmsg1"), $("#userName"));
						break;
					case 'userName':
						$("#errmsg1").html('<p>Name should be alphabet & Less than 60 char</p>');
						msgFocus($("#errmsg1"), $("#userName"));
						break;
					case 'emptyloginUserName':
						$("#errmsg9").html('<p>Username must require</p>');
						msgFocus($("#errmsg9"), $("#loginUserName"));
						break;
					case 'loginUserName':
						$("#errmsg9").html('<p>Username must be alphabet or numeric & Less than 60 char</p>');
						msgFocus($("#errmsg9"), $("#loginUserName"));
						break;
					case 'loginUserNameSpace':
						$("#errmsg9").html('<p>You can not use any spaces in username</p>');
						msgFocus($("#errmsg9"), $("#loginUserName"));
						break;
					case 'loginUserNameAlready':
						$("#errmsg9").html('<p>This username already exists. Please try new</p>');
						msgFocus($("#errmsg9"), $("#loginUserName"));
						break;
					case 'emptyuserrole':
						$("#errmsg2").html('<p>User Role must require</p>');
						msgFocus($("#errmsg2"), $("#userRole"));
						break;
					case 'userRole':
						$("#errmsg2").html('<p>Invalid user role</p>');
						msgFocus($("#errmsg2"), $("#userRole"));
						break;
					case 'emptyusergender':
						$("#errmsg3").html('<p>Gender must require</p>');
						msgFocus($("#errmsg3"), $("#userGender"));
						break;
					case 'usergender':
						$("#errmsg3").html('<p>Invalid Gender! Please refresh and try again</p>');
						msgFocus($("#errmsg3"), $("#userGender"));
						break;
					case 'usermobile':
						$("#errmsg4").html('<p>Invalid Mobile number!</p>');
						msgFocus($("#errmsg4"), $("#userMobile"));
						break;
					case 'emptyuseremail':
						$("#errmsg5").html('<p>Email must require</p>');
						msgFocus($("#errmsg5"), $("#userEmail"));
						break;
					case 'userEmail':
						$("#errmsg5").html('<p>Invalid email</p>');
						msgFocus($("#errmsg5"), $("#userEmail"));
						break;
					case 'useremailalready':
						$("#errmsg5").html('<p>Email already exists. Please try new one</p>');
						msgFocus($("#errmsg5"), $("#userEmail"));
						break;
					case 'emptyuserpass':
						$("#errmsg6").html('<p>Password must require</p>');
						msgFocus($("#errmsg6"), $("#userPassword"));
						break;
					case 'userPassword':
						$("#errmsg6").html('<p>Password should be more than 7 & less than 60 charecter</p>');
						msgFocus($("#errmsg6"), $("#userPassword"));
						break;
					case 'userAddress':
						$("#errmsg7").html('<p>Address should be less than 60 charecter</p>');
						msgFocus($("#errmsg7"), $("#userAddress"));
						break;
					case 'adminimg':
						$("#errmsg8").html('<p>Only "JPEG" or "PNG" or "JPG" support</p>');
						msgFocus($("#errmsg8"), $("#userPicture"));
						break;
					case 'error':
						swal("Something Went Wrong!", {
							icon: "error",
						});
						break;
					default:
						swal("Something Went Wrong! Please Contact with developer.", {
							icon: "error",
						});
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Register User Account (user/create.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Edit User Account (user/create.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#adminEditSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsgAdmnName, #errmsgAdmnUserRole, #errmsgAdmnEmail, #errmsgAdmnPassword, #errmsgAdmnImg").html("");
		$("#errmsgAdmnParant").html("");

		var styleLoading = $(this).siblings(".styleLoading");
		var thisclass = $(this);
		var adminEditSubmit = $(this).attr("name");
		var adminInfoid = $(this).attr("data-infoid");
		var dataImgDelete = $("#deleteimg").attr("data-img_delete");


		styleLoading.html("");

		var editAdmnAccForm = $("#editAdmnAccForm")[0];
		var editAdmnAccFormData = new FormData(editAdmnAccForm);
		editAdmnAccFormData.append("adminEditSubmit", adminEditSubmit);
		editAdmnAccFormData.append("adminInfoid", adminInfoid);
		editAdmnAccFormData.append("dataImgDelete", dataImgDelete);

		$.ajax({
			type: "POST",
			url: "update.php",
			data: editAdmnAccFormData,
			processData: false,
			contentType: false,
			cache: false,
			beforeSend: function() {
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
				switch(finaldata) {
					case 'success':
						swal("Successfully! Profile has been updated.", {
							icon: "success",
						});
						break;
					case 'emptyusername':
						$("#errmsg1").html('<p>Name must require</p>');
						msgFocus($("#errmsg1"), $("#userName"));
						break;
					case 'userName':
						$("#errmsg1").html('<p>Name should be alphabet & Less than 60 char</p>');
						msgFocus($("#errmsg1"), $("#userName"));
					break;
					case 'emptyloginUserName':
						$("#errmsg9").html('<p>Username must require</p>');
						msgFocus($("#errmsg9"), $("#loginUserName"));
						break;
					case 'loginUserName':
						$("#errmsg9").html('<p>Username must be alphabet or numeric & Less than 60 char</p>');
						msgFocus($("#errmsg9"), $("#loginUserName"));
						break;
					case 'loginUserNameSpace':
						$("#errmsg9").html('<p>You can not use any spaces in username</p>');
						msgFocus($("#errmsg9"), $("#loginUserName"));
						break;
					case 'loginUserNameAlready':
						$("#errmsg9").html('<p>This username already exists. Please try new</p>');
						msgFocus($("#errmsg9"), $("#loginUserName"));
						break;
					case 'emptyuserrole':
						$("#errmsg2").html('<p>User Role must require</p>');
						msgFocus($("#errmsg2"), $("#userRole"));
						break;
					case 'userRole':
						$("#errmsg2").html('<p>Invalid user role</p>');
						msgFocus($("#errmsg2"), $("#userRole"));
						break;
					case 'emptyusergender':
						$("#errmsg3").html('<p>Gender must require</p>');
						msgFocus($("#errmsg3"), $("#userGender"));
						break;
					case 'usergender':
						$("#errmsg3").html('<p>Invalid Gender! Please refresh and try again</p>');
						msgFocus($("#errmsg3"), $("#userGender"));
						break;
					case 'usermobile':
						$("#errmsg4").html('<p>Invalid Mobile number!</p>');
						msgFocus($("#errmsg4"), $("#userMobile"));
						break;
					case 'emptyuseremail':
						$("#errmsg5").html('<p>Email must require</p>');
						msgFocus($("#errmsg5"), $("#userEmail"));
						break;
					case 'userEmail':
						$("#errmsg5").html('<p>Invalid email</p>');
						msgFocus($("#errmsg5"), $("#userEmail"));
						break;
					case 'useremailalready':
						$("#errmsg5").html('<p>Email already exists. Please try new one</p>');
						msgFocus($("#errmsg5"), $("#userEmail"));
						break;
					case 'emptyuserpass':
						$("#errmsg6").html('<p>Password must require</p>');
						msgFocus($("#errmsg6"), $("#userPassword"));
						break;
					case 'userPassword':
						$("#errmsg6").html('<p>Password should be more than 7 & less than 60 charecter</p>');
						msgFocus($("#errmsg6"), $("#userPassword"));
						break;
					case 'userAddress':
						$("#errmsg7").html('<p>Address should be less than 60 charecter</p>');
						msgFocus($("#errmsg7"), $("#userAddress"));
						break;
					case 'adminimg':
						$("#errmsg8").html('<p>Only "JPEG" or "PNG" or "JPG" support</p>');
						msgFocus($("#errmsg8"), $("#userPicture"));
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
	// End: Edit User Account (user/edit.php)
	//-------------------------------------------------------------------

  //-------------------------------------------------------------------
  // start: Status Change User Account (user/index.php)
  //-------------------------------------------------------------------
  $(document).on("change", ".adminStatus", function(e){
    e.preventDefault();
    $(this).prop("disabled", true);

    var thisclass = $(this);
    var status = $(this).attr("data-status");
    var id = $(this).attr("data-id");
    var changesubmit = 'changesubmit';

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
						swal("Something Went Wrong. Please refresh and try again!", {
							icon: "error",
						});
        		break;
        	case 'unsuccessfully':
						swal("Something Went Wrong. Please Contact with developer!", {
							icon: "error",
						});
        		break;
        	default:
						swal("Something Went Wrong. Please refresh and try again!", {
							icon: "error",
						});
        }
      }
    });
    return false;
  });
  //-------------------------------------------------------------------
  // End: Status Change User Account (user/index.php)
  //-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Delete User Account (user/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#admnDelBtn", function(e){
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

				var thisclass = $(this);
				var admninfo = $(this).attr("data-admn_info");
				var admnDelBtn = $(this).attr("name");

				if(getBasename[0] == 'show.php'){
					var cameFrom = "show";
				}else {
					var cameFrom = "index";
				}

				$.ajax({
					type: "POST",
					url: "delete.php",
					data: {admninfo:admninfo, admnDelBtn:admnDelBtn, cameFrom:cameFrom},
					success:function(finaldata){
						console.log(finaldata);
						thisclass.prop("disabled", false);
						switch(finaldata) {
							case 'success':
								if(getBasename[0] == 'show.php'){
									window.location.href = mainwebroot+"view/user/";
								}else {
									jplist.resetContent(function(){
					            //remove element with id = el1
					            thisclass.closest(".eachAdmnData").remove();
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
	// End: Delete User Account (user/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// Start: Register User role (user-role/create.php)
	//-------------------------------------------------------------------\
	$(document).on("click", "#userRoleRegSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2, #errmsg3").html("");
		$("#errmsgParant").html("");

		var styleLoading = $(this).siblings(".styleLoading");
		var thisclass = $(this);
		var userRoleRegSubmit = $(this).attr("name");

		styleLoading.html("");

		var regUserRoleForm = $("#regUserRoleForm")[0];
		var regUserRoleFormData = new FormData(regUserRoleForm);
		regUserRoleFormData.append("userRoleRegSubmit", userRoleRegSubmit);

		$.ajax({
			type: "POST",
			url: "store.php",
			data: regUserRoleFormData,
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
						window.location.href = mainwebroot+"view/user-role";
						break;
					case 'emptyuserrole':
						$("#errmsg1").html('<p>Name must require</p>');
						msgFocus($("#errmsg1"), $("#userRoleName"));
						break;
					case 'userRoleName':
						$("#errmsg1").html('<p>Name must be alphabet</p>');
						msgFocus($("#errmsg1"), $("#userRoleName"));
						break;
					case 'userRoleNameAdmin':
						$("#errmsg1").html('<p>You can\'t use "Super Admin" as user role name</p>');
						msgFocus($("#errmsg1"), $("#userRoleName"));
						break;
					case 'emptyPagePermission':
						$("#errmsg2").html('<p>Permision pages must require</p>');
						msgFocus($("#errmsg2"), $("#permissionPages"));
						break;
					case 'permissionPage':
						$("#errmsg2").html('<p>Invalid Permision pages. Please refresh & try again</p>');
						msgFocus($("#errmsg2"), $("#permissionPages"));
						break;
					case 'shortDescription':
						$("#errmsg3").html('<p>Too Long! Short Description should be less than 250 charecter</p>');
						msgFocus($("#errmsg3"), $("#permissionPages"));
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
	// End: Register User role (user-role/create.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// Start: Edit User role (user-role/edit.php)
	//-------------------------------------------------------------------\
	$(document).on("click", "#userRoleEditSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2, #errmsg3").html("");
		$("#errmsgParant").html("");

		var styleLoading = $(this).siblings(".styleLoading");
		var thisclass = $(this);
		var userRoleEditSubmit = $(this).attr("name");
		var userRoleId = $(this).attr("data-usrole");

		styleLoading.html("");

		var editUserRoleForm = $("#editUserRoleForm")[0];
		var editUserRoleFormData = new FormData(editUserRoleForm);
		editUserRoleFormData.append("userRoleEditSubmit", userRoleEditSubmit);
		editUserRoleFormData.append("userRoleId", userRoleId);

		$.ajax({
			type: "POST",
			url: "update.php",
			data: editUserRoleFormData,
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
						swal("Successfully! User Role has been updated", {
							icon: "success",
						});
						break;
					case 'emptyuserrole':
						$("#errmsg1").html('<p>Name must require</p>');
						msgFocus($("#errmsg1"), $("#userRoleName"));
						break;
					case 'userRoleName':
						$("#errmsg1").html('<p>Name must be alphabet</p>');
						msgFocus($("#errmsg1"), $("#userRoleName"));
						break;
					case 'userRoleNameAdmin':
						$("#errmsg1").html('<p>You can\'t use "Administrator" as user role name</p>');
						msgFocus($("#errmsg1"), $("#userRoleName"));
						break;
					case 'emptyPagePermission':
						$("#errmsg2").html('<p>Permision pages must require</p>');
						msgFocus($("#errmsg2"), $("#permissionPages"));
						break;
					case 'permissionPage':
						$("#errmsg2").html('<p>Invalid Permision pages. Please refresh & try again</p>');
						msgFocus($("#errmsg2"), $("#permissionPages"));
						break;
					case 'shortDescription':
						$("#errmsg3").html('<p>Too Long! Short Description should be less than 250 charecter</p>');
						msgFocus($("#errmsg3"), $("#permissionPages"));
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
	// End: Edit User role (user-role/edit.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Delete User Role (user-role/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#usrlDelBtn", function(e){
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
					var usrlinfo = $(this).attr("data-usrole_info");
					var usrlDelBtn = $(this).attr("name");

					if(getBasename[0] == 'show.php'){ //if start
						var cameFrom 	= "show";
					}else{
						var cameFrom 	= "index";
					}


					$.ajax({
						type: "POST",
						url: "delete.php",
						data: {usrlinfo:usrlinfo, usrlDelBtn:usrlDelBtn, cameFrom:cameFrom},
						success:function(finaldata){
							console.log(finaldata);
							thisclass.prop("disabled", false);
							switch(finaldata) {
								case 'success':
									if(getBasename[0] != 'show.php'){ //if start
										jplist.resetContent(function(){
												$("#eachData"+usrlinfo).remove();
										});
										swal("Successfully! User Role has been deleted!", {
								      icon: "success",
								    });
									}else{
										window.location.href = mainwebroot+"view/user-role/";
									}
									break;
									case 'adminhas':
										swal("You can't Delete it. This user role used in a user account!", {
											icon: "error",
										});
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
	// End: Delete User Role (user-role/index.php)
	//-------------------------------------------------------------------
});
