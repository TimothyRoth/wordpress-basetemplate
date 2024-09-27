<?php

namespace basetemplate\Metaboxes;


class Frontpage extends METABOX
{
    private string $target_page_id;
    private string $current_page_id;
    private string $teaser_meta_box_id = 'teaser_box';
    private string $teaser_meta_box_title = 'Teaser Box';
    private string $teaser_meta_box_screen = 'page';
    private string $block_1_meta_box_id = 'block_1';
    private string $block_1_meta_box_title = 'Block 1';
    private string $block_1_meta_box_screen = 'page';
    private string $headline = 'headline';
    private string $sub_headline = 'sub_headline';
    private string $bullets = 'bullets';
    private string $appointment_link = 'appointment_link';
    private string $appointment_text = 'appointment_text';
    private string $block_1_headline = 'block_1_headline';
    private string $block_1_select = 'block_1_select';
    private string $block_1_sub_headline_left = 'block_1_sub_headline_left';
    private string $block_1_sub_headline_right = 'block_1_sub_headline_right';
    private string $block_1_text_block_left = 'block_1_text_block_left';
    private string $block_1_text_block_right = 'block_1_text_block_right';
    private string $block_1_button_text = 'block_1_button_text';
    private string $block_1_button_link = 'block_1_button_link';
    private string $test_checkbox = 'test_checkbox';

    public function __construct()
    {
        parent::__construct();
        $this->target_page_id = get_option('page_on_front') ?: 0;
    }

    protected function define_meta_boxes(): void
    {

        $this->current_page_id = get_the_ID();

        if ($this->current_page_id !== $this->target_page_id) {
            return;
        }

        $this->meta_boxes = [
            $this->teaser_meta_box_id => [
                $this->meta_box_setting_title => $this->teaser_meta_box_title,
                $this->meta_box_setting_screen => $this->teaser_meta_box_screen,
                $this->meta_box_setting_fields => [
                    $this->headline => [
                        $this->input_option_input_type => $this->input_type_input,
                        $this->input_option_type => $this->type_text,
                        $this->input_option_placeholder => 'Überschrift',
                    ],
                    $this->sub_headline => [
                        $this->input_option_input_type => $this->input_type_input,
                        $this->input_option_type => $this->type_text,
                        $this->input_option_placeholder => 'Zweite Überschrift',
                    ],
                    $this->bullets => [
                        $this->input_option_input_type => $this->input_type_textarea,
                        $this->input_option_placeholder => 'Bullets',
                    ],
                    $this->appointment_text => [
                        $this->input_option_input_type => $this->input_type_input,
                        $this->input_option_type => $this->type_text,
                        $this->input_option_placeholder => 'Termin vereinbaren Button Text',
                    ],
                    $this->appointment_link => [
                        $this->input_option_input_type => $this->input_type_input,
                        $this->input_option_type => $this->type_text,
                        $this->input_option_placeholder => 'Termin vereinbaren Button Link',
                    ],
                    $this->test_checkbox => [
                        $this->input_option_input_type => $this->input_type_input,
                        $this->input_option_type => $this->type_checkbox,
                        $this->input_option_label => 'Test Checkbox',
                    ],
                ],
            ],
            $this->block_1_meta_box_id => [
                $this->meta_box_setting_title => $this->block_1_meta_box_title,
                $this->meta_box_setting_screen => $this->block_1_meta_box_screen,
                $this->meta_box_setting_fields => [
                    $this->block_1_headline => [
                        $this->input_option_input_type => $this->input_type_input,
                        $this->input_option_type => $this->type_text,
                        $this->input_option_placeholder => 'Überschrift',
                    ],
                    $this->block_1_sub_headline_left => [
                        $this->input_option_input_type => $this->input_type_input,
                        $this->input_option_type => $this->type_text,
                        $this->input_option_placeholder => 'Linke Sub-Überschrift',
                    ],
                    $this->block_1_text_block_left => [
                        $this->input_option_input_type => $this->input_type_textarea,
                        $this->input_option_placeholder => 'Textblock links',
                    ],
                    $this->block_1_sub_headline_right => [
                        $this->input_option_input_type => $this->input_type_input,
                        $this->input_option_type => $this->type_text,
                        $this->input_option_placeholder => 'Rechte Sub-Überschrift',
                    ],
                    $this->block_1_text_block_right => [
                        $this->input_option_input_type => $this->input_type_textarea,
                        $this->input_option_placeholder => 'Textblock rechts',
                    ],
                    $this->block_1_button_text => [
                        $this->input_option_input_type => $this->input_type_input,
                        $this->input_option_type => $this->type_text,
                        $this->input_option_placeholder => 'Button Text',
                    ],
                    $this->block_1_button_link => [
                        $this->input_option_input_type => $this->input_type_input,
                        $this->input_option_type => $this->type_text,
                        $this->input_option_placeholder => 'Button Link',
                    ],
                    $this->block_1_select => [
                        $this->input_option_input_type => $this->input_type_select,
                        $this->input_select_options => [
                            'Option 1',
                            'Option 2',
                            'Option 3',
                        ],
                    ],
                ],
            ],
        ];
    }


    /*
     * getters
     * */

    public function get_headline(): string|bool
    {
        return $this->get_meta_value($this->headline, $this->target_page_id);
    }

    public function get_sub_headline(): string|bool
    {
        return $this->get_meta_value($this->sub_headline, $this->target_page_id);
    }

    public function get_bullets(): string|bool
    {
        return $this->get_meta_value($this->bullets, $this->target_page_id);
    }

    public function get_appointment_text(): string|bool
    {
        return $this->get_meta_value($this->appointment_text, $this->target_page_id);
    }

    public function get_appointment_link(): string|bool
    {
        return $this->get_meta_value($this->appointment_link, $this->target_page_id);
    }

    public function get_block_1_headline(): string|bool
    {
        return $this->get_meta_value($this->block_1_headline, $this->target_page_id);
    }

    public function get_block_1_sub_headline_left(): string|bool
    {
        return $this->get_meta_value($this->block_1_sub_headline_left, $this->target_page_id);
    }

    public function get_block_1_sub_headline_right(): string|bool
    {
        return $this->get_meta_value($this->block_1_sub_headline_right, $this->target_page_id);
    }

    public function get_block_1_text_block_left(): string|bool
    {
        return $this->get_meta_value($this->block_1_text_block_left, $this->target_page_id);
    }

    public function get_block_1_text_block_right(): string|bool
    {
        return $this->get_meta_value($this->block_1_text_block_right, $this->target_page_id);
    }

    public function get_block_1_button_text(): string|bool
    {
        return $this->get_meta_value($this->block_1_button_text, $this->target_page_id);
    }

    public function get_block_1_button_link(): string|bool
    {
        return $this->get_meta_value($this->block_1_button_link, $this->target_page_id);
    }

    public function is_test_checkbox_checked(): bool
    {
        return $this->get_meta_value($this->test_checkbox, $this->target_page_id, true);
    }

    public function get_block_1_select(): string|bool
    {
        return $this->get_meta_value($this->block_1_select, $this->target_page_id);
    }

}
