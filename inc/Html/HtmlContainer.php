<?php

namespace basetemplate\Html;

/**
 * @class HtmlContainer
 * @description This class contains methods that can be used to generate HTML elements
 *
 * @example
 * If you are annoyed by using the same markup or elements in multiple places
 * you can add them as public methods in this class and use them like this:
 * ThemeWizard::Html()->custom_logo();
 * */
class HtmlContainer
{
    public function custom_logo(): string
    {
        $custom_logo_id = get_theme_mod('custom_logo');
        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
        $logo_link = !empty(get_theme_mod('logo_link')) ?  get_theme_mod('logo_link') : get_home_url();
        $html = "<a href='" . $logo_link . "' class='custom-logo-link'>" . get_bloginfo('name') . "</a>";

        if (!empty($custom_logo_id)) {
            $html = "<a target='_blank' href='" . $logo_link . "' class='custom-logo-link'><img src='" . $logo[0] . "' alt='logo'></a>";
        }

        return $html;

    }
}