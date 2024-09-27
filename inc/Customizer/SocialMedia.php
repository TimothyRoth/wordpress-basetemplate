<?php

namespace basetemplate\Customizer;

class SocialMedia extends CUSTOMIZER
{
    private string $social_media_facebook = 'social_media_facebook';
    private string $social_media_instagram = 'social_media_instagram';
    private string $social_media_linkedin = 'social_media_linkedin';
    private string $social_media_xing = 'social_media_xing';

    protected function define_customizer_fields(): void
    {
        $this->add_customizer_field($this->social_media_facebook, [
            $this->field_setting_label => _x('Facebook Link', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_url,
        ]);

        $this->add_customizer_field($this->social_media_instagram, [
            $this->field_setting_label => _x('Instagram Link', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_url,
        ]);

        $this->add_customizer_field($this->social_media_linkedin, [
            $this->field_setting_label => _x('LinkedIn Link', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_url,
        ]);

        $this->add_customizer_field($this->social_media_xing, [
            $this->field_setting_label => _x('Xing Link', 'Theme customizer', 'basetemplate'),
            $this->field_setting_type => $this->input_type_url,
        ]);
    }

    public function get_company_facebook(): string
    {
        return $this->get_customizer_value($this->social_media_facebook);
    }

    public function get_company_instagram(): string
    {
        return $this->get_customizer_value($this->social_media_instagram);
    }

    public function get_company_linkedin(): string
    {
        return $this->get_customizer_value($this->social_media_linkedin);
    }

    public function get_company_xing(): string
    {
        return $this->get_customizer_value($this->social_media_xing);
    }
}
