import { createObserver } from "./helpers/createObserver";
import { initialiseObserver } from "./helpers/initialiseObserver";

export function lazyLoadImages ($) {

        var images = $('article.format-image');
        var observer = createObserver($);

        initialiseObserver(images, observer);

        $(document).on('newContentLoaded', function() {
            observer.disconnect();
            var images = $('article.format-image');
            observer = createObserver($);
            initialiseObserver(images, observer);
        });
}