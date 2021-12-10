$(document).ready(function(){
	let mainwebroot = location.origin+"/";

	//-------------------------------------------------------------------
	// start: commom js (register.php)
	//-------------------------------------------------------------------
	$(document).on("change", "select", function(){
		$(this).siblings(".errmsgFind").html("");
		$(this).removeClass("is-invalid");
		$(this).attr("style", "");
	});
	$(document).on("keypress change", "input, textarea", function(){
		$(this).siblings(".errmsgFind").html("");
		$(this).removeClass("is-invalid");
		$(this).attr("style", " ");
	});
	$(document).on("click", "#deleteimg", function(e){
    e.preventDefault();
    $(this).attr('data-img_delete', '1');
    $('#selectedavatar').attr('src', domain+'img/avatar-man.png');

  });
	//-------------------------------------------------------------------
	// start: commom js (register.php)
	//-------------------------------------------------------------------


	//-------------------------------------------------------------------
	// start: Register Account (register.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#stuRegSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2, #errmsg3, #errmsg4, #errmsg5, #errmsg6, #errmsg7, #errmsg8, errmsg9, errmsg10").html("");
		$("#errmsgParant").html("");
		let thisclass 		= $(this);
		let styleLoading 	= $(this).siblings(".styleLoading");
		let stuRegSubmit 	= $(this).attr("name");
		let stuRegTkn 		= $(this).attr("data-tkn_reg");
		let showErrMsg 		= $(this).siblings(".showErrMsg");
		let cameFrom 			= "front";

		styleLoading.html("");

		let stdnForm = $("#stdnForm")[0];
		let stdnFormData = new FormData(stdnForm);
		stdnFormData.append("stuRegSubmit", stuRegSubmit);
		stdnFormData.append("cameFrom", cameFrom);
		stdnFormData.append("stuRegTkn", stuRegTkn);
		$.ajax({
			type: "POST",
			url: "store.php",
			data: stdnFormData,
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
					inputId.addClass('is-invalid');;
					// inputId.focus().css({"border": "1px solid #e23e32", "box-shadow": "0rem 0.2rem 1rem rgb(255, 204, 200)"});
				}
				switch(finaldata){
					case 'success':
						window.location.href = mainwebroot+"verify.php";
						break;
					case 'nameempty':
						$("#errmsg1").html('Name Must Require');
						msgFocus($("#errmsg1"), $("#studentName"));
						break;
					case 'studentname':
						$("#errmsg1").html('Name should be Alphabet')
						msgFocus($("#errmsg1"), $("#studentName"));
						break;
					case 'idempty':
						$("#errmsg2").html('ID Must Require');
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
						toastr.error('Something Went Wrong.');
						// $("#errmsgParant").html('<div class="alert alert-danger">Something Went Wrong</div>');
						break;
					default:
						toastr.error('Something Went Wrong. Please contact with developer.');
						// $("#errmsgParant").html('<div class="alert alert-danger">Something Went Wrong. Please contact with developer</div>');
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Register Account (register.php)
	//-------------------------------------------------------------------


	//-------------------------------------------------------------------
	// start: Student Login (index.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#userLogSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		let thisclass = $(this);
		let userLogSubmit = $(this).attr("name");
		let stuLogTkn 		= $(this).attr("data-tkn_log");
		let showErrMsg 		= $('#loginErroMSg');
		let userLogForm 	= $("#userLogForm")[0];
		let admnFormData 	= new FormData(userLogForm);
		admnFormData.append("userLogSubmit", userLogSubmit);
		admnFormData.append("stuLogTkn", stuLogTkn);
		$.ajax({
			type: "POST",
			url: mainwebroot+"action/login.php",
      data: admnFormData,
      processData: false,
      contentType: false,
      cache: false,
      success:function(finaldata){
      	thisclass.prop("disabled", false);
				switch (finaldata) {
					case 'success':
						window.location.href = mainwebroot+"book";
						break;
					case 'invalid':
						showErrMsg.html('<p class="alert alert-danger">Invalid Email or Password</p>');
						break;
					case 'disable':
						showErrMsg.html('<p class="alert alert-danger">This account has been disabled. Please contact with Admin</p>');
						break;
					case 'notverify':
						showErrMsg.html('<p class="alert alert-danger">This account is not verify yet. Please wait for admin verify.</p>');
						break;
					case 'error':
						showErrMsg.html('<p class="alert alert-danger">Something went wrong</p>');
						break;
					case 'empty':
						showErrMsg.html('<p class="alert alert-danger">Email & Password must require</p>');
						break;
					default:
						showErrMsg.html('<p class="alert alert-danger">Something went wrong. Please contact with developer</p>');

				}
      }
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Student Login (index.php)
	//-------------------------------------------------------------------

});
