import { filterContentByCategoryAjax } from './ajax/filterContentByCategoryAjax.js';

//rafactor this function
export function categoryDropdown($) {

    const dropdownMenuSidebarVariant = $('.widget-area .category-dropdown-menu');
    const dropdownButtonSidebarVariant = $('.widget-area #dropdownMenuButton');

    const dropdownMenuHeaderVariant = $('.site-main .category-dropdown-menu');
    const dropdownButtonHeaderVariant = $('.site-main #dropdownMenuButton');
    const caretIcon = $('.caret-icon');

    dropdownButtonSidebarVariant.on('click', function () {
        caretIcon.toggleClass('rotated');
        dropdownMenuSidebarVariant.toggleClass('show-menu');

        if(dropdownMenuSidebarVariant.hasClass('show-menu')){
            dropdownMenuSidebarVariant.slideDown(300);
            dropdownButtonSidebarVariant.attr('aria-expanded', 'true');
        }else{
            dropdownMenuSidebarVariant.slideUp(300);
            dropdownButtonSidebarVariant.attr('aria-expanded', 'false');
        }
    });

    dropdownButtonHeaderVariant.on('click', function () {
        caretIcon.toggleClass('rotated');
        dropdownMenuHeaderVariant.toggleClass('show-menu');

        if(dropdownMenuHeaderVariant.hasClass('show-menu')){
            dropdownMenuHeaderVariant.slideDown(300);
            dropdownButtonHeaderVariant.attr('aria-expanded', 'true');
        }else{
            dropdownMenuHeaderVariant.slideUp(300);
            dropdownButtonHeaderVariant.attr('aria-expanded', 'false');
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