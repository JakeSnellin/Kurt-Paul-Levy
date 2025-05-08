export function initialiseObserver(images, observer) {

    if (!images || images.length === 0) return;

    setTimeout(() => {
        images.each(function() {
            observer.observe(this); // observe everything
        });
    }, 500);
}