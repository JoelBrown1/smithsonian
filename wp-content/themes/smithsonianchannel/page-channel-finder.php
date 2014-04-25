<?php
//Template Name: Channel Finder Page
get_header(); ?>

<div class="mainTitle">
		  <div class="page-container clearfix">
			<h1><?php the_title(); ?></h1>
		</div>
</div>


<?php global $cf; ?>
		
<div id="province-nav">

<div class="page-container clearfix">
        
        <div id="province-nav-wrapper">
        
        <h2>Select Your Province</h2>

            <?php $regions = $cf->getRegions(); ?>
            <div>
                <?php foreach ($regions as $r) { ?>
                <?php $name = str_replace(" ", "-", $r->name); ?>
                    <div class="channel-col"><a href="#<?php echo $name; ?>"><?php echo $r->name; ?></a></div>
                <?php } ?>
            </div>
            </div>
                
            <div style="clear:both;"></div>

	</div> <!-- #province-nav-wrapper -->  
</div> <!-- #province-nav -->
        
        <div class="page-container clearfix">
        
        <div id="channel-finder-wrapper">
            <?php
                foreach ($regions as $r) {
                    $package = $cf->getPackagesByRegion($r->name);
					$name = str_replace(" ", "-", $r->name);
            ?>
                    <h2 id="<?php echo $name; ?>"><?php echo $r->name; ?></h2>
					<h2 class="province"><a href="#"><?php echo $r->name; ?></a></h2>
                    
                    <div class="package-details">
                    
                    <div class="channel-headings">
                        <div class="channel-row">
                            <div class="channel-col provider-title">Provider</div>
                            <div class="channel-col package-title">Cable Package</div>
                            <div class="channel-col">Contact</div>
                            <div class="channel-last">Channel</div>
                        </div>
                    </div>

                    <div class="channel-details">
                        <?php foreach ($package as $p) { ?>
                        <div class="channel-row">
                            <div class="channel-col provider-logo"><img src="<?php echo $p->logo_url; ?>" alt="<?php echo $p->provider_name; ?>"/></div>
                            <div class="channel-col package"><?php echo str_replace(", ", "<br />", $p->cable_package); ?></div>
                            <div class="channel-col contact"><?php echo str_replace(", ", "<br />", $p->contact); ?><br />
                           <a href="<?php echo str_replace("&", "&amp;", $p->website); ?>" target="_blank">Visit Website</a></div>
                            <div class="channel-last">
                                <?php 
                                    $channels = json_decode($p->channels); 

                                    foreach($channels as $c) { 
                                        $e = explode(" ", $c);

                                        for ($i = 0; $i < count($e); $i++) {
                                            if ($i == 2) {
                                                echo "<span>". $e[$i] ."</span>";
                                            } else {
                                                echo $e[$i] ." ";
                                            }
                                        }

                                        echo "<br />";
                                    } 
                                    ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    </div> <!-- .package-detials -->
                    
                    
                    
                    <div class="mobile-package-details">
                    
                    <div class="channel-headings">
                        <div class="channel-row">
                            <div class="channel-col provider-title">Provider</div>
                            <div class="channel-col package-title">Cable Package</div>
                            <div class="channel-col">Contact</div>
                            <div class="channel-last">Channel</div>
                        </div>
                    </div>

                    <div class="channel-details">
                        <?php foreach ($package as $p) { ?>
                        <div class="channel-row">
                            <div class="channel-col provider-logo"><img src="<?php echo $p->logo_url; ?>" alt="<?php echo $p->provider_name; ?>"/></div>
                            <div class="channel-col package"><?php echo str_replace(", ", "<br />", $p->cable_package); ?></div>
                            <div class="channel-col contact"><?php echo str_replace(", ", "<br />", $p->contact); ?><br />
                            <a href="<?php echo str_replace("&", "&amp;", $p->website); ?>" target="_blank">Visit Website</a></div>
                            <div class="channel-last">
                                <?php 
                                    $channels = json_decode($p->channels); 

                                    foreach($channels as $c) { 
                                        $e = explode(" ", $c);

                                        for ($i = 0; $i < count($e); $i++) {
                                            if ($i == 2) {
                                                echo "<span>". $e[$i] ."</span>";
                                            } else {
                                                echo $e[$i] ." ";
                                            }
                                        }

                                        echo "<br />";
                                    } 
                                    ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    
                    </div> <!-- .mobile-package-detials -->
            <?php } ?>
            
        </div> <!-- #channel-finder-wrapper -->
</div>

<?php get_footer(); ?>