import { handleCategoryFilter } from "./handleCategoryFilter";

export function categoryNavbar ($) {
    $('body').on('click', '.nav-category-menu .menu-item', function (e) {
        e.preventDefault();

        const categoryText = $(this).text();
        handleCategoryFilter($, categoryText);
    });

    $('.btn-nav-category').on('click', function () {
        $('.btn-nav-category').attr('aria-pressed', 'false');
        $(this).attr('aria-pressed', 'true');
    });
}