<?php

namespace basetemplate\Metaboxes;

abstract class METABOX
{
    protected array $meta_boxes = [];
    protected string $input_type_input = 'input';
    protected string $input_type_textarea = 'textarea';
    protected string $input_type_select = 'select';
    protected string $input_type_wp_editor = 'wp_editor';
    protected string $type_checkbox = 'checkbox';
    protected string $type_text = 'text';
    protected string $type_number = 'number';
    protected string $type_email = 'email';
    protected string $type_url = 'url';
    protected string $input_select_options = 'select_options';
    protected string $input_option_label = 'label';
    protected string $input_option_type = 'type';
    protected string $input_option_placeholder = 'placeholder';
    protected string $input_option_rows = 'rows';
    protected string $input_option_input_type = 'input_type';
    protected string $meta_box_setting_title = 'title';
    protected string $meta_box_setting_screen = 'screen';
    protected string $meta_box_setting_context = 'context';
    protected string $meta_box_setting_priority = 'priority';
    protected string $meta_box_setting_fields = 'fields';


    /**
     * @hint Registers the meta boxes and saves the meta fields
     * @hint if you want to extend the parents constructor without overwriting it, use parent::__construct() in the child class constructor
     */
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'register_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
        add_action('admin_footer', array($this, 'add_scripts'));
    }

    /**
     * @return void
     * @hint this method should define the meta boxes inside their child classes
     *
     * @example
     * protected function define_meta_boxes() {
     *     $this->meta_boxes = [
     *          $this->example_meta_box_id => [
     *              $this->meta_box_setting_title => $this->example_meta_box_title,
     *              $this->meta_box_setting_screen => $this->example_meta_box_screen,
     *              $this->meta_box_setting_fields => [
     *          $this->example_headline => [
     *              $this->input_option_input_type => $this->input_type_input,
     *              $this->input_option_type => $this->type_text,
     *              $this->input_option_placeholder => 'Headline',
     *          ],
     *          $this->example_sub_headline => [
     *              $this->input_option_input_type => $this->input_type_input,
     *              $this->input_option_type => $this->type_text,
     *              $this->input_option_placeholder => 'Sub Headline',
     *          ]
     *    ];
     * }
     *
     * */
    abstract protected function define_meta_boxes(): void;

    /**
     * @return void
     * @hint Registers the meta boxes
     * @description Loops through the meta boxes and registers them based on the settings
     */

    public function register_meta_boxes(): void
    {

        $this->define_meta_boxes();

        foreach ($this->meta_boxes as $meta_box_id => $meta_box_settings) {
            add_meta_box(
                $meta_box_id,
                $meta_box_settings[$this->meta_box_setting_title],
                [$this, 'render_meta_box'],
                $meta_box_settings[$this->meta_box_setting_screen] ?? 'post',
                $meta_box_settings[$this->meta_box_setting_context] ?? 'normal',
                $meta_box_settings[$this->meta_box_setting_priority] ?? 'default',
                $meta_box_settings[$this->meta_box_setting_fields] ?? []
            );
        }

    }

    public function render_meta_box($post, $box): void
    {
        $this->render_meta_fields($box['args']);
    }

    /**
     * @param array $meta_fields
     * @return void
     * @hint Renders the meta fields
     * @description renders a meta field based on its input type
     * */
    public function render_meta_fields(array $meta_fields): void
    {
        wp_nonce_field(basename(__FILE__), 'metabox_nonce');

        foreach ($meta_fields as $name => $settings) {

            $value = get_post_meta(get_the_ID(), $name, true);

            $fn = match ($settings['input_type']) {
                $this->input_type_textarea => 'renderTextarea',
                $this->input_type_select => 'renderSelect',
                $this->input_type_wp_editor => 'renderWpEditor',
                default => 'renderInput',
            };

            $this->$fn($name, $settings, $value);
        }
    }

    /**
     * @param int $post_id
     * @return void
     * @hint Saves the fields of the meta boxes on "save_post"
     * @description adds a nonce check, checks if the user has the right to edit the post, and saves the meta fields
     * @description uses the defined meta boxes from the $this->>define_meta_boxes() method called inside the child class
     * */

    public function save_meta_boxes($post_id): void
    {

        if (!isset($_POST['metabox_nonce']) || !wp_verify_nonce($_POST['metabox_nonce'], basename(__FILE__))) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $this->define_meta_boxes();

        foreach ($this->meta_boxes as $box_settings) {
            $this->save_meta_fields($box_settings[$this->meta_box_setting_fields]);
        }
    }

    /**
     * @param string $meta_key
     * @param int|string|null $target_id set a target (useful if you want to use a specific id for getters and setters outside the edit page)
     * @param bool $is_checkbox use this if you want to get the value of a checkbox as a boolean
     * @return string|bool
     * @hint Gets the value of a meta field
     * @description gets the value of a meta field based on the meta key and the target id
     */
    protected function get_meta_value(string $meta_key, int|string $target_id = null, bool $is_checkbox = false): string|bool
    {

        if ($target_id === null) {
            $target_id = get_the_id();
        }

        $value = get_post_meta($target_id, $meta_key, true);

        if ($is_checkbox) {
            return $value === '1';
        }

        if ((int)$value === 1 || $value === null) {
            return false;
        }

        return $value;
    }

    /**
     * @param array $meta_fields the structure of the meta fields is defined in the define_meta_boxes method
     * @return void
     * @description saves the meta fields of a meta box based on the input type
     * */
    public function save_meta_fields(array $meta_fields): void
    {
        foreach ($meta_fields as $meta_field => $values) {

            if (isset($values[$this->input_option_type]) && $values[$this->input_option_type] === $this->type_checkbox) {
                $value = isset($_POST[$meta_field]) ? '1' : '0';
                update_post_meta(get_the_ID(), $meta_field, $value);
                continue;
            }

            if (isset($_POST[$meta_field])) {
                update_post_meta(get_the_ID(), $meta_field, $_POST[$meta_field]);
            }
        }
    }


    public function renderInput($name, $settings, $value): void
    {

        ob_start();

        if (isset($settings[$this->input_option_label])) { ?>
            <label for="<?php echo $name; ?>">
                <?php echo $settings['label']; ?>
            </label>
        <?php }

        if ($settings[$this->input_option_type] === $this->type_checkbox) { ?>
            <input class="meta-box-input" type="<?= $settings[$this->input_option_type] ?>"
                   name="<?php echo $name; ?>" id="<?php echo $name; ?>"
                   value="1" <?php echo (!empty($value) && $value === '1') ? 'checked' : ''; ?>>
            <?php echo ob_get_clean();
            return;
        } ?>

        <input class="meta-box-input" type="<?php echo $settings[$this->input_option_type]; ?>"
               placeholder="<?php echo $settings[$this->input_option_placeholder] ?? ''; ?>"
               name="<?php echo $name; ?>" id="<?php echo $name; ?>"
               value="<?php echo $value; ?>"><br/>
        <?php echo ob_get_clean();
    }

    public function renderTextarea($name, $settings, $value): void
    {
        ob_start(); ?>

        <?php if (isset($settings[$this->input_option_label])) { ?>
        <label for="<?php echo $name; ?>">
            <?php echo $settings[$this->input_option_label]; ?>
        </label>
    <?php } ?>

        <textarea class="meta-box-input" placeholder="<?php echo $settings[$this->input_option_placeholder] ?? ''; ?>"
                  name="<?php echo $name; ?>"
                  id="<?php echo $name; ?>"><?php echo $value; ?></textarea><br/>
        <?php echo ob_get_clean();
    }

    public function renderSelect($name, $settings, $value): void
    {
        ob_start(); ?>

        <?php
        if (isset($settings[$this->input_option_label])) { ?>
            <label for="<?php echo $name; ?>">
                <?php echo $settings[$this->input_option_label]; ?>
            </label>
        <?php } ?>

        <select class="meta-box-input" name="<?php echo $name; ?>">
            <?php foreach ($settings[$this->input_select_options] as $option) { ?>
                <option value="<?php echo $option; ?>" <?php echo($value === $option ? 'selected' : ''); ?>><?php echo $option; ?></option>
            <?php } ?>
        </select>
        <?php echo ob_get_clean();
    }

    public function renderWpEditor($name, $settings, $value): void
    {
        ob_start();

        if (isset($settings[$this->input_option_label])) { ?>
            <label for="<?php echo $name; ?>">
                <b><?php echo $settings[$this->input_option_label]; ?></b>
            </label>
        <?php }

        $editor_settings = [
            'textarea_name' => $name,
            'textarea_rows' => $settings[$this->input_option_rows] ?? 10,
        ];

        wp_editor(htmlspecialchars_decode($value), $name, $editor_settings);

        echo ob_get_clean();
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

}
