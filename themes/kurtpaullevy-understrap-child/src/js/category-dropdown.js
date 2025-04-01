import { filterContentByCategoryAjax } from './ajax/filterContentByCategoryAjax.js';

export function categoryDropdown($) {
    $('#dropdownMenuButton').on('click', function () {
        $('.caret-icon').toggleClass('rotated');
        const dropdownMenu = $('.category-dropdown-menu');
        if(dropdownMenu.hasClass('show-menu')){
            $('.category-dropdown').css('background-color', '');
            dropdownMenu.removeClass('show-menu');
            dropdownMenu.attr('aria-expanded', 'false');
        }else {
            dropdownMenu.addClass('show-menu');
            $('.category-dropdown').css('background-color', '#f5f5f5');
            dropdownMenu.attr('aria-expanded', 'true');

        }
    });

    $('.dropdown-menu .menu-item').on('click', function (e) {
        e.preventDefault();

        $('.caret-icon').toggleClass('rotated');

         // Make all items visible again before hiding the clicked one
         $('.dropdown-menu .menu-item').removeClass('hidden').addClass('visible');

         // Hide the clicked item
         $(this).addClass('hidden').removeClass('visible');

        var categoryText = $(this).text();

        $('#dropdown-btn-text').text(categoryText);

        filterContentByCategoryAjax($, categoryText);
        
        });
}