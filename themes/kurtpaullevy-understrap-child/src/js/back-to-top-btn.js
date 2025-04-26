export function handleBackToTopButton($) {
    const backToTopBtn = $('.back-to-top');
    const footer = $('.site-footer');

    if (!backToTopBtn.length) return;

    function updateButton() {
        const scrollPosition = $(window).scrollTop();
        const viewportHeight = $(window).height();
        const buttonHeight = backToTopBtn.outerHeight();
        const footerTop = footer.length ? footer.offset().top : 0;
        const triggerPoint = viewportHeight * 0.25;

        const bottomOfViewport = scrollPosition + viewportHeight;

        // Show/hide the button based on scroll trigger
        if (scrollPosition > triggerPoint) {
            backToTopBtn.addClass('back-to-top--visible');
        } else {
            backToTopBtn.removeClass('back-to-top--no-transition');
            backToTopBtn.removeClass('back-to-top--visible');
        }

        // If footer is in view, adjust bottom position to stay above it
        if (bottomOfViewport >= footerTop) {
            const overlap = bottomOfViewport - footerTop;
            const offset = overlap + 65;
            backToTopBtn.addClass('back-to-top--no-transition').css('bottom', `${offset}px`);
        } else {
            // Remove inline style so SCSS handles it
            if (backToTopBtn.hasClass('back-to-top--visible')) {
                backToTopBtn.css('bottom', ''); // reset to CSS class value
            }
        }
    }

    // Bind click once
    backToTopBtn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 600);
    });

    // Initial run
    updateButton();

    // On scroll and resize
    $(window).on('scroll resize', updateButton);
}