<?php

namespace customizer;
class CompanyDetails
{
    public string $company_name = 'company_details_company';
    public string $company_ceo = 'company_details_ceo';
    public string $company_street = 'company_details_street';
    public string $company_zipcode = 'company_details_zipcode';
    public string $company_city = 'company_details_city';
    public string $company_phone = 'company_details_phone';
    public string $company_email = 'company_details_email';
    public string $company_homepage_url = 'company_details_homepage';

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

        $wp_customize->add_section('basetemplate_company_details', [
            'title' => __('Firmen Informationen', 'basetemplate'),
            'priority' => 30,
        ]);

        /**
         * Settings
         *
         */

        $wp_customize->add_setting($this->company_name, [
            'transport' => 'postMessage',
        ]);

        $wp_customize->add_setting($this->company_ceo, [
            'transport' => 'postMessage',
        ]);

        $wp_customize->add_setting($this->company_street, [
            'transport' => 'postMessage',
        ]);

        $wp_customize->add_setting($this->company_zipcode, [
            'transport' => 'postMessage',
        ]);

        $wp_customize->add_setting($this->company_city, [
            'transport' => 'postMessage',
        ]);

        $wp_customize->add_setting($this->company_phone, [
            'transport' => 'postMessage',
        ]);

        $wp_customize->add_setting($this->company_email, [
            'transport' => 'postMessage',
        ]);

        $wp_customize->add_setting($this->company_homepage_url, [
            'transport' => 'postMessage',
        ]);

        /**
         * Controls
         *
         */

        $wp_customize->add_control($this->company_name, [
            'label' => _x('Firmenname', 'Theme customizer', 'basetemplate'),
            'section' => 'basetemplate_company_details',
            'type' => 'text',
        ]);
        $wp_customize->add_control($this->company_ceo, [
            'label' => _x('Geschäftsführer', 'Theme customizer', 'basetemplate'),
            'section' => 'basetemplate_company_details',
            'type' => 'text',
        ]);

        $wp_customize->add_control($this->company_city, [
            'label' => _x('Stadt', 'Theme customizer', 'basetemplate'),
            'section' => 'basetemplate_company_details',
            'type' => 'text',
        ]);

        $wp_customize->add_control($this->company_zipcode, [
            'label' => _x('Postleitzahl', 'Theme customizer', 'basetemplate'),
            'section' => 'basetemplate_company_details',
            'type' => 'text',
        ]);

        $wp_customize->add_control($this->company_street, [
            'label' => _x('Straße', 'Theme customizer', 'basetemplate'),
            'section' => 'basetemplate_company_details',
            'type' => 'text',
        ]);

        $wp_customize->add_control($this->company_phone, [
            'label' => _x('Telefon', 'Theme customizer', 'basetemplate'),
            'section' => 'basetemplate_company_details',
            'type' => 'text',
        ]);

        $wp_customize->add_control($this->company_email, [
            'label' => _x('E-Mail', 'Theme customizer', 'basetemplate'),
            'section' => 'basetemplate_company_details',
            'type' => 'text',
        ]);

        $wp_customize->add_control($this->company_homepage_url, [
            'label' => _x('Homepage', 'Theme customizer', 'basetemplate'),
            'section' => 'basetemplate_company_details',
            'type' => 'text',
        ]);

    }
}
