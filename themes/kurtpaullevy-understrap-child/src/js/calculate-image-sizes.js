export function calculateImageSizes($) {
  if (!$('body').hasClass('archive')) return;

  let alignTimeout;
  let observer;

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
      if (img.complete && img.naturalHeight > tallestHeight) {
        tallestHeight = img.naturalHeight;
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

  function debounceAlign() {
    clearTimeout(alignTimeout);
    alignTimeout = setTimeout(alignImagesByTallest, 100);
  }

  // Re-align when any image loads
  $('.wp-post-image').each(function () {
    const img = this;
    if (!img.complete) {
      $(img).on('load', debounceAlign);
    }
  });

  // Observe for new images being lazy-loaded
  observer = new MutationObserver(() => {
    $('.wp-post-image').off('load').on('load', debounceAlign);
    debounceAlign();
  });
  observer.observe(document.body, { childList: true, subtree: true });

  // Initial run
  $(window).on('load', debounceAlign);

  // Only react to real layout changes (width changes)
  let lastWidth = window.innerWidth;

  let resizeTimeout;
  $(window).on('resize', function () {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      const currentWidth = window.innerWidth;
      if (currentWidth !== lastWidth) {
        lastWidth = currentWidth;
        alignImagesByTallest();
      }
      // else: Ignore height-only changes (common on iOS scroll)
    }, 100);
  });

  // Optional: Respond to orientation changes
  window.addEventListener('orientationchange', debounceAlign);
}