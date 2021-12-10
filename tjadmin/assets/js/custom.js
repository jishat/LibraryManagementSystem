$(window).on('load', function(){
  $('.overlay').fadeOut('slow');
  
});
$(document).ready(function(){
  var domain = "http://"+window.location.hostname+"/ciu/";
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#selectedavatar').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $(document).on("click", "#uploadimg", function(e){
    e.preventDefault();
    $(this).next().attr('data-img_delete', '0');
    $("#ImgInput").click();
      $("#ImgInput").change(function() {
        readURL(this);
      });
  });



  $('[data-toggle="tooltip"]').tooltip();
});
