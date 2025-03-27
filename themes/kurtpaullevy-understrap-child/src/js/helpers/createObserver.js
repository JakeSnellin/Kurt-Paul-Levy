export function createObserver($) {
    var observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var $img = $(entry.target);
                $img.addClass('fade-in');
                observer.unobserve(entry.target); // Stop observing after image is loaded
            }
        });
    }, { threshold: 0.2 });

    return observer;
}