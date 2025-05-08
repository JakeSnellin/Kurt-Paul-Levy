import { createElement } from "../helpers/createElement.js";
import { registerUserAjax } from "../ajax/registerUserAjax.js";

export function validateAndRegisterUser($) {
    $('#contact-form').on('submit', (e) => {
        e.preventDefault();

        const email = $('#email').val();
        const validationContainer = $('#validation-container');
        
        // Clear any existing validation messages
        validationContainer.text("");

        // Validate email format

        if(email === "") return;

        if (!(/^[^@]+@[^@]+\.[^@]+$/.test(email))) {
            createElement($, 'p', { class: 'my-11 lh-sm text-warning d-flex align-items-center', id: 'validation-text' }, "Incorrect email", '#validation-container');
            createElement($, 'i', { class: "bi bi-exclamation-circle ps-2" }, "", "#validation-text");
        } else {
            createElement($, 'p', { class: 'my-11 lh-sm text-success d-flex align-items-center', id: 'validation-text' }, "Success", '#validation-container');
            createElement($, 'i', { class: "bi bi-check-circle ps-2" }, "", "#validation-text");
            registerUserAjax($, email);  // Only call AJAX if validation is successful
        }
    });
}