<?php
	$scheduleXML = array();
	$sArray = array();
	$sindex = array();
	$primeArray = array();

// Register Menus on WP Appearance > Menus //
	function register_my_menus() {
	  register_nav_menus(
		array(
		  'header-menu' => __( 'Header Menu' ),
		  'footer-menu' => __( 'Footer Menu' )
		)
	  );
	}
add_action( 'init', 'register_my_menus' );
add_theme_support('post-thumbnails');
//	shows page image size
add_image_size('shows-thumb', 460, 250, true);

// Stop WordPress from adding p tags and removing line break
remove_filter ('the_content', 'wpautop');

// including jQuery on WP
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
	function my_jquery_enqueue() {
		wp_deregister_script('jquery');
		wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") ."://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", false, null);
		wp_enqueue_script('jquery');
	}

// adding the functions that gather all the data for the schedule in the footer and the main schedule page on the first load.
	function getinitialData() {	
		global $scheduleXML;
		global $sArray;
		global $sindex;
		global $primeArray;

		$rDate = date("Ymd");
		$scheduleXML = loadDailySchedule($rDate);
		// var_dump($scheduleXML);

		$length = count($scheduleXML["Clip"]);
		// echo "the length of the shows is: ".$length;

		// get the current time (EST) to show what should be on tv now...
		date_default_timezone_set('US/Eastern');
		$currenttime = date('H:i');
		
		list($hrs,$mins) = explode(':',$currenttime);

		// making a new array with the key being the time the show plays?
		$sArray = array();
		$primeArray = array();
		for( $i = 0; $i<$length; $i++){
			$sArray[$scheduleXML["Clip"][$i]["PlayAt"]] = $scheduleXML["Clip"][$i];
		}

		$keys = array_keys($sArray);

		//current time as date object
		$cTime = strtotime($currenttime);

		// primetime date object
		$primetime = strtotime("19:00");
		foreach ($keys as $k) {
			$sTime = strtotime($k);
			if($cTime >= $sTime){
				$sindex = $k;
			}

			if($sTime > $primetime){
				$pIndex = $k;
				// echo "primeIndex is: $k";
				array_push($primeArray, $sArray[$pIndex]);
			}
		}

		// trying to set the variables to be exposed in a single call for all the parts of the site as required...
		set_query_var('scheduleXML', $scheduleXML);
		set_query_var('sArray', $sArray);
		set_query_var('sindex', $sindex);
		set_query_var('primeArray', $primeArray);
	}
	add_action('wp_head','getinitialData');


// custom function to load the data for the schedule based on the date
	function loadDailySchedule($cDate){
		// get the directory of the template
		$dirPath = get_template_directory_uri();

		// get the file that we are supposed to load in
		$fileToRead = $dirPath."/tvshowsxmls/playlist".$cDate.".xml";

		// load the data into an xml object
		$xml=simplexml_load_file($fileToRead);
		$array = json_decode(json_encode((array)$xml), true);
		return $array;
	}


// enqueing JS files on Schedule page
	function includeJDate(){
		// trying to get the jQueryDate js file in...
		if( is_page_template('page-schedule.php')){ 
			wp_enqueue_script('jQuerydate', get_template_directory_uri().'/js/vendor/jQuerydate.js', array('jquery'), null, true);

			// including the js file that builds and controls the jquery-ui calendar
			wp_enqueue_script('scheduleManipulation', get_template_directory_uri().'/js/scheduleManipulation.js', array('jquery'), null, true);
			wp_enqueue_style('calendarCSS', get_template_directory_uri().'/css/jquery-ui-1.10.3.custom.css');
		}
	}

	add_action('wp_enqueue_scripts', 'includeJDate');	


// including JS file for specific show page show ribbons
	function showPageRibbonPopulation(){
		if( is_page_template('page-single-show.php')){
			wp_enqueue_script('showPageRibbonPopulation', get_template_directory_uri().'/js/videoWithSeparatePlaylist.js', array('jquery', 'videoRibbonControls'), null, true);
		}
	}
	add_action('wp_footer', 'showPageRibbonPopulation');

// including JS file on Channel Finder page
	function channelFinderAccordion(){
		if( is_page_template('page-channel-finder.php')){
			wp_enqueue_script('channelFinderAccordion', get_template_directory_uri().'/js/ddaccordion.js', array('jquery'), null, true);
			wp_enqueue_script('channelFinderToggle', get_template_directory_uri().'/js/channelFinderToggle.js', array('jquery'), null, true);
		}
	}
	add_action('wp_footer', 'channelFinderAccordion');	


// including JS file for all videos page show ribbons
	function libraryCrawl(){
		if( is_page_template('page-video-library.php')){
			wp_enqueue_script('libraryCrawl', get_template_directory_uri().'/js/libraryCrawl.js', array('jquery','videoRibbonControls' ), null, true);
		}
	}
	add_action('wp_footer', 'libraryCrawl');

// including JS file for all ribbon controls
	function videoRibbonControls(){
		if( is_page_template('page-single-show.php') || is_page_template('page-video-library.php')){
			wp_enqueue_script('videoRibbonControls', get_template_directory_uri().'/js/videoRibbonControls.js', array('jquery'), null, true);
		}
	}
	add_action('wp_footer', 'videoRibbonControls');

// including JS file for responsive menu
	function responsiveMenu(){
		wp_enqueue_script('responsiveMenu', get_template_directory_uri().'/js/responsiveMenu.js', array('jquery'), null, true);
	}
	add_action('wp_footer', 'responsiveMenu');
	
// including JS file on Shows main page
	function includeshowsExtra(){
		if( is_page_template('page-shows.php')){
			wp_enqueue_script('showsExtraUI', 'http://code.jquery.com/ui/1.10.3/jquery-ui.js', array('jquery'), null, true);
			wp_enqueue_script('showsExtra', get_template_directory_uri()."/js/showsExtra.js", array('jquery'), null, true);
		}
	}
	add_action('wp_footer', 'includeshowsExtra');
	
// including JS file on Shows page
	function includejQueryUI(){
		if( is_page_template('page-single-show.php')){
			wp_enqueue_script('showsExtra', 'http://code.jquery.com/ui/1.10.3/jquery-ui.js', array('jquery'), null, true);
		}
	}
	add_action('wp_footer', 'includejQueryUI');
	
// including modernizr
	function modernizr(){
		wp_enqueue_script('modernizr', get_template_directory_uri().'/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', array(), null, true);
	}
	add_action('wp_footer', 'modernizr');

//Enqueue IP redirect script for U.S visitors
	function IpRedirect() {
	wp_enqueue_script( 'IpRedirect', get_template_directory_uri().'/js/ip-redirect.js', array('jquery'), true );
}

add_action( 'wp_enqueue_scripts', 'IpRedirect' );

// A copy of rel_canonical but to allow an override on a custom tag
	function rel_canonical_with_custom_tag_override() { 
	
		if( !is_singular() ) 
			return; 
			global $wp_the_query; 
			if( !$id = $wp_the_query->get_queried_object_id() ) 
			return;
			 
			 // check whether the current post has content in the "canonical_url" custom field
			 $canonical_url = get_post_meta( $id, 'canonical_url', true ); 
			 if( '' != $canonical_url ) { 
			 
			 // trailing slash functions copied from http://core.trac.wordpress.org/attachment/ticket/18660/canonical.6.patch
			 $link = user_trailingslashit( trailingslashit( $canonical_url ) ); 
			 }
	
	else {
		$link = get_permalink( $id );
	} 
		echo "<link rel='canonical' href='" . esc_url( $link ) . "' />\n"; 
	} 
	
	// remove the default WordPress canonical URL function 
	
	if( function_exists( 'rel_canonical' ) ){ 
		remove_action( 'wp_head', 'rel_canonical' ); 
	} 
		
	// replace the default WordPress canonical URL function with your own 
	add_action( 'wp_head', 'rel_canonical_with_custom_tag_override' );


// Pagination on search results page //
	function pagination_nav($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination'> <ul>";
         
         echo "<li><a href='".get_pagenum_link($paged - 1)."'><img src='".get_template_directory_uri()."/images/arrow-next.png'></a></li>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<li><span class='current'>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
             }
         }
		// Next Arrow
        echo "<li><a href='".get_pagenum_link($paged + 1)."'><img src='".get_template_directory_uri()."/images/arrow-prev.png'></a></li>";  
        
         echo "</div>\n";
     }
}

// adding in google click tracking codes on the homepage only.
	function homeClickTracking(){
		if( is_page(33)){
			wp_enqueue_script('homeClickTrack','http://o2.eyereturn.com/?site=5020&page=homepage', null, true);
		}
	}

	add_action('wp_head', 'homeClickTracking');

// Include the Google Analytics Tracking Code (ga.js)
// @ http://code.google.com/apis/analytics/docs/tracking/asyncUsageGuide.html
function google_adServices_code(){ ?>

		<script type="text/javascript">
			/* <![CDATA[ */
			var google_conversion_id = 979030318;
			var google_custom_params = window.google_tag_params;
			var google_remarketing_only = true;
			/* ]]> */
			</script>
			<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
			</script>
			<noscript>
			<div style="display:inline;">
			<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/979030318/?value=0&amp;guid=ON&amp;script=0"/>
			</div>
			</noscript>

<?php }

// adding the add_action for the google_adServices_code call
add_action('wp_footer', 'google_adServices_code');

function googleAnalytics_code(){ ?>
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-44833446-1', 'smithsonianchannel.ca');
	ga('send', 'pageview');

	</script>
<?php }

add_action('wp_footer','googleAnalytics_code');

function comScore_tag(){ 

/*Begin comScore Tag*/ ?>
<script>
  var _comscore = _comscore || [];
  _comscore.push({ c1: "2", c2: "9013446" });
  (function() {
    var s = document.createElement("script"), el = document.getElementsByTagName("script")[0]; s.async = true;
    s.src = (document.location.protocol == "https:" ? "https://sb" : "http://b") + ".scorecardresearch.com/beacon.js";
    el.parentNode.insertBefore(s, el);
  })();
</script>
<noscript>
  <img src="http://b.scorecardresearch.com/p?c1=2&c2=9013446&cv=2.0&cj=1" />
</noscript>

<?php }

// adding ComScore tracking code
add_action('wp_footer', 'comScore_tag');

?>