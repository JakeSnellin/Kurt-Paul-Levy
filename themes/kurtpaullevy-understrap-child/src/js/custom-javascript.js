// Add your custom JS here.

import { header } from "./header-navigation.js";
import { progressBar } from "./progress-bar.js";
import { validateAndRegisterUser } from "./validation/userValidation.js";
import { pageTransition } from "./page-transition.js";

(function($) {

    $(document).ready(function() {
        pageTransition($);
        progressBar($);
        header.publicToggleShowNav();
        validateAndRegisterUser($); 
    });

})(jQuery);