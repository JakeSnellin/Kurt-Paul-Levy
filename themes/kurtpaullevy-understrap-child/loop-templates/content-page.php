<?php
/**
 * Partial template for content in page.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="d-flex flex-column flex-xxl-column-reverse">

		<?php
		if ( ! is_page_template( 'page-templates/no-title.php' ) ) {
			the_title(
				'<header class="entry-header"><h1 class="entry-title">',
				'</h1></header><!-- .entry-header -->'
			);
		}

		echo get_the_post_thumbnail( $post->ID, 'full' );
		?>

		<div class="entry-content mb-xxl-40 mt-22 mt-xxl-0">

			<?php
			$content = get_the_content(); 
			$strippedContent = wp_filter_nohtml_kses( $content );
			understrap_link_pages();
			?>

			<p><?php echo $strippedContent ?></p>

		</div><!-- .entry-content -->

		<footer class="entry-footer">

			<?php // understrap_edit_post_link(); ?>

		</footer><!-- .entry-footer -->

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
