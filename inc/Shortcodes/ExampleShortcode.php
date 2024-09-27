<?php

namespace basetemplate\Shortcodes;

class ExampleShortcode extends SHORTCODE
{
    public function __construct()
    {
        $this->create(
            'my_shortcode',
            function () {
                echo "<div>This is my rendered shortcode.</div>";
            }
        );
    }

}