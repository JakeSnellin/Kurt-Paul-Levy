<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <div class="content-image-wrapper">
        <?php
        // Check if the post has a featured image and display it
        if ( has_post_thumbnail() ) : ?>
            <div class="entry-thumbnail">
                <?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
            </div>
        <?php endif; ?>

          <!-- Text to be displayed beside the image -->
          <div class="entry-content">
            <?php the_content(); ?>
        </div><!-- .entry-content -->
    </div><!-- .content-image-wrapper -->

</article><!-- #post-<?php the_ID(); ?> -->