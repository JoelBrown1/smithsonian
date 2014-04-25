<?php
/*
	Template Name: Search Page
*/

get_header(); ?>

<div class="mainTitle">
		  <div class="page-container clearfix">
			<h1>Search results for: <?php echo get_search_query(); ?></h1>
		</div>
	</div>
    
    <div class="page-container clearfix">

		  <?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
        
                 <?php //echo the_permalink()."<br>"; 
				$heystack = str_replace("http://","",get_permalink(get_the_ID()));
				// echo the_ID()."<br>";
				$needle = '/';
				$pos = strripos($heystack, $needle);
				$sArray = (explode("/",$heystack));
				// echo count($sArray)."<br>";
				// print_r($sArray);
				$arrayLength = count($sArray) - 4;
				$showURL;
				for($i=count($sArray);$i>$arrayLength; $i--){
					if(count($sArray)>$arrayLength){
						// echo "still to large: ".$sArray[$i]."<br>";
						unset($sArray[$i]);
					}
				}
				$fURL = "http://".implode("/", $sArray);
				// echo $fURL."<br>";
				// echo $showRUL."<br>";

				 // $urlArray = array preg_split("/^[/]/$", the_permalink());
				 // print_r($urlArray);
				// the_permalink()
				
				
				// Display grandparent title next to the episode title
			$current = $post->ID;
			$parent = $post->post_parent;
			$grandparent_get = get_post($parent);
			$grandparent = $grandparent_get->post_parent;
				
			?>
            
         
              
			
			<div class="post-content">
            
		<h2>
        	<a href="<?php echo $fURL; ?>">
        
		<?php if ($root_parent = get_the_title($grandparent) !== $root_parent = get_the_title($current)) {
				
				echo get_the_title($grandparent);
				
				} else {
					echo get_the_title($parent); }?> - 
        
		<?php the_title(); ?></a>
        
        </h2>
        
        <?php the_content(); ?>
        
        </div>

               
             <hr />
             </div>
                
			<?php endwhile; ?>
  
<?php pagination_nav(); ?>
		</div>
		
<?php get_footer(); ?>