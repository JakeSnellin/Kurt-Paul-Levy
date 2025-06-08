export function calculateImageSizes($) {
  if (!$('body').hasClass('archive')) return;

  function alignImagesByTallest() {
    const images = $('.wp-post-image');
    if (images.length === 0) return;

    images.css({
      maxHeight: '',
      width: '',
      height: ''
    });

    let tallestImage = null;
    let tallestHeight = 0;

    images.each(function () {
      const img = $(this)[0];
      if (img.complete && img.height > tallestHeight) {
        tallestHeight = img.height;
        tallestImage = $(this);
      }
    });

    if (!tallestImage) return;

    tallestImage.css({
      maxHeight: window.innerWidth >= 1440 ? '90vh' : '80vh',
      height: 'auto',
      width: 'auto'
    });

    const finalWidth = tallestImage[0].getBoundingClientRect().width;

    images.each(function () {
      const img = $(this);
      if (img[0] !== tallestImage[0]) {
        img.css({
          width: `${finalWidth}px`,
          height: 'auto'
        });
      }
    });

    setTimeout(() => {
      tallestImage.css({
        width: `${finalWidth}px`,
        height: 'auto'
      });
    }, 50);
  }

  // Run on load
  $(window).on('load', function () {
    alignImagesByTallest();
  });

  // Store the last known viewport size
  let lastViewport = {
    width: window.innerWidth,
    height: window.innerHeight
  };

  let resizeTimeout;
  $(window).on('resize', function () {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      // Only run if viewport size really changed
      const currentWidth = window.innerWidth;
      const currentHeight = window.innerHeight;

      if (currentWidth !== lastViewport.width || currentHeight !== lastViewport.height) {
        lastViewport.width = currentWidth;
        lastViewport.height = currentHeight;
        alignImagesByTallest();
      }
      // else: Ignore resize events caused by UI chrome changes that don't affect layout
    }, 100);
  });
}