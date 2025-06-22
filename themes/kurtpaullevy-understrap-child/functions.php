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
		'category_navbar'   => esc_html__('Category Navbar Menu', 'understrap-child'),
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

	$to = 'contact@kurtpaullevy.com';
	$subject = 'kurt Paul Levy contact form submitted';
	$message .= 'Hi Tom, <br /><br />';
	$message .= 'Someone has subscribed. <br /><br />';
	$message .= 'Thier email is ' . $email . '<br /><br />';
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

function understrap_child_add_span_to_menu_item_text ($items, $args) {
	if($args->theme_location == 'primary') {
		$items = preg_replace_callback('/(<a.*?>)(.*?)(<\/a>)/', function ($matches) {
			return $matches[1] . '<span>' . $matches[2] . '</span>' . $matches[3];
		}, $items);
	}

	return $items;
}

add_filter( 'wp_nav_menu_items', 'understrap_child_add_span_to_menu_item_text', 10, 2 );

function filter_lightbox_content() {
    if (isset($_POST['category']) && isset($_POST['postId'])) {
        // Sanitize inputs
        $category_slug = sanitize_text_field($_POST['category']);
        $post_id = sanitize_text_field($_POST['postId']);

        // Query for posts in the selected category
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => -1, // Get all posts
            'category_name' => $category_slug,
            'orderby' => 'title',
            'order' => 'ASC', // or DESC based on your needs
        );

        $query = new WP_Query($args);
        $posts = $query->get_posts();

        // Initialize previous and next post variables
        $previous_post = null;
        $next_post = null;

        if ($query->have_posts()) :
            foreach ($posts as $index => $post) {
                // If this is the clicked post, find previous and next posts
                if ($post->ID === (int)$post_id) {
                    $previous_post = isset($posts[$index - 1]) ? $posts[$index - 1] : null;
                    $next_post = isset($posts[$index + 1]) ? $posts[$index + 1] : null;
                    break;
                }
            }

            // Set the global post object for template part rendering
            $post = $posts[$index]; // Set the current post object
            setup_postdata($post); // Necessary for get_template_part()

            // Capture the content of the clicked post
            ob_start();
            get_template_part('loop-templates/content', get_post_format());
            $post_content = ob_get_clean();

            // Send the response with content and previous/next post IDs
            wp_send_json_success([
                'post_content' => $post_content,
                'previous_post' => $previous_post ? $previous_post->ID : null,
                'next_post' => $next_post ? $next_post->ID : null,
            ]);
        else :
            wp_send_json_error(['error' => 'No posts found for this category.']);
        endif;

        // Reset post data
        wp_reset_postdata();
    }
}

// Hook for lightbox functionality (logged-in users)
add_action('wp_ajax_filter_lightbox_content', 'filter_lightbox_content');
// Hook for lightbox functionality (non-logged-in users)
add_action('wp_ajax_nopriv_filter_lightbox_content', 'filter_lightbox_content');

function filter_category_posts() {
    if (isset($_POST['category'])) {
        // Sanitize the category input
        $category_slug = sanitize_text_field($_POST['category']);

        if($category_slug === "All work") {
			// Define query parameters for all posts
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => -1, // set a limit here
				'orderby' => 'title', 
				'order' => 'ASC'
			);
		}else{
			// Define query parameters to filter by category
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => -1, // set a limit here
				'category_name' => $category_slug,
				'orderby' => 'title', 
				'order' => 'ASC'
			);
		}

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            ob_start(); // Start output buffering to capture the HTML
            while ($query->have_posts()) : $query->the_post();
				$context = 'home';
				include locate_template('loop-templates/content-image.php');
            endwhile;
            $html = ob_get_clean(); // Get the buffered HTML output
            wp_send_json_success($html); // Return the HTML content as part of a JSON response
        else :
            wp_send_json_error(array('error' => 'No category specified.'));
        endif;

        // Reset post data
        wp_reset_postdata();
    }
}

// Hook for category filter functionality (logged-in users)
add_action('wp_ajax_filter_category_posts', 'filter_category_posts');
// Hook for category filter functionality (non-logged-in users)
add_action('wp_ajax_nopriv_filter_category_posts', 'filter_category_posts');

function hide_first_menu_item( $classes, $item, $args ) {
	if ( $args->theme_location === 'category_dropdown' && $item->ID === 65 ){
			$classes[] = 'hidden';
	}
	
	return $classes;
}

add_filter( 'nav_menu_css_class', 'hide_first_menu_item', 10, 3 );

function add_span_to_menu_item($items, $args) {
	if($args->theme_location === 'category_dropdown'){
		$items = preg_replace_callback('/(<a.*?>)(.*?)(<\/a>)/', function ($matches) {
			return $matches[1] . '<span>' . $matches[2] . '</span>' . $matches[3];
		}, $items);
	}
	return $items;
}

add_filter('wp_nav_menu_items', 'add_span_to_menu_item', 10, 2);

function add_button_to_menu_item($items, $args) {
    if ($args->theme_location === 'category_navbar' || $args->theme_location === 'category_dropdown') {
        $items = preg_replace_callback('/<a[^>]*?>(.*?)<\/a>/s', function ($matches) use ($args) {
            $label = wp_strip_all_tags($matches[1]);

            // Conditional classes
            $context_class = $args->theme_location === 'category_navbar' ? 'btn-navbar-category raised' : 'btn-dropdown-category';

            return '<button aria-pressed="false" type="button" class="btn ' . esc_attr($context_class) . '">' . esc_html($label) . '</button>';
        }, $items);
    }

    return $items;
}
add_filter('wp_nav_menu_items', 'add_button_to_menu_item', 10, 2);

function enqueue_lenis_script() {
    wp_enqueue_script(
        'lenis',
        'https://unpkg.com/lenis@1.3.1/dist/lenis.min.js',
        array(),
        '1.3.1',
        true
    );

    wp_enqueue_script(
        'lenis-init',
        get_stylesheet_directory_uri() . '/src/js/lenis-init.js',
        array('lenis'),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_lenis_script');

function enqueue_simplebar_assets () {
	wp_enqueue_style(
		'simplebar-css', 'https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.css',
		 array(),
    	null);

	wp_enqueue_script(
		'simplebar-js', 'https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js',
    	array(),
    	null,
    	true);
}

add_action('wp_enqueue_scripts', 'enqueue_simplebar_assets');




