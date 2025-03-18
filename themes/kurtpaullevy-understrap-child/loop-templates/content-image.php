<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header">

        <?php
        // Check if the post has a featured image and display it
        if ( has_post_thumbnail() ) : ?>
            <div class="entry-thumbnail">
                <?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
            </div>
        <?php endif; ?>

    </header><!-- .entry-header -->

	<div class="entry-content">
         <!-- Text to be displayed below the image -->
		<?php
        the_content();
		?>

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
