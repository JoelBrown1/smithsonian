$(document).ready(function() {

	// Slide in/out show details
	$(".shows-image").mouseenter(function () {
		$(this).find('.show-main-title').fadeOut(300);
		$(this).find( ".image-extras" ).animate({
	
		height: "toggle"
		},
		200, function() {
		// Animation complete.
		});
	
	});
	
	$(".shows-image").mouseleave(function () {
		$(this).find('.show-main-title').fadeIn(300);
		$(this).find('.image-extras').hide();
	
	});

});
