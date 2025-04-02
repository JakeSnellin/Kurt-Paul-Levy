import { filterContentByCategoryAjax } from './ajax/filterContentByCategoryAjax.js';

//refactor this function using event delegation. 
export function categoryDropdown($) {

    const dropdownMenuSidebarVariant = $('.widget-area .category-dropdown-menu');
    const dropdownButtonSidebarVariant = $('.widget-area #dropdownMenuButton');

    const dropdownMenuHeaderVariant = $('.site-main .category-dropdown-menu');
    const dropdownButtonHeaderVariant = $('.site-main #dropdownMenuButton');

    const dropdownSidebarVariant = $('.widget-area .category-dropdown');
    const dropdownHeaderVariant = $('.site-main .category-dropdown');

    const caretIcon = $('.caret-icon');

    dropdownButtonSidebarVariant.on('click', function () {
        caretIcon.toggleClass('rotated');
        dropdownMenuSidebarVariant.toggleClass('show-menu');

        if(dropdownMenuSidebarVariant.hasClass('show-menu')){
            dropdownSidebarVariant.css('background-color', "#EFEFEF");
            dropdownMenuSidebarVariant.slideDown(300);
            dropdownButtonSidebarVariant.attr('aria-expanded', 'true');
        }else{
            dropdownMenuSidebarVariant.slideUp(300, function() {dropdownSidebarVariant.css('background-color', "");});
            dropdownButtonSidebarVariant.attr('aria-expanded', 'false');
        }
    });

    dropdownButtonHeaderVariant.on('click', function () {
        caretIcon.toggleClass('rotated');
        dropdownMenuHeaderVariant.toggleClass('show-menu');

        if(dropdownMenuHeaderVariant.hasClass('show-menu')){
            dropdownHeaderVariant.css('background-color', "#EFEFEF");
            dropdownMenuHeaderVariant.slideDown(300);
            dropdownButtonHeaderVariant.attr('aria-expanded', 'true');
        }else{
            dropdownMenuHeaderVariant.slideUp(300, function() {dropdownHeaderVariant.css('background-color', "");});
            dropdownButtonHeaderVariant.attr('aria-expanded', 'false');
        }
    });

    

    $('.widget-area .category-dropdown-menu .menu-item').on('click', function (e) {
        e.preventDefault();

        $('widget-area .caret-icon').toggleClass('rotated');

         // Make all items visible again before hiding the clicked one
         $('.widget-area .category-dropdown-menu .menu-item').removeClass('hidden').addClass('visible');

         // Hide the clicked item
         $(this).addClass('hidden').removeClass('visible');

        var categoryText = $(this).text();

        $('.widget-area #dropdown-btn-text').text(categoryText);

        filterContentByCategoryAjax($, categoryText);
        
        });

        $('.site-main .category-dropdown-menu .menu-item').on('click', function (e) {
            e.preventDefault();
    
            $('.site-main .caret-icon').toggleClass('rotated');
    
             // Make all items visible again before hiding the clicked one
             $('.site-main .category-dropdown-menu .menu-item').removeClass('hidden').addClass('visible');
    
             // Hide the clicked item
             $(this).addClass('hidden').removeClass('visible');
    
            var categoryText = $(this).text();
    
            $('.site-main #dropdown-btn-text').text(categoryText);
    
            filterContentByCategoryAjax($, categoryText);

        });
}