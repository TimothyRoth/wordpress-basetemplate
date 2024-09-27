<?php

namespace basetemplate\Shortcodes;

/**
 * @class SHORTCODE
 * @hint This class is not an abstract class because it can be useful to call this to render shortcodes globally
 * @hint At some point I considered moving this inside the Helper class. I kept it here to keep the codebase DRY.
 * */
class SHORTCODE
{
    /**
     * @param string $shortcode_name
     * @param callable $callback
     * @return void
     *
     * @example
     * ThemeWizard::Shortcodes()->create(
     *      'shortcode_name',
     *      function(){
     *          return 'shortcode_content';
     *      }
     * );
     *
     * */
    public function create(string $shortcode_name, callable $callback): void
    {
        add_shortcode($shortcode_name, $callback);
    }

    /**
     * @param string $shortcode_name
     * @return string
     *
     * @example
     * ThemeWizard::Shortcodes()->render(
     *      'shortcode_name'
     * );
     *
     * */
    public function render(string $shortcode_name): string
    {
        return do_shortcode('[' . $shortcode_name . ']');
    }

}