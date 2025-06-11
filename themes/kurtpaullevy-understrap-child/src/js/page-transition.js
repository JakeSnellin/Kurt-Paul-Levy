export function pageTransition ($) {

  let isTransitioning = false;

  // Function to trigger page fade-in

  function pageFadeIn() {
    // Check if it's an archive page
    if ($('body').hasClass('archive')) {
      // Only load non-content-area elements immediately
      $('#sidebar__contact, .category-dropdown, #scroll-progress-bar, body.home #wrapper-footer').addClass('loaded');
  
      // Then add .loaded to .content-area
      $('.content-area').addClass('loaded');
  
    } else {
      // For all other pages, load everything at once
      $('.content-area, #sidebar__contact, .nav-category-menu, .category-dropdown, #scroll-progress-bar, body.home #wrapper-footer').addClass('loaded');
    }
  }

  // Function to trigger page fade-out
  function pageFadeOut() {
    $('.content-area, #sidebar__contact, .category-dropdown, #scroll-progress-bar, body.home #wrapper-footer').removeClass('loaded');
  }

  // On page load, add the 'loaded' class to trigger fade-in
  pageFadeIn();

  // Add page transition when navigating between pages
  
  $('#menu-sidebar-menu a, #main-menu a, .custom-logo-link').on('click', function(event) {
    if (isTransitioning) return;
    isTransitioning = true;
    
    var targetLink = this;
    event.preventDefault(); // Prevent default behavior (navigation)

    pageFadeOut(); // Trigger fade-out

    // Wait for fade-out to complete before navigating
    setTimeout(function() {
      // Push the new state to history before navigation
      window.history.pushState({ path: targetLink.href }, '', targetLink.href);
      
      // Navigate to the new page
      window.location = targetLink.href;
    }, 500); // Match the fade-out duration (500ms)
  });

  // When the back/forward button is pressed, trigger the fade effect
  $(window).on('popstate', function() {
    pageFadeOut(); // Trigger fade-out before loading new page content
    
    // Wait for the fade-out to complete, then reload the content
    setTimeout(function() {
      location.reload(); // Reload the page when navigating through history
    }, 500); // Match fade-out duration
  });
}