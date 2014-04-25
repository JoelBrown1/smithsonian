
$(document).ready(function(){
	var $ = jQuery;
	var isShowing = false;
	var eMessage = false;
	var calendarVis = true;
	var calHideable = false;

	if($(window).width()<800){
		calendarVis = false;
		calHideable = true;
	}

	$(window).on('resize', toggleCheck);
// && $(".calendar-wrapper").css('display') == 'none'
	function toggleCheck( evt ){
		if($(".toggleSchedule").css('display') !== "none" && $(window).width()<800){
			$(".calendar-wrapper").css('display', 'none');
			calendarVis = false;
			calHideable = true;
		} else if($(window).width()>800){
			calendarVis = true;
			$(".calendar-wrapper").css('display', 'block');
			calHideable = false;
		}
	}

	$(".toggleSchedule").on("click", toggleMenu);

	function toggleMenu( evt ){
        evt.preventDefault();
        if($(evt.target).hasClass('ui-icon')) { 
        	var elClicked = true; 
        } else { 
        	elClicked = false; 
        };
        evt.stopPropagation();
        if (!calendarVis) {
            //Search is currently hidden. Slide down and show it.
            $(".calendar-wrapper").slideDown(200);
            $(".toggleSchedule").focus(); //Set focus on the search input field.
            $('body').on("click", toggleMenu);
            calendarVis = true; //Set search visible flag to visible.
        } else {
        	if( !$(evt.target).hasClass('ui-icon') ){
        		hideMenu();
        	}
            //Search is currently showing. Slide it back up and hide it.
			// 
        }
	}

	function hideMenu(){
        	$('body').off("click");
            $(".calendar-wrapper").slideUp(200);
            calendarVis = false;
	}

	if($(".toggleSchedule").css('display') !== "none"){
		console.log("this toggle switch is visible...");
	}
	// var dailySchedule = <?php echo json_encode($scheduleXML) ?>;
	$("#scheduleScroller").append("<ul class='scheduleList'></ul>");

	loadSchedule(dailySchedule);

	function loadSchedule(data){
		if(isShowing){

			$('.scheduleList').animate( { opacity: 0 }, 500, "linear", function(){ 
				$('.scheduleList').empty();

				popList(data);

				$('.scheduleList').animate( { opacity: 1 }, 500, "linear");
			} );
		} else {
			popList(data);
		}

		isShowing = true;
	}

	function popList(data){
		console.log("this is the schedule data: ", data);
		if( data == "null"){

			eMessage = true;
			console.log("the error message: "+eMessage);
			$("#scheduleScroller").append("<div id='errorMessage'><strong>Sorry.</strong> There is no schedule available yet for the date that you have selected. Please pick another date.</div>")
		} else {
			for(i=0; i<data.Clip.length; i++){

				// breaking down the data into individual function calls so that it is easier to understand and change
				var showTime = getShowTime(data.Clip[i].PlayAt);
				
				var sTitle = getProperTitle(data.Clip[i].Title);

				var eTitle = data.Clip[i].Episode;

				var eSummary = data.Clip[i].EpisodeSummary;
				// this line is to be used when all the show details are available... show title, episode title, short description etc.
				$(".scheduleList").append("<li class='showInfo clearfix'><div class='showTime'>"+ showTime +"</div><div class='sInfoContainer '><div class='showTitle'>"+ sTitle +"</div><div class='eArrow'></div><div class='episodeTitle'>"+eTitle+"</div><div class='sDescription'>"+eSummary+"</div></div></li>");
			}

			// adding the click event to the eArrow container
			$(".eArrow").on("click", showDescription);
		}
		$()
	}

	function showDescription( evt ){

		var clicked = $(evt.target);
		var descriptor = $(evt.target).parent().find($(".sDescription"));
		if($(descriptor).css("display") == "none"){

			$(descriptor).css("display", "inline-block");
			$(clicked).css("background-position", "top right");
		} else {
			$(descriptor).css("display", "none");	
			$(clicked).css("background-position", "top left");
		}
	}

	function getProperTitle(data){

		var c = data.search("; ");
		if( c != -1){

			var p2 = data.substring( 0, c );
			var p1 = data.substring( c+2, data.length);
			data = p1+" "+p2;

		} 
		return data;
	}

	function getShowTime( data ){

		var showTime = data.substr(0, 5);

		var time = Number(data.substring(0,2));
		// getting the minute values for the haolf hour
		var mins = Number(data.substring(3,5));
		if(mins === 0){
			showTime = showTime.substring(0,2);
		}

		if( time > 11 ){
			if( time > 12 ){
				var afternoonTime = time - 12;
				showTime = showTime.replace(time, String(afternoonTime));
			}
			// adding the PM to the time stamp 
			showTime = showTime+" PM";
		} else {
			//removing the 0 if it is the first character
			if( showTime.substring(0,2) == "00"){
				showTime = showTime.replace("00", "12");
			}

			if( showTime.charAt(0) == "0")
			{
				showTime = showTime.substr(1, 5);
			}

			// adding the am to the time stamp
			showTime = showTime+" AM";
		}

		return showTime
	}


	$('#scheduleData').ready(function() {
	    $(".dmloader").fadeOut('slow');
	});

	function clearContent(){
		$('.scheduleList').empty();
	}

	$(function() {
		$( "#calenderSchedule" ).datepicker({
			dayNamesMin		: [ "S", "M", "T", "W", "T", "F", "S" ],
			monthNames	: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
			monthNamesShort	: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],

			inline: true,
			// dateFormat: 'yymmdd',
			changeMonth: false,
			onSelect: function(dateText, inst){
				console.log("we clicked on: ",inst);
				if(eMessage){
					eMessage = false;
					$("#errorMessage").remove();
				}

				var rawDate = $(this).datepicker('getDate');

				var dateRequest = $.datepicker.formatDate('yy', rawDate)+$.datepicker.formatDate('mm', rawDate)+$.datepicker.formatDate('dd', rawDate);

				$("#dateToDisplay").html($.datepicker.formatDate('d', rawDate));
				$("#selectedDate").val($.datepicker.formatDate('d', rawDate));

				// getting the new xml file that needs to be loaded into the schedule:
				var newSchedURL = "<?php echo $path = get_template_directory_uri(); ?>";

				var fileToLoad = newSchedURL+"/tvshowsxmls/playlist"+dateRequest+".xml";

				// ajax call to get the new file loaded and supply new data
				$.ajax({
					type: "GET",
					url: "../wp-content/themes/smithsonianchannel/getScheduleData.php",
					dataType: "json",
					cache: false,
					data: { 'date': dateRequest },
					success: function( json ){
						loadSchedule(json);
						if(calHideable){
							console.log("trying to get the button that was clicked on: ");
							hideMenu();
						}
						
					},
					error: function(){
						console.log("no data was seen...");
						loadSchedule("null");
					}
				})

			}
		});

		$( "#dialog-link, #icons li" ).hover(
			function() {
				$( this ).addClass( "ui-state-hover" );
			},
			function() {
				$( this ).removeClass( "ui-state-hover" );
			}
		);
	});
});



