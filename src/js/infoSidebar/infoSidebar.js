'use strict'

const infoSidebar = () => {
    const menu_button = jQuery('.info-bar');

    menu_button.on('click', function () {
        const container = jQuery(this);
        container.toggleClass('active');
    });

    jQuery('body').on('click', function (e) {
        const container = jQuery('.info-bar');
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.removeClass('active');
        }
    });
}

module.exports = {
    infoSidebar
}