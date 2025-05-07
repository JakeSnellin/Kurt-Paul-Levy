import { filterContentByCategoryAjax } from './ajax/filterContentByCategoryAjax.js';

export function categoryDropdown($) {

    function toggleDropdown({ button, menu, container }) {
        const caretIcon = container.find('.caret-icon');
        caretIcon.toggleClass('rotated');
        menu.toggleClass('show-menu');

        if (menu.hasClass('show-menu')) {
            container.css('background-color', "#EFEFEF");
            menu.slideDown(300);
            button.attr('aria-expanded', 'true');
            setupOutsideClickListener(menu, button, container);
        } else {
            menu.slideUp(300, () => container.css('background-color', ""));
            button.attr('aria-expanded', 'false');
        }
    }

    function setupOutsideClickListener (menu, button, container) {
        function outsideClickHandler (event) {
            if(!menu.is(event.target) && menu.has(event.target).length === 0 && 
            !button.is(event.target) && button.has(event.target).length === 0) {
                menu.removeClass('show-menu');
                menu.slideUp(300, () => container.css('background-color', ""));
                button.attr('aria-expanded', 'false');
                container.find('.caret-icon').removeClass('rotated');

                $(document).off('click.dropdown', outsideClickHandler);
            }
        }

        setTimeout(() => {
            $(document).on('click.dropdown', outsideClickHandler)
        }, 0)
    }

    // Event delegation for click on dropdown buttons
    $('body').on('click', '.category-dropdown__menu-btn', function () {

        const isSidebar = $(this).closest('.widget-area').length > 0;

        const context = isSidebar ? '.widget-area' : '.site-main';

        toggleDropdown({
            button: $(this),
            menu: $(`${context} .category-dropdown-menu`),
            container: $(`${context} .category-dropdown`)
        });
    });

    // Event delegation for dropdown menu item clicks
    $('body').on('click', '.category-dropdown-menu .menu-item', function (e) {
        e.preventDefault();

        $(document).off('click.dropdown');

        const $this = $(this);
        const isSidebar = $this.closest('.widget-area').length > 0;
        const context = isSidebar ? '.widget-area' : '.site-main';

        $(`${context} .caret-icon`).toggleClass('rotated');
        $(`${context} .category-dropdown-menu .menu-item`).removeClass('hidden').addClass('visible');
        $this.addClass('hidden').removeClass('visible');

<<<<<<< Updated upstream
        const categoryText = $this.text();
        $(`${context} #dropdown-btn-text`).text(categoryText);

        toggleDropdown({
            button: $(this).parent().prev(),
            menu: $(`${context} .category-dropdown-menu`),
            container: $(`${context} .category-dropdown`)
        });

        filterContentByCategoryAjax($, { category: categoryText });
    });
=======
        $('.widget-area #dropdown-btn-text').text(categoryText);

        if(categoryText === 'All work') {
            filterContentByCategoryAjax($, { category: 'All work'});
        }

        filterContentByCategoryAjax($, { category: categoryText });
        
        });

        $('.site-main .category-dropdown-menu .menu-item').on('click', function (e) {
            e.preventDefault();
    
            $('.site-main .caret-icon').toggleClass('rotated');
    
             // Make all items visible again before hiding the clicked one
             $('.site-main .category-dropdown-menu .menu-item').removeClass('hidden').addClass('visible');
    
             // Hide the clicked item
             $(this).addClass('hidden').removeClass('visible');
    
            var categoryText = $(this).text();
    
            $('.site-main #dropdown-btn-text').text(categoryText);

            if(categoryText === 'All work') {
                filterContentByCategoryAjax($, { category: "All work" });
            }
    
            filterContentByCategoryAjax($, { category: categoryText });

        });
>>>>>>> Stashed changes
}