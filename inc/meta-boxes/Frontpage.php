<?php

namespace meta_boxes;
class Frontpage extends Metabox
{

    private array $teaser_meta_fields;
    private array $block_1_meta_fields;
    public string $headline = 'headline';
    public string $sub_headline = 'sub_headline';
    public string $bullets = 'bullets';
    public string $appointment_link = 'appointment_link';
    public string $appointment_text = 'appointment_text';
    public string $block_1_headline = 'block_1_headline';
    public string $block_1_sub_headline_left = 'block_1_sub_headline_left';
    public string $block_1_sub_headline_right = 'block_1_sub_headline_right';
    public string $block_1_text_block_left = 'block_1_text_block_left';
    public string $block_1_text_block_right = 'block_1_text_block_right';
    public string $block_1_button_text = 'block_1_button_text';
    public string $block_1_button_link = 'block_1_button_link';

    public function __construct()
    {

        $this->teaser_meta_fields = [

            $this->headline => [
                'input_type' => 'textarea',
                'placeholder' => 'Überschrift'
            ],
            $this->sub_headline => [
                'input_type' => 'textarea',
                'placeholder' => 'Zweite Überschrift'
            ],
            $this->bullets => [
                'input_type' => 'textarea',
                'placeholder' => 'Bullets'
            ],
            $this->appointment_text => [
                'input_type' => 'text',
                'type' => 'text',
                'placeholder' => 'Termin vereinbaren Button Text'
            ],
            $this->appointment_link => [
                'input_type' => 'text',
                'type' => 'text',
                'placeholder' => 'Termin vereinbaren Button Link'
            ],
        ];

        $this->block_1_meta_fields = [
            $this->block_1_headline => [
                'input_type' => 'input',
                'type' => 'text',
                'placeholder' => 'Überschrift'
            ],
            $this->block_1_sub_headline_left => [
                'input_type' => 'input',
                'type' => 'text',
                'placeholder' => 'Linke Sub-Überschrift'
            ],
            $this->block_1_text_block_left => [
                'input_type' => 'textarea',
                'placeholder' => 'Textblock links'
            ],
            $this->block_1_sub_headline_right => [
                'input_type' => 'input',
                'type' => 'text',
                'placeholder' => 'Rechte Sub-Überschrift'
            ],
            $this->block_1_text_block_right => [
                'input_type' => 'textarea',
                'placeholder' => 'Textblock rechts'
            ],
            $this->block_1_button_text => [
                'input_type' => 'input',
                'type' => 'text',
                'placeholder' => 'Button Text'
            ],
            $this->block_1_button_link => [
                'input_type' => 'input',
                'type' => 'text',
                'placeholder' => 'Button Link'
            ],
        ];

        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post', array($this, 'save_fields'));
        add_action('admin_footer', array($this, 'add_scripts'));
    }

    public function add_metabox(): void
    {
        global $post;
        $page_id = get_option('page_on_front');

        if ($post->ID == $page_id) {
            add_meta_box(
                'Teaser Box',
                'Teaser Box',
                array($this, 'teaser_callback'),
                'page',
                'normal',
                'default'
            );

            add_meta_box(
                'Block 1',
                'Block 1',
                array($this, 'block_1_callback'),
                'page',
                'normal',
                'default'
            );
        }
    }

    public function teaser_callback(): void
    {
        $this->render_meta_fields($this->teaser_meta_fields);
    }

    public function block_1_callback(): void
    {
        $this->render_meta_fields($this->block_1_meta_fields);
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
        $this->save_meta_fields($this->teaser_meta_fields);
        $this->save_meta_fields($this->block_1_meta_fields);
    }

}
