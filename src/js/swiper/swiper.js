'use strict'

const {Swiper} = require('swiper');
const {Navigation, Pagination} = require('swiper/modules');

const swiper = () => {


    const blogSliderContainer = jQuery('.home .fab-blogposts-container');

    /* the parentClassName is used to determine the class name of the parent container that we put in the constructor of the new Swiper(...) */
    const parentClassName = 'blog-swiper-wrapper';
    /* use this function to apply the required DOM structure to any jQuery Object / DOM Element AND Activate Arrows and/or Pagination */
    swipifyContainer(
        blogSliderContainer,
        parentClassName,
        true,
        false
    );

};

/**
* @param {jQuery} container - The jQuery Object that should be swipified
 * @param {string} parentClassName - The class name of the parent container that we put in the constructor of the new Swiper(...)
 * @param {boolean} pagination - If true, the pagination will be added to the parent container
 * @param {boolean} arrows - If true, the arrows will be added to the parent container
 * @param {Object} options - If you want to pass custom options to the Swiper instance, you can do it here. Otherwise, the default options will be used
 * @returns {void}
 *
 * @description use this class to apply the required DOM structure to any jQuery Object / DOM Element AND Activate Arrows and/or Pagination
* */
const swipifyContainer = (container, parentClassName, pagination = false, arrows = false, options = null) => {
    container.addClass('swiper-wrapper');
    container.wrap('<div class="' + parentClassName + '"></div>');
    container.children().wrap('<div class="swiper-slide"></div>')

    const parent = jQuery('.' + parentClassName);

    const defaultOptions =   {
        modules: [Navigation, Pagination],
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        observer: true,
        observeParents: true,
    };

    if (arrows) {
        parent.append('<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>');
    }

    if (pagination) {
        parent.append('<div class="swiper-pagination"></div>');
    }

    new Swiper('.' + parentClassName, options ? options : defaultOptions);
}

module.exports = {
    swiper
}