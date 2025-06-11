// Add your custom JS here.

import { toggleShowNav } from "./header-navigation.js";
import { progressBar } from "./progress-bar.js";
import { validateAndRegisterUser } from "./validation/userValidation.js";
import { pageTransition } from "./page-transition.js";
import { lazyLoadImages } from "./lazy-load-images.js";
import { categoryDropdown } from "./category-dropdown.js";
import { galleryLightboxController } from "./lightbox.js";
import { handleBackToTopButton } from "./back-to-top-btn.js";
import { hoverMenuItems } from "./hover-menu-items.js";
import { categoryNavbar } from "./category-navbar.js";
//import { calculateImageSizes } from "./calculate-image-sizes.js";

(function($) {

    $(document).ready(function() {
        pageTransition($);
        lazyLoadImages($);
        progressBar($);
        toggleShowNav($);
        validateAndRegisterUser($); 
        categoryDropdown($);
        categoryNavbar($);
        galleryLightboxController($);
        handleBackToTopButton($);
        hoverMenuItems($);
    });

    /*$(window).on('load', function () {
        calculateImageSizes($);
    });*/

})(jQuery);