export function toggleShowNav($) {
    if ($('body').hasClass('home')) {
        return;
    }

    const navBar = $('#main-nav');
    if (navBar.length === 0) return;

    let lastScrollY = window.scrollY;
    let currentOffset = 0;
    const navHeight = navBar.outerHeight();
    let debounceTimer;

    $(window).on('scroll', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            let currentScrollY = window.scrollY;
            let delta = currentScrollY - lastScrollY;

            // If at the very top, don't move the nav — reset to visible
            if (currentScrollY <= 0) {
                currentOffset = 0;
            } else {
                // Update offset based on scroll direction
                currentOffset += delta;

                // Clamp the offset within allowed bounds
                currentOffset = Math.max(0, Math.min(navHeight, currentOffset));
            }

            // Apply transform
            navBar.css('transform', `translateY(-${currentOffset}px)`);

            lastScrollY = currentScrollY;
        }, 11);
    });
}