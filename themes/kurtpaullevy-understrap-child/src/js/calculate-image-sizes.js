export function calculateImageSizes($) {
    if (!$('body').hasClass('archive')) return;
  
    function alignImagesByTallest() {
      if (window.innerWidth < 1440) return;
  
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
  
      // Step 1: set max height and let it scale
      tallestImage.css({
        maxHeight: '93vh',
        height: 'auto',
        width: 'auto'
      });
  
      // delay slightly so browser can reflow, then read scaled width
      setTimeout(() => {
        const finalWidth = tallestImage[0].getBoundingClientRect().width;
  
        // apply that width to the other images
        images.each(function () {
          const img = $(this);
          if (img[0] !== tallestImage[0]) {
            img.css({
              width: `${finalWidth}px`,
              height: 'auto'
            });
          }
        });
      }, 50); // small delay to allow layout reflow
    }
  
    // Run on load
    $(window).on('load', function () {
      if (window.innerWidth >= 1440) {
        setTimeout(alignImagesByTallest, 50);
      }
    });
  
    // Debounced resize
    let resizeTimeout;
    $(window).on('resize', function () {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        if (window.innerWidth >= 1440) {
          alignImagesByTallest();
        } else {
          $('.wp-post-image').css({
            maxHeight: '',
            width: '',
            height: ''
          });
        }
      }, 150);
    });
  }