function adjustRibbonLayout( container ){
  // making the vidContainer visible if there were any video thumbnails to show
  $("#vidContent").css("display","block");

  //looking for the number of elements in the ribbon
  if( $(".thumb-images").length < 5 ){
    $(".left-arrow, .right-arrow").css({
                                        opacity : .2,
                                        cursor  : "auto"
                                      });
  }

  var maxWidth = $('.page-container').width();
  var buttonWidth = $(".left-arrow").width();
  var buttonOffset = parseInt($(".left-arrow").css("margin-right"));
  var containerWidth = maxWidth - (buttonWidth + buttonOffset)*2;

  var thumbOutterContainer = container.find('.thumb-outter-container');
  var numElementsInContainer = container.find('li').length;
  var ulThumbContainer = container.find('.video-thumbs');

  // trying get image thumbnails to display propperly at different screen sizes
  if( maxWidth <= 800 && maxWidth > 640){
    var numOfThumbs = 4;
  } else if( maxWidth <= 640 &&  maxWidth > 320){
    numOfThumbs = 3;
  } else if( maxWidth <=320 ){
    numOfThumbs = 2;
  } else {
    numOfThumbs = 5;
  }
  // need to get any 'thumb-images' container other than the first one to get the right amount of margin-left
  var imageMarginSpec = parseInt($(".thumb-images").eq(1).css('margin-left'));

  var spacesRequired = numOfThumbs - 1;
  
  if(maxWidth <=480){
    var thumbImageWidth = ( maxWidth - ( imageMarginSpec*spacesRequired ) )/numOfThumbs;
  } else {
    var thumbImageWidth = ( containerWidth - ( imageMarginSpec*spacesRequired ) )/numOfThumbs;
  }

  var liElementHeight = container.find('.thumb-container').height();

  var widthRemainder = thumbImageWidth % 1;
  var containerAdjustment = widthRemainder*numOfThumbs;

// making sure there are no decimal values in the widths of the images - ever!!!
  $('.thumb-images').css('width', Math.floor(thumbImageWidth));

  // setting the width of the ul element to allow for scrolling
  var cWidth = (Math.floor(thumbImageWidth) * numElementsInContainer) + (numElementsInContainer * imageMarginSpec);


  // adjusting the width of the outter-container so that the thumbnails are all properly displayed
  containerWidth -= containerAdjustment;
  buttonOffset += Math.floor(containerAdjustment/2);

  // trying to get the subtitle height
  // using aspect ratio to get the new image height (original height / original width x new width = new height) - 16X9
  var imgWidth = thumbOutterContainer.width()/2 - imageMarginSpec;
  var imgHeight = Math.floor((9/16)*$(".thumb-images").find('img').width());
  var subTitleHeight = $(".thumb-title").height() + parseInt($('.thumb-title').css('margin-top'));
  var tHeight = imgHeight + subTitleHeight;

  if( maxWidth <= 480 )
  {  
    // setting the height of the thumb-outter-container
    var containerHeight = tHeight*2+parseInt(container.find('li').css('margin-bottom'));
    var containerHalfHeight = tHeight+parseInt(container.find('li').css('margin-bottom'));

    if(numElementsInContainer > 3){
      $(".thumb-outter-container").css({
        width   : maxWidth
      });
      thumbOutterContainer.height(containerHeight);
    } else {
      $(".thumb-outter-container").css({
        width   : maxWidth
      });
      thumbOutterContainer.height(containerHalfHeight);
    }
    ulThumbContainer.css("width", '100%');

  } else {
    $(".thumb-outter-container").css({
      width   : containerWidth
    });

    thumbOutterContainer.height(tHeight);

    ulThumbContainer.css("width", cWidth);
  }

  $(".left-arrow").css("margin-right", buttonOffset);

}

$(document).ready(function(){
  // flag to change if the ribbon is in animation
  var isAnimated = false;
  var scrollSpeed = 250;

  // eventlisteners for the arrow buttons
  $(".left-arrow").on("click", directionToMove);
  $(".right-arrow").on("click", directionToMove);

  var ribbonArrowActivation = [];

  // setting up the conditional user feed back variables for each ribbon.
  var ribLength = $(".showRibbon").length;
  $(".showRibbon").each( function(){

    var ribbonIndicator = {};
    ribbonIndicator.moveLeft = false;
    ribbonIndicator.moveRight = true;
    ribbonIndicator.name = $(this).attr("data-show");
    ribbonArrowActivation.push(ribbonIndicator);
  });

  // This is a debounced onresize handler
  function on_resize(c, t) {
    onresize = function() {
      clearTimeout(t);
      t = setTimeout(c, 100)
    };
    return c
  };

  on_resize(resizeAllRibbons);
  
  function resizeAllRibbons(){
    $('.thumb-outter-container').each( function(){
      adjustRibbonLayout( $(this) );
    })
  }

  function makeActive( obj ){
    switch( obj.attr('class') ){
      case 'right-arrow':
        obj.siblings(".left-arrow").css("opacity", 1);
        break;

      case 'left-arrow':
        obj.siblings(".right-arrow").css("opacity", 1);
        break;
    }

    return true;
  }

  function makeInactive( obj ){
    obj.css('opacity', .2);
    return false;
  }

  function directionToMove( evt ){

    if(isAnimated == false){  

      var bClicked = $(evt.target);

      // the parent container of the button clicked:
      var parent = bClicked.parent();
      var ribbonTitle = $(parent).attr('data-show');

      for( var i=0; i<ribLength; i++){
        if( ribbonTitle == $(".showRibbon").eq(i).attr("data-show") ){
          var currentIndex = i;
          break;
        } 
      }

      // get the position of the ul element
      var container = bClicked.siblings( ".thumb-outter-container" ).children();
      var cWidth = container.width();
      var p = container.position();
      
      var thumbCount = container.find(".thumb-images").length;

      // margin-left value of any list element excluding the first element
      var mL = parseInt($('.thumb-images').eq(1).css("margin-left"));
  
      // get the calculated with of the parent container
      var pCWidth = $(".thumb-outter-container").width();

      var moveFullWidth = pCWidth+mL;

      if(thumbCount > 5){
        isAnimated = true; 
        switch( bClicked.attr('class') ){
          case "left-arrow":

            if(!ribbonArrowActivation[currentIndex].moveRight){
              moveRight = makeActive( bClicked );
              bClicked.siblings(".right-arrow").css("opacity", 1);
            }

            if( p.left < -1 && (p.left + pCWidth) < 1){
              // move full width to the right
              container.animate({ "left": "+="+(pCWidth + mL)+"px" }, scrollSpeed, "linear", function() {
                p = container.position();

                if(p.left == 0){
                  ribbonArrowActivation[currentIndex].moveLeft = makeInactive( bClicked );
                }

                isAnimated = false;
              }); 
            } else if ( p.left <= 0 ){ 
              var remainder = Math.abs(p.left);
              container.animate({ "left": "+="+(remainder)+"px" }, scrollSpeed, "linear", function() {
                p = container.position();
                isAnimated = false;
                ribbonArrowActivation[currentIndex].moveLeft = makeInactive( bClicked );
              });
            }
            break;
  
          case 'right-arrow':
            if(!ribbonArrowActivation[currentIndex].moveLeft){
              ribbonArrowActivation[currentIndex].moveLeft = makeActive( bClicked );
              bClicked.siblings(".left-arrow").css('opacity', 1);
            }
            if( p.left < 1 && (Math.abs(p.left) + pCWidth) < (cWidth - pCWidth)){
                container.animate({ "left": "-="+(pCWidth+mL)+"px" }, scrollSpeed, "linear", function() {
                  p = container.position();

                  if(Math.abs(p.left) - moveFullWidth == moveFullWidth){
                     ribbonArrowActivation[currentIndex].moveRight = makeInactive( bClicked );
                  }

                  isAnimated = false;
              });
            } else {
              var remainder = cWidth - (Math.abs(p.left)+pCWidth);
  
              container.animate({ "left": "-="+(remainder-mL)+"px" }, scrollSpeed, "linear", function() {
                p = container.position();
                isAnimated = false;
                ribbonArrowActivation[currentIndex].moveRight = makeInactive( bClicked );
              });
            }
            break;
        }
      }
    }    
  }



});
	