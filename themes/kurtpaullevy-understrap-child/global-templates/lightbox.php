<?php
/**
 * Hero setup
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
      <?php get_template_part('icon-templates/icons', 'caret'); ?>
    </button>

    <button 
      class="gallery-lightbox__btn gallery-lightbox__btn--next btn btn-light raised" 
      aria-controls="gallery-lightbox" 
      id="gallery-lightbox__btn-next"
    >
      <?php get_template_part('icon-templates/icons', 'caret'); ?>
    </button>
  </div>

  <div class="gallery-lightbox__content">
    <div class="gallery-lightbox__track">
      <!--<div class="gallery-lightbox__item">
          <img src="https://picsum.photos/1010/715" alt="" />
          <div class="gallery-lightbox__info">
            <div class="gallery-lightbox__meta">
            <p> 12cm x 21cm <br> Watercolour <br> 1989 </p>
            </div>
            <div class="gallery-lightbox__tags">
              <div class="tag">Abstract</div>
              <div class="tag">Watercolour</div>
              <div class="tag">Print</div>
            </div>
          </div>
        </div>
        <div class="gallery-lightbox__item">
          <div>
          <img src="https://picsum.photos/1010/715" alt="" />
          <div class="gallery-lightbox__info">
            <div class="gallery-lightbox__meta">
            <p> 12cm x 21cm <br> Watercolour <br> 1989 </p>
            </div>
            <div class="gallery-lightbox__tags">
              <div class="tag">Abstract</div>
              <div class="tag">Watercolour</div>
              <div class="tag">Print</div>
            </div>
          </div>
        </div>-->
      <!-- dynamic content -->
    </div>
  </div>
</div>