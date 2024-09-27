<?php

namespace basetemplate\Taxonomies;

use basetemplate\ThemeWizard;

class ExampleTaxonomy extends TAXONOMY
{
    protected function get_post_type(): string|array
    {
        return [ThemeWizard::ExamplePostType()->get_slug()];
    }
}