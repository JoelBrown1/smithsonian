<?php
//Template Name: Video Library
get_header(); ?>

<div class="mainTitle">
		  <div class="page-container clearfix">
			<h1><?php the_title(); ?></h1>
		</div>
</div>


<div class="page-container clearfix">

		<?php while(have_posts()): the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2 class="page-title">Featured Video</h2>
		
			<div class="post-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
			<?php
				$post_id = $post->ID;
				// echo "this is the post-id: ".$post_id."<br>";
				$ribData = get_post_meta( $post_id, 'brightcove_ribbon' );
				// $ribData = preg_split('|', $ribData);
				// var_dump($ribData);
				echo"<br>";
				foreach ($ribData as $rib) {
					$d = explode("|", $rib);
					// echo $d[0]."<br>";
					// echo $d[1]."<br>"; 
					?>
					<div class="showRibbon clearfix" data-show="<?php echo $d[1] ?>">
						<h2><?php echo $d[0]?></h2>
						<hr>
						<div class='left-arrow'></div>
						<div class="thumb-outter-container">
        					<div class="thumb-container">
        						<ul class="video-thumbs"></ul>
        					</div>
        				</div>
						<div class='right-arrow'></div>
					</div>
					<?php

				}

			?>
			<script>
				var rd = <?php echo json_encode($ribData) ?>;
				// console.log("meta data:", rd);
			</script>
		</div>
		<?php $current_page_id = $post->ID; ?>
		<?php endwhile; ?>
</div>
<?php get_footer(); ?>