// Add your custom JS here.

import { toggleShowNav } from "./header-navigation.js";
import { progressBar } from "./progress-bar.js";
import { validateAndRegisterUser } from "./validation/userValidation.js";
import { pageTransition } from "./page-transition.js";
import { lazyLoadImages } from "./lazy-load-images.js";
import { categoryDropdown } from "./category-dropdown.js";
<<<<<<< Updated upstream
import { galleryLightboxController } from "./lightbox.js";
import { handleBackToTopButton } from "./back-to-top-btn.js";
import { calculateImageSizes } from "./calculate-image-sizes.js";
=======
import { lightBox } from "./lightbox.js";
>>>>>>> Stashed changes

(function($) {

    $(document).ready(function() {
        pageTransition($);
        lazyLoadImages($);
        progressBar($);
        toggleShowNav($);
        validateAndRegisterUser($); 
        categoryDropdown($);
<<<<<<< Updated upstream
        galleryLightboxController($);
        handleBackToTopButton($);
        calculateImageSizes($);
=======
        lightBox($);
>>>>>>> Stashed changes
    });

})(jQuery);