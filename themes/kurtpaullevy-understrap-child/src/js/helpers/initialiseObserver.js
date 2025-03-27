export function initialiseObserver(images, observer) {
    images.each(function() {
        observer.observe(this);
    });
}