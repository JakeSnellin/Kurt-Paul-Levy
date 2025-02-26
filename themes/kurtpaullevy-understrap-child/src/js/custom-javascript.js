// Add your custom JS here.

import { header } from "./header-navigation.js";
import { validateAndRegisterUser } from "./validation/userValidation.js";

(function($) {

    $(document).ready(function() {
        header.publicToggleShowNav();
        validateAndRegisterUser($);  // Call the function directly
    });

})(jQuery);