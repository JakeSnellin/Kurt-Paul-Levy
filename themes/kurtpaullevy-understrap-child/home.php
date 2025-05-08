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

                <?php get_template_part( 'global-templates/lightbox' ); ?>

                <?php get_template_part( 'global-templates/dropdown', 'category' ) ?>
                
                <div id="image-grid-container">
                    <?php
                    if ( have_posts() ) :
                        while ( have_posts() ) : the_post();
                            get_template_part( 'loop-templates/content', get_post_format() );
                        endwhile;
                    else :
                        echo '<p>No posts found.</p>';
                    endif;
                    ?>
                </div><!-- .image-grid-container -->

            </main><!-- #main -->

            <?php
            // Do the right sidebar check and close div#primary.
            get_template_part( 'global-templates/right-sidebar-check' );
            ?>

        </div><!-- .row -->

    </div><!-- #content -->

</div><!-- #archive-wrapper -->

<?php get_template_part('global-templates/back-to-top-button') ?>

<?php get_footer(); ?>