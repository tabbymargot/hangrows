<?php
/**
 * Custom amendments for the theme.
 *
 * @package     FoodiePro
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2014, Shay Bocks
 * @license     GPL-2.0+
 * @link        http://www.shaybocks.com/foodie-pro/
 * @since       1.0.1
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CHILD_THEME_NAME', 'Foodie Pro Theme' );
define( 'CHILD_THEME_VERSION', '2.1.8' );
define( 'CHILD_THEME_URL', 'http://shaybocks.com/foodie-pro/' );
define( 'CHILD_THEME_DEVELOPER', 'Shay Bocks' );

add_action( 'after_setup_theme', 'foodie_pro_load_textdomain' );
/**
 * Loads the child theme textdomain.
 *
 * @since  2.1.0
 * @return void
 */
function foodie_pro_load_textdomain() {
	load_child_theme_textdomain(
		'foodiepro',
		trailingslashit( get_stylesheet_directory() ) . 'languages'
	);
}

add_action( 'genesis_setup', 'foodie_pro_theme_setup', 15 );
/**
 * Theme Setup
 *
 * This setup function hooks into the Genesis Framework to allow access to all
 * of the core Genesis functions. All the child theme functionality can be found
 * in files located within the /includes/ directory.
 *
 * @since  1.0.1
 * @return void
 */
function foodie_pro_theme_setup() {
	//* Add viewport meta tag for mobile browsers.
	add_theme_support( 'genesis-responsive-viewport' );

	//* Add HTML5 markup structure.
	add_theme_support( 'html5' );

	//*	Set content width.
	$content_width = apply_filters( 'content_width', 610, 610, 980 );

	//* Add new featured image sizes.
	add_image_size( 'horizontal-thumbnail', 680, 450, true );
	add_image_size( 'vertical-thumbnail', 680, 900, true );
	add_image_size( 'square-thumbnail', 320, 320, true );

	//* Add Accessibility support
	add_theme_support(
		'genesis-accessibility',
		array(
			'headings',
			'search-form',
			'skip-links',
		)
	);

	//* Add support for custom background.
	add_theme_support( 'custom-background' );

	//* Unregister header right sidebar.
	unregister_sidebar( 'header-right' );

	//* Add support for custom header.
	add_theme_support( 'genesis-custom-header', array(
			'width'  => 800,
			'height' => 340,
		)
	);

	//* Add support for 4-column footer widgets.
	add_theme_support( 'genesis-footer-widgets', 4 );
}

add_action( 'genesis_setup', 'foodie_pro_includes', 20 );
/**
 * Load additional functions and helpers.
 *
 * DO NOT MODIFY ANYTHING IN THIS FUNCTION.
 *
 * @since   2.0.0
 * @return  void
 */
function foodie_pro_includes() {
	$includes_dir = trailingslashit( get_stylesheet_directory() ) . 'includes/';

	// Load the customizer library.
	require_once $includes_dir . 'vendor/customizer-library/customizer-library.php';

	// Load all customizer files.
	require_once $includes_dir . 'customizer/customizer-display.php';
	require_once $includes_dir . 'customizer/customizer-settings.php';

	// Load everything in the includes root directory.
	require_once $includes_dir . 'helper-functions.php';
	require_once $includes_dir . 'compatability.php';
	require_once $includes_dir . 'simple-grid.php';
	require_once $includes_dir . 'widgeted-areas.php';
	require_once $includes_dir . 'widgets.php';

	// End here if we're not in the admin panel.
	if ( ! is_admin() ) {
		return;
	}

	// Load the TGM Plugin Activation class.
	require_once $includes_dir . 'vendor/class-tgm-plugin-activation.php';

	// Load everything in the admin root directory.
	require_once $includes_dir . 'admin/functions.php';
}

/**
 * Load Genesis
 *
 * This is technically not needed.
 * However, to make functions.php snippets work, it is necessary.
 */
require_once( get_template_directory() . '/lib/init.php' );

add_action( 'wp_enqueue_scripts', 'foodie_pro_enqueue_js' );
/**
 * Load all required JavaScript for the Foodie theme.
 *
 * @since   1.0.1
 * @return  void
 */
function foodie_pro_enqueue_js() {
	$js_uri = get_stylesheet_directory_uri() . '/assets/js/';
	// Add general purpose scripts.
	wp_enqueue_script(
		'foodie-pro-general',
		$js_uri . 'general.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);
}

add_filter( 'body_class', 'foodie_pro_add_body_class' );
/**
 * Add the theme name class to the body element.
 *
 * @since  1.0.0
 *
 * @param  string $classes
 * @return string Modified body classes.
 */
function foodie_pro_add_body_class( $classes ) {
	$classes[] = 'foodie-pro';
	return $classes;
}

//* Add post navigation.
add_action( 'genesis_after_entry_content', 'genesis_prev_next_post_nav', 5 );

add_filter( 'excerpt_more', 'foodie_pro_read_more_link' );
add_filter( 'get_the_content_more_link', 'foodie_pro_read_more_link' );
add_filter( 'the_content_more_link', 'foodie_pro_read_more_link' );
/**
 * Modify the Genesis read more link.
 *
 * @since  1.0.0
 *
 * @param  string $more
 * @return string Modified read more text.
 */
function foodie_pro_read_more_link() {
	return '...</p><p><a class="more-link" href="' . get_permalink() . '">' . __( 'Read More', 'foodiepro' ) . ' &raquo;</a></p>';
}

add_filter( 'genesis_comment_form_args', 'foodie_pro_comment_form_args' );
/**
 * Modify the speak your mind text.
 *
 * @since   1.0.0
 *
 * @param   $args the default comment reply text.
 * @return  $args the modified comment reply text.
 */
function foodie_pro_comment_form_args( $args ) {
	$args['title_reply'] = __( 'Comments', 'foodiepro' );
	return $args;
}

add_filter( 'genesis_footer_creds_text', 'foodie_pro_footer_creds_text' );
/**
 * Customize the footer text
 *
 * @since  1.0.0
 *
 * @param  string $creds Default credits.
 * @return string Modified Shay Bocks credits.
 */
function foodie_pro_footer_creds_text( $creds ) {
	return sprintf(
		'[footer_copyright before="%s "] &middot; [footer_childtheme_link before=""] %s <a href="http://shaybocks.com/">%s</a> &middot; %s [footer_genesis_link url="http://www.studiopress.com/" before=""] &middot; [footer_wordpress_link before=" %s"]',
		__( 'Copyright', 'foodiepro' ),
		__( 'by', 'foodiepro' ),
		CHILD_THEME_DEVELOPER,
		__( 'Built on the ', 'foodiepro' ),
		__( 'Powered by ', 'foodiepro' )
	);
}

//* MY ADDITIONS

//* Add Google Fonts - see http://www.wpbeginner.com/wp-themes/how-add-google-web-fonts-wordpress-themes/

function wpb_add_google_fonts() {

	wp_enqueue_style( 'wpb-google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600|Montserrat:400,700|Patua+One:400', false ); 
	}

add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );

//* Remove sidebar from selected pages

add_action( 'get_header', 'remove_primary_sidebar_selected_pages' );

function remove_primary_sidebar_selected_pages() {
	if ( is_page_template( 'page_no_sidebar.php' || 'page_scrapbook.php' ) ) {
	remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
	}
}

//* Remove 'Blog' heading from blogroll page 
		remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_date] [post_edit]';
	return $post_info;
}

//* Load JS file

function wpmu_load_scripts() {
	wp_enqueue_script( 'youtube', get_stylesheet_directory_uri() . '/scripts/youtube.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'wpmu_load_scripts' );

add_action( 'wp_enqueue_scripts', 'rgc_simple_social_icons_fontawesome' );



// *Replace simple social icons with font awesome - see https://robincornett.com/simple-social-icons-fontawesome/

/**
 * Enqueue FontAwesome stylesheet - need to make sure the version is set to latest version to get latest icons, ie here it is 4.6.3
 */
function rgc_simple_social_icons_fontawesome() {
	wp_enqueue_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array(), '4.6.3' );
}

add_filter( 'simple_social_default_css', 'rgc_simple_social_icons_css' );
/**
 * Replace Simple Social Icons' stylesheet
 */
function rgc_simple_social_icons_css( $css_file ) {
	// $css_file = get_stylesheet_directory_uri() . '../../themes/foodiepro-2.1.8/style.css';
	$css_file = 'style.css'; // alternate method: if you want to just add your styling to your theme styesheet

	return $css_file;
}

add_filter( 'simple_social_default_glyphs', 'rgc_simple_social_icons_glyphs' );
/**
 * Replace Simple Social Icons's glyphs with FontAwesome
 */
function rgc_simple_social_icons_glyphs( $glyphs ) {
	$glyphs = array(
		'bloglovin'   => '<span class="fa fa-heart"></span>',
		'dribbble'    => '<span class="fa fa-dribbble"></span>',
		'email'       => '<span class="fa fa-envelope"></span>',
		'facebook'    => '<span class="fa fa-facebook"></span>',
		'flickr'      => '<span class="fa fa-flickr"></span>',
		'github'      => '<span class="fa fa-github"></span>',
		'gplus'       => '<span class="fa fa-google-plus"></span>',
		'instagram'   => '<span class="fa fa-instagram"></span>',
		'linkedin'    => '<span class="fa fa-linkedin"></span>',
		'pinterest'   => '<span class="fa fa-pinterest"></span>',
		'rss'         => '<span class="fa fa-rss"></span>',
		'stumbleupon' => '<span class="fa fa-stumbleupon"></span>',
		'tumblr'      => '<span class="fa fa-tumblr"></span>',
		'twitter'     => '<span class="fa fa-twitter"></span>',
		'vimeo'       => '<span class="fa fa-vimeo-square"></span>',
		'youtube'     => '<span class="fa fa-youtube"></span>',
	);

	return $glyphs;
}

//*Edit text in footer
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] HANNAH GROWS &middot; WEBSITE BY <a href="http://www.carolinemarie.co.uk">Caroline Marie Web Design</a> ';
	return $creds;
}

//* Add new button to Naked Social Media plugin - see https://gist.github.com/nosegraze/73e950885fdbbecb20fe

/**
 * Add 'Share' button as a new button.
 *
 * @param array $sites Available sites.
 *
 * @return array
 */
function nss_addon_add_share( $sites ) {
	$sites['share'] = __( 'Share' );
	return $sites;
}
add_filter( 'naked-social-share/available-sites', 'nss_addon_add_share' );

/**
 * Display the Share Button
 */
function nss_addon_display_share( $site_name, $share_numbers, $post, $disable_counters ) {
	// Bail if the site name isn't 'share'.
	if ( $site_name != 'share' ) {
		return;
	}
	?>
	<li class="nss-share">
			<?php echo "Share this post:"; ?>
			<span class="nss-site-name"><?php _e( 'share' ); ?></span>
			<?php if ( $disable_counters == false ) : ?>
				<span class="nss-site-count"><!-- Share count here --></span>
			<?php endif; ?>
	</li>
	<?php
}
add_action( 'naked_social_share_display_buttons', 'nss_addon_display_share', 10, 4 );


//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'sp_read_more_link' );
function sp_read_more_link() {
	return '... <a class="more-link" href="' . get_permalink() . '">View Post &raquo;</a>';
}

//Add CSS style to next_posts_link() and previous_posts_link() - see http://bit.ly/2fmCUkZ


//    add_filter('next_posts_link_attributes', 'posts_link_attributes');
//    add_filter('previous_posts_link_attributes', 'posts_link_attributes');
//
//  
//
//    function posts_link_attributes() {
//        return 'class="more-link"';
//    }
    
