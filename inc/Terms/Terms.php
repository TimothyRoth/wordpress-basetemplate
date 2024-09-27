<?php

namespace basetemplate\Terms;

class Terms
{
    /**
     * @param string $term_name
     * @param string $taxonomy_name
     * @param bool $auto_hook
     * @param array $args
     * @return mixed
     *
     * @example
     * ThemeWizard::Terms()->create(
     *      'example_term',         // the name of the term
     *      'example_taxonomy')     // the name of the taxonomy
     * ;
     *
     * */
    public function create(string $term_name, string $taxonomy_name, bool $auto_hook = false, array $args = []): mixed
    {
        if ($auto_hook) {
            add_action('init', function () use ($term_name, $taxonomy_name, $args) {
                $term_info = wp_insert_term($term_name, $taxonomy_name, $args);
                is_wp_error($term_info) ? false : $term_info['term_id'];
            });
            return true;
        }

        $term_info = wp_insert_term($term_name, $taxonomy_name, $args);
        return is_wp_error($term_info) ? false : $term_info['term_id'];
    }

    /**
     * @param int $term_id
     * @param string $taxonomy_name
     * @param array $args
     * @return object|bool
     *
     * @example
     * ThemeWizard::Terms()->read(
     *      1,                  // the id of the term
     *      'example_taxonomy'  // the name of the taxonomy
     * );
     *
     * */
    public function read(int $term_id, string $taxonomy_name, array $args = []): object|bool
    {
        $term = get_term($term_id, $taxonomy_name, $args);
        return is_wp_error($term) ? false : (object)$term;
    }

    /**
     * @param int $term_id
     * @param string $taxonomy_name
     * @param array $args
     * @return mixed
     *
     * @example
     * ThemeWizard::Terms()->update(
     *      1,                          // the id of the term
     *      'example_taxonomy',         // the name of the taxonomy
     *      ['name' => 'new_name']      // new args
     * );
     *
     * */
    public function update(int $term_id, string $taxonomy_name, array $args = []): mixed
    {
        $term_info = wp_update_term($term_id, $taxonomy_name, $args);
        return is_wp_error($term_info) ? false : $term_info['term_id'];
    }

    /**
     * @param int $term_id
     * @param string $taxonomy_name
     * @param array $args
     * @return int|bool
     *
     * @example
     * ThemeWizard::Terms()->delete(
     *      1,                  // the id of the term
     *      'example_taxonomy'  // the name of the taxonomy
     * );
     *
     * */
    public function delete(int $term_id, string $taxonomy_name, array $args = []): int|bool
    {
        $term_info = wp_delete_term($term_id, $taxonomy_name, $args);
        return !is_wp_error($term_info);
    }

    /**
     * @param string $taxonomy_name
     * @return mixed
     *
     * @example
     * ThemeWizard::Terms()->getByTaxonomy('example_taxonomy');
     *
     * */
    public function getByTaxonomy(string $taxonomy_name): mixed
    {
        return get_terms([
            'taxonomy' => $taxonomy_name,
            'hide_empty' => false,
        ]);
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $taxonomy_name
     * @param array $args
     * @return mixed
     *
     * @example
     * ThemeWizard::Terms()->getBy(
     *      'slug',                 // the field to search by
     *      'example-term',         // the value to search for
     *      'example_taxonomy'      // the name of the taxonomy
     * );
     *
     * */
    public function getBy(string $field, string $value, string $taxonomy_name, array $args = []): mixed
    {
        return get_term_by($field, $value, $taxonomy_name, $args);
    }


}