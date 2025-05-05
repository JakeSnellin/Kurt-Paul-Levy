<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Understrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="hero" id="index-hero">

	<div class="wrapper" id="index-wrapper">

		<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">
		
		<?php
			// Do the left sidebar check and open div#primary.
			get_template_part( 'global-templates/left-sidebar-check' );
		
		?>

		<div class="content-area__media-group">
			<div class="content-area__media-item">
				<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
			</div>
			<div class="arrow-icons">
				<span class="arrow"></span>
				<span class="arrow"></span>
				<span class="arrow"></span>
			</div>
		</div>

		</div> <!-- #content -->

	</div>

	</div> <!-- #index-wrapper -->

</div>

<?php get_footer() ?>

<!--<div class="wrapper" id="index-wrapper">

	<div class="<?php /* echo esc_attr( $container ); */ ?>" id="content" tabindex="-1">

			<?php
			// Do the left sidebar check and open div#primary.
			/*get_template_part( 'global-templates/left-sidebar-check' );*/
			?>

			<main class="site-main" id="main">
				<?php /*
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();

						get_template_part( 'loop-templates/content', 'page' );
					}
				} else {
					get_template_part( 'loop-templates/content', 'none' );
				}
				*/?>
			</main>

			<?php /*
			// Do the right sidebar check and close div#primary.
			get_template_part( 'global-templates/right-sidebar-check' );
			*/?>

	</div> --><!-- #content -->

<?php /* get_footer(); */

