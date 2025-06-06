import { handleCategoryFilter } from "./handleCategoryFilter";

export function categoryNavbar ($) {
    $('body').on('click', '.nav-category-menu .menu-item', function (e) {
        e.preventDefault();

        const categoryText = $(this).text();
        handleCategoryFilter($, categoryText);
    });

    $('.nav-category-menu').on('click touchstart', '.btn-navbar-category', function () {
        $('.nav-category-menu .btn-navbar-category').removeClass('active').attr('aria-pressed', 'false');
        $(this).addClass('active').attr('aria-pressed', 'true');
    });
}