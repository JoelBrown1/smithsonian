<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Smithsonian Channel
 * @since Smithsonian Channel 1.1
 */

get_header(); ?>

	<div class="mainTitle">
		  <div class="page-container clearfix">
			<h1><?php _e( 'Error 404 Page', 'smithsonianchannel' ); ?></h1>
		</div>
	</div>
    
    <div class="page-container clearfix">

		<h2 class="page-title"><?php _e( 'This Page Could Not Be Found!', 'smithsonianchannel' ); ?></h2>
        
         <ul class="sitemap-list">
			<?php
				// Add pages you'd like to exclude in the exclude here
				wp_list_pages(
				  array(
					'exclude' => '',
					'title_li' => '',
					'depth' => '2',
				  )
				);
            ?>
        </ul>
	

	
	</div>
<?php get_footer(); ?>