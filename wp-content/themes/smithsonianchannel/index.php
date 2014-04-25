<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage Smithsonian Channel
 * @since Smithsonian Channel 1.1
 **/

get_header(); ?>

		 <section>

		<div class="mainTitle">
		  <div class="page-container clearfix">
			<h1><?php _e( 'Not Found', 'smithsonianchannel' ); ?></h1>
		</div>
	</div>
    
    <div class="page-container clearfix">

		<h2><?php _e( 'This is somewhat embarrassing, isn’t it?', 'smithsonianchannel' ); ?></h2>
		<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'smithsonianchannel' ); ?></p>

		<?php get_search_form(); ?>
	</div>

		</section>
<?php get_footer(); ?>