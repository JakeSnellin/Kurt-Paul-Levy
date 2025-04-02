<?php
/**
 * Hero setup
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<div class="lightbox" role="dialog" aria-label="Image lightbox" aria-hidden="true">
    <div class="lightbox__buttons" >
        <button class="lightbox__previous" aria-label="Previous image">
            <?php get_template_part('icon-templates/icons', 'caret') ?>
        </button>
        <button class="lightbox__next" aria-label="Next image">
            <?php get_template_part('icon-templates/icons', 'caret') ?>
        </button>
        <button class="lightbox__close" aria-label="Close lightbox">
            <?php get_template_part('icon-templates/icons', 'close') ?>
        </button>
    </div>
    <div class="lightbox__content">
        <!-- dynamic content -->
    </div>
</div>