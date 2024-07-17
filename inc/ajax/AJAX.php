<?php

namespace ajax;

class AJAX
{
    /**
     * @throws \JsonException
     */
    public function send_json_response($response): void
    {
        wp_die(json_encode($response, JSON_THROW_ON_ERROR));
    }

    public function register($ajax_call): void {
        add_action('wp_ajax_' . $ajax_call, [$this, $ajax_call]);
        add_action('wp_ajax_nopriv_' . $ajax_call, [$this, $ajax_call]);
    }

}