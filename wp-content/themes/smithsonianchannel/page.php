<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 */
get_header(); ?>

<div class="mainTitle">
		  <div class="page-container clearfix">
			<h1><?php the_title(); ?></h1>
		</div>
</div>


<div class="page-container clearfix">

	<?php while ( have_posts() ) : the_post(); ?>
    	<?php the_content(); ?>	
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>