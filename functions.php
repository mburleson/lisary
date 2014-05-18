<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Lisa Robbin Young' );
define( 'CHILD_THEME_URL', 'http://www.LisaRobbinYoung.com/' );
define( 'CHILD_THEME_VERSION', '1.0' );


//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

add_action( 'wp_enqueue_scripts', 'minimum_enqueue_scripts' );
function minimum_enqueue_scripts() {

	wp_enqueue_style( 'minimum-google-fonts', '//fonts.googleapis.com/css?family=Lily+Script+One|Raleway:400,300,500,600,700,800,900|Open+Sans:400italic,600italic,700italic,800italic,400,600,700,800)', array(), CHILD_THEME_VERSION );

}


/**
 * Register and Enqueue Secondary Navigation Menu Script
 * 
 * @author Brad Potter
 * 
 * @link http://www.bradpotter.com
 */
function gst_secondarymenu_script() {
    
	wp_register_script( 'secondary-menu', get_stylesheet_directory_uri() . '/js/secondarymenu.js', array('jquery'), '1.0.0', false );
	wp_enqueue_script( 'secondary-menu' );

 }
add_action('wp_enqueue_scripts', 'gst_secondarymenu_script');


//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'minimum_secondary_menu_args' );
function minimum_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] )
	return $args;

	$args['depth'] = 1;
	return $args;

}

//* Register after post widget area
genesis_register_sidebar( array(
	'id'            => 'top-hero',
	'name'          => __( 'Top Hero', 'LisaRobbinYoung' ),
	'description'   => __( 'This is the top hero area', 'LisaRobbinYoung' ),
) );
genesis_register_sidebar( array(
	'id'            => 'home-featured',
	'name'          => __( 'Home Featured', 'LisaRobbinYoung' ),
	'description'   => __( 'This is the home video area', 'LisaRobbinYoung' ),
) );

function top_hero_area(){
		if (is_home() || is_front_page()) {
			echo '</div><div class="container" id="top_hero_wrap">';
					// <div class="row-fluid">
					// <a href="" class="span2 offset10 members_button hidden-phone hidden-tablet">Members Area</a>
					// </div>';
			echo '<div class="row span4 pull-right" id="top-hero-widget">'
			;genesis_widget_area( 'top-hero' );
			echo '</div>';
			echo '</div>';
			echo '<div class="site-container">';
}
}

add_action ('genesis_before_header', 'top_hero_area');

function home_featured_area(){
		if (is_home() || is_front_page()) {
			echo '<div class="row-fluid home-featured">';
			genesis_widget_area( 'home-featured' );
			echo '</div>';
			}
		}

add_action ('genesis_before_entry_content', 'home_featured_area');


function top_events_area(){
		if (is_home() || is_front_page()) {
			echo '<div class="row-fluid"><a href="events/" class="up_events span12 hidden-tablet" href=""><img class="hidden-tablet" src="http://lisarobbinyoung.com/staging/wp-content/themes/Lisa-Robbin-Young/images/events.png" /></a></div>';
			
}
}


add_action( 'genesis_before_sidebar_widget_area', 'top_events_area' );


//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );



//* Wrap .nav-primary in a custom div
add_filter( 'genesis_do_nav', 'genesis_child_nav', 10, 3 );
function genesis_child_nav($nav_output, $nav, $args) {
 
return '<div class="container"><div class="nav-primary-wrapper hidden-phone hidden-tablet">' . $nav_output . '</div></div>';
 
}
 
//* Wrap .nav-secondary in a custom div
add_filter( 'genesis_do_subnav', 'genesis_child_subnav', 10, 3 );
function genesis_child_subnav($subnav_output, $subnav, $args) {
 
return '<div class="nav-secondary-wrapper">' . $subnav_output . '</div>';
 
}

//* Add new image size
add_image_size( 'singular', 680, 200, TRUE );
 
add_action ( 'genesis_entry_header', 'sk_featured_image_title_singular', 9 );
function sk_featured_image_title_singular() {
 
	if ( !has_post_thumbnail() )
		return;
 
	echo '<div class="singular-thumbnail">';
	genesis_image( array( 'size' => 'singular' ) );
	echo '</div>';
 
}


//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
$post_info = '[post_date] by [post_author_posts_link] [post_edit]';
return $post_info;
}

//* Customize the entry meta in the entry footer (requires HTML5 theme support)
add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
function sp_post_meta_filter($post_meta) {
$post_meta = '[post_comments] [post_share]';
return $post_meta;
}

// Create shortcode for Post Info sharing icons
function post_share_shortcode() {
if (!is_page()) {
 $permalink = get_permalink();
 $datatext = get_the_title();
 $share_buttons = '
 
<div class="all-buttons">
 <!-- Facebook Like Button -->
 <div class="fb-like" href="'.$permalink.'"
 data-send="false" data-layout="button_count"
 data-width="90" data-show-faces="false" data-font="arial">
 </div>
 
<!-- Google +1 Button -->
 <div class="plusone">
 <g:plusone size="medium" href="'.$permalink.'">
 </g:plusone>
 </div>
 
<!-- Tweet Button -->
 <div class="tweet">
 <a href="https://twitter.com/share" class="twitter-share-button"
 data-url="'.$permalink.'" data-text="'.$datatext.'">Tweet</a>
 </div>
 
<!-- Pinterest Button -->
<div class="pinterest-button">
 <a href="http://pinterest.com/pin/create/button/?url=%s&media=%s"
 class="pin-it-button" count-layout="horizontal">Pin It</a>
</div>
 </div>
 </div>

';
 
return $share_buttons;
}}
add_shortcode('post_share', 'post_share_shortcode');