<?php
/**
 * Template part for displaying page content in front page
 *
 * @package Understrap
 */

defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<div class="homepage-media-wrapper__items">
			
			<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>

			<div class="arrow-icons">
				<span class="arrow"></span>
				<span class="arrow"></span>
				<span class="arrow"></span>
			</div>

		</div><!-- .content-area -->

</article>
