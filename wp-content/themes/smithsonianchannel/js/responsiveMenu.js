$(document).ready(function(){
	var $ = jQuery;
	
// Turns main nav to dropdown menu	
	var menuVis = true;
	var menuHideable = false;

	if($(window).width()<640){
		menuVis = false;
		menuHideable = true;
	}

	$(window).on('resize', menuCheck);
// && $("#navigation").css('display') == 'none'
	function menuCheck( evt ){
		if($("#pull").css('display') !== "none" && $(window).width()<640){
			$("#navigation").css('display', 'none');
			menuVis = false;
			menuHideable = true;
		} else if($(window).width()>640){
			menuVis = true;
			$("#navigation").css('display', 'block');
			menuHideable = false;
		}
	}

	$("#pull").on("click", toggleResponsiveMenu);

	function toggleResponsiveMenu( evt ){
        evt.preventDefault();
        evt.stopPropagation();
        if (!menuVis) {
            //Search is currently hidden. Slide down and show it.
            $("#navigation").slideDown(200);
            $("#pull").focus(); //Set focus on the search input field.
            menuVis = true; //Set search visible flag to visible.
           // $('body').on("click", toggleResponsiveMenu);
        } else {
            //Search is currently showing. Slide it back up and hide it.
			hideMenu();
        }
	}

	function hideMenu(){
        	$('body').off("click");
            $("#navigation").slideUp(200);
            menuVis = false;
	}

	if($("#pull").css('display') !== "none"){
		console.log("this toggle switch is visible...");
	}


// Turns Season nav to dropdonw on shows page @ 640px breakpoint
	 $(function() {
	   
      // Create the dropdown base
      $("<select />").appendTo("#seasons");
      
      // Create default option "Go to..."
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Go to..."
      }).appendTo("#seasons select");
      
      // Populate dropdown with menu items
      $("#seasons ul").each(function() {
       var el = $(this);
       $("<option />", {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo("#seasons select");
      });
      
	   // To make dropdown actually work
	   // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
      $("#seasons select").change(function() {
        window.location = $(this).find("option:selected").val();
      });
	 
	 });
	 
	 
	 var searchvisible = 0;            
    $("#search-menu").click(function(e){ 
        //This stops the page scrolling to the top on a # link.
        e.preventDefault();
        if (searchvisible ===0) {
            //Search is currently hidden. Slide down and show it.
            $("#search-form").slideDown(200);
            $("#s").focus(); //Set focus on the search input field.
            searchvisible = 1; //Set search visible flag to visible.
        } else {
            //Search is currently showing. Slide it back up and hide it.
            $("#search-form").slideUp(200);
            searchvisible = 0;
        }
    });


});