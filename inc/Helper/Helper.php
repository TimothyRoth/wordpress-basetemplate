<?php

namespace basetemplate\Helper;

/**
 * @class Helper
 * @description This class contains helper functions that can be used throughout the theme
 *
 * @example
 * If you are annoyed by not having full IDE support like autocompletion
 * for WordPress functions like get_template_directory_uri() and get_template_directory()
 * you can add them as public methods in this class and use them like this:
 * ThemeWizard::Helper()->get_template_directory_uri();
 * */
class Helper
{
    /**
     * @param string $string
     * @return string
     * @hint This function will separate camel case string
     *
     * @example
     * ThemeWizard::Helper()->separate_camel_case('camelCaseString'); // returns 'camel Case String'
     * */
    public function separate_camel_case(string $string): string
    {
        return preg_replace('/(?<!^)([A-Z])/', ' $1', $string);
    }

    /**
     * @return string template directory uri
     * */
    public function get_template_directory_uri(): string
    {
        return get_template_directory_uri();
    }

    /**
     * @return string template directory
     * */

    public function get_template_directory(): string
    {
        return get_template_directory();
    }

}