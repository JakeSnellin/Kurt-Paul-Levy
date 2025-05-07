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
				<span class="arrow arrow-1"></span>
				<span class="arrow arrow-2"></span>
				<span class="arrow arrow-3"></span>
			</div>
		</div>

		</div> <!-- #content -->

	</div>

	</div> <!-- #index-wrapper -->

</div>

<?php get_footer();

