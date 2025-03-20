
//Functionality for progress bar

export function progressBar($) {
    const progressBar = $('#scroll-progress-bar');

    // Listen for the scroll event
    $(window).on('scroll', function () {
        const scrollTop = window.scrollY; // Get the current scroll position
        const maxScrollHeight = document.documentElement.scrollHeight; // Total document height
        const viewportHeight = window.innerHeight; // Viewport height

        // Calculate scrollable height (max scroll height - viewport height)
        const scrollableHeight = maxScrollHeight - viewportHeight;

        // Calculate the scroll progress percentage
        const percentage = (scrollTop / scrollableHeight) * 100;

        // Update the width of the progress bar based on scroll percentage
        progressBar.width(percentage + '%');
    });
}


