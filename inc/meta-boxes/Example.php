<?php

namespace meta_boxes;
class Example extends Metabox
{
    private array $meta_fields;

    public string $test_input_text = 'test_input_text';
    public string $test_input_number = 'test_input_number';
    public string $test_input_wp_editor = "text_input_wp_editor";

    public function __construct()
    {

        /*
         * For each specific Meta-Box Area you need to create a new Array with the fields you want to display and later save.
         * The key is the name of the field and the value is an array with the settings for the field.
          * To check the @params take a further look into the Metabox base class.
         * */

        $this->meta_fields = [
            $this->test_input_text => [
                'input_type' => 'input',
                'type' => 'text',
                'placeholder' => 'Text Input Text',
            ],
            $this->test_input_number => [
                'input_type' => 'input',
                'type' => 'number',
                'placeholder' => 'Text Input Number',
            ],
            $this->test_input_wp_editor => [
                'input_type' => 'wp_editor',
                'label' => 'Text Input WP Editor',
            ]
        ];

        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post', array($this, 'save_fields'));
        add_action('admin_footer', array($this, 'add_scripts'));
    }

    public function add_metabox(): void
    {
        add_meta_box(
            'Example Meta',
            'Example Meta',
            array($this, 'callback'), // the callback associated with the meta box
            'example', // name of the associated custom post type
            'normal',
            'default'
        );
    }

    public function callback(): void
    {
        $this->render_meta_fields($this->meta_fields); // here simply use the render_meta_fields method to render the fields for the specific meta-box
    }

    public function add_scripts(): void
    { ?>
        <style>
            .meta-box-input {
                width: 100%;
                margin-bottom: 10px;
            }
        </style>
        <?php
    }

    public function save_fields(): void
    {
        $this->save_meta_fields($this->meta_fields); // // here simply use the save_meta_fields by passing the meta_fields array you want to save
    }

}