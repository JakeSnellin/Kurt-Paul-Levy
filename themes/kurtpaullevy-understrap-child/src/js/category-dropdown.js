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
            if (!$(e.target).closest('.category-dropdown').length) {
                toggleDropdown();
                $(document).off('click.dropdown', outsideClickHandler);
            }
        }

        $(document).off('click.dropdown');
        $(document).on('click.dropdown', outsideClickHandler);
    }
}