<?php
/**
 * Left sidebar check
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );

if ( 'left' === $sidebar_pos || 'both' === $sidebar_pos ) {
	get_template_part( 'sidebar-templates/sidebar', 'left' );
}
?>

<div class="<?php echo esc_attr( !is_front_page() ? 'col-md content-area' : 'content-area' ); ?>" id="primary">
