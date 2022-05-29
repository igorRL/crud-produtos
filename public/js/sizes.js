function sizeOfThings(){
  var screenWidth = $( window ).width();
  var screenHeight = $( window ).height();
  $(".screen-width").css("width",screenWidth);
  $(".screen-height").css("height",screenHeight);
  $(".min-screen-height").css("min-height",screenHeight);
};

sizeOfThings();
window.addEventListener('resize', function(){
  sizeOfThings();
});