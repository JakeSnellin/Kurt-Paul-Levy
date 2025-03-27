import { filterContentByCategoryAjax } from './ajax/filterContentByCategoryAjax.js';

export function categoryDropdown($) {
    $('#dropdownMenuButton').on('click', function () {
        $('.caret-icon').toggleClass('rotated');
    });

    $('.menu-item-object-category a').on('click', function (e) {
        e.preventDefault();

        // Get the href value of the clicked link
        var url = $(this).attr('href');

        // Use the URLPattern API to extract the category
        var category = getCategoryFromUrl(url);

        if(!category) return;

        var upperCaseCategory = category.charAt(0).toUpperCase() + category.slice(1);

        $('#dropdown-btn-text').text(upperCaseCategory);

        filterContentByCategoryAjax($, category);
        
        });

        function getCategoryFromUrl(url) {
            // Create a URL object from the given URL string
            const currentUrl = new URL(url);
        
            // Split the pathname into segments by '/'
            const pathSegments = currentUrl.pathname.split('/');
        
            // The category is in the second position of the path (e.g., '/category/abstract/')
            return pathSegments[2] || null; // 'abstract' for /category/abstract/
        }
}