<?php
/**
 * Lightbox 
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<div class="gallery-lightbox" aria-label="Gallery lightbox" role="dialog" aria-live="polite">
  <button 
    class="gallery-lightbox__btn gallery-lightbox__btn--close btn btn-light raised" 
    aria-controls="carousel" 
    id="gallery-lightbox__btn-close"
  >
    <?php get_template_part('icon-templates/icons', 'close'); ?> 
  </button>

  <div class="gallery-lightbox__controls">
    <button 
      class="gallery-lightbox__btn gallery-lightbox__btn--prev btn btn-light raised" 
      aria-controls="gallery-lightbox" 
      id="gallery-lightbox__btn-prev"
    >
      <?php get_template_part('icon-templates/icons', 'caret-prev'); ?>
    </button>

    <button 
      class="gallery-lightbox__btn gallery-lightbox__btn--next btn btn-light raised" 
      aria-controls="gallery-lightbox" 
      id="gallery-lightbox__btn-next"
    >
      <?php get_template_part('icon-templates/icons', 'caret-next'); ?>
    </button>
  </div>

  <div class="gallery-lightbox__content">
    <div class="gallery-lightbox__track">
    </div>
  </div>
</div>