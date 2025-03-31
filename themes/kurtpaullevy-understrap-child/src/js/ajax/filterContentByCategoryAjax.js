export function filterContentByCategoryAjax ($, category) {
    const ajaxUrl = `${window.location.origin}/wp-admin/admin-ajax.php`;
    $.ajax({
        type: "post",
        url: ajaxUrl,
        data: {
            action: 'filter_work_by_category',
            category: category
        },
        success: function(response) {
            // Update the content area with the new posts
            $('#image-grid-container').html(response);
            $(document).trigger('newContentLoaded');
        },
        error: function(error) {
            console.log('Error:', error);
        }
    })
}