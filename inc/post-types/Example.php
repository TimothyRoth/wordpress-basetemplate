<?php

namespace post_types;
class Example
{

    public string $name;

    public function __construct()
    {
        $this->name = 'example';
        add_action('init', [$this, 'register_baufi_online_calc_post_type']);
    }

    public function register_baufi_online_calc_post_type(): void
    {
        $labels = array(
            'name' => _x('Beispiel', 'Post Type General Name', 'basetemplate'),
            'singular_name' => _x('Beispiel', 'Post Type Singular Name', 'basetemplate'),
            'menu_name' => __('Beispiel', 'basetemplate'),
            'name_admin_bar' => __('Beispiel', 'basetemplate'),
            'archives' => __('Archiv', 'basetemplate'),
            'attributes' => __('Eigenschaften', 'basetemplate'),
            'parent_item_colon' => __('Übergeordnete Beispiele:', 'basetemplate'),
            'all_items' => __('Alle Beispiel', 'basetemplate'),
            'add_new_item' => __('Neuen Beispiel hinzufügen', 'basetemplate'),
            'add_new' => __('Neuen Beispiel hinzufügen', 'basetemplate'),
            'new_item' => __('Neuer Beispiel', 'basetemplate'),
            'edit_item' => __('Beispiel bearbeiten', 'basetemplate'),
            'update_item' => __('Beispiel editieren', 'basetemplate'),
            'view_item' => __('Beispiel ansehen', 'basetemplate'),
            'view_items' => __('Beispiel ansehen', 'basetemplate'),
            'search_items' => __('Beispiel suchen', 'basetemplate'),
            'not_found' => __('Beispiel nicht gefunden', 'basetemplate'),
            'not_found_in_trash' => __('Beispiel konnte nicht im Papierkorb gefunden werden', 'basetemplate'),
            'insert_into_item' => __('Zu diesem Beispiel hinzufügen', 'basetemplate'),
            'uploaded_to_this_item' => __('Für diesen Beispiel hochladen', 'basetemplate'),
            'items_list' => __('Beispielsliste', 'basetemplate'),
            'items_list_navigation' => __('Beispielslistennavigation', 'basetemplate'),
            'filter_items_list' => __('Beispielslistenfilter', 'basetemplate'),
        );

        $args = array(
            'label' => __('Beispiel', 'basetemplate'),
            'description' => __('Baufi Beispiel', 'basetemplate'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'thumbnail'),
            'hierarchical' => false,
            'public' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-insert',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => false,
            'can_export' => true,
            'has_archive' => false,
            'exclude_from_search' => false,
            'show_in_rest' => true,
        );
        register_post_type($this->name, $args);
    }
}