<?php
/**
 * The template for displaying category selected work page
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="archive-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php
			// Do the left sidebar check and open div#primary.
			get_template_part( 'global-templates/left-sidebar-check' );
			?>

			<main class="site-main" id="main">

				<div id="selected-work">

					<?php $args = array(
						'post_type' => 'post',
						'posts_per_page' => -1,
						'category_name' => 'selected-work',
						'orderby' => 'title', 
						'order' => 'ASC'
					);
					?>

					<?php $query = new WP_Query($args); ?>

					<?php
					if ( $query->have_posts() ) {
						?>
						<!--<header class="page-header">-->
							<?php /*
							the_archive_title( '<h1 class="page-title">', '</h1>' );
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
							*/?>
						<!--</header>--><!-- .page-header -->
						<?php
						// Start the loop.
						while ( $query->have_posts() ) {
							$query->the_post();

							/*
							* Include the Post-Format-specific template for the content.
							* If you want to override this in a child theme, then include a file
							* called content-___.php (where ___ is the Post Format name) and that will be used instead.
							*/
							get_template_part( 'loop-templates/content', get_post_format() );
						}
					} else {
						get_template_part( 'loop-templates/content', 'none' );
					}

					wp_reset_postdata();
					?>

				</div>

			</main>

			<?php
			// Do the right sidebar check and close div#primary.
			get_template_part( 'global-templates/right-sidebar-check' );
			?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php get_template_part('global-templates/back-to-top-button') ?>

<?php
get_footer();
