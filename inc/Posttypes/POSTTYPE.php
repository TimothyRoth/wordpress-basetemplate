<?php

namespace basetemplate\Posttypes;

use basetemplate\ThemeWizard;
use WP_Query;

abstract class POSTTYPE
{

    /**
     * @description a post type by the name of the child class will be created
     * @hint to create a post type the only thing you need to do is to create child class of this class
     * @hint to pass your own parameters you can override the parents constructor and call the create method with your own parameters
     * */
    public function __construct()
    {
        $this->create(
            $this->get_name()
        );
    }

    /**
     * @param string $table_name
     * @param bool $auto_hook
     * @param bool $show_in_menu
     * @param bool $public
     * @param bool $has_archive
     * @param string $menu_icon
     * @param array|null $args
     * @param string|null $text_domain
     * @return mixed
     * @description this method is used to create a post type
     *
     * @example
     * $this->create(
     *      'example_post_type', // the name of the post type
     *      false, // auto hook
     *      // overwrite default values ...
     * )
     *
     * */
    public function create(string $table_name, bool $auto_hook = false, bool $show_in_menu = true, bool $public = true, bool $has_archive = true, string $menu_icon = "dashicons-admin-post", array $args = null, string $text_domain = null): mixed
    {
        $labels = [
            'name' => _x(ThemeWizard::Helper()->separate_camel_case($table_name), 'post type general name', ''),
        ];

        $text_domain = $text_domain ?: "basetemplate";

        $default_args = [
            'label' => __($table_name, $text_domain),
            'labels' => $labels,
            'hierarchical' => false,
            'public' => $public,
            'show_ui' => $show_in_menu,
            'show_in_menu' => $show_in_menu,
            'show_in_admin_bar' => $show_in_menu,
            'show_in_nav_menus' => $show_in_menu,
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'thumbnail'],
            'menu_icon' => $menu_icon,
            'can_export' => true,
            'publicly_queryable' => $public,
            'has_archive' => $has_archive,
            'exclude_from_search' => !$public,
            'capability_type' => 'post',
            '_builtin' => false,
            'query_var' => false,
        ];

        if ($args) {
            $default_args = array_merge($default_args, $args);
        }

        if ($auto_hook) {
            return add_action('init', function () use ($table_name, $default_args) {
                register_post_type($table_name, $default_args);
            });
        }

        return register_post_type($table_name, $default_args);
    }

    /**
     * @param string $table_name
     * @param bool $auto_hook
     * @return mixed
     * @description this method is used to drop a post type
     *
     * @example
     * $this->drop("example_post_type");
     *
     * */
    public function drop(string $table_name, bool $auto_hook = false): mixed
    {
        if ($auto_hook) {
            return add_action('init', function () use ($table_name) {
                unregister_post_type($table_name);
            });
        }

        return unregister_post_type($table_name);
    }

    /**
     * @param array|null $custom_query_args
     * @return array
     * @description this method is used to query posts of the post type
     *
     * @example
     * TemplateWizard::ExamplePostType()->query([
     *      'posts_per_page' => 10 // overwrite default posts_per_page value
     * ]);
     *
     * */
    public function query(array $custom_query_args = null): array
    {
        $query_args = [
            'post_type' => $this->get_name(),
            'posts_per_page' => -1,
        ];

        if ($custom_query_args) {
            $query_args = array_merge($query_args, $custom_query_args);
        }

        return (new WP_Query($query_args))->posts;
    }

    /**
     * @return string
     * @description this method is used to get the name of the post type based on the class name
     * @hint a different name can be forced by overwriting this method inside the child class
     * */
    public function get_name(): string
    {
        $namespace = "basetemplate\\Posttypes\\";
        $class_name = static::class;

        $post_type_name = $class_name;

        if (str_starts_with($class_name, $namespace)) {
            $post_type_name = str_replace($namespace, '', $class_name);
        }

        return str_replace($namespace, '', $post_type_name);
    }

    public function get_slug(): string
    {
        return strtolower($this->get_name());
    }

}