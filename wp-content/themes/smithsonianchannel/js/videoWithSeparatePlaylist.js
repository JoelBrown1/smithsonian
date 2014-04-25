var $ = jQuery;
// console.log("the jquery object is: ",$);
var isLoaded = false;
var BCL = {};

// vars for show page specifically
var playListID;

// logging
BCL.log = function (message) {
  if (window["console"] && console["log"]) {
    var d = new Date();
  };
};

BCL.onTemplateLoad = function( experienceID ){
	BCL.log("template loaded");
  // get references to the player and API Modules and Events
  BCL.player = brightcove.api.getExperience(experienceID);
  BCL.APIModules = brightcove.api.modules.APIModules;
  BCL.adEvent = brightcove.api.events.AdEvent;
  BCL.contentEvent = brightcove.api.events.ContentEvent;
  BCL.mediaEvent = brightcove.api.events.MediaEvent;

  // trying to get the playlist
  BCL.playList = brightcove.api.data;
}

BCL.onTemplateReady = function( evt ){
  
  BCL.videoPlayer = BCL.player.getModule(BCL.APIModules.VIDEO_PLAYER);

  // trying to add the content module to the BCL object
  BCL.contentMod = BCL.player.getModule(BCL.APIModules.CONTENT);
  BCL.videoPlayer.getCurrentVideo( BCL.onGetVideo );

  BCL.videoPlayer.addEventListener(BCL.mediaEvent.CHANGE, BCL.vidChange);
}

BCL.onGetVideo = function (videoDTO) {
  playListID = videoDTO.playlistID;

  BCL.contentMod.getPlaylistByID(playListID, BCL.playListObject)
  BCL.loadVidDetails(videoDTO);
}

BCL.loadVidDetails = function ( obj ){
   // setting the initial video title and description
  $("#displayedTitle").html(obj.displayName);
  if(!obj.longDescription){
    $("#displayedDescription").html(obj.shortDescription);
  } else {
    $("#displayedDescription").html(obj.longDescription);
  }
}

BCL.playListObject = function ( con ){
  // looping through all the objects returned
  console.log("elements returned to the playlist object: ", con);
  if(con != null){
    console.log("what does con equal: ", (con == null));
    if(con.videos.length != 0 || con.videos.length != 1){
      if( !isLoaded ){  

        var ribbonLength = con.videos.length;   
        if( con.videos.length > 15 ){
          ribbonLength = 15;
        }   
        $('.thumb-outter-container').css('background-image', 'none');
        // populating the thumbnails or the episodes that are available
        for(var i=0; i<ribbonLength; i++){

          var v = con.videos[i];

          var displayName = v.displayName.replace(/'/g,"&rsquo;");
          displayName = v.displayName.replace(/"/g,"&#8220;");

          var sDesc = v.shortDescription.replace(/'/g,"&rsquo;");
          sDesc = v.shortDescription.replace(/"/g,"&#8220;");

          if(v.longDescription != null){
            var lDesc = v.longDescription.replace(/'/g,"&rsquo;");
            lDesc = v.longDescription.replace(/"/g,"&#8220;");
          } 

          $('.video-thumbs').append("<li class='thumb-images'><img src='"+v.thumbnailURL+"' data-id='"+v.id+"' data-Title=\""+v.displayName+"\"data-sDescr=\""+sDesc+"\" data-lDescr=\""+lDesc+"\"/><div class='thumb-title'>"+v.displayName+"</div></li>");
       }
  
        isLoaded = true;
      }


      adjustRibbonLayout( $('#videos') );
      $(".thumb-images").on('click', BCL.getData); 
  
    } else {
      $("#videos h4").css("display", "none");
      $("#episodes").css("display", "none");
    }
  } else {
    $("h4").hide();
    $("#episodes").hide();
    $("#videos hr").hide();
  }
}

BCL.getData = function ( evt ){
  var obj = $(evt.target);

  var vID = obj.attr('data-id');
  BCL.videoPlayer.loadVideoByID(vID);

  $("#displayedTitle").html($(obj).attr('data-Title'));

  if(obj.longDescription == undefined){
    $("#displayedDescription").html($(obj).attr('data-sdescr'));
  } else {
    $("#displayedDescription").html($(obj).attr('data-ldescr'));

  }

}

BCL.vidChange = function ( evt ){
  BCL.videoPlayer.play();

  // making the page scroll back up to the video player
  $('html,body').animate({ scrollTop: $("#myExperience").offset().top - 25},1000);
}
