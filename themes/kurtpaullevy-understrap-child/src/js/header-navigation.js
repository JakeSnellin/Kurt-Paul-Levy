export function toggleShowNav($) {

    if($('body').hasClass('home')){
        return;
    }

    const navBar = $('#main-nav');

    if (navBar.length === 0) return;

    let lastScrollY = window.scrollY;
    let currentOffset = 0;
    const navHeight = navBar.outerHeight(); // total height of nav bar

    $(window).on('scroll', function () {
        const currentScrollY = window.scrollY;
        const delta = currentScrollY - lastScrollY;

        // Move the nav bar based on scroll direction
        currentOffset += delta;

        // Clamp the offset between 0 (fully visible) and navHeight (fully hidden)
        currentOffset = Math.max(0, Math.min(navHeight, currentOffset));

        // Apply transform
        navBar.css('transform', `translateY(-${currentOffset}px)`);

        lastScrollY = currentScrollY;
    });
}