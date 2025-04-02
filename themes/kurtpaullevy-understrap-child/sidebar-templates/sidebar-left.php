<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'left-sidebar' ) ) {
	return;
}

?>

<div class="d-none d-xxl-block widget-area" id="left-sidebar">

	<?php get_template_part( 'global-templates/navbar-branding' ); ?>

	<?php dynamic_sidebar( 'left-sidebar' ); ?>

	<?php get_template_part('global-templates/dropdown', 'category'); ?>

	<?php get_template_part('icon-templates/icons', 'email'); ?>

</div><!-- #left-sidebar -->
