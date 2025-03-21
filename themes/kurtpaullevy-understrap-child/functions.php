<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;



/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";
	
	$css_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_styles );

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $css_version );
	wp_enqueue_script( 'jquery' );
	
	$js_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . $theme_scripts );
	
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $js_version, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );

/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );

/**
 * Support SVG mime type
 */
add_filter('upload_mimes', function( $mimes ){
	$mimes[ 'svg' ] = 'image/svg+xml';
	return $mimes;
});

/**
 * Register Primary Menu location
 */
function understrap_child_register_menu() {
	register_nav_menu('primary', esc_html__('Primary Menu', 'understrap-child'));
}

add_action( 'init', 'understrap_child_register_menu');

/**
 * Hide admin bar during development 
 */
add_filter('show_admin_bar', '__return_false');

/**
 * Set mail content type to HTML
 */
function understrap_child_set_html_mail_content_type() {
	return 'text/html';
}
add_filter( 'wp_mail_content_type', 'understrap_child_set_html_mail_content_type' );


/**
 * Register a new user and send admin email notification  
 */
function understrap_child_registration_form() {
	$email = sanitize_email($_POST['ajax_data']);

	$message = "";

	$to = get_bloginfo('admin_email');
	$subject = 'kurt Paul Levy contact form submitted';
	$message .= 'Hi Tom, <br /><br />';
	$message .= 'Someone has subscribed. <br /><br />';
	$message .= 'There email is ' . $email . '<br /><br />';
	$message .= 'Thank you!';

	wp_mail($to, $subject, $message);

	$return = [];
	$return['success'] = 1;
	$return['message'] = 'Thanks for registering.';

	wp_send_json($return);
}

add_action('wp_ajax_register_user', "understrap_child_registration_form");
add_action('wp_ajax_nopriv_register_user', "understrap_child_registration_form");

/**
 * Support image post format
 */

 function childtheme_formats(){
	add_theme_support( 'post-formats', array('image') ); 
}
add_action( 'after_setup_theme', 'childtheme_formats', 11 );