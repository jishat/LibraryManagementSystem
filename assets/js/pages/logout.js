$(document).ready(function(){
//-------------------------------------------------------------------
// Start: Logout Account
//-------------------------------------------------------------------
$(document).on("click", "#logout", function(e){
  e.preventDefault();
  $(this).prop("disabled", true);

  var thisclass = $(this);
  var admnLogout = $(this).attr("data-name");

  $.ajax({
    type: "POST",
    url: "http://"+window.location.hostname+"/tjadmin/action/logout.php",
    data: {admnLogout:admnLogout},
    success:function(finaldata){
      console.log(finaldata);
      thisclass.prop("disabled", false);
      switch(finaldata) {
        case 'success':
          window.location.href = "http://"+window.location.hostname+"/tjadmin";
          break;
        default:
          toastr.warning('Something Went Wrong. Please Contact with developer')
      }
    }
  });
  return false;
});
//-------------------------------------------------------------------
// Start: Logout Account
//-------------------------------------------------------------------

});
