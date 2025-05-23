export function createImageObserver($, threshold) {
    const observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const img = $(entry.target);
                if (img.hasClass('fade-init')) {
                    img.removeClass('fade-init').addClass('fade-in');
                }
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: threshold });

    return observer;
}

export function createFooterObserver($, threshold) {
    const observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const footerText = $(entry.target).find('.footer-intro-text');
                footerText.addClass('fade-in');
                observer.unobserve(entry.target); // stop observing the footer itself
            }
        });
    }, { threshold: threshold });

    return observer;
}

