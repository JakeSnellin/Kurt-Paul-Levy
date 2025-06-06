<?php
/**
 * Category menu items
 *
 * @package Understrap
 */

defined( 'ABSPATH' ) || exit;

// Default fallback in case no location is passed
$menu_location = isset($args['menu_location']) ? sanitize_key($args['menu_location']) : 'category_dropdown';

wp_nav_menu(array(
    'theme_location' => $menu_location,
    'container'      => false,
    'items_wrap'     => '%3$s', // Only outputs the <li> items
    'depth'          => 1,
    'walker'         => new Walker_Nav_Menu(),
));
?>