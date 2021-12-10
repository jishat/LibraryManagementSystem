$(document).ready(function(){
	var mainwebroot = "http://"+window.location.hostname+"/ciu/tjadmin/";



	//-------------------------------------------------------------------
	// start: Create Student Account (student/creat.php)
	//-------------------------------------------------------------------
	$(document).on("keypress change", "input", function(){
		$(this).siblings(".errmsgTw").html("");
		$(this).attr("style", "");
	});
	$(document).on("change", "#faculty", function(){
		$(this).siblings(".errmsgTw").html("");
		$(this).attr("style", "");
	});

	$(document).on("click", "#stuRegSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		var thisclass = $(this);
		var stuRegSubmitLoading = $(this).siblings(".stuRegSubmitLoading");
		var stuRegSubmit = $(this).attr("name");
		var showErrMsg 	= $(this).siblings(".showErrMsg");

		$("#errmsgName, #errmsgStdnId, #errmsgFaculty, #errmsgStdnBatch, #errmsgStdnMobile, #errmsgStdnEmail, #errmsgStdnPass, #errmsgStdnImg").html("");
		stuRegSubmitLoading.html("");

		var admnStdnForm = $("#admnStdnForm")[0];
		var admnStdnFormData = new FormData(admnStdnForm);
		admnStdnFormData.append("stuRegSubmit", stuRegSubmit);
		$.ajax({
			type: "POST",
			url: "store.php",
            data: admnStdnFormData,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
						stuRegSubmitLoading.html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
					},
            success:function(finaldata){
            	console.log(finaldata);
            	thisclass.prop("disabled", false);
            	stuRegSubmitLoading.html("");
            	function msgFocus(selectId, inputId){
            		$('html, body').animate({
			        scrollTop: selectId.offset().top-300
				    }, 1500);
				    inputId.focus().css({"border": "1px solid #e23e32", "box-shadow": "0rem 0.2rem 1rem rgb(255, 204, 200)"});
            	}
            	switch(finaldata) {
					case 'success':
						window.location.href=mainwebroot+"admin/view/student/";
						break;
					case 'nameempty':
						$("#errmsgName").html('<p>Name Must Require</p>');
						msgFocus($("#errmsgName"), $("#Name"));
						break;
					case 'idempty':
						$("#errmsgStdnId").html('<p>ID Must Require</p>');
						msgFocus($("#errmsgStdnId"), $("#id"));
						break;
					case 'facultyempty':
						$("#errmsgFaculty").html('<p>Faculty Must Require</p>');
						msgFocus($("#errmsgFaculty"), $("#faculty"));
						break;
					case 'batchempty':
						$("#errmsgStdnBatch").html('<p>Batch Must Require</p>');
						msgFocus($("#errmsgStdnBatch"), $("#batch"));
						break;
					case 'mobileempty':
						$("#errmsgStdnMobile").html('<p>Mobile Must Require</p>');
						msgFocus($("#errmsgStdnMobile"), $("#mobile"));
						break;
					case 'emailempty':
						$("#errmsgStdnEmail").html('<p>Email Must Require</p>');
						msgFocus($("#errmsgStdnEmail"), $("#email"));
						break;
					case 'passwordempty':
						$("#errmsgStdnPass").html('<p>Password Must Require</p>');
						msgFocus($("#errmsgStdnPass"), $("#password"));
						break;
					case 'studentimg':
						$("#errmsgStdnImg").html('<p>Only "JPEG" or "PNG" or "JPG" support</p>');
						msgFocus($("#errmsgStdnImg"), $("#picture"));
						break;
					case 'studentname':
						$("#errmsgName").html('<p>Name should be Alphabet</p>')
						msgFocus($("#errmsgName"), $("#name"));
						break;
					case 'studentid':
						$("#errmsgStdnId").html('<p>ID should be numeric</p>');
						msgFocus($("#errmsgStdnId"), $("#id"));
						break;
					case 'faculty':
						$("#errmsgFaculty").html('<p>Invalid Faculty</p>');
						msgFocus($("#errmsgFaculty"), $("#faculty"));
						break;
					case 'batch':
						$("#errmsgStdnBatch").html('<p>Batch should be numeric</p>');
						msgFocus($("#errmsgStdnBatch"), $("#batch"));
						break;
					case 'mobile':
						$("#errmsgStdnMobile").html('<p>Mobile should be only numeric</p>');
						msgFocus($("#errmsgStdnMobile"), $("#mobile"));
						break;
					case 'email':
						$("#errmsgStdnEmail").html('<p>Invalid Email</p>');
						msgFocus($("#errmsgStdnEmail"), $("#email"));
						break;
					case 'password':
						$("#errmsgStdnPass").html('<p>Password should be less than 60 charecter</p>');
						msgFocus($("#errmsgStdnPass"), $("#password"));
						break;
					case 'emailalready':
						$("#errmsgStdnEmail").html('<p>Email already exists. Please try new one</p>');
						msgFocus($("#errmsgStdnEmail"), $("#email"));
						break;
					case 'error':
						$("#errmsgParantStdnAcc").html('<p>Something Went Wrong</p>');
						break;
					default:
					    $("#errmsgParantStdnAcc").html('<p>Something Went Wrong</p>');
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Create Student Account (student/creat.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Disable Student Account (student/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".disableStudentAcc", function(e){
		e.preventDefault();
		if(window.confirm("Are your sure to Disable")){
			$(this).prop("disabled", true);

			var thisclass = $(this);
			var usrnm = $(this).attr("data-stdnt_usr");
			var disableStudentAcc = $(this).attr("name");

			$.ajax({
				type: "POST",
				url: "disable.php",
	            data: {usrnm:usrnm, disableStudentAcc:disableStudentAcc},
	            success:function(finaldata){
	            	console.log(finaldata);
	            	thisclass.prop("disabled", false);
	            	switch(finaldata) {
						case 'success':
							thisclass.removeClass("disableButton disableStudentAcc");
							thisclass.addClass("enableButton enableStudentAcc");
							thisclass.attr("name", "enableStudentAcc");
							thisclass.text("Enable");
							break;
						case 'error':
							window.alert("Something Went Wrong");
							break;
						default:
						    window.alert("Something Went Wrong 2");
					}
				}
			});
			return false;
		}else{
			return false;
		}
	});
	//-------------------------------------------------------------------
	// End: Disable Student Account (student/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Enable Student Account (student/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".enableStudentAcc", function(e){
		e.preventDefault();
		if(window.confirm("Are your sure to Enable")){
			$(this).prop("disabled", true);

			var thisclass = $(this);
			var usrnm = $(this).attr("data-stdnt_usr");
			var enableStudentAcc = $(this).attr("name");

			$.ajax({
				type: "POST",
				url: "enable.php",
	            data: {usrnm:usrnm, enableStudentAcc:enableStudentAcc},
	            success:function(finaldata){
	            	console.log(finaldata);
	            	thisclass.prop("disabled", false);
	            	switch(finaldata) {
						case 'success':
							thisclass.removeClass("enableButton enableStudentAcc");
							thisclass.addClass("disableButton disableStudentAcc");
							thisclass.attr("name", "disableStudentAcc");
							thisclass.text("Disable");
							break;
						case 'error':
							window.alert("Something Went Wrong");
							break;
						default:
						    window.alert("Something Went Wrong 2");
					}
				}
			});
			return false;
		}else{
			return false;
		}
	});
	//-------------------------------------------------------------------
	// End: Enable Student Account (student/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Delete Student Account (student/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".deleteStudntAcc", function(e){
		e.preventDefault();
		if(window.confirm("Are your sure to Delete")){
			$(this).prop("disabled", true);

			var thisclass = $(this);
			var usrnm = $(this).attr("data-stdnt_usr");
			var deleteStudntAcc = $(this).attr("name");

			$.ajax({
				type: "POST",
				url: "delete.php",
	            data: {usrnm:usrnm, deleteStudntAcc:deleteStudntAcc},
	            success:function(finaldata){
	            	console.log(finaldata);
	            	thisclass.prop("disabled", false);
	            	switch(finaldata) {
						case 'delete':
							window.location.reload();
							break;
						case 'error':
							window.alert("Something Went Wrong");
							break;
						default:
						    window.alert("Something Went Wrong");
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
	// start: Select Data per page (in all page)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// End: Select Data per page (in all page)
	//-------------------------------------------------------------------

	$(document).on("change", ".data_table_entities", function(){
		var selectedEntities = $(this).children("option:selected").val();
		var selectedEntitiesAction = "selectedEntitiesAction";
		$.ajax({
			type: "POST",
			url: "store.php",
            data: {selectedEntities:selectedEntities, selectedEntitiesAction:selectedEntitiesAction},
            success:function(finaldata){
            	console.log(finaldata);
            	if(finaldata === 'success'){
            		window.location.reload();
            	}
           	}
		});
		return false;
	});





	//-------------------------------------------------------------------
	// start: Add New Book (book /create.php)
	//-------------------------------------------------------------------
	$(document).on("change", "#category", function(){
		$(this).siblings(".errmsgTw").html("");
		$(this).attr("style", "");
	});
	$(document).on("change keypress", "#bookDescription", function(){
		$(this).siblings(".errmsgTw").html("");
		$(this).attr("style", "");
	});

	$(document).on("click", "#newBookSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		// $("#errmsgAdmnName, #errmsgAdmnUserRole, #errmsgAdmnEmail, #errmsgAdmnPassword, #errmsgAdmnImg").html("");
		// $("#errmsgAdmnParant").html("");

		var newBookSubmitLoading = $(this).siblings(".newBookSubmitLoading");
		var thisclass = $(this);
		var newBookSubmit = $(this).attr("name");

		newBookSubmitLoading.html("");

		var newBookAddedForm = $("#newBookAddedForm")[0];
		var newBookAddedFormData = new FormData(newBookAddedForm);
		newBookAddedFormData.append("newBookSubmit", newBookSubmit);

		$.ajax({
			type: "POST",
			url: "store.php",
            data: newBookAddedFormData,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
				newBookSubmitLoading.html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
			},
            success:function(finaldata){
            	console.log(finaldata);
            	thisclass.prop("disabled", false);
            	newBookSubmitLoading.html("");
            	function msgFocus(selectId, inputId){
            		$('html, body').animate({
			        scrollTop: selectId.offset().top-300
				    }, 1500);
				    inputId.focus().css({"border": "1px solid #e23e32", "box-shadow": "0rem 0.2rem 1rem rgb(255, 204, 200)"});
            	}
            	switch(finaldata) {
					case 'success':
						window.location.href=mainwebroot+"admin/view/book/";
						break;
					case 'emptybookname':
						$("#errmsgBookName").html('<p>Name must require</p>');
						msgFocus($("#errmsgBookName"), $("#bookName"));
						break;
					case 'emptywritername':
						$("#errmsgWriterName").html('<p>Writer Name must require</p>');
						msgFocus($("#errmsgWriterName"), $("#writerName"));
						break;
					case 'emptycategory':
						$("#errmsgBookCategory").html('<p>Book Category must require</p>');
						msgFocus($("#errmsgBookCategory"), $("#category"));
						break;
					case 'emptytotalstock':
						$("#errmsgTotalStock").html('<p>Total Stock must require</p>');
						msgFocus($("#errmsgTotalStock"), $("#totalStock"));
						break;
					case 'emptybookdesc':
						$("#errmsgBookDes").html('<p>Book Description Must require</p>');
						msgFocus($("#errmsgBookDes"), $("#bookDescription"));
						break;
					case 'bookName':
						$("#errmsgBookName").html('<p>Book name should be alphabet</p>');
						msgFocus($("#errmsgBookName"), $("#bookName"));
						break;
					case 'writerName':
						$("#errmsgWriterName").html('<p>Writer name should be alphabet</p>');
						msgFocus($("#errmsgWriterName"), $("#writerName"));
						break;
					case 'totalStock':
						$("#errmsgTotalStock").html('<p>Stock should be numeric</p>');
						msgFocus($("#errmsgTotalStock"), $("#totalStock"));
						break;
					case 'category':
						$("#errmsgBookCategory").html('<p>Invalid Category</p>');
						msgFocus($("#errmsgBookCategory"), $("#category"));
						break;
					case 'bookDescription':
						$("#errmsgBookDes").html('<p>Email already exists. Please try new one</p>');
						msgFocus($("#errmsgBookDes"), $("#bookDescription"));
						break;
					case 'bookImg':
						$("#errmsgBookImg").html('<p>Only "JPEG or "PNG" or "JPG" format support"</p>');
						msgFocus($("#errmsgBookImg"), $("#bookImage"));
						break;
					case 'error':
						$("#errmsgBookParant").html('<p>Something Went Wrong</p>');
						break;
					default:
					    $("#errmsgBookParant").html('<p>Something Went Wrong 2</p>');
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Add New Book (book /create.php)
	//-------------------------------------------------------------------

});
