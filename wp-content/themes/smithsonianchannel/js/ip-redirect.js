jQuery(function($) {
			   $.getJSON( "http://smart-ip.net/geoip-json?callback=?", function(data){
				
			   if (data.countryCode != "CA") { 
			   		$('#redirect').slideDown(1000);
				 	document.getElementById('redirect').innerHTML = "<p>Viewing from the United States? Visit <a href=\"http://www.smithsonianchannel.com\">smithsonianchannel.com</a></p>";
					
			   }
			   });
});