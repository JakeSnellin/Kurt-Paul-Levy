export function calculateImageSizes($) {
  if (!$('body').hasClass('archive')) return;

  let lastKnownWidth = null;

  // Utility: Check if an element is visible in the viewport
  function isElementInViewport(el) {
    const rect = el.getBoundingClientRect();
    return rect.height > 0 && rect.top >= 0 && rect.bottom <= window.innerHeight;
  }

  function alignImagesByTallest() {
    const images = $('.wp-post-image');
    if (images.length === 0) return;

    // Reset styles
    images.css({
      maxHeight: '',
      width: '',
      height: ''
    });

    let tallestImage = null;
    let tallestHeight = 0;

    // Find tallest *visible* image
    images.each(function () {
      const img = $(this)[0];
      if (
        img.complete &&
        img.height > tallestHeight &&
        isElementInViewport(img)
      ) {
        tallestHeight = img.height;
        tallestImage = $(this);
      }
    });

    if (!tallestImage) return;

    // Set temporary dimensions on tallest to measure its width
    tallestImage.css({
      maxHeight: '89vh',
      height: 'auto',
      width: 'auto'
    });

    const finalWidth = tallestImage[0].getBoundingClientRect().width;

    // Avoid redundant updates
    if (finalWidth === lastKnownWidth) return;
    lastKnownWidth = finalWidth;

    // Apply width to other images
    images.each(function () {
      const img = $(this);
      if (img[0] !== tallestImage[0]) {
        img.css({
          width: `${finalWidth}px`,
          height: 'auto'
        });
      }
    });

    // Apply final width to the tallest after layout settles
    setTimeout(() => {
      tallestImage.css({
        width: `${finalWidth}px`,
        height: 'auto'
      });
    }, 50);
  }

  // Run once on window load using requestAnimationFrame
  $(window).on('load', function () {
    requestAnimationFrame(() => {
      alignImagesByTallest();
    });
  });

  // Fallback for lazy-loaded images
  $('.wp-post-image').each(function () {
    if (!this.complete) {
      $(this).on('load', alignImagesByTallest);
    }
  });

  // Use ResizeObserver instead of window.resize for precision
  if (typeof ResizeObserver !== 'undefined') {
    const observer = new ResizeObserver(() => {
      alignImagesByTallest();
    });

    $('.wp-post-image').each(function () {
      observer.observe(this);
    });
  }

  // Optional: Keep this if you want broader compatibility
  let resizeTimeout;
  $(window).on('resize', function () {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      // Optional: Only run when near top of the page
      if ($(window).scrollTop() < 100) {
        alignImagesByTallest();
      }
    }, 100);
  });
}