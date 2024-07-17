# How to Use Features in Your Web Application

This document guides you through triggering modals, making AJAX calls, registering cronjob and adding meta-boxes in your web application.

## Triggering a Modal

To trigger a modal, use an `<a>` tag with the `href` attribute set to `#modalId`, corresponding to the modal's identifier. For example, a modal can be triggered by an `<a href="#test">` if the modal has an ID of "test" and is defined with a class of "trigger-test" (for JavaScript interaction) and "modal" (for CSS styling purposes).

### Example:

```html
<!-- Trigger Link -->
<a href="#test">Trigger Modal</a>

<!-- Modal Element -->
<div id="test" class="trigger-test modal">
    <!-- Modal Content Here -->
</div>
<!-- Modal Element -->
```

## Implementing AJAX in WordPress

AJAX (Asynchronous JavaScript and XML) enables your WordPress site to handle data asynchronously between the server and the client without reloading the page. Here's a step-by-step guide on setting up AJAX calls using WordPress standards.

### Define Your AJAX PHP Class

Create a PHP class that handles the AJAX request. Use the `ExampleRequest` class in the `ajax` namespace to encapsulate the AJAX logic.

```php
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
```

### Base AJAX Class

Make sure to implement the AJAX class provided by the theme. This class handles the AJAX request and response, ensuring that the data is sent and received correctly.

```php
class ExampleRequest extends AJAX
```

### JavaScript Client-Side Logic

Define JavaScript functions to trigger AJAX requests from the client side. This example uses jQuery to handle the event binding and the AJAX request.
The name of the AJAX action should match the method name registered in the PHP class.

```javascript
'use strict';

const exampleRequest = () => {

    const trigger_button = jQuery('.trigger-ajax-test');
    trigger_button.on('click', function () {
        exampleClientCall('Button was clicked and AJAX request was sent!');
    });

    const exampleClientCall = example_data => {
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax.url, // Ensure `ajax.url` is properly localized to your script
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
```

## Meta-Boxes

Adding new meta-boxes to your WordPress theme is straightforward with a class-based approach, allowing for organized and reusable code. Here's how you can implement it:

**Create a New Class for Each Meta-Box**: Define a class in the `inc/meta-boxes/` directory. For instance, a class `Example` extends a base class `Metabox` which handles rendering and saving the meta fields.

**Define Meta Fields**: In your class constructor, define the meta fields you want to manage. These fields could be inputs, text areas, select boxes, or even WordPress editors. Each field is specified with settings like type, placeholder, etc.

   ```php
   $this->meta_fields = [
       'test_input_text' => [
           'input_type' => 'input',
           'type' => 'text',
           'placeholder' => 'Text Input Text',
       ],
       'test_input_number' => [
           'input_type' => 'input',
           'type' => 'number',
           'placeholder' => 'Text Input Number',
       ],
       'test_input_wp_editor' => [
           'input_type' => 'wp_editor',
           'label' => 'Text Input WP Editor',
       ]
   ];
 ```

**Add Meta-Box to the Admin Interface:** Utilize the WordPress add_meta_boxes action to hook your meta-box into the admin. Specify where it appears and its priority.

```php
add_action('add_meta_boxes', array($this, 'add_metabox')); 
```
**Rendering Meta Fields:** Use the callback method to render fields in the meta-box. The rendering is handled by the base Metabox class which dynamically calls the appropriate rendering method based on the type of input.

```php
public function callback(): void {
    $this->render_meta_fields($this->meta_fields);
}
```
**Saving Meta Fields:**  Capture and save the input from the meta-box fields using the save_post action. The save_fields method ensures that data entered is stored correctly.

   ```php
public function callback(): void {
    $this->save_meta_fields($this->meta_fields);
}
```

## Implementing Cron Jobs in WordPress

WordPress provides a powerful system to handle scheduled tasks using WP-Cron. Here’s how to implement and manage custom cron jobs in your WordPress theme or plugin.

### Setup a Custom Cron Job

Create a class to encapsulate all logic related to your cron job. In this example, the class `TestObserver` in the `cronjobs` namespace is used.

```php
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
}
```

### Define the Scheduling Frequency

Customize how frequently your cron job runs by adding a new schedule to WordPress's cron schedules.

```php
public function test_cronjob_schedule($schedules): array
{
    $oneHour = 6000; // Interval in seconds
    $schedules['every_hour'] = [
        'interval' => $oneHour,
        'display' => __('Every Hour', 'basetemplate')
    ];
    return $schedules;
}
```

### Cron Job Execution

Define what the cron job does when it is executed. Place your logic inside the method specified in the cron schedule.

```php
public function test_cronjob(): void
{
    // Your task logic here
}
```

### Initial Setup and Registration

Ensure your cron job is registered with the appropriate hooks and schedules when WordPress initializes:

```php
add_action('init', function () {
    // Set timezone and locale
    date_default_timezone_set("Europe/Berlin");
    setlocale(LC_TIME, 'de_DE', 'de_DE.UTF-8');

    // Schedule the event if it's not already scheduled
    if (!wp_next_scheduled('test_cronjob_schedule')) {
        wp_schedule_event(time(), 'every_hour', 'test_cronjob_schedule');
    }
});
```

This modular approach to creating meta-boxes simplifies adding custom functionality to your WordPress themes or plugins. The entire system is built with flexibility in mind, allowing you to easily extend or modify features as needed.

For any questions or assistance with the theme, feel free to contact:
[roth@marketport.de](mailto:roth@marketport.de)