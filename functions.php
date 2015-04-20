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
define('PUBLIC_DIST_FOLDER', PUBLIC_ASSETS . '/dist');
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
if (!isset($content_width)) {
  $content_width = 900;
}

if (function_exists('add_theme_support')) {
  // Add Thumbnail Theme Support
  add_theme_support('post-thumbnails');
  add_image_size('large', 1024, '', true); // Large Thumbnail
  add_image_size('medium', 250, '', true); // Medium Thumbnail

  // Enables post and comment RSS feed links to head
  add_theme_support('automatic-feed-links');

  // Switch default core markup for search form, comment form, and comments to output valid HTML5.
  add_theme_support('html5', array(
    'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
  ));

  // Localisation Support
  load_theme_textdomain($textdomain, get_template_directory() . '/languages');
}

/** 

  REGISTER WP MENU
  
*/
function theme_nav() {
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul>%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Register HTML5 Blank Navigation
function register_html5_menu() {
  global $textdomain;
  register_nav_menus(array( 
    'header-menu' => __('Header Menu', $textdomain), 
    'sidebar-menu' => __('Sidebar Menu', $textdomain), 
    'extra-menu' => __('Extra Menu', $textdomain) 
  ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '') {
  $args['container'] = false;
  return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var) {
  return is_array($var) ? array() : '';
}

/** 

  ENQUEUE SCRIPTS/STYLES
  
*/
function theme_javascript() {
  if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array(), null, false);

    wp_enqueue_script('theme-plugins', PUBLIC_DIST_FOLDER . '/plugins.min.js', array('jquery'), THEME_VERSION, true);
    wp_enqueue_script('theme-application', PUBLIC_DIST_FOLDER . '/application.min.js', array('jquery'), THEME_VERSION, true);

    // Localize JS
    $themeAPI = array(
      'siteUrl' => get_site_url(),
      'themePath' => get_stylesheet_directory_uri(),
    );

    wp_localize_script('theme-application', 'theme_api', $themeAPI);
  }
}

// Load Page conditional scripts
function page_conditional_scripts() {
  if (is_page('pagenamehere')) {
    wp_register_script('scriptname', PUBLIC_DIST_FOLDER . '/scriptname.js', array('jquery'), '1.0.0'); 
    wp_enqueue_script('scriptname'); 
  }
}

// Load HTML5 Blank styles
function theme_stylesheet() {
  wp_enqueue_style('theme-custom-style', PUBLIC_DIST_FOLDER . '/application.min.css', array(), THEME_VERSION, 'all');
  wp_enqueue_style('theme-style', get_stylesheet_uri());
}

/** 

  CLEAN UP FUNCTIONS
  
*/
// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist) {
  return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes) {
  global $post;
  if (is_home()) {
    $key = array_search('blog', $classes);
    if ($key > -1) {
      unset($classes[$key]);
    }
  } elseif (is_page()) {
    $classes[] = sanitize_html_class($post->post_name);
  } elseif (is_singular()) {
    $classes[] = sanitize_html_class($post->post_name);
  }
  return $classes;
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action('wp_head', array(
    $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
    'recent_comments_style'
  ));
}

/** 

  REGISTER SIDEBARS/WIDGETS
  
*/
// If Dynamic Sidebar Exists
if (function_exists('register_sidebar')) {
  // Define Sidebar Widget Area 1
  register_sidebar(array(
    'name' => __('Widget Area 1', $textdomain),
    'description' => __('Description for this widget-area...', $textdomain),
    'id' => 'widget-area-1',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));

  // Define Sidebar Widget Area 2
  register_sidebar(array(
    'name' => __('Widget Area 2', $textdomain),
    'description' => __('Description for this widget-area...', $textdomain),
    'id' => 'widget-area-2',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
}

/** 

  HELPERS
  
*/
// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function theme_pagination() {
  global $wp_query;
  $big = 999999999;
  echo paginate_links(array(
    'base' => str_replace($big, '%#%', get_pagenum_link($big)),
    'format' => '?paged=%#%',
    'current' => max(1, get_query_var('paged')),
    'total' => $wp_query->max_num_pages
  ));
}

// Create 20 Word Callback for Index page Excerpts, call using custom_excerpt('excerpt_index'); 
function excerpt_index($length) { return 20; }

// Create 40 Word Callback for Custom Post Excerpts, call using custom_excerpt('excerpt_custom_post');
function excerpt_custom_post($length) { return 40; }

// Create the Custom Excerpts callback
function custom_excerpt($length_callback = '', $more_callback = '') {
  global $post;
  if (function_exists($length_callback)) {
    add_filter('excerpt_length', $length_callback);
  }
  if (function_exists($more_callback)) {
    add_filter('excerpt_more', $more_callback);
  }
  $output = get_the_excerpt();
  $output = apply_filters('wptexturize', $output);
  $output = apply_filters('convert_chars', $output);
  $output = '<p>' . $output . '</p>';
  echo $output;
}

// Custom View Article link to Post
function view_more_article($more) {
  global $post, $textdomain;
  return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', $textdomain) . '</a>';
}

// Remove Admin bar
function remove_admin_bar() { return false; }

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag) {
  return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions($html) {
  $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
  return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults) {
  $myavatar = PUBLIC_ASSETS . '/iamges/gravatar.jpg';
  $avatar_defaults[$myavatar] = "Custom Gravatar";
  return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments() {
  if (!is_admin()) {
    if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script('comment-reply');
    }
  }
}

// Custom Comments Callback
function themecomments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/** 

  ACTIONS/FILTERS/SHORTCODES
  
*/
// Add Actions
add_action('init', 'theme_javascript'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'page_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'theme_stylesheet'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'create_post_type'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'theme_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'view_more_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('shortcode_demo', 'shortcode_demo'); // You can place [shortcode_demo] in Pages, Posts now.
add_shortcode('shortcode_demo_2', 'shortcode_demo_2'); // Place [shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [shortcode_demo] [shortcode_demo_2] Here's the page title! [/shortcode_demo_2] [/shortcode_demo]

/** 

  CUSTOM POST TYPE
  
*/
function create_post_type() {
  global $textdomain;
  register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
  register_taxonomy_for_object_type('post_tag', 'html5-blank');
  register_post_type('html5-blank', // Register Custom Post Type
    array(
    'labels' => array(
      'name' => __('HTML5 Blank Custom Post', $textdomain), // Rename these to suit
      'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
      'add_new' => __('Add New', $textdomain),
      'add_new_item' => __('Add New HTML5 Blank Custom Post', $textdomain),
      'edit' => __('Edit', $textdomain),
      'edit_item' => __('Edit HTML5 Blank Custom Post', $textdomain),
      'new_item' => __('New HTML5 Blank Custom Post', $textdomain),
      'view' => __('View HTML5 Blank Custom Post', $textdomain),
      'view_item' => __('View HTML5 Blank Custom Post', $textdomain),
      'search_items' => __('Search HTML5 Blank Custom Post', $textdomain),
      'not_found' => __('No HTML5 Blank Custom Posts found', $textdomain),
      'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', $textdomain)
    ),
    'public' => true,
    'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
    'has_archive' => true,
    'supports' => array(
      'title',
      'editor',
      'excerpt',
      'thumbnail'
    ), // Go to Dashboard Custom HTML5 Blank post for supports
    'can_export' => true, // Allows export in Tools > Export
    'taxonomies' => array(
      'post_tag',
      'category'
    ) // Add Category and Post Tags support
  ));
}

/** 

  SHORTCODES
  
*/
// Shortcode Demo with Nested Capability
function shortcode_demo($atts, $content = null) {
  return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
// Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
function shortcode_demo_2($atts, $content = null) {
  return '<h2>' . $content . '</h2>';
}

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
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point( $path ) {
  // update path
  $path = get_stylesheet_directory() . '/admin/fields';
  // return
  return $path;
}
add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point( $paths ) {
  // remove original path (optional)
  unset($paths[0]);
  // append path
  $paths[] = get_stylesheet_directory() . '/admin/fields';
  // return
  return $paths;
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