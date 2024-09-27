<?php

namespace basetemplate\Menu;

class ExampleMenu extends MENU
{
    public function __construct()
    {
        $this->createMenuPage(
            'Example Menu',
            'Example Menu',
            'manage_options',
            'example-menu',
            function () {
                echo "<div><h1>This is my rendered menu page.</h1></div>";
            },
            true
        );
    }
}