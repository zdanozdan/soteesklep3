$(function(){
 
    $("#wysuwane").css("left","-210px");
 
$("#wysuwane").hover(
  function () {
    $("#wysuwane").stop().animate({left: "0px"}, 1000 );
        $(this).addClass("zamknij");
  },
  function () {
    $("#wysuwane").stop().animate({left: "-210px"}, 1000 );
        $(this).removeClass("zamknij");
  }
);
});
