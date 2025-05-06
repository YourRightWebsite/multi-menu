jQuery('.js-multi-menu-mega-toggle-close').on('click', function() {
    let parent = jQuery(this).parents('.menu-mega-container').first();
    parent.removeClass('open');
    jQuery('body').removeClass('mm-lock');
});

jQuery('.js-multi-menu-mega-toggle-open').on('click', function() {
    let parent = jQuery(this).parents('.js-multi-menu-mega').first();
    let container = parent.find('.menu-mega-container');

    if(container.hasClass('open')) {
        container.removeClass('open');
        jQuery('body').removeClass('mm-lock');
    }
    else {
        container.addClass('open');
        jQuery('body').addClass('mm-lock');
    }
});

jQuery('.js-menu-clickable-toggle').on('click', function(e) {

    e.preventDefault();
    e.stopPropagation();

    let toggle = jQuery(this);
    let parent = jQuery(this).parents('.menu-item').first();
    let innerWrapper = parent.find('.submenu-inner-wrapper').first();
    let menuClickable = parent.find('menu-clickable').first();
    let arrow = parent.find('.arrow-toggle').first();

    console.log(innerWrapper);

    if(innerWrapper.hasClass('expanded')) {
        arrow.removeClass('rotate');
        innerWrapper.removeClass('expanded');
    }
    else {
        arrow.addClass('rotate');
        innerWrapper.addClass('expanded');
    }
});

/* Handle opening and closing the mega menu on click and hover */

jQuery(document).ready(function($) {
    let $megaMenuTray = $('.mega-menu-tray');
    let $megaMenuTrayInner = $('.js-mega-menu-tray-inner');
    let isButtonOpen = false;
    let $currentButton = null;
    let activeTimeout = null;

    // Function to open the mega menu
    function openMegaMenu($element) {
        // Clear any pending timeout
        if (activeTimeout) {
            clearTimeout(activeTimeout);
            activeTimeout = null;
        }

        // Clear existing content and classes
        $megaMenuTrayInner.empty();
        $megaMenuTray.removeClass('menu-open');

        // Get submenu content
        let $submenu = $element.closest('.menu-item').find('.submenu-outer-wrapper').clone();

        // Only append if submenu exists
        if ($submenu.length) {
            $megaMenuTrayInner.append($submenu);
            $megaMenuTray.addClass('menu-open');
        }
    }

    // Function to close the mega menu
    function closeMegaMenu() {
        if (!isButtonOpen) {
            // $megaMenuTrayInner.empty();
            $megaMenuTray.removeClass('menu-open');
        }
    }

    // Debounce function to limit rapid event firing
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Debounced open function
    const debouncedOpenMegaMenu = debounce(openMegaMenu, 50);

    // Hover handling for the entire menu container
    $('.menu-mega-container-inner').hover(
        function() {
            // Keep menu open while inside the container
        },
        function() {
            // Close menu after a delay when leaving the entire container
            if (activeTimeout) {
                clearTimeout(activeTimeout);
            }
            activeTimeout = setTimeout(() => {
                closeMegaMenu();
                activeTimeout = null;
            }, 200); // Increased delay for better UX
        }
    );

    // Hover handling for individual menu items
    $('.menu-clickable, .js-menu-clickable-toggle').hover(
        function() {
            if (!isButtonOpen) {
                debouncedOpenMegaMenu($(this));
            }
        },
        function() {
            // No immediate close; rely on container hover-out
        }
    );

    // Click handling for button items
    $('.js-menu-clickable-toggle.is-button').on('click', function(e) {
        e.preventDefault();

        let $this = $(this);

        // If clicking the same button that's already open
        if (isButtonOpen && $currentButton.is($this)) {
            $megaMenuTrayInner.empty();
            $megaMenuTray.removeClass('menu-open');
            isButtonOpen = false;
            $currentButton = null;
        } else {
            openMegaMenu($this);
            isButtonOpen = true;
            $currentButton = $this;
        }
    });
});