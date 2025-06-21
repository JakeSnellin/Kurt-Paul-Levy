<?php
/**
 * Content image partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <?php
    // Determine the classes for the content wrapper
    $content_wrapper_classes = '';
    if ( ( isset($context) && $context === 'home' ) || is_home() ) {
        $content_wrapper_classes = 'home-page';
    } elseif ( ( isset($context) && $context === 'category' ) || is_category() ) {
        $content_wrapper_classes = 'category-page';
    }
    ?>

    <div class="content-image-wrapper <?php echo esc_attr( $content_wrapper_classes ); ?>">

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="entry-thumbnail">
                <?php the_post_thumbnail( 'full' ); ?>
            </div>
        <?php endif; ?>

        <!-- Text to be displayed beside the image -->
        <div class="entry-content">
            <?php the_content(); ?>
        </div><!-- .entry-content -->

        <?php if ( ( isset($context) && $context === 'home' ) || is_home() ) : ?>
            <!-- Display category pill below the image -->
            <?php 
            $categories = get_the_category();
            ?>
            <div class="category-pill-container">
            <?php
            foreach ( $categories as $category ) :
                // Skip the 'Selected Work' category by name or slug
                if ( $category->name === 'Selected Work' || $category->slug === 'selected-work' ) {
                    continue;
                }
            ?>
                <div class="category-pill <?php echo esc_attr( $category->slug ); ?>">
                    <?php echo esc_html( $category->name ); ?>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div><!-- .content-image-wrapper -->

</article><!-- #post-<?php the_ID(); ?> -->