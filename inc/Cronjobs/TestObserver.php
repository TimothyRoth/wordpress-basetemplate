<?php

namespace basetemplate\Cronjobs;

use WP_Query;

class TestObserver extends CRON
{
    public function __construct()
    {
        parent::__construct();

        $this->register(function () {
            // ...
        },
            'new_cronjob',
            1000,
            'every_1000_seconds'
        );
    }

}