<<<<<<< Updated upstream
export function galleryLightboxController ($) {
    const galleryLightbox = $('.gallery-lightbox');
    const galleryLightboxTrack = $('.gallery-lightbox__track');
    const imageGridContainer = $('.image-grid-container');
    const prevBtn = $('.gallery-lightbox__btn--prev');
    const nextBtn = $('.gallery-lightbox__btn--next');
    const closeBtn = $('.gallery-lightbox__btn--close');
    let lightboxImages;
    let originalContent;

    let index;

    // Listen for a click on a gallery image
    imageGridContainer.on('click', function (e) {
    const closestFormatImage = $(e.target).closest('.format-image');
    if (closestFormatImage.length) { // Check if an element with .format-image was found
        index = closestFormatImage.index() + 1; // Get the index of the .format-image element

        createGalleryLightboxItems();

        updateTrackPosition();
        
        openGalleryLightbox();
    }
    });

    function createGalleryLightboxItems() {
        // Select all articles in the image grid container
        lightboxImages = $('.image-grid-container article');
        const lightboxHTML = [];

        lightboxImages.each(function() {
            const article = $(this);

            const imgSrc = article.find('img').attr('src');
            const imgAlt = article.find('img').attr('alt') || '';
            const srcset = article.find('img').attr('srcset');
            const fetchPriority = article.find('img').attr('fetchPriority');

            const metaText = article.find('p').first().html(); // gets inner HTML including <br>
            const metaParts = metaText.split('<br>').map(item => item.trim());

            // metaParts[0] = "12cm x 21cm", metaParts[1] = "Watercolour", metaParts[2] = "1989"
            const dimensions = metaParts[0] || '';
            const medium = metaParts[1] || '';
            const year = metaParts[2] || '';

            const tags = article.find('.category-pill-container .category-pill');
            let tagsHTML = '';
            tags.each(function() {
                const tagText = $(this).text().trim();
                tagsHTML += `<div class="tag">${tagText}</div>`;
            });

            const itemHTML = `
            <div class="gallery-lightbox__item">
              <img src="${imgSrc}" alt="${imgAlt}" srcset="${srcset}" fetchPriority="${fetchPriority}" />
              <div class="gallery-lightbox__info">
                <div class="gallery-lightbox__meta">
                  <p>${dimensions} <br> ${medium} <br> ${year}</p>
                </div>
                <div class="gallery-lightbox__tags">
                  ${tagsHTML}
                </div>
              </div>
            </div>
          `;

            lightboxHTML.push(itemHTML);
        });

        galleryLightboxTrack.html(lightboxHTML.join(''));

        lightboxImages = galleryLightboxTrack.children();

        cloneGalleryLightboxItems();
    }

    function updateTrackPosition() {
        galleryLightboxTrack.css('transform', 'translateX(' + (-(index * 100)) + '%)');
        lightboxImages.each(function(i, slide) {
            if (i === index) {
                $(slide).attr('aria-hidden', 'false');  // The active slide should be visible
            } else {
                $(slide).attr('aria-hidden', 'true');  // All other slides should be hidden
            }
        });
    }

    prevBtn.on('click', function () {
        galleryLightboxTrack.css('transition', 'transform 0.4s ease-in-out');
        if (index <= 0) return;
        index--;
        updateTrackPosition();
    });

    nextBtn.on('click', function () {
        galleryLightboxTrack.css('transition', 'transform 0.4s ease-in-out');
        if (index >= lightboxImages.length - 1) return;
        index++;
        updateTrackPosition();
    });

    galleryLightboxTrack.on('transitionend', function () {
        if($(lightboxImages[index]).attr('id') === 'lastClone') {
            galleryLightboxTrack.css("transition", "none");
            index = lightboxImages.length - 2;
            updateTrackPosition();	
        }
        if($(lightboxImages[index]).attr('id') === 'firstClone') {
            galleryLightboxTrack.css("transition", "none");
            index = 1;
            updateTrackPosition();	
        }
    })

    function openGalleryLightbox () {
        $(document.body).css('overflow', 'hidden');
        galleryLightbox.addClass('lightbox-gallery--open');
        galleryLightbox.attr('aria-hidden', 'false');
        // Focus on the close button when carousel opens
        galleryLightbox.focus();
    };

    closeBtn.on('click', function () {
        galleryLightboxTrack.css('transition', 'none');
        $(document.body).css('overflow', '');
        galleryLightbox.removeClass('lightbox-gallery--open');
        galleryLightbox.attr('aria-hidden', 'true');
        
        // Restore the original content of the image grid
        $('.image-grid-container').html(originalContent);
        // Return focus to the gallery image or button that opened the carousel
        $(this).focus();  // Or store and use the original focus element
    });

    function cloneGalleryLightboxItems() {

        // Save the original content before modifying it
        //originalContent = $('.image-grid-container').html();

        // Select all articles in the image grid container
        //lightboxImages = $('.image-grid-container article');

        // Replace existing content in carouselSlide with articles.
        //galleryLightboxTrack.html(lightboxImages);

        // Clone the first article and prepend it to the start of the carousel slide
        let firstClonedArticle = lightboxImages.eq(0).clone();  // Cloning the first article
        galleryLightboxTrack.append(firstClonedArticle);

        // Set the id of the first cloned article
        firstClonedArticle.attr('id', 'firstClone');

        // Clone the last article and append it to the end of the carousel slide
        let lastClonedArticle = lightboxImages.eq(lightboxImages.length - 1).clone();  // Cloning the last article
        lastClonedArticle.attr('id', 'lastClone');

        // Append the last cloned article to carouselSlide
        galleryLightboxTrack.prepend(lastClonedArticle);

        lightboxImages = galleryLightboxTrack.children();
    }

     // Keyboard Accessibility for arrow keys and Escape key
     $(document).on('keydown', function (e) {
        if (e.key === 'ArrowLeft') {
            prevBtn.click();
        } else if (e.key === 'ArrowRight') {
            nextBtn.click();
        } else if (e.key === 'Escape') {
            closeBtn.click();
        }
    });
=======
import { filterLightBoxAjax } from "./ajax/filterLightBoxContentAjax";

export function lightBox ($) {
    $('#image-grid-container').on('click', function(e) {
        if($(e.target).closest('.format-image')){ //
            const clickedPostID = $(e.target).closest('.format-image').attr('id').replace('post-', '');
            console.log(clickedPostID);
            //get the category 
            const categoryText = $('#dropdown-btn-text').text();

            //open the lightbox.
            $('.lightbox').addClass('open');
            $('body').css('overflow', 'hidden');

            filterLightBoxAjax($, { postId: clickedPostID, category: categoryText });
        }
    })
>>>>>>> Stashed changes
}