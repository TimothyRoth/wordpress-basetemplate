<?php

namespace customizer;

use WP_Customize_Control;
class SiteIdentity
{

    public string $logo_link = 'logo_link';

    public function __construct()
    {
        add_action('customize_register', [$this, 'theme_customize_register']);
    }

    public function theme_customize_register($wp_customize): void
    {
        $wp_customize->add_setting($this->logo_link, array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'esc_url_raw'
        ));

        // Add a control for the logo link
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, $this->logo_link, array(
            'label' => __('Logo Link', 'theme_textdomain'),
            'section' => 'title_tagline',
            'settings' => $this->logo_link,
            'type' => 'url',
        )));

    }
}
