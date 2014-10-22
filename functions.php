<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sample Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.0.1' );

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
	wp_enqueue_style( 'google-font-lato', '//fonts.googleapis.com/css?family=Lato:300,700', array(), CHILD_THEME_VERSION );
}

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

/**
 * Insert custom sidebar created with Simple Sidebar plugin: use as widegtized area after the content
 *
 * @author Sacha Benda
 */
add_action( 'genesis_before_sidebar_widget_area', 'sax_extra_sidebar' );
function sax_extra_sidebar() {
	$sidebar = get_post_meta( get_the_ID(), 'wpcf-extra-sidebar-slug', true);
	if ( is_active_sidebar ( $sidebar ) ) { 
		echo '<aside class="extra-sidebar widget-area role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">';
		dynamic_sidebar($sidebar);
		echo '</aside>';
	}
}

//* Remove 'You are here' from the front of breadcrumb trail
add_filter( 'genesis_breadcrumb_args', 'sax_prefix_breadcrumb' );
function sax_prefix_breadcrumb( $args ) {
  $args['labels']['prefix'] = '';
  return $args;
}

//* Change the footer text
add_filter('genesis_footer_creds_text', 'sax_footer_creds_filter');
function sax_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] &middot; <a href="#"</a> &middot; Made by <a href="http://www.theblink.co" title="The Blink">The Blink</a>';
	return $creds;
}

//* Add shortcode functionality to sidebar
add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
add_filter( 'widget_text', array( $wp_embed, 'autoembed'), 8 ); //adds embed funciontality - ex. youtube videos
