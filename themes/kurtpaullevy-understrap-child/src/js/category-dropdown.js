import { handleCategoryFilter } from './handleCategoryFilter.js';

export function categoryDropdown($) {

    const $toggleBtn = $('.category-dropdown__menu-btn');
    const $menu = $('.category-dropdown-menu');
    const $scrollContainer = $('.scroll-container');
    const $dropdown = $('.category-dropdown');

    function toggleDropdown () {
        const caretIcon = $dropdown.find('.caret-icon');
        caretIcon.toggleClass('rotated');
        if ($menu.hasClass('open')) {
            // Slide up (close)
            $menu.removeClass('open');
            setTimeout(() => {
                $dropdown.css('background-color', "")
            }, 300)
            $toggleBtn.attr('aria-expanded', 'false');
        } else {
            // Slide down (open)
            $menu.addClass('open');
            $dropdown.css('background-color', "#EFEFEF");
            $toggleBtn.attr('aria-expanded', 'true');
            setTimeout(() => {
            const simplebarInstance = SimpleBar.instances.get($scrollContainer[0]);
            if (simplebarInstance) {
                simplebarInstance.recalculate();
                simplebarInstance.getScrollElement().scrollTop = 0;
            }
        }, 50); // Slight delay to ensure layout has been rendered*/
            setupOutsideClickListener();
        }
    }

    $('body').on('click', '.category-dropdown__menu-btn', function () {
        toggleDropdown();
    });

     $('body').on('click', '.category-dropdown-menu .menu-item', function (e) {
        e.preventDefault();

        $(document).off('click.dropdown');

        const $this = $(this);

        $('.category-dropdown-menu .menu-item').removeClass('hidden').addClass('visible');
        $this.addClass('hidden').removeClass('visible');

        const categoryText = $this.text();
        $('#dropdown-btn-text').text(categoryText);

        toggleDropdown();

        handleCategoryFilter($, categoryText);
    });

    function setupOutsideClickListener () {
        function outsideClickHandler (e) {
            if(!$menu.is(e.target) && $menu.has(e.target).length === 0 && !$toggleBtn.is(e.target) && $toggleBtn.has(e.target).length === 0) {
                    toggleDropdown();
                    $(document).off('click.dropdown', outsideClickHandler);
                }
        }
    
    setTimeout(() => {
            $(document).on('click.dropdown', outsideClickHandler)
        }, 0)
  }

    /*function toggleDropdown({ button, menu, container }) {
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

        $(`${context} .category-dropdown-menu .menu-item`).removeClass('hidden').addClass('visible');
        $this.addClass('hidden').removeClass('visible');

        const categoryText = $this.text();
        $(`${context} #dropdown-btn-text`).text(categoryText);

        toggleDropdown({
            button: $(this).parent().prev(),
            menu: $(`${context} .category-dropdown-menu`),
            container: $(`${context} .category-dropdown`)
        });

        filterContentByCategoryAjax($, { category: categoryText });
    });*/
}