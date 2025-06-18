<?php
/**
 * Back to top button
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<button class="back-to-top"><div class="back-to-top__btn-wrapper"><span id="back-to-top__btn-text"><?php esc_html_e('Back to top', 'understrap-child') ?></span><?php get_template_part('icon-templates/icons', 'caret-up'); ?></div></button>