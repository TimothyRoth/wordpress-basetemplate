<?php

namespace customizer;
class SocialMedia
{
    public string $company_facebook = 'social_media_facebook';
    public string $company_instagram = 'social_media_instagram';
    public string $company_linkedin = 'social_media_linkedin';
    public string $company_xing = 'social_media_xing';

    public function __construct()
    {
        add_action('customize_register', [$this, 'theme_customize_register']);
    }

    public function theme_customize_register($wp_customize): void
    {
        /**
         * Sections
         *
         */

        $wp_customize->add_section('basetemplate_company_social_media', [
            'title' => __('Social Media', 'basetemplate'),
            'priority' => 40,
        ]);

        /**
         * Settings
         *
         */


        $wp_customize->add_setting($this->company_xing, [
            'transport' => 'postMessage',
        ]);

        $wp_customize->add_setting($this->company_facebook, [
            'transport' => 'postMessage',
        ]);

        $wp_customize->add_setting($this->company_instagram, [
            'transport' => 'postMessage',
        ]);

        $wp_customize->add_setting($this->company_linkedin, [
            'transport' => 'postMessage',
        ]);

        /**
         * Controls
         *
         */


        $wp_customize->add_control($this->company_xing, [
            'label' => _x('XING Link', 'Theme customizer', 'basetemplate'),
            'section' => 'basetemplate_company_social_media',
            'type' => 'text',
        ]);


        $wp_customize->add_control($this->company_facebook, [
            'label' => _x('Facebook Link', 'Theme customizer', 'basetemplate'),
            'section' => 'basetemplate_company_social_media',
            'type' => 'text',
        ]);

        $wp_customize->add_control($this->company_instagram, [
            'label' => _x('Instagram Link', 'Theme customizer', 'basetemplate'),
            'section' => 'basetemplate_company_social_media',
            'type' => 'text',
        ]);

        $wp_customize->add_control($this->company_linkedin, [
            'label' => _x('LinkedIN Link', 'Theme customizer', 'basetemplate'),
            'section' => 'basetemplate_company_social_media',
            'type' => 'text',
        ]);
    }
}
