jQuery('.js-multi-menu-fullscreen-toggle-close').on('click', function() {
    let parent = jQuery(this).parents('.menu-fullscreen-container').first();
    parent.removeClass('open');
    jQuery('body').removeClass('mm-lock');
});

jQuery('.js-multi-menu-fullscreen-toggle-open').on('click', function() {
    let parent = jQuery(this).parents('.js-multi-menu-fullscreen').first();
    let container = parent.find('.menu-fullscreen-container');

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