<?php

namespace ajax;

use WP_Query;

class ExampleRequest extends AJAX
{

    public function __construct()
    {
       $this->register('example_request');
    }

    /**
     * @throws \JsonException
     */
    public function example_request(): void
    {
        $response = $_POST['example_data'];
        $this->send_json_response($response);
    }
    

}