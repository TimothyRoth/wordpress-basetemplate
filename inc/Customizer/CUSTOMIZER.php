<?php

namespace basetemplate\Customizer;

use basetemplate\ThemeWizard;

abstract class CUSTOMIZER
{
    protected array $customizer_fields = [];
    protected string $section_name;
    protected bool $extend_existing_section = false;
    private bool $fields_defined = false;
    protected string $input_type_text = 'text';
    protected string $input_type_url = 'url';
    protected string $input_type_email = 'email';
    protected string $input_type_image = 'image';
    protected string $section_setting_title = 'title';
    protected string $section_setting_priority = 'priority';
    protected string $field_setting_default = 'default';
    protected string $field_setting_transport = 'transport';
    protected string $field_setting_label = 'label';
    protected string $field_setting_type = 'type';
    protected string $field_setting_section = 'section';
    protected string $field_setting_description = 'description';

    public function __construct()
    {
        /**
         * @hint to extend existing sections, set the $section_name property in the constructor of the child class
         * afterward run parent::__construct();
         * what this will do is to add the customizer fields to the existing section instead of creating a new one by default
         * @hint If you do not set $this->section_name in the constructor of the child class a new customizer section will be automatically generated.
         * @hint A child class with the name CompanyDetails will by default create a section with the name Company Details in
         * the customizer and be visible as soon as there are customer fields attached to it.
         * You can use the define_customizer_fields method inside the child class to define the structure of the customizer fields.
         *
         * @Example
         * Example 1: Customizer subclass that extends CUSTOMIZER and does not set the section_name property
         * class CompanyDetails extends CUSTOMIZER {
         *      protected function define_customizer_fields() {
         *          // Define the customizer fields here
         *      }
         * }
         * Example 2: Customizer subclass that extends CUSTOMIZER and sets the section_name property
         * class CompanyDetails extends CUSTOMIZER {
         *      public function __construct() {
         *          $this->section_name = 'title_tagline'; // Extends the Site Identity section
         *          parent::__construct();
         *      }
         *      protected function define_customizer_fields() {
         *          // Define the customizer fields here
         *       }
         * }
         * */

        add_action('customize_register', [$this, 'register_section']);
    }

    protected function get_section_name(): string
    {
        /**
         * @hint If the section name is not set, the section name will be the name of the class
         * */
        if (!isset($this->section_name)) {
            $namespace = "basetemplate\\Customizer\\";
            $class_name = static::class;

            if (str_starts_with($class_name, $namespace)) {
                return str_replace($namespace, '', $class_name);
            }

            return $class_name;
        }

        /**
         * Otherwise the section name will be the value of the section_name property and extend an existing section if a section with the same name already exists
         * @hint if you set $this->section_name to a value not matching with any existing section, there won't be any section created,
         * neither will the fields be added to an existing section
         * */
        $this->extend_existing_section = true;
        return $this->section_name;
    }

    protected function define_customizer_fields_if_needed(): void
    {
        if (!$this->fields_defined) {
            $this->define_customizer_fields();
            $this->fields_defined = true;
        }
    }

    public function register_section($wp_customize): void
    {
        $this->define_customizer_fields_if_needed();

        $section_name = $this->get_section_name();

        if (!$this->extend_existing_section) {
            $wp_customize->add_section($section_name, [
                $this->section_setting_title => __(ThemeWizard::Helper()->separate_camel_case($section_name), 'basetemplate'),
                $this->section_setting_priority => 30,
            ]);
        }

        foreach ($this->customizer_fields as $field_key => $field_settings) {
            $wp_customize->add_setting($field_key, [
                $this->field_setting_default => $field_settings['default'] ?? '',
                $this->field_setting_transport => $field_settings['transport'] ?? 'postMessage',
            ]);

            $control_class = 'WP_Customize_Control';
            if ($field_settings[$this->field_setting_type] === $this->input_type_image) {
                $control_class = 'WP_Customize_Image_Control';
            }

            $wp_customize->add_control(new $control_class($wp_customize, $field_key, [
                $this->field_setting_label => $field_settings['label'] ?? '',
                $this->field_setting_section => $section_name,
                $this->field_setting_type => $field_settings['type'] ?? 'text',
                $this->field_setting_description => $field_settings['description'] ?? '',
                $this->field_setting_default => $field_settings['default'] ?? '',
            ]));
        }
    }

    /**
     * @hint this method has to be used in every child class that extends this class
     * @hint define the customizer fields in this method
     * @hint use the add_customizer_field method to add fields
     *
     * @example
     * protected function define_customizer_fields() {
     *     $this->add_customizer_field('field_key',
     *          [
     *              $this->field_setting_label => 'Field Label',
     *              $this->>field_setting_type => 'text',
     *          ]
     *      });
     * }
     *
     * */
    abstract protected function define_customizer_fields(): void;

    /**
     * @param string $key
     * @param array $settings
     *
     * @description  add a customizer field
     *
     * @example
     *  $this->add_customizer_field('field_key',
     *      [
     *          $this->field_setting_label => 'Field Label',
     *          $this->>field_setting_type => 'text',
     *      ]
     *  });,
     *
     */
    protected function add_customizer_field(string $key, array $settings): void
    {
        $this->customizer_fields[$key] = $settings;
    }

    /**
     * @param string $key
     * @return string|bool
     * @description  get the value of a customizer field
     *
     * @example
     * $value = $this->get_customizer_value('field_key');
     */

    protected function get_customizer_value(string $key): string|bool
    {
        $value = get_theme_mod($key, true);

        if ((int)$value === 1 || $value === null) {
            return false;
        }

        return get_theme_mod($key, 'true');
    }

}
