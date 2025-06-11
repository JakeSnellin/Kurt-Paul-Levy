export function calculateImageSizes($) {

   if (!$('body').hasClass('archive')) return;

    const images = $('.wp-post-image');
    var $tallestImage = null;
    var maxHeight = 0;

    // Find the tallest image
    images.each(function () {
      var $img = $(this);
      var height = $img.height();

      if (height > maxHeight) {
        maxHeight = height;
        $tallestImage = $img;
      }
    });

    if ($tallestImage) {
      var targetWidth = $tallestImage.width();

      // Apply that width to all images
      images.each(function () {
        $(this).css({
          width: targetWidth + 'px',
          height: 'auto'
        });
      });
    }
}