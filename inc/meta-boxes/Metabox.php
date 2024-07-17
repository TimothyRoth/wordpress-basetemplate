<?php

namespace meta_boxes;
class Metabox
{
    public function renderInput($name, $settings, $value): void
    {

        ob_start(); ?>

        <?php
        if (isset($settings['label'])) { ?>
            <label for="<?php echo $name; ?>">
                <?php echo $settings['label']; ?>
            </label>
        <?php } ?>

        <input class="meta-box-input" type="<?php echo $settings['type']; ?>"
               placeholder="<?php echo $settings['placeholder']; ?>"
               name="<?php echo $name; ?>" id="<?php echo $name; ?>"
               value="<?php echo $value; ?>"><br/>
        <?php echo ob_get_clean();
    }

    public function renderTextarea($name, $settings, $value): void
    {
        ob_start(); ?>

        <?php
        if (isset($settings['label'])) { ?>
            <label for="<?php echo $name; ?>">
                <?php echo $settings['label']; ?>
            </label>
        <?php } ?>

        <textarea class="meta-box-input" placeholder="<?php echo $settings['placeholder']; ?>"
                  name="<?php echo $name; ?>"
                  id="<?php echo $name; ?>"><?php echo $value; ?></textarea><br/>
        <?php echo ob_get_clean();
    }

    public function renderSelect($name, $settings, $value): void
    {
        ob_start(); ?>

        <?php
        if (isset($settings['label'])) { ?>
            <label for="<?php echo $name; ?>">
                <?php echo $settings['label']; ?>
            </label>
        <?php } ?>

        <select class="meta-box-input" name="<?php echo $name; ?>">
            <?php foreach ($settings['values'] as $option) { ?>
                <option value="<?php echo $option; ?>" <?php echo($value === $option ? 'selected' : ''); ?>><?php echo $option; ?></option>
            <?php } ?>
        </select>
        <?php echo ob_get_clean();
    }

    public function renderWpEditor($name, $settings, $value): void
    {
        ob_start();
        if (isset($settings['label'])) { ?>
            <label for="<?php echo $name; ?>">
                <b><?php echo $settings['label']; ?></b>
            </label>
        <?php }

        $editor_settings = [
            'textarea_name' => $name,
            'textarea_rows' => $settings['rows'] ?? 10,
        ];

        wp_editor(htmlspecialchars_decode($value), $name, $editor_settings);

        echo ob_get_clean();
    }

    public function render_meta_fields(array $meta_fields): void
    {
        foreach ($meta_fields as $name => $settings) {
            $value = get_post_meta(get_the_ID(), $name, true);

            $fn = match ($settings['input_type']) {
                'textarea' => 'renderTextarea',
                'select' => 'renderSelect',
                'wp_editor' => 'renderWpEditor',
                default => 'renderInput',
            };

            $this->$fn($name, $settings, $value);
        }
    }

    public function save_meta_fields($meta_fields): void
    {
        foreach ($meta_fields as $meta_field => $values) {
            if (isset($_POST[$meta_field])) {
                update_post_meta(get_the_ID(), $meta_field, $_POST[$meta_field]);
            }
        }
    }

}
