export var header = (function ($) {

    function privateToggleShowNav() { 

        var navBar = $('#main-nav');

        if(navBar) {
            var lastScrollTop = 0; 
            $( window ).on('scroll', function() {

                var scrollTop = window.scrollY;
                
                if(scrollTop < lastScrollTop) {
                    navBar.removeClass('scrolled-down');
                    navBar.addClass('scrolled-up');
                    //console.log('Scrolling up');
                }else {
                    navBar.removeClass('scrolled-up');
                    navBar.addClass('scrolled-down');
                    //console.log('Scrolling down');
                }
                lastScrollTop = scrollTop;
            });
        }
    }

    return {
        publicToggleShowNav: function () { 
            privateToggleShowNav(); 
        }, 
    }
})( jQuery );