</div> <!-- #main -->
        </div> <!-- #main-container -->
		
<footer>
        <div class="schedule-footer">
        	<div class="scheduleContainer">
                <div id="leftSide">
				<div id="nowShowing">
					<ul>
                    	<li class="nowShowingTitle">Now Playing:</li>
						<?php
							$date = date_create_from_format('H:i', $sArray[$sindex]["PlayAt"]);
							$time = date_format($date, 'g:i A');
						?>
							<li class="currentShow"><span class="titleStamp"><?php echo $sArray[$sindex]["Title"];?></span></li>
					</ul>
                </div>
			</div>
			<div id="rightSide">
				<div id="upNext">
					<ul>
                    <li class="nowShowingTitle">Tonight:</li>
						<?php
							for($i=0; $i<3; $i++){ 
								$date = date_create_from_format('H:i', $primeArray[$i]["PlayAt"]);
								$pTime = date_format($date, 'g:i A');
								$sTitle = $primeArray[$i]["Title"];
						?>
								<li class="upNextShow"><span class="timeStamp"><?php echo $pTime; ?></span><span class="titleStamp"><?php echo $sTitle; ?></span></li>
						<?php
							}
						?>
					</ul>
                    
				</div>			
			</div>
            <div id="scheduleLink"><a href=" <?php site_url();?>/schedule">SCHEDULE</a></div>
            </div> <!-- #scheduleContainer -->
        </div> <!-- .schedule-footer -->
        
        <div class="footer-container">
        <div class="page-container clearfix">
            	
                <img src="<?php echo get_template_directory_uri(); ?>/images/bam-logo.png" alt="Blue Ant Media logo" class="bam-logo" />
            	<p class="comScore">A Blue Ant Media Entertainment Site</p>
                
               	<p class="copyright">&copy; <?php echo date("Y") ?> Blue Ant Media All rights reserved.</p>
				
                <?php /* Display Menus on Footer */
				wp_nav_menu(array( 'menu' => 'footer-menu', 'menu_class' => 'nav-bar-content_footer', 'menu_id' => 'footer_navigation', 'container' => false, 'theme_location' => 'primary-menu', 'show_home' => '1')); ?>
                                
                <p class="aboutContact_footer"><a href="<?php echo site_url(); ?>/about-contact">About &amp; Contact</a></p>
       </div>
      </div>
       
        
        <?php
			wp_footer();
		?>
        </footer>
	</body>
</html>