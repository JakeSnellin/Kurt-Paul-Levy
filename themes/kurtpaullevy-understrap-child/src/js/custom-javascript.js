// Add your custom JS here.

import { header } from "./header-navigation.js";
import { progressBar } from "./progress-bar.js";
import { validateAndRegisterUser } from "./validation/userValidation.js";
import { pageTransition } from "./page-transition.js";
import { lazyLoadImages } from "./lazy-load-images.js";
import { categoryDropdown } from "./category-dropdown.js";

(function($) {

    $(document).ready(function() {
        pageTransition($);
        lazyLoadImages($);
        progressBar($);
        header.publicToggleShowNav();
        validateAndRegisterUser($); 
        categoryDropdown($);
    });

})(jQuery);