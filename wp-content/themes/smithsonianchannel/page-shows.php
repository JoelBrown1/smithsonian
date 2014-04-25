<?php 
//Template Name: Shows Page
get_header(); ?>

	<div class="mainTitle">
		  <div class="page-container clearfix">
			<h1><?php the_title(); ?></h1>
		</div>
	</div>
        
<?php
	// Display featured image as background image on #pageBanner 
    global $post; 
    $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600,1000 ), false, '' ); 
?>
    <div id="pageBanner" style="background: url(<?php echo $src[0]; ?> ) no-repeat center center; background-size: cover;">
    
    	<div class="show-banner-text">
        	<div class="page-container clearfix">
					<?php if(get_post_meta($post->ID, 'show_banner_heading', true)): ?>
                            <h1><?php echo get_post_meta($post->ID, 'show_banner_heading', true); ?></h1>
                    <?php endif; ?>
                    
                    <?php if(get_post_meta($post->ID, 'show_banner_desc', true)): ?>
                            <p><?php echo get_post_meta($post->ID, 'show_banner_desc', true); ?></p>
                    <?php endif; ?>
        	</div>            
        </div>
		
	</div>
    
      <div class="page-container clearfix">

	<h2 class="page-title"><?php the_title(); ?></h2>

 <?php
		/// show child thumbs
	$child_pages = $wpdb->get_results("SELECT *    FROM $wpdb->posts WHERE post_parent = ".$post->ID."    AND post_type = 'page' ORDER BY menu_order", 'OBJECT');
		?>
    
	<?php
	// Split content into 2 even columns
    	$count = 0;
		if ( $child_pages ) :  foreach ( $child_pages as $pageChild ) : setup_postdata( $pageChild ); 
		if( $count%2 == 0){ ?>
			 <div class="show_col_left">
	<?php	} else { ?>
			<div class="show_col_right">
	<?php   } ?>
    

	<div class="shows-image">
    
   
		<a href="<?php echo get_permalink($pageChild->ID); ?>"><?php echo get_the_post_thumbnail($pageChild->ID, 'shows-thumb'); ?></a>

		<h3 class="show-main-title"><a href="<?php echo get_permalink($pageChild->ID); ?>"><?php echo $pageChild->post_title; ?></a></h3>
    	
        
		<div class="image-extras" onclick="window.location='<?php echo get_permalink($pageChild->ID); ?>';">

			<div class="image-extras-content">
                            <div class="show_excerpt">
                                 <h3><a href="<?php echo get_permalink($pageChild->ID); ?>"><?php echo $pageChild->post_title; ?></a></h3>
								<h2><?php echo get_post_meta($pageChild->ID, 'show_excerpt', true); ?></h2>
                        	</div>
							<a href="<?php echo get_permalink($pageChild->ID); ?>" class="learn-more">Show me more</a>
						</div>
			</div>
		</div> <!-- .shows-image slide -->
	</div> <!-- .show_col_left/right -->
    
   
<?php 
	$count++;
	endforeach; 
	endif;
?>
</div>
<?php get_footer(); ?>