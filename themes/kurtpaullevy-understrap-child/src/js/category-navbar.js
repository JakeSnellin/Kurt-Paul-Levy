import { handleCategoryFilter } from "./handleCategoryFilter";

export function categoryNavbar ($) {
    $('body').on('click', '.nav-category-menu .menu-item', function (e) {
        e.preventDefault();

        const categoryText = $(this).text();
        handleCategoryFilter($, categoryText);
    });

    $('.nav-category-menu').on('click', '.btn-navbar-category', function () {
        $('.nav-category-menu .btn-navbar-category').attr('aria-pressed', 'false');
        $(this).attr('aria-pressed', 'true');
    });
}