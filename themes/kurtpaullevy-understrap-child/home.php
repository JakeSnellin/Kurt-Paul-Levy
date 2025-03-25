<?php
/**
 * The template for displaying all work pages.
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

            <main class="site-main" id="main" role="main">
                
                <?php if ( have_posts() ) : ?>
                    <div class="image-grid-container">
                        <?php
                        // Start the loop.
                        while ( have_posts() ) :
                            the_post();

                            /*
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'loop-templates/content', get_post_format() );
                        endwhile;
                        ?>
                    </div><!-- .flex-container -->
                <?php else : ?>
                    <?php get_template_part( 'loop-templates/content', 'none' ); ?>
                <?php endif; ?>

            </main><!-- #main -->

            <?php
            // Display the pagination component.
            // understrap_pagination();

            // Do the right sidebar check and close div#primary.
            get_template_part( 'global-templates/right-sidebar-check' );
            ?>

        </div><!-- .row -->

    </div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php get_footer(); ?>