<?php

namespace cronjobs;

use WP_Query;

class TestObserver
{
    public function __construct()
    {

        add_action('init', function () {
            date_default_timezone_set("Europe/Berlin");
            setlocale(LC_TIME, 'de_DE', 'de_DE.UTF-8');

            if (!wp_next_scheduled('test_cronjob_schedule')) {
                wp_schedule_event(time(), 'every_hour', 'test_cronjob_schedule');
            }
        });

        add_filter('cron_schedules', [$this, 'test_cronjob_schedule']);
        add_action('test_cronjob_schedule', [$this, 'test_cronjob']);
    }

    public function test_cronjob_schedule($schedules): array
    {
        $oneHour = 6000;
        $schedules['every_hour'] = [
            'interval' => $oneHour,
            'display' => __('Every Hour', 'basetemplate')
        ];
        return $schedules;
    }

    public function test_cronjob(): void
    {
        // ... do something
    }


}