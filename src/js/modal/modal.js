'use strict'

const modal = () => {

    const trigger = jQuery('a');
    const close = jQuery('.close-modal');

    trigger.on('click', function () {
        const href = jQuery(this).attr('href');
        if(href.startsWith("#") && href.length > 1) {
            const action = href.replace("#", "trigger-");
            openModal(action);
        }
    });

    close.on('click', function () {
        jQuery('.modal').removeClass('active');
        jQuery('body').removeClass('modal-open');
    });
}


const openModal = modal => {
    const element = jQuery("." + modal);
    if (element.length > 0) {
        jQuery('body').addClass('modal-open');
        element.addClass('active');
    }
}

module.exports = {
    modal
}