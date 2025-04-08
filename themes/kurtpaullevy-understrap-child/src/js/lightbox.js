export function lightBox ($) {
    const carousel = $('.carousel');
    const carouselInner = $('.carousel__inner');
    const carouselSlide = $('.carousel__slide');
    const imageGridContainer = $('.image-grid-container');
    const prevBtn = $('.carousel__button--prev');
    const nextBtn = $('.carousel__button--next');
    const closeBtn = $('.carousel__button--close');
    let carouselImages;
    let originalContent;

    let index;

    // Listen for a click on a gallery image
    imageGridContainer.on('click', function (e) {
    const closestFormatImage = $(e.target).closest('.format-image');
    if (closestFormatImage.length) { // Check if an element with .format-image was found
        index = closestFormatImage.index() + 1; // Get the index of the .format-image element

        addSlideContentToCarousel();

        updateCarouselSlidePosition();
        
        openCarousel();
    }
    });

    function updateCarouselSlidePosition() {
        carouselSlide.css('transform', 'translateX(' + (-(index * 100)) + '%)');
        carouselImages.each(function(i, slide) {
            if (i === index) {
                $(slide).attr('aria-hidden', 'false');  // The active slide should be visible
            } else {
                $(slide).attr('aria-hidden', 'true');  // All other slides should be hidden
            }
        });
    }

    prevBtn.on('click', function () {
        carouselSlide.css('transition', 'transform 0.4s ease-in-out');
        if (index <= 0) return;
        index--;
        updateCarouselSlidePosition();
    });

    nextBtn.on('click', function () {
        carouselSlide.css('transition', 'transform 0.4s ease-in-out');
        if (index >= carouselImages.length - 1) return;
        index++;
        updateCarouselSlidePosition();
    });

    carouselSlide.on('transitionend', function () {
        if($(carouselImages[index]).attr('id') === 'lastClone') {
            console.log('last clone');
            carouselSlide.css("transition", "none");
            //carouselSlide.css("transition", "none");
            index = carouselImages.length - 2;
            updateCarouselSlidePosition();	
        }
        if($(carouselImages[index]).attr('id') === 'firstClone') {
            console.log('first clone');
            carouselSlide.css("transition", "none");
            index = 1;
            updateCarouselSlidePosition();	
        }
    })

    function openCarousel () {
        $(document.body).css('overflow', 'hidden');
        carousel.addClass('carousel--open');
        carousel.attr('aria-hidden', 'false');
        // Focus on the close button when carousel opens
        carousel.focus();
    };

    closeBtn.on('click', function () {
        $(document.body).css('overflow', '');
        carousel.removeClass('carousel--open');
        carousel.attr('aria-hidden', 'true');
        
        // Restore the original content of the image grid
        $('.image-grid-container').html(originalContent);
        // Return focus to the gallery image or button that opened the carousel
        $(this).focus();  // Or store and use the original focus element
    });

    function addSlideContentToCarousel() {

        // Save the original content before modifying it
        originalContent = $('.image-grid-container').html();

        // Select all articles in the image grid container
        carouselImages = $('.image-grid-container article');

        // Replace existing content in carouselSlide with articles.
        carouselSlide.html(carouselImages);

        // Clone the first article and prepend it to the start of the carousel slide
        let firstClonedArticle = carouselImages.eq(0).clone();  // Cloning the first article
        carouselSlide.append(firstClonedArticle);

        // Set the id of the first cloned article
        firstClonedArticle.attr('id', 'firstClone');

        // Clone the last article and append it to the end of the carousel slide
        let lastClonedArticle = carouselImages.eq(carouselImages.length - 1).clone();  // Cloning the last article
        lastClonedArticle.attr('id', 'lastClone');

        // Append the last cloned article to carouselSlide
        carouselSlide.prepend(lastClonedArticle);

        carouselImages = carouselSlide.children();
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
}