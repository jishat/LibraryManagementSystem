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
	// start: Edit User Account (user/create.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#adminEditSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsgAdmnName, #errmsgAdmnUserRole, #errmsgAdmnEmail, #errmsgAdmnPassword, #errmsgAdmnImg").html("");
		$("#errmsgAdmnParant").html("");

		var styleLoading 		= $(this).siblings(".styleLoading");
		var thisclass 			= $(this);
		var adminEditSubmit = $(this).attr("name");
		var adminInfoid 		= $(this).attr("data-infoid");
		var dataImgDelete 	= $("#deleteimg").attr("data-img_delete");


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


});
