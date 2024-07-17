<?php
require_once('inc/index.php');
$directory = get_template_directory_uri();

function theme_setup(): void
{

    // Adds Theme Supports
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');

    // Register Menus
    register_nav_menus(
        [
            'main' => 'Main Menu',
            'footer' => 'Footer Menu',
            'websites' => 'Websites Menu'
        ]
    );

    // Hide WP Version for safety reasons
    remove_action('wp_head', 'wp_generator');

    // Remove RSD Links
    remove_action('wp_head', 'rsd_link');

    // Disable XML-RPC
    add_filter('xmlrpc_enabled', '__return_false');

    // Remove Shortlink from Head
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

    // Remove WLManifest Link
    remove_action('wp_head', 'wlwmanifest_link');

    // Remove Emoticons
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');

    // Remove oEmbed
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

    // Modify Error Messages
    add_filter('login_errors', 'explain_less_login_issues');

    // Stop Edit in Backend
    define('DISALLOW_FILE_EDIT', true);

    // Remove All Yoast HTML Comments
    add_action('wp_head', function () {
        ob_start(function ($o) {
            return preg_replace('/^\n?<!--.*?[Y]oast.*?-->\n?$/mi', '', $o);
        });
    }, ~PHP_INT_MAX);

    function kb_svg($svg_mime)
    {
        $svg_mime['svg'] = 'image/svg+xml';
        $svg_mime['ico'] = 'image/x-icon';
        return $svg_mime;
    }

    add_filter('upload_mimes', 'kb_svg');

    /**
     * Title
     *
     */
    function custom_wp_title($title, $sep)
    {
        global $paged, $page;

        if (is_feed()) {
            return $title;
        }

        // Add the site name.
        $title .= get_bloginfo('name', 'display');

        // Add the site description for the home/front page.
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page())) {
            $title = "$title $sep $site_description";
        }

        // Add a page number if necessary.
        if (($paged >= 2 || $page >= 2) && !is_404()) {
            $title = "$title $sep " . sprintf(__('Page %s', 'basetemplate'), max($paged, $page));
        }

        return $title;
    }

    add_filter('wp_title', 'custom_wp_title', 10, 2);


    /**
     * Filters the content to remove any extra paragraph or break tags
     * caused by shortcodes.
     *
     */
    function tgm_io_shortcode_empty_paragraph_fix($content)
    {

        $array = [
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        ];
        return strtr($content, $array);

    }

    add_filter('the_content', 'tgm_io_shortcode_empty_paragraph_fix');

    // Filter except length to 35 words.
    function tn_custom_excerpt_length($length)
    {
        return 20;
    }

    add_filter('excerpt_length', 'tn_custom_excerpt_length', 999);

}

add_action('after_setup_theme', 'theme_setup');

/**
 * A bit login safety
 *
 */
function explain_less_login_issues(): string
{
    return 'ERROR: Not for you!';
}

/**
 * Theme Assets
 *
 */
function basetemplate_theme_assets(): void
{
    if (!is_admin()) {

        wp_deregister_script('jquery');
        wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js', false, '3.6.1', true);
        wp_enqueue_script('jquery');
        // JS
        wp_enqueue_script('bundle', get_template_directory_uri() . '/dist/main.min.js', ['wp-i18n'], '0.1', true);
        wp_enqueue_script('baufi_lead', 'https://www.baufi-lead.de/baufilead/partner/ejzbNF35UNSyrCgPTtNK0PkUN2Fj0O/imports.js', ['wp-i18n'], '0.1', true);
        wp_localize_script('bundle', 'ajax', ['url' => admin_url('admin-ajax.php')]);
        // CSS
        wp_enqueue_style('main', get_template_directory_uri() . '/dist/main.min.css', [], '0.1', 'all');
    }
}

add_action('wp_enqueue_scripts', 'basetemplate_theme_assets');

function admin_script(): void
{
    wp_enqueue_media();
}

add_action('admin_enqueue_scripts', 'admin_script');





