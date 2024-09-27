'use strict';

const exampleRequest = () => {

    const trigger_button = jQuery('.trigger-ajax-test')
    trigger_button.on('click', function () {
        exampleClientCall('Button was clicked and AJAX request was sent!');
    });

    const exampleClientCall = example_data => {
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax.url,
            data: {
                action: 'example_request',
                example_data
            },
            success: function (response) {
                alert(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
    }
}



module.exports = {
    exampleRequest
}