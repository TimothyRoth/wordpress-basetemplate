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

    new Swiper('.' + parentClassName, {
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
    })

};

const swipifyContainer = (container, parentClassName, pagination = false, arrows = false) => {
    container.addClass('swiper-wrapper');
    container.wrap('<div class="' + parentClassName + '"></div>');
    container.children().wrap('<div class="swiper-slide"></div>')

    const parent = jQuery('.' + parentClassName);

    if (arrows) {
        parent.append('<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>');
    }

    if (pagination) {
        parent.append('<div class="swiper-pagination"></div>');
    }
}

module.exports = {
    swiper
}