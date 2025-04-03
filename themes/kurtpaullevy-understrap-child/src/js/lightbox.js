import { filterLightBoxAjax } from "./ajax/filterLightBoxContentAjax";

export function lightBox ($) {
    $('#image-grid-container').on('click', function(e) {
        if($(e.target).closest('.format-image')){ //
            const clickedPostID = $(e.target).closest('.format-image').attr('id').replace('post-', '');
            console.log(clickedPostID);
            //get the category 
            const categoryText = $('#dropdown-btn-text').text();

            //open the lightbox.
            $('.lightbox').addClass('open');
            $('body').css('overflow', 'hidden');

            filterLightBoxAjax($, { postId: clickedPostID, category: categoryText });
        }
    })
}