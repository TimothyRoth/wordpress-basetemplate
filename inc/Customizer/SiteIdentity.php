<?php

namespace basetemplate\Customizer;

class SiteIdentity extends CUSTOMIZER
{
    private string $logo_link = 'logo_link';

    private string $test_image = 'test_image';

    public function __construct()
    {
        /**
         * set section_name to the value of an existing section to extend it instead of creating a new one
         * @hint it is still important to run the parent constructor to register the customizer fields
         * */
        $this->section_name = 'title_tagline';

        parent::__construct();
    }

    protected function define_customizer_fields(): void
    {
        $this->add_customizer_field($this->logo_link, [
            $this->field_setting_label => _x('Logo Link', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_url,
        ]);

        $this->add_customizer_field($this->test_image, [
            $this->field_setting_label => _x('Test Image', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_image,
        ]);

    }

    public function get_logo_link(): string|bool
    {
        return $this->get_customizer_value($this->logo_link);
    }

}
