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

        <hr class="mb-xxl-22">

        <!-- Footer Section -->
        <footer class="site-footer" id="colophon">
            <div class="d-flex flex-column flex-xxl-row">

                <!-- Email Registration Form -->
                <form novalidate id="contact-form" class="d-flex mt-xxl-38 flex-column flex-xxl-row mb-56 gap-xxl-4">
                    <div class="form-group mb-11 mb-xxl-0">
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
                        <p id="email-help-block" class="my-11 lh-sm" role="alert">
                            <small><?php esc_html_e('Register your email for notifications of upcoming exhibitions.', 'understrap-child'); ?></small>
                        </p>
                    </div>

                    <button
                        class="btn btn-light raised mb-xxl-auto me-auto mt-xxl-n14"
                        type="submit"
                        name="submit"
                        id="submit-btn"
                        aria-label="Submit email for exhibition notifications"
                    >
                        <?php esc_html_e('Register', 'understrap-child'); ?>
                    </button>
                </form>

                <!-- Site Info Section -->
                <div class="site-info ms-xxl-auto d-flex flex-column justify-content-between">
                    <p class="lh-sm mb-4 xxl-xxl-0">
                        <small><?php esc_html_e('contact@kurtpaullevy.com', 'understrap-child'); ?></small>
                    </p>
                    <p class="ms-auto"><?php esc_html_e('copyrightkurtlevy', 'understrap-child'); ?></p>
                    <?php /* understrap_site_info(); */ ?>
                </div><!-- .site-info -->

            </div>
        </footer><!-- #colophon -->
    </div><!-- .container(-fluid) -->
</div><!-- #wrapper-footer -->

<?php // Closing div#page from header.php. ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>