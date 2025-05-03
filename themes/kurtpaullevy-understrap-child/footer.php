<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">
    <div class="<?php echo esc_attr( $container ); ?>">

        <?php
            if ( is_front_page() ) {
                $footer_text = get_field( 'footer_intro_text', get_option( 'page_on_front' ) );
                if ( $footer_text ) {
                    echo '<div class="footer-intro-text">';
                    echo wpautop( wp_kses_post( $footer_text ) );
                    echo '</div>';
                }
            }
        ?>

        <?php if( !is_front_page() ) : ?>

        <hr>

        <?php endif; ?>

        <!-- Footer Section -->
        <footer class="site-footer" id="colophon">
            <div class="d-flex flex-column flex-xxl-row">

                <!-- Email Registration Form -->
                <form novalidate id="contact-form" class="d-flex flex-column flex-xxl-row gap-xxl-4">
                    <div class="form-group mb-xxl-0">
                        <input
                            type="email"
                            autocomplete="off"
                            class="form-control px-0"
                            id="email"
                            aria-label="Email"
                            aria-describedby="email-help-block"
                            placeholder="Your email"
                        >
                        <div id="validation-container"></div>
                        <div id="email-help-block" role="alert">
                            <p><?php esc_html_e('Register your email for notifications of upcoming exhibitions.', 'understrap-child'); ?></p>
                        </div>
                    </div>

                    <button
                        class="btn btn-light raised mb-xxl-auto me-auto"
                        type="submit"
                        name="submit"
                        id="submit-btn"
                        aria-label="Submit email for exhibition notifications"
                    >
                        <?php esc_html_e('Register', 'understrap-child'); ?>
                    </button>
                </form>

                <!-- Site Info Section -->
                <div class="site-info ms-xxl-auto">
                        <p><?php esc_html_e('contact@kurtpaullevy.com', 'understrap-child'); ?></p>
                    <?php /* understrap_site_info(); */ ?>
                </div><!-- .site-info -->
            </div>
            <p class="ms-auto footer__copyright-text"><?php esc_html_e('© 2025 Kurt Paul Levy', 'understrap-child'); ?></p>
        </footer><!-- #colophon -->
    </div><!-- .container(-fluid) -->
</div><!-- #wrapper-footer -->

<?php // Closing div#page from header.php. ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>