<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="scroll-wrapper">

	<div class="wrapper" id="index-wrapper">

		<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

			<div class="row">

				<?php
				// Do the left sidebar check and open div#primary.
				get_template_part( 'global-templates/left-sidebar-check' );
				?>

				<main class="site-main" id="main">

					<?php
					if ( have_posts() ) {
						// Start the Loop.
						while ( have_posts() ) {
							the_post();

							get_template_part( 'loop-templates/content', 'page' );
						}
					} else {
						get_template_part( 'loop-templates/content', 'none' );
					}
					?>

				</main>

				<?php
				// Do the right sidebar check and close div#primary.
				get_template_part( 'global-templates/right-sidebar-check' );
				?>

			</div><!-- .row -->

		</div><!-- #content -->

	</div><!-- #index-wrapper -->

	<?php
	get_footer();
	?>

</div><!-- #scroll-wrapper -->
