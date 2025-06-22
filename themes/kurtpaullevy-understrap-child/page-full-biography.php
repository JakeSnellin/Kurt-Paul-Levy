<?php
/**
 * The template for displaying the full biography page
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="biography-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php
			// Do the left sidebar check and open div#primary.
			get_template_part( 'global-templates/left-sidebar-check' );
			?>

			<main class="site-main" id="main">

            <div class="bio-intro-text">
                <?php 
                    $intro_text = get_field('intro_text');
                    $formatted = wpautop( $intro_text );
                    $paragraphs = explode('</p>', $formatted);
                    $paragraphs = array_filter(array_map('trim', $paragraphs)); // remove empty entries
                    $count = count($paragraphs);

                    // Open first wrapper
                    echo '<div class="intro-wrapper intro-wrapper-1">';

                    foreach ($paragraphs as $i => $para) {
                        // Split after 3 paragraphs (adjust as needed)
                        if ($i === 3) {
                            echo '</div><div class="intro-wrapper intro-wrapper-2">';
                        }

                        // Re-append </p> tag since explode removed it
                        echo $para . '</p>';
                    }

                    // Close final wrapper
                    echo '</div>';
                ?>
            </div>

                <div class="bio-main-images">
                    
                    <?php 
                        $main_image_1 = get_field('main_image_1');
                        $main_image_2 = get_field('main_image_2');

                        if ( $main_image_1 ) : ?>

                        <div class="bio-main-image">
                            <?php echo wp_get_attachment_image($main_image_1['ID'], 'large', false, ['class' => 'img-fluid']); ?>
                            <?php if (!empty($main_image_1['caption'])): ?>
                                <p class="bio-image-caption"><?php echo esc_html($main_image_1['caption']); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <?php  if ( $main_image_2 ) : ?>

                            <div class="bio-main-image">
                            <?php echo wp_get_attachment_image($main_image_2['ID'], 'large', false, ['class' => 'img-fluid']); ?>
                            <?php if (!empty($main_image_2['caption'])): ?>
                                <p class="bio-image-caption"><?php echo esc_html($main_image_2['caption']); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                </div>

                <div class="portrait-gallery">

                    <?php $portrait_gallery_title = get_field('self_portrait_section_title') ?>
                    <?php if ( $portrait_gallery_title ) : ?>
                        <h2 class="portrait-gallery__title"><?php echo esc_html( $portrait_gallery_title ) ?></h2>
                    <?php endif; ?>

                    <div class="portrait-gallery__groups">
                    
                        <?php
        
                            $galleryImages = [];

                            for($i = 0; $i <= 6; $i++) {
                                $img = get_field("gallery_image_$i");
                                if ($img) {
                                    $galleryImages[] = $img;
                                }
                            }
                        ?>

                        <?php for($i = 0; $i < count($galleryImages); $i++) : ?>

                                <?php if($i === 0) : ?>
                                    <div class="portrait-gallery__group portrait-gallery__group--first">
                                <?php endif; ?>

                                <?php if($i === 3) : ?>
                                    </div>
                                    <div class="portrait-gallery__group portrait-gallery__group--second">
                                <?php endif; ?>

                                <?php echo wp_get_attachment_image($galleryImages[$i]['ID'], 'large', false, ['class' => 'img-fluid']); ?>

                                <?php if($i === count($galleryImages) - 1) : ?>
                                    </div>
                                <?php endif; ?>

                        <?php endfor; ?> 

                    </div>

                </div>

                <div class="book-feature">
                    <p>
                        <?php esc_html_e("Kurt is to be featured in a new book ‘Deya Heydays - the History of an Artists Community’"); ?>
                        <a href="https://deyaheydays.com/" target="_blank" rel="noopener noreferrer">
                            <?php esc_html_e('www.deyaheydays.com', 'understrap'); ?>
                        </a>
                    </p>
                </div>

			</main>

			<?php
			// Do the right sidebar check and close div#primary.
			get_template_part( 'global-templates/right-sidebar-check' );
			?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php
get_footer();
