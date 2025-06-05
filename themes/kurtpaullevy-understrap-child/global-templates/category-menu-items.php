<?php
/**
 * Category menu items
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<?php 
// Display the menu if it exists
wp_nav_menu(array(
    'theme_location' => 'category_dropdown',
    'container' => false,
    'items_wrap' => '%3$s', // Only outputs the <li> items
    'depth' => 1, // Prevents nested menu items from being displayed
    'walker' => new Walker_Nav_Menu() // Optional: if you need custom walker for dropdowns
)); 
?>