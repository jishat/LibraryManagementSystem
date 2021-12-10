$(document).ready(function(){
	let mainwebroot = "http://"+window.location.hostname+"/";

	//-------------------------------------------------------------------
	// start: commom js (verify.php)
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
	// start: commom js (verify.php)
	//-------------------------------------------------------------------


	//-------------------------------------------------------------------
	// start: Verify Resend Code (verify.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#resendCodeSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		let thisclass = $(this);
		let resendCodeSubmit = $(this).attr("name");
		$.ajax({
			type: "POST",
			url: mainwebroot+"action/resendcode.php",
      data: {resendCodeSubmit:resendCodeSubmit},
      success:function(finaldata){
      	thisclass.prop("disabled", false);
				console.log(finaldata);
				if(finaldata === "success"){
      		toastr.success('Code Resend Successfully.');
      	}else if(finaldata === "error"){
      		toastr.error('Something went wrong.');
      	}else{
					toastr.error('Something went wrong. Please contact with developer');
      	}
      }
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Verify Resend Code (verify.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Verify Code (verify.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#verifySumbit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		let thisclass 		= $(this);
		let verifySumbit 	= $(this).attr("name");
		let verifyFormData = new FormData(verifyForm);
		verifyFormData.append("verifySumbit", verifySumbit);
		$.ajax({
			type: "POST",
			url: mainwebroot+"action/verifycode.php",
			data: verifyFormData,
      processData: false,
      contentType: false,
      cache: false,
			success:function(finaldata){
				thisclass.prop("disabled", false);
				console.log(finaldata);
				if(finaldata === "success"){
					window.location.href = mainwebroot+"success.php";
				}else if(finaldata === "expire"){
					toastr.error('Your security code expired. Please resend');
				}else if(finaldata === "successverify"){
					window.location.href = mainwebroot+"profile.php";
				}else if(finaldata === "notmatch"){
					toastr.error('Your security code is not matching');
				}else if(finaldata === "error"){
					toastr.error('Something went wrong.');
				}else{
					toastr.error('Something went wrong. Please contact with developer');
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Verify Code (verify.php)
	//-------------------------------------------------------------------





	//-------------------------------------------------------------------
	// start: Admin Submit Login
	//-------------------------------------------------------------------
	$(document).on("click", "#userLogSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		let thisclass = $(this);
		let userLogSubmit = $(this).attr("name");
		let showErrMsg 	= $('#loginErroMSg');
		let userLogForm = $("#userLogForm")[0];
		let admnFormData = new FormData(userLogForm);
		admnFormData.append("userLogSubmit", userLogSubmit);
		$.ajax({
			type: "POST",
			url: mainwebroot+"action/login.php",
      data: admnFormData,
      processData: false,
      contentType: false,
      cache: false,
      success:function(finaldata){
      	thisclass.prop("disabled", false);
      	if(finaldata === "success"){
      		toastr.success('Code Resend Successfully.');
      	}else if(finaldata === "error"){
      		toastr.error('Something went wrong.');
      	}else{
					toastr.error('Something went wrong. Please contact with developer');
      	}
      }
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Admin Submit Login
	//-------------------------------------------------------------------

});
