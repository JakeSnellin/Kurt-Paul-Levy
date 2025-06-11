<?php
/**
 * Dropdown category menu
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<div class="category-dropdown">
  <button class="category-dropdown__menu-btn btn btn-light raised" type="button" id="dropdownMenuButton" aria-expanded="false">
    <span id="dropdown-btn-text"><?php esc_html_e('All work', 'understrap-child') ?></span>
    <?php get_template_part('icon-templates/icons', 'caret-down'); ?>
  </button>

  <div class="category-dropdown-menu" aria-labelledby="dropdownMenuButton">
    <div data-simplebar data-lenis-prevent class="scroll-container">
      <ul>
        <?php
          get_template_part('global-templates/category-menu-items', null, [
          'menu_location' => 'category_dropdown'
          ]);
        ?>
      </ul>
    </div>
  </div>
</div>