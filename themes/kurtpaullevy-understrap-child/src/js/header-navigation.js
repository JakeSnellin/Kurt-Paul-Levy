export function toggleShowNav($) {
    if ($('body').hasClass('home')) return;

    const navBar = $('#main-nav');
    if (navBar.length === 0) return;

    let lastScrollY = window.scrollY;
    let currentOffset = 0;
    const navHeight = navBar.outerHeight();

    let ticking = false;

    function updateNav() {
        const currentScrollY = window.scrollY;
        const delta = currentScrollY - lastScrollY;

        currentOffset += delta;
        currentOffset = Math.max(0, Math.min(navHeight, currentOffset));

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