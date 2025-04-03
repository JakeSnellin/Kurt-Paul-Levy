export function filterContentByCategoryAjax($, { category = 'All work' }) {
    const ajaxUrl = `${window.location.origin}/wp-admin/admin-ajax.php`;
    $.ajax({
        url: ajaxUrl, // Ensure ajaxurl is defined in your theme or script
        method: 'POST',
        data: {
            action: 'filter_category_posts',
            category: category
        },
        success: function(response) {
            if (response.success) {
                // Handle success (e.g., update the grid of posts)
                $('#image-grid-container').html(response.data);
                $(document).trigger('newContentLoaded');
            } else {
                console.log('Error: ' + response.data.error);
            }
        }
    });
}