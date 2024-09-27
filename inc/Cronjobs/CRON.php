<?php

namespace basetemplate\Cronjobs;

abstract class CRON
{

    protected string $timezone = "Europe/Berlin";
    protected string $locale = 'de_DE.UTF-8';

    /**
     * @hint Initializes the cron job with timezone and locale settings.
     * @hint to register a cron job, use the register method in the constructor of the child class
     * @hint call the parent constructor in the child class constructor if you want to use the timezone and locale settings
     * */
    public function __construct()
    {
        add_action('init', [$this, 'initializeCron']);
    }

    /**
     * @Initializes the cron job with timezone and locale settings.
     */
    public function initializeCron(): void
    {
        date_default_timezone_set($this->timezone);
        setlocale(LC_TIME, $this->locale);
    }

    /**
     * Registers a cron job.
     *
     * @param callable|string|array $event The event to be scheduled (callable, method name, or array with object/method).
     * @param string $schedule_name The name of the cron job schedule.
     * @param int $interval The interval in seconds for the cron job.
     * @param string $interval_name The name of the custom interval.
     * @param string|null $text_domain The text domain for the plugin.
     *
     * @example
     * Example 1: Register a new cron job with a callable function.
     *  $this->register(
     *      function () {           // callable function
     *          // do something     // function body
     *      },
     *      'new_cronjob',          // schedule name
     *      1000,                   // interval in seconds
     *      'every_1000_seconds'    // interval name
     *   );
     * Example 2: Register a new cron job with a method.
     * $this->register(
     *      'new_callback',                 // method name
     *      'new_cronjob',                  // schedule name
     *      1000,                           // interval in seconds
     *      'every_1000_seconds'            // interval name
     * );
     * Example 3: Register a new cron job with an array.
     * $this->register(
     *      [$this, 'new_callback'],         // array with object/method
     *      'new_cronjob',                   // schedule name
     *      1000,                            // interval in seconds
     *      'every_1000_seconds'             // interval name
     * );
     *
     */

    public function register(callable|string|array $event, string $schedule_name, int $interval = 2880, string $interval_name = 'timothy_roth_basetemplate_interval', string $text_domain = null): void
    {
        $text_domain = $text_domain ?: "basetemplate";

        add_filter('cron_schedules', function ($schedules) use ($interval_name, $interval, $text_domain): array {
            $schedules[$interval_name] = [
                'interval' => $interval,
                'display' => __($interval_name, $text_domain),
            ];
            return $schedules;
        });

        $next_scheduled = wp_next_scheduled($schedule_name);

        if ($next_scheduled) {
            $schedules = wp_get_schedules();
            $current_interval = $schedules[$interval_name]['interval'];

            $interval_changed = $current_interval !== $interval;

            if ($interval_changed) {
                wp_schedule_event(time(), $interval_name, $schedule_name);
            }
        }

        if (!$next_scheduled) {
            wp_schedule_event(time(), $interval_name, $schedule_name);
        }

        if (is_callable($event)) {
            add_action($schedule_name, $event);
        } elseif (is_string($event) && method_exists($this, $event)) {
            add_action($schedule_name, [$this, $event]);
        } elseif (is_array($event) && is_callable($event)) {
            add_action($schedule_name, $event);
        } else {
            throw new \InvalidArgumentException('Invalid event provided for CRON registration.');
        }
    }

    /**
     * Deletes a cron job.
     *
     * @param string $schedule_name The name of the cron job schedule.
     *
     * @example
     * $this->delete('new_cronjob');
     *
     */

    public function delete(string $schedule_name): void
    {
        $cron_is_known = wp_next_scheduled($schedule_name);

        if ($cron_is_known) {
            wp_unschedule_event($cron_is_known, $schedule_name);
        }
    }
}
