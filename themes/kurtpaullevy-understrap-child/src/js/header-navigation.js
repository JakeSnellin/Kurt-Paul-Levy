export function toggleShowNav($) {
    if ($('body').hasClass('home')) return;

    const navBar = $('#main-nav');
    if (navBar.length === 0) return;

    let lastScrollY = window.scrollY;
    let currentOffset = 0;
    const navHeight = navBar.outerHeight();

    let ticking = false;

    function updateNav() {
        const currentScrollY = Math.max(0, window.scrollY); // clamp to 0
        const delta = currentScrollY - lastScrollY;

        currentOffset += delta;

        // Clamp offset between 0 and navHeight
        currentOffset = Math.max(0, Math.min(navHeight, currentOffset));

        // Apply the transform
        navBar.css('transform', `translateY(-${currentOffset}px)`);

        lastScrollY = currentScrollY;
        ticking = false;
    }

    $(window).on('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(updateNav);
            ticking = true;
        }
    });
}