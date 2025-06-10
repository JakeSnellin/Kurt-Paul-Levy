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
                const gridContainer = $('#image-grid-container');
                
                // Fade out the current content
                gridContainer.fadeOut(500, function() {
                    // Scroll to the top of the page
                    window.scrollTo({ top: 0, behavior: 'instant' });

                    // Update the content after the fade-out is complete
                    gridContainer.html(response.data);
                    
                    // Fade in the new content
                    gridContainer.fadeIn(500);
                    
                    // Trigger any additional actions if needed
                    $(document).trigger('newContentLoaded');
                });
            } else {
                console.log('Error: ' + response.data.error);
            }
        }
    });
}