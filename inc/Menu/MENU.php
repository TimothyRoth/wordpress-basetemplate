<?php

namespace basetemplate\Menu;

abstract class MENU
{

    /**
     * @param string $page_title
     * @param string $menu_title
     * @param string $capability
     * @param string $menu_slug
     * @param callable $function
     * @param bool $auto_hook
     * @param string $icon_url
     * @param int $position
     * @param string|null $text_domain
     * @return void
     * @hint This function will create a menu page in the admin panel
     *
     * @example
     * ThemeWizard::Menu()->createMenuPage(
     *      'Example Menu',                 // page_title
     *      'Example Menu',                 // menu_title
     *      'manage_options',               // capability
     *      'example-menu',                 // menu_slug
     *      function () {                   // callback
     *          echo "<div><h1>Hello</h1></div>";
     *      },
     *      true,                           // auto_hook default false
     *      'dashicons-admin-generic',      // icon_url default 'dashicons-admin-generic'
     *      6,                              // position default 6
     *      'basetemplate'                  // text_domain default null
     * );
     *
     *
     */
    public function createMenuPage(string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function, bool $auto_hook = false, string $icon_url = 'dashicons-admin-generic', int $position = 6, string $text_domain = null): void
    {
        if ($auto_hook) {
            add_action('admin_menu', function () use ($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position) {
                add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
            });
            return;
        }

        $text_domain = $text_domain ?? "basetemplate";

        add_menu_page(
            __($page_title, $text_domain),
            __($menu_title, $text_domain),
            $capability,
            $menu_slug,
            $function,
            $icon_url,
            $position
        );
    }

}