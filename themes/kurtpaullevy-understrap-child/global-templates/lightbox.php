<?php
/**
 * Hero setup
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<div class="carousel" aria-label="Image carousel" role="dialog" aria-live="polite"> <!-- aria-hidden="true" -->
  <div class="carousel__inner">
    <div class="carousel__slide">
      <!-- dynamic content -->
    </div>
    <button class="carousel__button carousel__button--prev raised btn btn-light" aria-controls="carousel" id="prev-btn">
	    <?php get_template_part('icon-templates/icons', 'caret'); ?>
    </button>
    <button class="carousel__button carousel__button--next raised btn btn-light" aria-controls="carousel" id="next-btn btn btn-light">
    	<?php get_template_part('icon-templates/icons', 'caret'); ?>
    </button>
    <button class="carousel__button carousel__button--close raised btn btn-light" aria-controls="carousel" id="close-btn btn btn-light">
   	    <?php get_template_part('icon-templates/icons', 'close'); ?> 
    </button>
  </div>
</div>