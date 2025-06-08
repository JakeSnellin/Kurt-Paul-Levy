export function calculateImageSizes($) {
  if (!$('body').hasClass('archive')) return;

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

    // Find tallest image
    images.each(function () {
      const img = $(this)[0];
      if (img.complete && img.height > tallestHeight) {
        tallestHeight = img.height;
        tallestImage = $(this);
      }
    });

    if (!tallestImage) return;

    // Step 1: Set max height for the tallest image (for scaling)
    tallestImage.css({
      maxHeight: window.innerWidth >= 1400 ? '93vh' : '83vh',
      height: 'auto',
      width: 'auto'
    });

    // Immediately set width to prevent layout shifts
    const finalWidth = tallestImage[0].getBoundingClientRect().width;

    // Apply width to all images before applying final width
    images.each(function () {
      const img = $(this);
      if (img[0] !== tallestImage[0]) {
        img.css({
          width: `${finalWidth}px`,
          height: 'auto'
        });
      }
    });

    // Apply the width to the tallest image once layout has stabilized
    setTimeout(() => {
      tallestImage.css({
        width: `${finalWidth}px`,
        height: 'auto'
      });
    }, 50); // Slight delay to allow the layout to settle
  }

  // Run on load
  $(window).on('load', function () {
    alignImagesByTallest();
  });

  // Debounced resize
  let resizeTimeout;
  $(window).on('resize', function () {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      alignImagesByTallest();
    }, 100); // Reduced delay for quicker resize handling
  });
}