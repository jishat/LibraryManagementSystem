$(document).ready(function(){
	var mainwebroot = "http://"+window.location.hostname+"/tjadmin/";

	//-------------------------------------------------------------------
	// start: Admin Submit Login
	//-------------------------------------------------------------------
	$(document).on("click", "#userLogSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		var thisclass = $(this);
		var userLogSubmit = $(this).attr("name");
		var showErrMsg 	= $('#loginErroMSg');
		var userLogForm = $("#userLogForm")[0];
		var admnFormData = new FormData(userLogForm);
		admnFormData.append("userLogSubmit", userLogSubmit);
		$.ajax({
			type: "POST",
			url: "action/login.php",
      data: admnFormData,
      processData: false,
      contentType: false,
      cache: false,
      success:function(finaldata){
          console.log(finaldata);
      	thisclass.prop("disabled", false);
      	if(finaldata === "success"){
      		window.location.href = mainwebroot+"view/dashboard";
      	}else if(finaldata === "invalid"){
      		showErrMsg.html('<p class="alert alert-danger">Invalid Email or Password</p>');
      	}else if(finaldata === "error"){
      		showErrMsg.html('<p class="alert alert-danger">Something went wrong</p>');
      	}else if(finaldata === "empty"){
      		showErrMsg.html('<p class="alert alert-danger">Email & Password must require</p>');
      	}else{
      		showErrMsg.html('<p class="alert alert-danger">Something went wrong. Please contact with developer</p>');
      	}
      }
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Admin Submit Login
	//-------------------------------------------------------------------

});
