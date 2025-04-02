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
function understrap_child_register_menus() {
	register_nav_menus(array(
		'primary' 			=> esc_html__('Primary Menu', 'understrap-child'),
		'sidebar' 			=> esc_html__('Sidebar Menu', 'understrap-child'),
		'category_dropdown' => esc_html__('Dropdown Menu', 'understrap-child'),
	));
}

add_action( 'init', 'understrap_child_register_menus');

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

function understrap_child_add_post_count_to_menu_items( $items, $args ) {
    if ( isset( $args->menu ) && is_a( $args->menu, 'WP_Term' ) ) {
		
		$menu_slug = $args->menu->slug;

		if( 'sidebar-menu' === $menu_slug ) {
			$menu_labels_to_count = array(
				'All work' => array(
					'post_type' => 'post',
					'category' => '',      
				),
				'Selected work' => array(
					'post_type' => 'post',
					'category' => 'selected-work',
				),
			);
	
			// Loop through all menu items and modify the title
			foreach ( $items as $item ) {
				foreach( $menu_labels_to_count as $label => $args ){
					if( $label === $item->title ){
						$args_query = array(
							'post_type'=>$args[ 'post_type' ],
							'category_name'=>$args[ 'category' ],
							'post_status'=>'publish'
						);
						$query = new WP_Query( $args_query );
						$post_count = $query->found_posts;
					}
				}

				if( $item->title !== 'Full biography' ){
					$item->title .= ' [' . $post_count . ']';
				}
			}

			// Always reset post data after custom query
			wp_reset_postdata();
		}
    }

    return $items; // Return the modified menu items
}

add_filter( 'wp_nav_menu_objects', 'understrap_child_add_post_count_to_menu_items', 10, 2 );

function filter_posts_ajax_handler() {
    // Check if we received a valid category
    if (isset($_POST['category'])) {
        $category_slug = sanitize_text_field($_POST['category']);

		if($category_slug === "All work") {
			// Define query parameters for all posts
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => -1, // set a limit here
			);
		}else{
			// Define query parameters to filter by category
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => -1, // set a limit here
				'category_name' => $category_slug,
			);
		}

        // Query the posts
        $query = new WP_Query($args);

        // Check if there are posts
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                // Output the content image template part here
                get_template_part('loop-templates/content', get_post_format());
            endwhile;
        else :
            echo '<p>No posts found for this category.</p>';
        endif;

        // Always reset post data after custom query
        wp_reset_postdata();
    }

    // Terminate AJAX correctly
    wp_die();
}

// Hook for logged-in users
add_action('wp_ajax_filter_work_by_category', 'filter_posts_ajax_handler');

// Hook for non-logged-in users
add_action('wp_ajax_nopriv_filter_work_by_category', 'filter_posts_ajax_handler');

function add_class_to_specific_menu_item( $classes, $item, $args ) {
	// Check if the menu item ID is 65
	if( $item->ID === 65 ){
		// Add custom hidden class to menu item
		$classes[] = 'hidden';
	}
	return $classes;
}

add_filter( 'nav_menu_css_class', 'add_class_to_specific_menu_item', 10, 3 );

function add_span_to_menu_item($items, $args) {
	if($args->theme_location === 'category_dropdown'){
		$items = preg_replace_callback('/(<a.*?>)(.*?)(<\/a>)/', function ($matches) {
			return $matches[1] . '<span>' . $matches[2] . '</span>' . $matches[3];
		}, $items);
	}
	return $items;
}

add_filter('wp_nav_menu_items', 'add_span_to_menu_item', 10, 2);

