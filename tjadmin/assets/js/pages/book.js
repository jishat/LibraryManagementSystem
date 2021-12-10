"use strict";
$(document).ready(function(){
	var mainwebroot = window.location.origin+"/tjadmin/";
	var currentUrl 	= window.location.href;
	var getPath  = window.location.pathname.split( '/' );
	var getBasename = getPath.reverse();
	// console.log(getBasename[0]);

	//-------------------------------------------------------------------
	// start: Common Js (book section)
	//-------------------------------------------------------------------
	$(document).on("change keypress change", "select, input, textarea", function(){
		$(this).siblings(".errmsgTw").html("");
		$(this).attr("style", "");
	});

	$(document).on("click", "#deleteimg", function(e){
    e.preventDefault();
    $(this).attr('data-img_delete', '1');
    $('#selectedavatar').attr('src', domain+'img/dummybook.jpg');

  });
	//-------------------------------------------------------------------
	// End: Common Js (book section)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Create Book (book/creat.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#bookRegSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2, #errmsg3, #errmsg4, #errmsg5, #errmsg6, #errmsg7").html("");
		$("#errmsgParant").html("");
		let thisclass 		= $(this);
		let styleLoading 	= $(this).siblings(".styleLoading");
		let bookRegSubmit 	= $(this).attr("name");
		let showErrMsg 		= $(this).siblings(".showErrMsg");
		let description = editor.getData();
		styleLoading.html("");

		let bookRegForm = $("#bookRegForm")[0];
		let bookRegFormData = new FormData(bookRegForm);
		bookRegFormData.append("bookRegSubmit", bookRegSubmit);
		bookRegFormData.append("description", description);
		// console.log();
		$.ajax({
			type: "POST",
			url: "store.php",
      data: bookRegFormData,
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
						window.location.href = mainwebroot+"view/book/";
						break;
					case 'emptybookname':
						$("#errmsg1").html('<p>Name Must Require</p>');
						msgFocus($("#errmsg1"), $("#name"));
						break;
					case 'bookName':
						$("#errmsg1").html('<p>Book Name should be Less than 255 char</p>');
						msgFocus($("#errmsg1"), $("#name"));
						break;
					case 'writerName':
						$("#errmsg2").html('<p>Writer Name should be Less than 255 char</p>')
						msgFocus($("#errmsg2"), $("#writer"));
						break;
					case 'emptyCat':
						$("#errmsg3").html('<p>Category Must Require</p>')
						msgFocus($("#errmsg3"), $("#category"));
						break;
					case 'categorynotfound':
						$("#errmsg3").html('<p>Category not found</p>')
						msgFocus($("#errmsg3"), $("#category"));
						break;
					case 'invalidcat':
						$("#errmsg3").html('<p>Invalid Category</p>')
						msgFocus($("#errmsg3"), $("#category"));
						break;
					case 'emptystock':
						$("#errmsg4").html('<p>Sotck must require</p>')
						msgFocus($("#errmsg4"), $("#stock"));
						break;
					case 'stock':
						$("#errmsg4").html('<p>Sotck should be numeric</p>')
						msgFocus($("#errmsg4"), $("#stock"));
						break;
					case 'shelf':
						$("#errmsg5").html('<p>Book shelf too long</p>')
						msgFocus($("#errmsg5"), $("#shelf"));
						break;

					case 'description':
						$("#errmsg7").html('<p>Description too long!</p>')
						msgFocus($("#errmsg7"), $("#description"));
						break;
					case 'bookImg':
						$("#errmsg6").html('<p>Only "JPEG" or "PNG" or "JPG" support</p>')
						msgFocus($("#errmsg6"), $("#picture"));
						break;
					case 'unsuccess':
						swal("Something Went Wrong. Please Contact with developer!", {
							icon: "error",
						});
						break;
					case 'error':
						swal("Something Went Wrong!", {
							icon: "error",
						});
						break;
					default:
						swal("Something Went Wrong. Please Contact with developer!", {
							icon: "error",
						});
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Create Book (book/creat.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Edit Book (book/edit.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#bookEditSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2, #errmsg3, #errmsg4, #errmsg5, #errmsg6, #errmsg7").html("");
		$("#errmsgParant").html("");
		let thisclass 			= $(this);
		let styleLoading 		= $(this).siblings(".styleLoading");
		let bookEditSubmit	= $(this).attr("name");
		let bookInfoid 			= $(this).attr("data-infoid_book");
		let dataImgDelete 	= $("#deleteimg").attr("data-img_delete");
		let description 		= editor.getData();

		styleLoading.html("");

		let editBookForm = $("#editBookForm")[0];
		let editBookFormData = new FormData(editBookForm);
		editBookFormData.append("bookEditSubmit", bookEditSubmit);
		editBookFormData.append("bookInfoid", bookInfoid);
		editBookFormData.append("dataImgDelete", dataImgDelete);
		editBookFormData.append("description", description);
		$.ajax({
			type: "POST",
			url: "update.php",
			data: editBookFormData,
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
					if(inputId != null){
						inputId.focus().css({"border": "1px solid #e23e32", "box-shadow": "0rem 0.2rem 1rem rgb(255, 204, 200)"});
					}
				}
				switch(finaldata){
					case 'success':
						swal("Successfully! Book has been updated!", {
							icon: "success",
						});
						break;
					case 'emptybookname':
						$("#errmsg1").html('<p>Name Must Require</p>');
						msgFocus($("#errmsg1"), $("#name"));
						break;
					case 'bookName':
						$("#errmsg1").html('<p>Book Name should be Less than 255 char</p>');
						msgFocus($("#errmsg1"), $("#name"));
						break;
					case 'writerName':
						$("#errmsg2").html('<p>Writer Name should be Less than 255 char</p>')
						msgFocus($("#errmsg2"), $("#writer"));
						break;
					case 'emptyCat':
						$("#errmsg3").html('<p>Category Must Require</p>')
						msgFocus($("#errmsg3"), $("#category"));
						break;
					case 'categorynotfound':
						$("#errmsg3").html('<p>Category not found</p>')
						msgFocus($("#errmsg3"), $("#category"));
						break;
					case 'invalidcat':
						$("#errmsg3").html('<p>Invalid Category</p>')
						msgFocus($("#errmsg3"), $("#category"));
						break;
					case 'emptystock':
						$("#errmsg4").html('<p>Sotck must require</p>')
						msgFocus($("#errmsg4"), $("#stock"));
						break;
					case 'stock':
						$("#errmsg4").html('<p>Sotck should be numeric</p>')
						msgFocus($("#errmsg4"), $("#stock"));
						break;
					case 'shelf':
						$("#errmsg5").html('<p>Book shelf too long</p>')
						msgFocus($("#errmsg5"), $("#shelf"));
						break;
					case 'description':
						$("#errmsg7").html('<p>Description too long!</p>')
						msgFocus($("#errmsg7"), $("#description"));
						break;
					case 'bookImg':
						$("#errmsg6").html('<p>Only "JPEG" or "PNG" or "JPG" support</p>')
						msgFocus($("#errmsg6"), $("#picture"));
						break;
					case 'unsuccess':
						swal("Something Went Wrong. Please Contact with developer!", {
							icon: "error",
						});
						break;
					case 'error':
						swal("Something Went Wrong!", {
							icon: "error",
						});
						break;
					default:
						swal("Something Went Wrong. Please Contact with developer!", {
							icon: "error",
						});
				}
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Edit Book (book/edit.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start:  Status Change Book (book/index.php)
	//-------------------------------------------------------------------
	$(document).on("change", ".bookStatus", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);

		let thisclass = $(this);
		let status = $(this).attr("data-status");
		let id = $(this).attr("data-id");
		let changesubmit = 'bookstatussubmit';

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
							swal("Successfully! Book has been deactivated!", {
								icon: "success",
							});
						}else {
							thisclass.attr("data-status", "1");
							thisclass.next().html('Active');
							swal("Successfully! Book has been activated!", {
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
	});
	//-------------------------------------------------------------------
	// End: Status Change Book (book/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Delete Book (student/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".bookDelBtn", function(e){
		e.preventDefault();

		swal({
		  title: "Are you sure?",
		  text: "Once deleted, You will not be able to recover this book!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
				$(this).prop("disabled", true);

				let thisclass = $(this);
				let bookInfo = $(this).attr("data-book_info");
				let bookDelBtn = $(this).attr("name");
				if(getBasename[0] == 'show.php'){
					var cameFrom = "show";
				}else {
					var cameFrom = "index";
				}

				$.ajax({
					type: "POST",
					url: "delete.php",
					data: {bookInfo:bookInfo, bookDelBtn:bookDelBtn, cameFrom:cameFrom},
					success:function(finaldata){
						thisclass.prop("disabled", false);
						switch(finaldata) {
							case 'success':
								if(getBasename[0] == 'show.php'){
									window.location.href = mainwebroot+"view/book/";
								}else {
									jplist.resetContent(function(){
										thisclass.closest(".eachBookData").remove();
									});
									swal("Successfully! Book has been deleted!", {
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
								swal("Something Went Wrong! Please Contact with developer", {
									icon: "error",
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
		  }
		});

	});
	//-------------------------------------------------------------------
	// End: Delete Book (student/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// Start: Register category (category/create.php)
	//-------------------------------------------------------------------\
	$(document).on("click", "#categoryRegSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2, #errmsg3").html("");
		$("#errmsgParant").html("");

		let styleLoading = $(this).siblings(".styleLoading");
		let thisclass = $(this);
		let categoryRegSubmit = $(this).attr("name");

		styleLoading.html("");

		let regCategoryForm = $("#regCategoryForm")[0];
		let regCategoryFormData = new FormData(regCategoryForm);
		regCategoryFormData.append("categoryRegSubmit", categoryRegSubmit);

		$.ajax({
			type: "POST",
			url: "store.php",
			data: regCategoryFormData,
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
					if(inputId != null){
						inputId.focus().css({"border": "1px solid #e23e32", "box-shadow": "0rem 0.2rem 1rem rgb(255, 204, 200)"});
					}
				}
				switch(finaldata) {
					case 'success':
						window.location.href = mainwebroot+"view/category";
						break;
					case 'emptyname':
						$("#errmsg1").html('<p>Category name must require</p>');
						msgFocus($("#errmsg1"), $("#name"));
						break;
					case 'categoryName':
						$("#errmsg1").html('<p>Too Long! Category name must be less than 60 char</p>');
						msgFocus($("#errmsg1"), $("#facultyName"));
						break;
					case 'parentCategory':
						$("#errmsg2").html('<p>Invalid Parent Category</p>');
						msgFocus($("#errmsg2"), $("#facultyName"));
						break;
					case 'shortDescription':
						$("#errmsg3").html('<p>Too Long! Short Description should be less than 250 charecter</p>');
						msgFocus($("#errmsg3"), $("#shortDescription"));
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
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// End: Register category (category/create.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// Edit Category (category/edit.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#categoryEditSubmit", function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$("#errmsg1, #errmsg2, #errmsg3").html("");
		$("#errmsgParant").html("");

		let styleLoading = $(this).siblings(".styleLoading");
		let thisclass = $(this);
		let categoryEditSubmit = $(this).attr("name");
		let cateinfo = $(this).attr("data-cateinfo");

		styleLoading.html("");

		let editCategoryForm = $("#editCategoryForm")[0];
		let editCategoryFormData = new FormData(editCategoryForm);
		editCategoryFormData.append("categoryEditSubmit", categoryEditSubmit);
		editCategoryFormData.append("cateinfo", cateinfo);

		$.ajax({
			type: "POST",
			url: "update.php",
			data: editCategoryFormData,
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
					if(inputId != null){
						inputId.focus().css({"border": "1px solid #e23e32", "box-shadow": "0rem 0.2rem 1rem rgb(255, 204, 200)"});
					}
				}
				switch(finaldata) {
					case 'success':
						swal("Successfully! Category has been updated!", {
							icon: "success",
						});
						break;
					case 'emptyname':
						$("#errmsg1").html('<p>Category name must require</p>');
						msgFocus($("#errmsg1"), $("#name"));
						break;
					case 'categoryName':
						$("#errmsg1").html('<p>Too Long! Category name must be less than 60 char</p>');
						msgFocus($("#errmsg1"), $("#facultyName"));
						break;
					case 'parentCategory':
						$("#errmsg2").html('<p>Invalid Parent Category</p>');
						msgFocus($("#errmsg2"), $("#facultyName"));
						break;
					case 'shortDescription':
						$("#errmsg3").html('<p>Too Long! Short Description should be less than 250 charecter</p>');
						msgFocus($("#errmsg3"), $("#shortDescription"));
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
			}
		});
		return false;
	});
	//-------------------------------------------------------------------
	// Edit Category (category/edit.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Delete Category(category/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#categoryDelBtn", function(e){
		e.preventDefault();

		swal({
		  title: "Are you sure?",
		  text: "Once deleted, you will not be able to recover this category!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
				$(this).prop("disabled", true);

				let thisclass 			= $(this);
				let catinfo 				= $(this).attr("data-cat_info");
				let categoryDelBtn 	= $(this).attr("name");

				if(getBasename[0] == 'show.php'){ //if start
					var cameFrom 	= "show";
				}else{
					var cameFrom 	= "index";
				}

				$.ajax({
					type: "POST",
					url: "delete.php",
					data: {catinfo:catinfo, categoryDelBtn:categoryDelBtn, cameFrom:cameFrom},
					success:function(finaldata){
						thisclass.prop("disabled", false);
						switch(finaldata) {
							case 'success':
								if(getBasename[0] != 'show.php'){ //if start
									jplist.resetContent(function(){
										thisclass.closest(".eachCategoryData").remove();
									});
									swal("Successfully! Category has been deleted!", {
										icon: "success",
									});
								}else{
									window.location.href = mainwebroot+"view/category/";
								}

								break;
							case 'categoryhas':
								toastr.warning("You can&apos;t Delete it. This category used in a Book.");
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
		  }
		});




	});
	//-------------------------------------------------------------------
	// End: Delete Category(category/index.php)
	//-------------------------------------------------------------------

});
