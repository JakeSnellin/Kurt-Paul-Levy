<?php
/**
 * Header Navbar (bootstrap5)
 *
 * @package Understrap
 * @since 1.1.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<nav id="main-nav" class="z-3 bg-white fixed-top" aria-labelledby="main-nav-label">

	<h2 id="main-nav-label" class="screen-reader-text">
		<?php esc_html_e( 'Main Navigation', 'understrap' ); ?>
	</h2>

	<div class="<?php echo esc_attr( $container ); ?>">

		<!-- Your site branding in the menu -->
		<?php get_template_part( 'global-templates/navbar-branding' ); ?>

		<!-- The WordPress Menu goes here -->
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'menu_class'      => 'navbar-nav',
				'fallback_cb'     => '',
				'menu_id'         => 'main-menu',
				'depth'           => 0,
				'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
			)
		);
		?>

		<ul class="nav-category-menu">
			<?php
				get_template_part('global-templates/category-menu-items', null, [
    			'menu_location' => 'category_navbar'
			]);
			?>
      	</ul>

	</div><!-- .container(-fluid) -->

</nav><!-- #main-nav -->
