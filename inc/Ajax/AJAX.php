<?php

namespace basetemplate\Ajax;

use JsonException;

abstract class AJAX
{

    /**
     * @param string|array $response the response to send
     * @return void
     * @throws JsonException
     *
     * @example
     * Example 1: single value response
     * $this->send_json_response(
     *      'example_response'
     * );
     * Comes out as: {"example_response":"example_response"}
     * Example 2: array response
     * $this->send_json_response(
     *      [
     *          'success' => 'true',
     *          'message' => 'example_response'
     *     ]
     * );
     * Comes out as: {"success":"true","message":"example_response"}
     */

    public function send_json_response(string|array $response): void
    {
        wp_die(json_encode($response, JSON_THROW_ON_ERROR));
    }

    /**
     * @param array $requests register the ajax calls either with a lambda function or a method
     * @return void
     *
     * @example
     * Example 1: register as ajax_hook => [{object_instance} => {method}]
     * $this->register(
     *      'ajax_hook' => [$this, 'example_method']
     * );
     *Example 2: register as ajax_hook => {lambda_function}
     * $this->register(
     *      'ajax_hook' => function() {
     *          $this->>send_json_response('example_response');
     *      }
     * );
     *
     */

    public function register(array $requests): void
    {
        foreach ($requests as $client_hook => $method) {
            if (is_array($method) && isset($method['callback'])) {
                $ajax_method = $method[0];
                $callback = $method['callback'];
            } else {
                $ajax_method = $method;
                $callback = null;
            }

            $handler = function () use ($ajax_method, $callback) {
                $result = call_user_func($ajax_method);
                if (is_callable($callback)) {
                    call_user_func($callback, $result);
                } else {
                    wp_send_json_success($result);
                }
            };

            add_action("wp_ajax_{$client_hook}", $handler);
            add_action("wp_ajax_nopriv_{$client_hook}", $handler);
        }
    }


}