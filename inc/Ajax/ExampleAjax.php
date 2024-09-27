<?php

namespace basetemplate\Ajax;

use WP_Query;

class ExampleAjax extends AJAX
{

    public function __construct()
    {
        $this->register(
            [
                'example_request' => function () {
                    $response = $_POST['example_data'];
                    $this->send_json_response($response);
                },
            ]
        );
    }

}