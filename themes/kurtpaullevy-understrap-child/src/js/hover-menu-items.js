export function hoverMenuItems ($) {
    const menu = $('.menu');
    const items = $('.menu-item');

    items.on('click', function() {
        // Remove active class from all items
        items.removeClass('active');

        // Add active class to the clicked item
        $(this).addClass('active');

        // Add active class to the menu
        menu.addClass('active');
    });
}
