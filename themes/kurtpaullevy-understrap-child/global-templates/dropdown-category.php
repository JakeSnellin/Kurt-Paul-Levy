<div class="category-dropdown">
  <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    <span id="dropdown-btn-text"><?php esc_html_e('All work', 'understrap-child') ?></span>
    <?php get_template_part('icon-templates/icons', 'caret'); ?>
  </button>

  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <?php 
    // Display the menu if it exists
    wp_nav_menu(array(
      'theme_location' => 'category_dropdown', // Define this location in your theme
      'container' => false,
      'items_wrap' => '%3$s', // Only outputs the <li> items
      'depth' => 1, // Prevents nested menu items from being displayed
      'walker' => new Walker_Nav_Menu() // Optional: if you need custom walker for dropdowns
    )); 
    ?>
  </ul>
</div>