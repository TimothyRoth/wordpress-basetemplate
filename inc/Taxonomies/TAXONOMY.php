<?php

namespace basetemplate\Taxonomies;

use basetemplate\ThemeWizard;

abstract class TAXONOMY
{

    protected string $taxonomy_name;
    protected array|string $post_type_name;

    /**
     * @hint the associated post type is defined by the get_post_type method
     * on default that method will return 'post'
     * @hint you can overwrite the get_post_type method and the get_name method inside the child class if you want to change
     * the associated post type/s or the taxonomy name
     * @description by default the name of the taxonomy will be the name of the class separated by camel case // ExampleTaxonomy ->  Example Taxonomy
     * */

    public function __construct()
    {
        $this->post_type_name = $this->get_post_type();
        $this->taxonomy_name = $this->get_name();

        $this->create($this->taxonomy_name, $this->post_type_name);
    }

    /**
     * @param string $taxonomy_name
     * @param string|array $post_type_name
     * @param bool $auto_hook
     * @param array|null $args
     * @param string|null $text_domain
     * @return void
     *
     * @example
     * ThemeWizard::Taxonomies()->create(
     *      'example_taxonomy',             // the name of the taxonomy
     *      'example_post_type',            // the name of the post type
     *      false,                          // auto hook
     *      ['hierarchical' => true]        // additional args
     * );
     *
     * */
    public function create(string $taxonomy_name, string|array $post_type_name, bool $auto_hook = false, array $args = null, string $text_domain = null): void
    {
        $text_domain = $text_domain ?: "basetemplate";
        $seperated_taxonomy_name = ThemeWizard::Helper()->separate_camel_case($taxonomy_name);
        $labels = array(
            'name' => _x($seperated_taxonomy_name, 'taxonomy general name', $text_domain),
            'singular_name' => _x($seperated_taxonomy_name, 'taxonomy singular name', $text_domain),
            'search_items' => __('Search in ' . $seperated_taxonomy_name, $text_domain),
            'all_items' => __('All ' . $seperated_taxonomy_name, $text_domain),
            'parent_item' => __('Superior ' . $seperated_taxonomy_name, $text_domain),
            'parent_item_colon' => __('Superior ' . $taxonomy_name . ':', $text_domain),
            'edit_item' => __('Edit ' . $seperated_taxonomy_name, $text_domain),
            'update_item' => __('Save' . $seperated_taxonomy_name, $text_domain),
            'add_new_item' => __('New ' . $seperated_taxonomy_name, $text_domain),
            'new_item_name' => __('Name of ' . $seperated_taxonomy_name, $text_domain),
            'menu_name' => __($seperated_taxonomy_name, $text_domain),
        );

        $default_args = array(
            'labels' => $labels,
            'public' => true,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => array('slug' => $taxonomy_name),
        );

        if ($args) {
            $default_args = array_merge($default_args, $args);
        }

        if (is_string($post_type_name)) {
            $post_type_name = lcfirst($post_type_name);
        }

        if ($auto_hook) {
            register_taxonomy($taxonomy_name, $post_type_name, $default_args);
            return;
        }

        add_action('init', function () use ($taxonomy_name, $post_type_name, $default_args, &$return_value) {
            register_taxonomy($taxonomy_name, $post_type_name, $default_args);
        });

    }

    /**
     * @param string $taxonomy_name
     * @return object|null
     *
     * @example
     * ThemeWizard::Taxonomies()->read('example_taxonomy');
     *
     * */
    public function read(string $taxonomy_name): ?object
    {
        $taxonomy_object = get_taxonomy($taxonomy_name);
        return $taxonomy_object ? (object)$taxonomy_object : null;
    }

    /**
     * @param string $taxonomy_name
     * @param string $post_type_name
     * @param array $args
     * @return bool
     *
     * @example
     * ThemeWizard::Taxonomies()->update(
     *      'example_taxonomy',             // the name of the taxonomy
     *      'example_post_type',            // the name of the post type
     *      ['hierarchical' => false]       // additional args
     * );
     *
     * */
    public function update(string $taxonomy_name, string $post_type_name, array $args = []): bool
    {
        $old_taxonomy = $this->read($taxonomy_name);

        if ($old_taxonomy) {
            $args = array_merge((array)$old_taxonomy, $args);
            $this->delete($taxonomy_name);
            $this->create($taxonomy_name, $post_type_name, 'false', $args);
            return true;
        }

        return false;
    }

    /**
     * @param string $taxonomy_name
     * @param bool $auto_hook
     * @return bool
     *
     * @example
     * ThemeWizard::Taxonomies()->delete('example_taxonomy');
     *
     * */
    public function delete(string $taxonomy_name, bool $auto_hook = false): bool
    {
        if ($auto_hook) {
            return add_action('init', function () use ($taxonomy_name) {
                unregister_taxonomy($taxonomy_name);
            });
        }

        if (taxonomy_exists($taxonomy_name)) {
            return unregister_taxonomy($taxonomy_name);
        }
        return false;
    }

    /**
     * @return string
     * @description this method is used to get the name of the taxonomy based on the class name
     * @hint a different name can be forced by overwriting this method inside the child class
     * */
    public function get_name(): string
    {
        $namespace = "basetemplate\\Taxonomies\\";
        $class_name = static::class;

        $taxonomy_name = $class_name;

        if (str_starts_with($class_name, $namespace)) {
            $taxonomy_name = str_replace($namespace, '', $class_name);
        }

        return str_replace($namespace, '', $taxonomy_name);
    }

    public function get_slug(): string
    {
        return strtolower($this->get_name());
    }

    /**
     * @description this method is used to get the associated post type/s
     * @hint you can overwrite this method inside the child class if you want to change the associated post type/s
     * */
    protected function get_post_type(): string|array
    {
        return 'post';
    }
}