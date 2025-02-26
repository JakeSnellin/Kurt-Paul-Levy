//import { createElement } from "../helpers/createElement.js";

export function registerUserAjax($, email) {
    // Perform the AJAX request
    $.ajax({
        type: "post",
        url: `${window.location.origin}/wp-admin/admin-ajax.php`,
        data: {
            action: "register_user",
            ajax_data: email,
        },
        /*success: function(response) {
            console.log(response);
            createElement($, 'p', { class: 'my-11 lh-sm text-success d-flex align-items-center', id: 'success-text' }, "Registration successful!", '#validation-container');
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            createElement($, 'p', { class: 'my-11 lh-sm text-danger d-flex align-items-center', id: 'error-text' }, "Something went wrong, please try again.", '#validation-container');
        }*/
    });
}