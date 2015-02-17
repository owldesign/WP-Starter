<?php
/*
 *  Author: Vadim Goncharov | @owldesign
 *  Author URL: owl-design.net 
 */

/** 

  DEFINE CONSTANTS
  
*/
// Public
define('PUBLIC_URL', get_template_directory_uri());
define('PUBLIC_DIR', get_template_directory());
define('PUBLIC_ASSETS', get_template_directory_uri() . '/assets');
define('PUBLIC_JS_FOLDER', PUBLIC_ASSETS . '/js');
define('PUBLIC_CSS_FOLDER', PUBLIC_ASSETS . '/css');

// Admin
define('ADMIN_URL', get_template_directory_uri() . '/admin');
define('ADMIN_DIR', get_template_directory() . '/admin');
define('ADMIN_ASSETS', get_template_directory_uri() . '/admin/assets');
define('ADMIN_JS_FOLDER', ADMIN_ASSETS . '/js');
define('ADMIN_CSS_FOLDER', ADMIN_ASSETS . '/css');

// Define the version
define('THEME_VERSION', 1.0);

/** 

  TEXTDOMAIN & THEME NAME
  
*/
global $textdomain, $themename;
$textdomain = 'theme';
$themename = 'theme';

/** 

  THEME SUPPORT
  
*/
// Add RSS Feeds to Head
add_theme_support('automatic-feed-links');

// Enable support for Post Thumbnails on posts and pages
add_theme_support('post-thumbnails');
add_image_size('featured-size', 1024); // Featured Image size

// Switch default core markup for search form, comment form, and comments to output valid HTML5.
add_theme_support('html5', array(
  'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
));

// Enable support for Post Formats. See http://codex.wordpress.org/Post_Formats
add_theme_support('post-formats', array(
  'image', 'gallery'
));

/** 

  REGISTER WP MENU
  
*/
register_nav_menus( 
	array(
		'primary'	=>	__('Primary Menu', $textdomain), // Register the Primary menu
	)
);

/** 

  ENQUEUE SCRIPTS/STYLES
  
*/
function theme_javascript() {
	wp_deregister_script('jquery');
	wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array(), null, false);
	wp_enqueue_script('theme-plugins', PUBLIC_JS_FOLDER . '/plugins.js', array('jquery'), THEME_VERSION, true);
	wp_enqueue_script('theme-application', PUBLIC_JS_FOLDER . '/application.js', array('jquery'), THEME_VERSION, true);

	// Localize JS
	$themeAPI = array(
	  'siteUrl' => get_site_url(),
	  'themePath' => get_stylesheet_directory_uri(),
	);

	wp_localize_script('theme-application', 'theme_api', $themeAPI);

}

function theme_stylesheet() {
  wp_enqueue_style('theme-custom-style', PUBLIC_CSS_FOLDER . '/application.css', array(), THEME_VERSION, 'all');
  wp_enqueue_style('theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'theme_javascript');
add_action('wp_enqueue_scripts', 'theme_stylesheet');

/** 

  CUSTOM FIELDS | ACF

*/
add_filter('acf/settings/path', 'my_acf_settings_path');
function my_acf_settings_path($path) {
  $path = ADMIN_DIR . '/acf/';
  return $path;
}
add_filter('acf/settings/dir', 'my_acf_settings_dir');
function my_acf_settings_dir($dir) {
  $dir = ADMIN_URL . '/acf/';
  return $dir;
}
// Hide ACF field group menu item
// add_filter('acf/settings/show_admin', '__return_false');
// Include ACF
include_once(ADMIN_DIR . '/acf/acf.php');

/** 

  THEME OPTIONS

*/
if (file_exists(ADMIN_DIR .'/theme-options.php')) {
  require_once ADMIN_DIR .'/theme-options.php';
}



