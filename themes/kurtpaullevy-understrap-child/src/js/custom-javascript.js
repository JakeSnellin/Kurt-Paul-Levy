// Add your custom JS here.

import { header } from "./header-navigation.js";
import { progressBar } from "./progress-bar.js";
import { validateAndRegisterUser } from "./validation/userValidation.js";

(function($) {

    $(document).ready(function() {
        progressBar($);
        header.publicToggleShowNav();
        validateAndRegisterUser($);  // Call the function directly
    });

})(jQuery);