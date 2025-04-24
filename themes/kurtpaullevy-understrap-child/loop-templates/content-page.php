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

	<div class="post-preview">

		<?php

		echo get_the_post_thumbnail( $post->ID, 'full' );
		?>

		<div class="entry-content">

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
