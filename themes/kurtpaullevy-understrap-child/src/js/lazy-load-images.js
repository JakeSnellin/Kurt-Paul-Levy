import { createImageObserver } from "./helpers/createObserver";
import { createFooterObserver } from "./helpers/createObserver";
import { initialiseObserver } from "./helpers/initialiseObserver";

export function lazyLoadImages ($) {

        const images = $('article.format-image');
        const  frontPageFooter = $('body').hasClass('home') ? $('#wrapper-footer') : "";

        const imageThreshold = 0.2;

        const footerThreshold = 0.4;

        const imageObserver = createImageObserver($, imageThreshold);

        initialiseObserver(images, imageObserver);

        const footerObserver = createFooterObserver($, footerThreshold);

        initialiseObserver(frontPageFooter, footerObserver);

        $(document).on('newContentLoaded', function() {
            observer.disconnect();
            var images = $('article.format-image');
            observer = createObserver($);
            initialiseObserver(images, observer);
        });
}