<?php
// Template Name: Sitemap Page
get_header(); ?>

<div class="mainTitle">
		  <div class="page-container clearfix">
			<h1><?php the_title(); ?></h1>
		</div>
</div>

<div class="page-container clearfix">
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