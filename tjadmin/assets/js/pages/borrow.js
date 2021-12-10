"use strict";
$(document).ready(function(){
	var mainwebroot = window.location.origin+"/tjadmin/";
	var domain = window.location.origin+"/";
	var currentUrl 	= window.location.href;
	var getPath  = window.location.pathname.split( '/' );
	var getBasename = getPath.reverse();
	console.log(getBasename[0]);

	//-------------------------------------------------------------------
	// start: Common Js (book section)
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
	//-------------------------------------------------------------------
	// End: Common Js (book section)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Pagination control (borrow/index.php)
	//-------------------------------------------------------------------
	// $(document).on("click", ".page-item", function(e){
	// 	e.preventDefault();
	// 	let pageNo = $(this).attr('data-page');
	// 	let method = 'pagination';
	//
	// 	// console.log();
	// 	$.ajax({
	// 		type: "POST",
	// 		url: "pagination.php",
  //     data: {pageNo:pageNo, method:method},
  //     success:function(finaldata){
	// 		}
	// 	});
	// 	return false;
	// });
	//-------------------------------------------------------------------
	// End: Pagination control (borrow/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Accept (borrow/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".borrowAccept", function(e){
		e.preventDefault();
		swal({
		  title: "Are you sure?",
		  text: "to Accept this request!",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
				$(this).prop("disabled", true);

				let thisClass 		= $(this);
				let borrow_info 	= $(this).attr('data-borrow_info');
				let borrowAccept 	= $(this).attr('name');

				if(getBasename[0] != 'show.php'){ //if start
					var actionParant 	= thisClass.closest('.actionParant');
					var actionChild		= actionParant.find('.actionChild');
					var card_count		= actionChild.attr('data-card_count'); //get the counter number of this card

					var returnDateParent 	=  actionParant.siblings('.returnDateParent');
					var returnDateChild		= returnDateParent.find('.returnDateChild');
				}

				// console.log();
				$.ajax({
					type: "POST",
					url: "accept.php",
		      data: {borrow_info:borrow_info, borrowAccept:borrowAccept},
		      success:function(finaldata){
						console.log(finaldata);
		        switch(finaldata){							
							case 'success':
								if(getBasename[0] != 'show.php'){ //if start
									actionParant.load(location.href + " #actionChild"+card_count);
									returnDateParent.load(location.href + " #returnDateChild"+card_count);
								}else{
									$('#actionParant').load(location.href + " #actionChild");
									$('#returnDateParent').load(location.href + " #returnDateChild");
								}
								swal("Successfully! Borrow request has been accepted!", {
									icon: "success",
								});

								break;
							case 'stockout':
								swal("Book is not available in stock!", {
									icon: "error",
								});
								break;
							case 'booknotfound':
								swal("Book is not found!", {
									icon: "error",
								});
								break;
							case 'unsuccess':
								swal("Accept is unsuccessfully. Something went wrong!", {
									icon: "error",
								});
								break;
							case 'error':
								swal("Something went wrong. Please contact with developer!", {
									icon: "error",
								});
								break;
							default:
								swal("Something went wrong. Please contact with developer!", {
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
	// End: Accept (borrow/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Reject (borrow/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".borrowReject", function(e){
		e.preventDefault();
			swal({
			  title: "Are you sure?",
			  text: "to Reject this request!",
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

					if(getBasename[0] == 'show.php'){ //if start
						var cameFrom 	= "show";
					}else{
						var cameFrom 	= "index";
					}

					// console.log();
					$.ajax({
						type: "POST",
						url: "reject.php",
			      data: {borrow_info:borrow_info, borrowReject:borrowReject, cameFrom:cameFrom},
			      success:function(finaldata){
							console.log(finaldata);
			        switch(finaldata){
								case 'success':
									if(getBasename[0] != 'show.php'){ //if start
										jplist.resetContent(function(){
												$("#eachData"+borrow_info).remove();
										});
										swal("Successfully! Borrow request has been rejected.", {
								      icon: "success",
								    });
									}else{
										window.location.href = mainwebroot+"view/borrow/";
									}
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
	// End: Reject (borrow/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Return (borrow/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".borrowReturn", function(e){
		e.preventDefault();
		swal({
		  title: "Are you sure?",
		  text: "to return this book?",
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {

				$(this).prop("disabled", true);

				let thisClass 		= $(this);
				let borrow_info 	= $(this).attr('data-borrow_info');
				let borrowReturn 	= $(this).attr('name');

				if(getBasename[0] == 'show.php'){ //if start
					var cameFrom 	= "show";
				}else{
					var cameFrom 	= "index";
				}

				// console.log();
				$.ajax({
					type: "POST",
					url: "return.php",
		      data: {borrow_info:borrow_info, borrowReturn:borrowReturn, cameFrom:cameFrom},
		      success:function(finaldata){
		        switch(finaldata){
							case 'success':
								if(getBasename[0] != 'show.php'){ //if start
									jplist.resetContent(function(){
											$("#eachData"+borrow_info).remove();
									});
									swal("Successfully! Book has been returned.", {
										icon: "success",
									});
								}else{
									window.location.href = mainwebroot+"view/borrow/";
								}
								break;
							case 'booknotfound':
								swal("Book is not found in database which you want to give back. Please contact with developer.", {
									icon: "error",
								});
								break;
							case 'unsuccess':
								swal("Something went wrong. Please contact with developer.", {
									icon: "error",
								});
								break;
							case 'error':
								swal("Something went wrong.", {
									icon: "error",
								});
								break;
							default:
								swal("Something went wrong. Please contact with developer.", {
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
	// End: Return (borrow/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Renew (borrow/index.php)
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


 			if(getBasename[0] != 'show.php'){ //if start
 				var actionParant 	= thisClass.closest('.actionParant');
 				var actionChild		= actionParant.find('.actionChild');
 				var card_count		= actionChild.attr('data-card_count'); //get the counter number of this card

 				var returnDateParent 	=  actionParant.siblings('.returnDateParent');
 				var returnDateChild		= returnDateParent.find('.returnDateChild');
 			} //end if

 			// console.log();
 			$.ajax({
 				type: "POST",
 				url: "renew.php",
 	      data: {borrow_info:borrow_info, borrowRenewSubmit:borrowRenewSubmit, returnDate:returnDate},
 	      success:function(finaldata){
 	        switch(finaldata){
 						case 'success':
 							if(getBasename[0] != 'show.php'){ //if start
 								actionParant.load(location.href + " #actionChild"+card_count);
 								returnDateParent.load(location.href + " #returnDateChild"+card_count);
 							}else{
 								$('#actionParant').load(location.href + " #actionChild");
 								$('#returnDateParent').load(location.href + " #returnDateChild");
 							}
							swal("Successfully! Book has been renewed.", {
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
							swal("Something went wrong!", {
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
	// End: Renew (borrow/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Search Student input portion (borrow/create.php)
	//-------------------------------------------------------------------
	$(document).on("keyup", "#studentNames", function(e){
		e.preventDefault();
		let thisclass = $(this);
		let searchdata 		= $(this).val();
		let inputname 		= $(this).attr('name');

		if(searchdata.length == 0){
			$("#searchStudentNameDropDown").html('');
			$("#searchStudentNameDropDown").css('display', 'none');
		}else {
			$.ajax({
				type: "POST",
				async: true,
				url: "student.php",
				data: {searchdata:searchdata, inputname:inputname},
				cache: false,
				success:function(finaldata){
					var data = "";
					var eachData = "";
					// console.log(finaldata);
					data = JSON.parse(finaldata);
					if(data == 'notfound'){
						$("#searchStudentNameDropDown").css('display', 'block');
						eachData = '<p class="px-3">Data not found</p>'
					}else{
						$("#searchStudentNameDropDown").css('display', 'block');
						for(var i = 0; i<data.length; i++){
							var getPic =  data[i].picture;
							if(getPic.length == 0){
								getPic = domain+'assets/img/avatar-man.png';
							}else {
								getPic = domain+'/upload/user/'+data[i].picture;
							}
			        // var eachData = res + '<p>' + data[i].servername +'</p>';
			        eachData = eachData + '<a href="#" class="dropdown-item eachStudent" data-std_id="'+data[i].id+'" data-std_name="'+data[i].name+'"><div class="media"><img src="'+getPic+'" alt="User Avatar" class="img-size-50 mr-3 img-circle"><div class="media-body"><h3 class="dropdown-item-title">'+ data[i].name +'</h3><p class="text-sm text-muted">ID: '+data[i].student_id+'</p></div></div></a><div class="dropdown-divider"></div>';
			    	}
					}
					$("#searchStudentNameDropDown").html(eachData);
				}
			});
		}
		return false;
	});
	$(document).on("click", ".eachStudent", function(e){
		e.preventDefault();
		let thisclass = $(this);
		let stdId 		= $(this).attr('data-std_id');
		let stdName 	= $(this).attr('data-std_name');

		$('#studentNames').val(stdName);
		$('#studentNames').attr('data-std_id', stdId);
		$("#searchStudentNameDropDown").html('');
		$("#searchStudentNameDropDown").css('display','none');
		return false;
	});
	//-------------------------------------------------------------------
	// End: Search Student input portion (borrow/create.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Search Book input portion (borrow/create.php)
	//-------------------------------------------------------------------
	$(document).on("keyup", "#bookNames", function(e){
		e.preventDefault();
		let thisclass = $(this);
		let searchdata 		= $(this).val();
		let inputname 		= $(this).attr('name');

		if(searchdata.length == 0){
			$("#searchBookNameDropDown").html('');
			$("#searchBookNameDropDown").css('display', 'none');
		}else {
			$.ajax({
				type: "POST",
				async: true,
				url: "book.php",
				data: {searchdata:searchdata, inputname:inputname},
				cache: false,
				success:function(finaldata){
					var data = "";
					var eachData = "";
					// console.log(finaldata);
					data = JSON.parse(finaldata);
					if(data == 'notfound'){
						$("#searchBookNameDropDown").css('display', 'block');
						eachData = '<p class="px-3">Data not found</p>'
					}else{
						$("#searchBookNameDropDown").css('display', 'block');
						for(var i = 0; i<data.length; i++){
							var getPic =  data[i].picture;
							if(getPic.length == 0){
								getPic = domain+'assets/img/dummybook.jpg';
							}else {
								getPic = domain+'/upload/book/'+data[i].picture;
							}
			        // var eachData = res + '<p>' + data[i].servername +'</p>';
			        eachData = eachData + '<a href="#" class="dropdown-item eachBook" data-book_id="'+data[i].id+'" data-book_name="'+data[i].book_name+'"><div class="media"><img src="'+getPic+'" alt="User Avatar" class="img-size-50 mr-3"><div class="media-body"><h3 class="dropdown-item-title">'+ data[i].book_name +'</h3><p class="text-sm text-muted">Book No: '+ data[i].book_id +'</p></div></div></a><div class="dropdown-divider"></div>';
			    	}
					}
					$("#searchBookNameDropDown").html(eachData);
				}
			});
		}
		return false;
	});
	$(document).on("click", ".eachBook", function(e){
		e.preventDefault();
		let thisclass = $(this);
		let bookid 		= $(this).attr('data-book_id');
		let bookName 	= $(this).attr('data-book_name');

		$('#bookNames').val(bookName);
		$('#bookNames').attr('data-book_id', bookid);
		$("#searchBookNameDropDown").html('');
		$("#searchBookNameDropDown").css('display','none');
		return false;
	});
	//-------------------------------------------------------------------
	// End: Search Book input portion (borrow/create.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Borrow Book (borrow/create.php)
	//-------------------------------------------------------------------
	$(document).on("click", "#borrowNow", function(e){
		e.preventDefault();
		let thisclass = $(this);
		thisclass.prop("disabled", false);

		let stdnID 				= $('#studentNames').attr('data-std_id');
		let dataID 				= $('#bookNames').attr('data-book_id');
		let borrowNow 		= $(this).attr('name');
		let booking 			= $('#reservation').val();

		$.ajax({
			type: "POST",
			url: "borrow.php",
			data: {stdnID:stdnID, dataID:dataID, borrowNow:borrowNow, booking:booking},
			beforeSend: function(){
				thisclass.html('Borrow Now <span class="spinner-border spinner-border-sm ml-2"></span>');
			},
			success:function(finaldata){
				console.log(finaldata);
				thisclass.html('Borrow Now');
				thisclass.prop("disabled", false);

				function msgFocus(selectId, inputId){
					$('html, body').animate({
						scrollTop: selectId.offset().top-300
					}, 1500);
					inputId.addClass('is-invalid');;
				}

				switch(finaldata){
					case 'success':
						window.location.href = mainwebroot+"view/borrow/";
						break;
					case 'emptystudent':
						$("#errmsg1").html('Student name Must Require.');
						msgFocus($("#errmsg1"), $("#studentNames"));
						break;
					case 'emptybook':
						$("#errmsg2").html('Book Must Require');
						msgFocus($("#errmsg2"), $("#bookNames"));
						break;
					case 'alreadyborrow':
						$("#errmsg2").html('This book already borrowed the selected student');
						msgFocus($("#errmsg2"), $("#bookNames"));
						break;
					case 'emptyreturn':
						$("#errmsg3").html('Return date must require');
						msgFocus($("#errmsg3"), $("#reservation"));
						break;
					case 'invaliddate':
						$("#errmsg3").html('Date must more than today');
						msgFocus($("#errmsg3"), $("#reservation"));
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
	// End: Borrow Book (borrow/create.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Accept Renew request (renew/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".acceptRenew", function(e){
		e.preventDefault();
		swal({
			title: "Are you sure?",
			text: "to accept request to renew this book!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
		 if (willDelete) {
			 $(this).prop("disabled", true);

				let thisClass 		= $(this);
				let renew_info 		= $(this).attr('data-renew_info');
				let acceptRenew 	= $(this).attr('name');

				if(getBasename[0] != 'show.php'){ //if start
	 				var actionParant 	= thisClass.closest('.actionParant');
	 				var actionChild		= actionParant.find('.actionChild');
	 				var card_count		= actionChild.attr('data-card_count'); //get the counter number of this card

	 				// var returnDateParent 	=  actionParant.siblings('.returnDateParent');
	 				// var returnDateChild		= returnDateParent.find('.returnDateChild');
	 			} //end if

				$.ajax({
					type: "POST",
					url: "accept.php",
		      data: {renew_info:renew_info, acceptRenew:acceptRenew},
		      success:function(finaldata){
						console.log(finaldata);
		        switch(finaldata){
							case 'success':
								if(getBasename[0] != 'show.php'){ //if start
									actionParant.load(location.href + " #actionChild"+card_count);
									$('#renewCheckedBoxParent'+card_count).load(location.href + " #renewCheckedBoxChild"+card_count);
								}else{
									$('#actionParant').load(location.href + " #actionChild");
								}
								swal("Successfully! Request has been accepted.", {
									icon: "success",
								});
								break;
							case 'unsuccess':
								swal("Something went wrong!", {
									icon: "error",
								});
								break;
							case 'invaliddate':
								swal("Please select a date which more than present return date!", {
									icon: "error",
								});
								break;
							case 'error':
								swal("Something went wrong. Please contact with developer!", {
									icon: "error",
								});
								break;
							default:
								swal("Something went wrong. Please contact with developer!", {
									icon: "error",
								});
						}
						thisClass.prop("disabled", false);
					}
				});
				return false;
		 }
		});


	});
	//-------------------------------------------------------------------
	// End: Accept Renew request (renew/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Reject Renew request (renew/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".rejectRenew", function(e){
		e.preventDefault();
			swal({
		   title: "Are you sure?",
		   text: "Once rejected, you will not be able to recover this request!",
		   icon: "warning",
		   buttons: true,
		   dangerMode: true,
		 })
		 .then((willDelete) => {
		   if (willDelete) {
				 $(this).prop("disabled", true);

	 			let thisClass 		= $(this);
	 			let renew_info 		= $(this).attr('data-renew_info');
	 			let rejectRenew 	= $(this).attr('name');

				if(getBasename[0] == 'show.php'){
					var cameFrom = "show";
				}else {
					var cameFrom = "index";
				}

	 			$.ajax({
	 				type: "POST",
	 				url: "reject.php",
	 	      data: {renew_info:renew_info, rejectRenew:rejectRenew, cameFrom:cameFrom},
	 	      success:function(finaldata){
	 	        switch(finaldata){
	 						case 'success':
	 							if(getBasename[0] != 'show.php'){ //if start
									jplist.resetContent(function(){
										$("#eachData"+renew_info).remove();
									});
									swal("Successfully! Renew request has been rejected.", {
										icon: "success",
									});
	 							}else{
	 								window.location.href = mainwebroot+"view/renew/";
	 							}
	 							break;
	 						case 'unsuccess':
								swal("Something went wrong!", {
									icon: "error",
								});
	 							break;
	 						case 'error':
								swal("Something went wrong!", {
									icon: "error",
								});
	 							break;
	 						default:
								swal("Something went wrong. Please contact with developer.", {
									icon: "error",
								});
	 					}
	 					thisClass.prop("disabled", false);
	 				}
	 			});
	 			return false;
		   }
		 });
	});
	//-------------------------------------------------------------------
	// End: Reject Renew request (renew/index.php)
	//-------------------------------------------------------------------

	//-------------------------------------------------------------------
	// start: Delete Renew request (renew/index.php)
	//-------------------------------------------------------------------
	$(document).on("click", ".deleteRenew", function(e){
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

				let thisClass 		= $(this);
				let deleteRenew 	= $(this).attr('name');

				if(getBasename[0] == 'show.php'){
					var cameFrom = "show";
				}else {
					var cameFrom = "index";
				}

				let renewDelete = $("#renewDelete")[0];
				let renewDeleteFormData = new FormData(renewDelete);
				renewDeleteFormData.append("deleteRenew", deleteRenew);
				renewDeleteFormData.append("cameFrom", cameFrom);

				if(renewDeleteFormData.get("checkedrenewrequest[]") == null){
					swal("You must select an item!", {
						icon: "error",
					});
					thisClass.prop("disabled", false);
				}else{
					$.ajax({
						type: "POST",
						url: "delete.php",
						data: renewDeleteFormData,
						processData: false,
						contentType: false,
						cache: false,
						success:function(finaldata){
							switch(finaldata){
								case 'success':
									if(getBasename[0] != 'show.php'){ //if start

										for (let [key, value] of renewDeleteFormData.entries()) {
										  // console.log(key, ':', value);
											jplist.resetContent(function(){
							            $("#eachData"+value).remove();
							        });
										}
										swal("Successfully! Item has been deleted.", {
											icon: "success",
										});
									}else{
										window.location.href = mainwebroot+"view/renew/";
									}
									break;
								case 'unsuccess':
									swal("Something went wrong!", {
										icon: "error",
									});
									break;
								case 'notpermission':
									swal("you can't delete which you didn't response yet", {
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
							thisClass.prop("disabled", false);
						}
					});
				}
				return false;
		  }
		});
	});
	//-------------------------------------------------------------------
	// End: Delete Renew request (renew/index.php)
	//-------------------------------------------------------------------


});
