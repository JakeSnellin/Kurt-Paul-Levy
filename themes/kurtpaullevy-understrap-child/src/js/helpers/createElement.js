 // Helper function to create an element and append it to the specified parent
 
 export function createElement($, tag, attributes = {}, content = '', parent = 'body') {
    // Create the element using jQuery
    const $element = $('<' + tag + '>');

    // Set attributes
    Object.entries(attributes).forEach(([key, value]) => {
        $element.attr(key, value);
    });

    // Set content (text or HTML)
    $element.html(content);

    // Append the element to the parent (default is body)
    $(parent).append($element);

    return $element;
}