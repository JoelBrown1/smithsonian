<?php
//Template Name: Season/Episode

//Redirect parent and grandchild to ancestor
global $post;
	$parent = $post->post_parent;
	if($parent)
		{
    		wp_redirect(get_permalink($parent),301); exit;
		}
?>