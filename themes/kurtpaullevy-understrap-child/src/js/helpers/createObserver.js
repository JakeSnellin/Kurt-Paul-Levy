export function createImageObserver($, threshold) {
    var observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const img = $(entry.target);
                img.addClass('fade-in');
                observer.unobserve(entry.target); // Stop observing after image is loaded
            }
        });
    }, { threshold: threshold });

    return observer;
}

export function createFooterObserver($, threshold) {
    var observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const text = $('body').hasClass('home') ? $('.footer-intro-text') : "";
                text.addClass('fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: threshold });

    return observer;
}

