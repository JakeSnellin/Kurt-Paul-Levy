import { handleCategoryFilter } from './handleCategoryFilter.js';

export function categoryDropdown($) {
    const $toggleBtn = $('.category-dropdown__menu-btn');
    const $menu = $('.category-dropdown-menu');
    const $scrollContainer = $('.scroll-container');
    const $dropdown = $('.category-dropdown');

    let isDropdownOpen = false; // Tracks dropdown state
    let backgroundResetTimeout = null; // Tracks background reset timeout

    function toggleDropdown() {
        const caretIcon = $dropdown.find('.icon-caret-down');
        caretIcon.toggleClass('rotated');

        if (isDropdownOpen) {
            // Close dropdown
            $menu.removeClass('open');

            // Clear any existing background reset timeout
            if (backgroundResetTimeout) {
                clearTimeout(backgroundResetTimeout);
            }

            backgroundResetTimeout = setTimeout(() => {
                $dropdown.css('background-color', "");
                backgroundResetTimeout = null;
            }, 300); // Matches close animation duration

            $toggleBtn.attr('aria-expanded', 'false');
            isDropdownOpen = false;
            $(document).off('click.dropdown'); // Remove outside click listener
        } else {
            // Open dropdown
            $menu.addClass('open');

            // Clear pending timeout if user reopened quickly
            if (backgroundResetTimeout) {
                clearTimeout(backgroundResetTimeout);
                backgroundResetTimeout = null;
            }

            $dropdown.css('background-color', "#EFEFEF");
            $toggleBtn.attr('aria-expanded', 'true');
            isDropdownOpen = true;

            setTimeout(() => {
                const simplebarInstance = SimpleBar.instances.get($scrollContainer[0]);
                if (simplebarInstance) {
                    simplebarInstance.recalculate();
                    simplebarInstance.getScrollElement().scrollTop = 0;
                }
            }, 50); // Delay to ensure DOM is ready

            setupOutsideClickListener();
        }
    }

    function setupOutsideClickListener() {
        function outsideClickHandler(e) {
            if (isDropdownOpen && !$(e.target).closest('.category-dropdown').length) {
                toggleDropdown();
            }
        }

        $(document).off('click.dropdown'); // Avoid duplicates
        $(document).on('click.dropdown', outsideClickHandler);
    }

    // Handle toggle button click
    $('body').on('click', '.category-dropdown__menu-btn', function () {
        toggleDropdown();
    });

    // Handle dropdown item selection
    $('body').on('click', '.category-dropdown-menu .menu-item', function (e) {
        e.preventDefault();

        const $this = $(this);

        // Reset visibility of all menu items
        $('.category-dropdown-menu .menu-item').removeClass('hidden').addClass('visible');
        $this.addClass('hidden').removeClass('visible');

        // Update button text
        const categoryText = $this.text();
        $('#dropdown-btn-text').text(categoryText);

        toggleDropdown();

        // Apply category filter
        handleCategoryFilter($, categoryText);
    });
}