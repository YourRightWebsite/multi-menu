jQuery('.js-multi-menu-slideout-toggle-close').on('click', function() {
    let parent = jQuery(this).parents('.menu-slideout-container').first();
    parent.removeClass('open');
});

jQuery('.js-multi-menu-slideout-toggle-open').on('click', function() {
    let parent = jQuery(this).parents('.js-multi-menu-slideout').first();
    let container = parent.find('.menu-slideout-container');

    if(container.hasClass('open')) {
        container.removeClass('open');
    }
    else {
        container.addClass('open');
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