'use strict';

const {infoSidebar} = require('./infoSidebar/infoSidebar');
const {modal} = require('./modal/modal');
const {swiper} = require('./swiper/swiper');
const {exampleRequest} = require('./ajax/ExampleRequest');
const {generatePdf} = require('./pdf/generatePdf');

jQuery(document).ready(() => {
    infoSidebar();
    modal();
    swiper();
    exampleRequest();
    generatePdf();
});
