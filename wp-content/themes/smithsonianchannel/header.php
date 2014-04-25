<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="main">
 *
 * @package WordPress
 * @subpackage Smithsonian Channel
*/
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<!-- [if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif] -->
<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
        <meta name="viewport" content="width=device-width">
        <meta property="twitter:account_id" content="4503599627486214" />
        <?php //fb open graph tags ?>
        <meta property="og:title" content="<?php the_title(); ?>"/>
        <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/facebooklogo.png"/>
        <meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
        <meta property="og:url" content="<?php echo get_permalink(); ?>"/>
        <meta property="og:description" content="Smithsonian Channel Canada is a new commercial-free network featuring exclusive, award-winning programming that entertains and inspires."/>
        
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" type="image/x-icon" />
    <?php //Apple Touch Icons ?>
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/touch-icons/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/images/touch-icons/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/touch-icons/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/touch-icons/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/images/touch-icons/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/images/touch-icons/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/touch-icons/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/touch-icons/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/images/touch-icons/apple-touch-icon-152x152.png" />
    <?php //Windows 8 Tile Icons ?>
    <meta name="msapplication-square70x70logo" content="smalltile.png" />
    <meta name="msapplication-square150x150logo" content="mediumtile.png" />
    <meta name="msapplication-wide310x150logo" content="widetile.png" />
    <meta name="msapplication-square310x310logo" content="largetile.png" />
        
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/reset.css" media="screen">
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen">
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/responsive.css" media="screen">
        
        <script type="text/javascript" src="//use.typekit.net/ggs1hec.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
            
<?php
	wp_head();
?>
    
</head>

<body <?php body_class(); ?>>
    <?php
        global $scheduleXML; 
        // $rDate = date("Ymd");
        // $scheduleXML = loadDailySchedule($rDate);
    ?>
 <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        
         <div class="header-container">
         
          <div id="redirect">
          </div> <!-- #redirect -->
         
            <header class="wrapper">
            
            <div class="page-container clearfix">
            
            	<div class="logo">
                <a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                <h1 class="title"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Smithsonian Channel" /></h1>
                </a>
                </div> <!-- .logo -->
                <nav>
                 <a href="#" title="menu_pull" id="pull"></a>
                    <?php /* Display Menus on Header */
					wp_nav_menu(array( 'menu' => 'header-menu', 'menu_class' => 'nav-bar-content', 'menu_id' => 'navigation', 'container' => false, 'theme_location' => 'primary-menu', 'show_home' => '1')); ?>
                </nav>
            <div class="search-box">
				 <?php get_search_form(); ?> 
			</div><!-- .search-box -->
            
            <div class="social">
            	<ul class="social-networks">
					<li class="facebook"><a href="https://www.facebook.com/SmithsonianChannelCanada" target="blank" title="Facebook">Facebook</a></li>
					<li class="twitter"><a href="https://twitter.com/smithsoniantvca" target="blank" title="Twitter">Twitter</a></li>
					<li class="youtube"><a href="http://www.youtube.com/user/smithsoniantvcanada" target="blank" title="YouTube">Youtube</a></li>
				</ul>
            </div> <!-- .social -->
            
            </div> <!-- .container -->
            
            </header>
        </div>
        
        <div class="main-container">
            <div class="main wrapper clearfix">