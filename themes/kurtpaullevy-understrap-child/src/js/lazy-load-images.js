import { createImageObserver } from "./helpers/createObserver";
import { createFooterObserver } from "./helpers/createObserver";
import { initialiseObserver } from "./helpers/initialiseObserver";

export function lazyLoadImages ($) {

        const images = $('article.format-image');
        const frontPageFooter = $('body').hasClass('home') ? $('#wrapper-footer') : $();

        const imageThreshold = 0.2;

        const footerThreshold = 0.3;

        markImagesBelowFold(images);

        let imageObserver = createImageObserver($, imageThreshold);

        initialiseObserver(images, imageObserver);

        let footerObserver = createFooterObserver($, footerThreshold);

        initialiseObserver(frontPageFooter, footerObserver);

        $(document).on('newContentLoaded', function() {
            imageObserver.disconnect();
            
            const images = $('article.format-image');
            
            markImagesBelowFold(images);
        
            imageObserver = createImageObserver($, imageThreshold);
            initialiseObserver(images, imageObserver);
        });

        function markImagesBelowFold(images) {
            images.each(function () {
                const rect = this.getBoundingClientRect();
                if (rect.top > window.innerHeight) {
                    $(this).addClass('fade-init');
                }
            });
        }
}