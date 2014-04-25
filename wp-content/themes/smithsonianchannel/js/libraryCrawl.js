// working with brightcove player first
var BCL = {};

BCL.onTemplateLoad = function( experienceID ){
  // get references to the player and API Modules and Events
  BCL.player = brightcove.api.getExperience(experienceID);
  BCL.APIModules = brightcove.api.modules.APIModules;
  BCL.contentEvent = brightcove.api.events.ContentEvent;

  // trying to get the playlist
  BCL.playList = brightcove.api.data;

}

BCL.onTemplateReady = function( evt ){
  // console.log("onTemplateReady: ", evt);
  BCL.videoPlayer = BCL.player.getModule(BCL.APIModules.VIDEO_PLAYER);

  // trying to add the content module to the BCL object
  BCL.contentMod = BCL.player.getModule(BCL.APIModules.CONTENT);
  BCL.videoPlayer.getCurrentVideo( BCL.onGetVideo );
}

BCL.onGetVideo = function (videoDTO) {
  // console.log("this is the current video content: ",videoDTO);
  playListID = videoDTO.playlistID;
  // console.log("the playlist id is: ", playListID);

  BCL.contentMod.getPlaylistByID(playListID, BCL.playListObject);

  //setting the displayed title and long description
  $("#displayedTitle").html(videoDTO.displayName);

  if(!videoDTO.longDescription){
		// console.log('no long description');
		$("#displayedDescription").html(videoDTO.shortDescription);

	} else {
		// console.log('long description is here');
		$("#displayedDescription").html(videoDTO.longDescription);

	}
  // api.brightcove.com/services/library?command=search_videos&token=42nLofnCvf5U3L_idEskcOthBakXB4Im6yuTjo7L-t4.
}


// doing some stuff when the document has finished loading
$(document).ready( function(){
	var numOfRibbons = $(".showRibbon").length;
	var numOfLoadedRibbons = 0;
	console.log("the number of ribbons: ", numOfRibbons);
	$(".showRibbon").each(function(){
		// console.log("getting the data attribute: ",$(this).attr("data-show"));
		// defining the search attribute
		doSearch( $(this) );
	})

	// doing the ajax call based on all the different parameters to search against
	function doSearch( s ){

		var container = $(s);
		var sParam = $(s).attr('data-show');

		$.ajax({
				type: "GET",
				url: "../wp-content/themes/smithsonianchannel/brightCoveData.php",
				cache: false,
				data: { 'command':"search_videos",
						'any': "tag:"+sParam},
				dataType: "json",
				success: function( result ){
					
					var numElements = result.items.length;

					if( numElements != 0){
						if( numElements > 15 ){
							numElements = 15;
						}
						container.find('.thumb-outter-container').css('background-image', 'none');
						for(k=0; k<numElements; k++){
							// converting any ' or " to ascii format characters
							var sDescr = result.items[k].shortDescription.replace(/'/g,"&rsquo;");
							if(result.items[k].longDescription)
							{
								var lDescr = result.items[k].longDescription.replace(/'/g,"&rsquo;");
							}
							// adding in the thumbnail images to the ribbon strip
							container.find('ul').append("<li class='thumb-images'><img src='"+result.items[k].thumbnailURL+"' data-sDesc=\""+sDescr+"\" data-lDesc=\""+lDescr+"\" data-vidRef=\""+result.items[k].id+"\" alt=\""+result.items[k].name+"\"/><div class='thumb-title'>"+result.items[k].name+"</div></li>")
							// container.find('div.thumbContainer').css("background-image","none");
						}

					    // adding events to the li elements
					    $(".thumb-images").on("click", switchVid);

						// console.log("this is the container: ", container);
						adjustRibbonLayout( container );
	
					} else {
						container.remove();
					}
				},
				complete: function(){
				},
				error: function( a, b, c ){
				}
			})
	}

	function showDetails( obj ){
		$("#displayedTitle").html($(obj).attr('alt'));

		if(obj.longDescription == undefined){
			$("#displayedDescription").html($(obj).attr('data-sdesc'));
		} else {
			$("#displayedDescription").html($(obj).attr('data-sdesc'));

		}
	}

	function switchVid( evt ){
		var vidRequest = $(evt.currentTarget).children();

		showDetails(vidRequest);

		// load the new vid into the player
		BCL.videoPlayer.loadVideoByID(vidRequest.attr('data-vidref'));

		// making the page scroll back up to the video player
		$('html,body').animate({ scrollTop: $("#BCLcontainingBlock").offset().top },1000);
		
	}
})
