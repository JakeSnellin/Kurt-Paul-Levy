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

function understrap_child_add_span_to_menu_item_text ($items, $args) {
	if($args->theme_location == 'primary') {
		$items = preg_replace_callback('/(<a.*?>)(.*?)(<\/a>)/', function ($matches) {
			return $matches[1] . '<span>' . $matches[2] . '</span>' . $matches[3];
		}, $items);
	}

	return $items;
}

add_filter( 'wp_nav_menu_items', 'understrap_child_add_span_to_menu_item_text', 10, 2 );

function understrap_child_add_contact_email_to_menu_items($items, $args) {

	if($args->theme_location == 'primary') {

		ob_start();
		$email_icon =  '<svg class="icon-email" xmlns="http://www.w3.org/2000/svg" width="21" height="15" viewBox="0 0 22 16" fill="none">
		<path xmlns="http://www.w3.org/2000/svg" d="M20.8455 1.09631L20.8466 1.09237L20.8227 1.0451C20.7446 0.880764 20.6425 0.729937 20.5215 0.597119C20.2075 0.250441 19.7725 0.0348929 19.2985 0C19.2968 0 19.2946 0 19.2929 0C19.294 0 19.289 0 19.2873 0C19.2856 0 19.284 0 19.2823 0C19.2801 0 19.2778 0 19.2762 0C19.2745 0 19.2728 0 19.2711 0C19.2689 0 19.2667 0 19.2645 0C19.2628 0 19.2611 0 19.2594 0C19.2578 0 19.2555 0 19.2539 0C19.2516 0 19.25 0 19.2477 0C19.246 0 19.2438 0 19.2421 0C19.2399 0 19.2377 0 19.236 0C19.2343 0 19.2321 0 19.2304 0C19.2282 0 19.226 0 19.2243 0C19.2221 0 19.221 0 19.2187 0C19.2165 0 19.2143 0 19.212 0C19.2104 0 19.2087 0 19.2065 0C19.2042 0 19.202 0 19.1998 0C19.1981 0 19.1959 0 19.1942 0C19.192 0 19.1897 0 19.188 0C19.1858 0 19.1847 0 19.1825 0C19.1808 0 19.178 0 19.1758 0C19.1741 0 19.1724 0 19.1702 0C19.1674 0 19.1657 0 19.1635 0H1.8376C1.8376 0 1.83314 0 1.83091 0C1.82924 0 1.82701 0 1.82589 0C1.82366 0 1.82143 0 1.8192 0C1.81753 0 1.81585 0 1.81362 0C1.81139 0 1.80916 0 1.80749 0C1.80582 0 1.80414 0 1.80191 0C1.79968 0 1.79689 0 1.79522 0C1.79355 0 1.79132 0 1.78964 0C1.78741 0 1.78574 0 1.78295 0C1.78128 0 1.77905 0 1.77737 0C1.77514 0 1.77347 0 1.77068 0C1.76901 0 1.76678 0 1.7651 0C1.76287 0 1.76064 0 1.75841 0C1.75674 0 1.75507 0 1.75284 0C1.7506 0 1.74837 0 1.7467 0C1.74503 0 1.74335 0 1.74112 0C1.73945 0 1.73722 0 1.73555 0C1.73387 0 1.73164 0 1.72941 0C1.72774 0 1.72607 0 1.72439 0C1.72216 0 1.72049 0 1.7177 0C1.71603 0 1.71435 0 1.71268 0C1.71101 0 1.70933 0 1.70655 0C1.70487 0 1.70376 0.000562788 1.70097 0C1.22693 0.0348929 0.791927 0.250441 0.478502 0.597119C0.357482 0.729937 0.255982 0.880764 0.177905 1.04454L0.153366 1.09181L0.154482 1.09575C0.0552118 1.32199 0 1.57187 0 1.83413V13.1608C0 14.175 0.824273 15 1.83705 15H19.163C20.1757 15 21 14.175 21 13.1608V1.83469C21 1.57243 20.9448 1.32199 20.8455 1.09631ZM1.07077 0.821671C1.21354 0.713616 1.38029 0.635388 1.56099 0.59543C1.56099 0.59543 1.56155 0.59543 1.5621 0.59543C1.56378 0.59543 1.56545 0.594868 1.56768 0.594305C1.56768 0.594305 1.5688 0.594305 1.56935 0.594305C1.64408 0.578547 1.72049 0.568979 1.79857 0.566165C1.80247 0.566165 1.80582 0.566165 1.80972 0.566165C1.81028 0.566165 1.81307 0.566165 1.81474 0.566165C1.81697 0.566165 1.81864 0.566165 1.82087 0.566165C1.82143 0.566728 1.82422 0.566165 1.82645 0.566165H1.83147C1.83147 0.566165 1.83593 0.566165 1.83816 0.566165H19.1702C19.1702 0.566165 19.1735 0.566165 19.1752 0.566165C19.1769 0.566165 19.1797 0.567291 19.1808 0.566165C19.183 0.566165 19.1841 0.566165 19.1869 0.566165C19.1886 0.566165 19.1897 0.566165 19.192 0.566165C19.1959 0.566165 19.2025 0.56504 19.2031 0.566165C19.2773 0.568417 19.3503 0.576858 19.4217 0.592054C19.4234 0.592054 19.4245 0.592053 19.4262 0.593179C19.4295 0.593742 19.4329 0.594305 19.4362 0.59543C19.6214 0.635951 19.7915 0.71643 19.937 0.827862C19.9376 0.827862 19.9381 0.828988 19.9387 0.82955C20.0575 0.920722 20.1607 1.03384 20.2427 1.16441C20.1897 1.31073 20.1055 1.44412 19.9956 1.55386L11.2576 10.2906C10.8405 10.7076 10.1618 10.7076 9.74516 10.2906L1.00608 1.55217C0.896216 1.44186 0.812004 1.30905 0.759023 1.16272C0.842677 1.02878 0.949197 0.913969 1.07077 0.821671ZM0.564387 13.1614V1.91067C0.578887 1.92643 0.593387 1.94162 0.609003 1.95682L6.79272 8.14017L0.905696 14.0258C0.69433 13.799 0.564387 13.4951 0.564387 13.1614ZM19.163 14.4316H1.8376C1.6781 14.4316 1.5253 14.4023 1.38476 14.3489L7.19371 8.54088L9.34697 10.6941C9.98274 11.3301 11.0178 11.3301 11.6536 10.6941L13.8359 8.51217L19.6571 14.332C19.5054 14.3961 19.3381 14.4316 19.1635 14.4316H19.163ZM20.4356 13.1614C20.4356 13.4805 20.3174 13.772 20.1216 13.9954L14.2363 8.11091L20.3916 1.95625C20.4066 1.94106 20.4217 1.92586 20.4356 1.9101V13.1608V13.1614Z" fill="#777777"/>
		</svg>';

		$items .= '<li class="menu-item menu-item-email">' . $email_icon . '<span>contact@kurtpaullevy.com</span></li>';
		
	}

	return $items;
}

add_filter( 'wp_nav_menu_items', 'understrap_child_add_contact_email_to_menu_items', 10, 2);

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
            'orderby' => 'date',
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
			);
		}else{
			// Define query parameters to filter by category
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => -1, // set a limit here
				'category_name' => $category_slug,
			);
		}

        $query = new WP_Query($args);

        if ($query->have_posts()) :
            ob_start(); // Start output buffering to capture the HTML
            while ($query->have_posts()) : $query->the_post();
				$context = 'home'; // or 'home', depending on logic
				include locate_template('loop-templates/content-image.php');
                //get_template_part('loop-templates/content', get_post_format());
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




