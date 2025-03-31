import { filterContentByCategoryAjax } from './ajax/filterContentByCategoryAjax.js';

export function categoryDropdown($) {
    $('#dropdownMenuButton').on('click', function () {
        $('.caret-icon').toggleClass('rotated');
    });

    $('.dropdown-menu .menu-item').on('click', function (e) {
        e.preventDefault();

         // Make all items visible again before hiding the clicked one
         $('.dropdown-menu .menu-item').removeClass('hidden').addClass('visible');

         // Hide the clicked item
         $(this).addClass('hidden').removeClass('visible');

        var categoryText = $(this).text();

        $('#dropdown-btn-text').text(categoryText);

        filterContentByCategoryAjax($, categoryText);
        
        });
}