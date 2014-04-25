<?php 
//Template Name: Single Shows Page
get_header(); ?>

	<div class="showMainTitle">
		<div class="page-container clearfix">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>
        
        
    <div id="show-pageBanner">
		<?php echo get_the_post_thumbnail(); ?>
        
        <div class="show-page-title">
		<div class="page-container clearfix">
			<h1 class="entry-title"><?php the_title(); ?></h1>
	</div>
    	</div>
        
	</div>
    
    		<?php /* Custom fields options */ ?>
			<div class="show-meta">
				<div class="page-container clearfix">
				<div class="show-desc">
					<?php if(get_post_meta($post->ID, 'show_desc', true)): ?>
                         <p><?php echo get_post_meta($post->ID, 'show_desc', true); ?></p>
                     <?php endif; ?>
                </div>
                
                    <div class="date-info-box">
                     <?php if(get_post_meta($post->ID, 'show_day', true)): ?>
                     	<h1><?php echo get_post_meta($post->ID, 'show_day', true); ?></h1>
                     <?php endif; ?>
                    
                    <?php if(get_post_meta($post->ID, 'show_date', true)): ?>
						<h2><?php echo get_post_meta($post->ID, 'show_date', true); ?></h2>
                    <?php endif; ?>
                     
                     <?php if(get_post_meta($post->ID, 'show_time', true)): ?>
                         <span><?php echo get_post_meta($post->ID, 'show_time', true); ?></span>
                         <p>ET<br />PT</p>
                     <?php endif; ?>
                     
                    </div>
                    </div>
				</div>

	
    <div class="page-container clearfix">
	<?php
		
				// Get season list
				$seasons = get_pages ( array( 'parent' => $post->ID, 'sort_column' => 'menu_order', 'hierarchical' => '0' ) );
				//var_dump ($seasons);
				
				// Push Array Seasons
				$seaArray = array();
				foreach ($seasons as $season_nav) {
					$seasons_name = $season_nav->post_name;
					$seasons_title = $season_nav->post_title;
				
				// echo 'THE VAR: '.$seasons_title.'<br />'; 
				
			
					// Get episode content
					$episodes = get_pages ( array( 'child_of' => $season_nav->ID, 'sort_column' => 'menu_order', 'hierarchical' => '0' ) );
					//var_dump ($episodes);
				
					// Push Array Episodes
					$epsArray = array();
					
					foreach ($episodes as $eps) {
						$episode_title = $eps->post_title;
						$episode_content = $eps->post_content;
						array_push($epsArray, array($episode_title, $episode_content));
			
					} // close episode content loop
					//var_dump($epsArray);
					//echo"num of elements in epsArray: ".$counter;
			
					array_push($seaArray, array($seasons_name, $seasons_title, $epsArray));
			
			} // end of foreach master statement
					//var_dump($seaArray);

		?>
        
        <div class="episode-details-wrapper">
            
            <div id="tabs">
                <ul>
                     
					 <?php 
					 // Don't show video tab if show doesn't have videos
					 
						if( empty( $post->post_content) ) { // Check for empty page 
						
							echo "<li style=\"display:none;\"><a href=\"#videos\">Videos</a></li>";

							} else {

								echo "<li><a href=\"#videos\">Videos</a></li>";

							}
					?>
                    
                     <?php 
					 // Don't show episodes tab if show doesn't have seasons
						//if (strlen($epsArray) !==0) {
						  if (count($epsArray) !==0) {
							                        
							echo "<li><a href=\"#episodes\">Episodes</a></li>";
							
						}
					?>
                    
	            </ul>
                
                 <?php
					// Don't show <hr /> if show doesn't have seasons
				
				if (count($epsArray) !==0 || ($post->post_content)) {  // Check for empty page 
                	echo "<hr />";
				}
				?>
				
                
                <?php 
					 // Don't show related videos content if show doesn't have videos
					 
						if( empty( $post->post_content) ) { // Check for empty page 
						
							echo "<div id=\"videos\" style=\"display:none;\">";
							
							 while ( have_posts() ) : the_post();
								the_content();
							endwhile;
                    
							echo "<h3 style=\"display:none;\">Related Videos</h3>
                			<hr / style=\"display:none;\">
                			</div>";	

						} else {
						 // Show related videos content if show has videos
							echo "<div id=\"videos\">";
							while ( have_posts() ) : the_post();
								the_content();
                    		endwhile;
                ?>    			<div id="vidContent"
									<h3>Related Videos</h3>
		                			<hr />
		                			<div class="showRibbon clearfix">
		                				<div class="left-arrow"></div>
		                				<div class="thumb-outter-container">
		                					<div class="thumb-container">
		                						<ul class="video-thumbs"></ul>
		                					</div>
		                				</div>
		                				<div class="right-arrow"></div>
		                			</div>
		                		</div>
                			</div>

				<?php	} ?>
                
                
               
                
                <div id="episodes">
                
                <?php
					// Don't show titles if show doesn't have seasons
						//if (strlen($epsArray) !==0) {
							if (count($epsArray) !==0) { ?>
                        
                         <?php echo "<div id=\"episodes-detail\">"; ?>
                        
                        <?php echo
							"<ul>
                                <li>" ;
						?>
								<?php the_title(); ?>
							   <?php echo "</li>
                                        
                               <li class=\"seasons-last\">
                                            Seasons
                                </li>
							</ul>
						</div>" ;
					?>

					<?php } ?>
                
                <div id="eps-content">
                
                 <div id="seasons">
                		<ul>
           				
                        <?php //Loop seaArray to display the Season nav
                        	foreach ($seaArray as $season) { ?>
	                    	<li><a href="#<?php echo $season[0] ?>"><?php echo $season[1] ?></a></li>
                         <?php } ?>
                        </ul>
                	</div>
                    
				
                <div id="episodes-wrapper">
                <?php //Loop post_name to display season on as div id
                	foreach ($seaArray as $season) { ?>
					
					<div id="<?php echo $season[0] ?>">
                    
                    	 <?php //Loop post_content to display episode content
                         	foreach ($season[2] as $ep) { ?>
				
                <div class="entry-title"><?php echo $ep[0] ?></div>
                <div class="entry"><?php echo $ep[1] ?></div>
                
                <?php }  //close first loop ?>
                
                </div>
                   <?php } //close second loop ?>

				</div> <!-- #episodes-wrapper -->
                
                </div> <!-- #eps-content -->
           
            
            </div> <!-- END .episode-details-wrapper -->
               
			<div style="clear:both;"></div>
            </div>
		</div> <!-- #tabs -->
        
        <script>
	$(function() {
					<?php 
						// Display episodes content if there is no video on the page
						if( empty( $post->post_content) ) { // Check for empty page 
							echo "$( \"#tabs\" ).tabs({ active: 1 });";
							} else {
								echo "$( \"#tabs\" ).tabs();";
						}
					?>
		$( "#eps-content" ).tabs();
	});
</script>
</div>
<?php get_footer(); ?>