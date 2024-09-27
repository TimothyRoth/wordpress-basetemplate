<?php

namespace basetemplate;

use basetemplate\Helper\Helper;
use basetemplate\Shortcodes\SHORTCODE as Shortcode;
use basetemplate\Menu\ExampleMenu;
use basetemplate\Posttypes\ExamplePostType;
use basetemplate\Ajax\ExampleAjax;
use basetemplate\Cronjobs\TestObserver;
use basetemplate\Customizer\CompanyDetails;
use basetemplate\Customizer\SiteIdentity;
use basetemplate\Customizer\SocialMedia;
use basetemplate\Html\HtmlContainer;
use basetemplate\Metaboxes\Frontpage;
use basetemplate\Shortcodes\ExampleShortcode;
use basetemplate\Taxonomies\ExampleTaxonomy;
use basetemplate\Terms\Terms;
use basetemplate\Mailer\Mailer;
use basetemplate\Pdf\Pdf;
use basetemplate\Qr\Qr;
use basetemplate\Csv\Csv;
use RuntimeException;

/**
 * @Class ThemeWizard
 *
 * @description Main class responsible for bootstrapping the theme.
 * @hint Adding annotations for IDE autocompletion and full support of the magic method __callStatic.
 * @hint You will need add an annotation for each class you want to access statically via ThemeWizard::{class_name}()
 *
 * @register for IDE support:
 *
 * @method static Helper Helper()
 * @method static Mailer Mailer()
 * @method static Qr Qr()
 * @method static SocialMedia SocialMedia()
 * @method static CompanyDetails CompanyDetails()
 * @method static SiteIdentity SiteIdentity()
 * @method static TestObserver TestObserver()
 * @method static HtmlContainer HtmlContainer()
 * @method static ExamplePostType ExamplePostType()
 * @method static ExampleTaxonomy ExampleTaxonomy()
 * @method static Frontpage Frontpage()
 * @method static ExampleAjax ExampleAjax()
 * @method static ExampleShortcode ExampleShortcode()
 * @method static Terms Terms()
 * @method static ExampleMenu ExampleMenu()
 * @method static Shortcode Shortcode()
 */
class ThemeWizard
{
    private static ?ThemeWizard $instance = null;
    private static array $buildRecipes = [];
    private static array $cache = [];
    private static array $bootstrap = [];

    public function __construct()
    {

        /**
         * @description  The Key is the name under which the module will accessible via ThemeWizard::{Key} which will return {value}
         * @hint These are basically the build paths for the classes you want to instantiate
         *
         * @register build recipe to make the class accessible via ThemeWizard::{Key}():
         * */

        self::$buildRecipes = [
            'Helper' => Helper::class,
            'Pdf' => Pdf::class,
            'Qr' => Qr::class,
            'ExamplePostType' => ExamplePostType::class,
            'ExampleTaxonomy' => ExampleTaxonomy::class,
            'Frontpage' => Frontpage::class,
            'SocialMedia' => SocialMedia::class,
            'CompanyDetails' => CompanyDetails::class,
            'SiteIdentity' => SiteIdentity::class,
            'TestObserver' => TestObserver::class,
            'ExampleAjax' => ExampleAjax::class,
            'HtmlContainer' => HtmlContainer::class,
            'ExampleShortcode' => ExampleShortcode::class,
            'Terms' => Terms::class,
            'ExampleMenu' => ExampleMenu::class,
            'Mailer' => Mailer::class,
            'Csv' => Csv::class,
            'Shortcode' => Shortcode::class
        ];

        /**
         * @description Classes that are instantiated at the start of the application
         * @hint The only classes belonging here are those that are using hooks or filters inside their constructor
         *
         * @register classes with their associated key from the self::buildRecipes array that should be instantiated at the start of the application:
         * */

        self::$bootstrap = [
            'ExamplePostType',
            'ExampleTaxonomy',
            'ExampleMenu',
            'ExampleShortcode',
            'ExampleAjax',
            'TestObserver',
            'Frontpage',
            'SocialMedia',
            'CompanyDetails',
            'SiteIdentity',
            'Pdf'
        ];

    }

    /**
     * @param string $name The name of the class to instantiate.
     * @param bool $forceFreshInstance If true, a new instance of the class will be created.
     * @return object The instantiated class object.
     * @description Create or return an existing instance of the given class.
     */
    public static function make(string $name, bool $forceFreshInstance = false): object
    {

        if (!isset(self::$buildRecipes[$name])) {
            throw new RuntimeException("Class {$name} is not defined in ThemeWizard.");
        }

        if ($forceFreshInstance) {
            return new self::$buildRecipes[$name]();
        }

        if (!isset(self::$cache[$name])) {
            self::$cache[$name] = new self::$buildRecipes[$name]();
        }

        return self::$cache[$name];

    }

    /**
     * @param string $name
     * @param array $arguments
     * @return object
     * @description Magic method to call static methods on the ThemeWizard class.
     * @throws RuntimeException
     *
     * @example ThemeWizard::{component_name}()->{method_name}();
     *
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return self::make($name);
    }

    /**
     * @return self The singleton instance of the ThemeWizard class.
     * @description Get the singleton instance of the ThemeWizard class.
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return void
     * @description Bootstraps the components defined in the self::bootstrap array by calling the make method inside a loop.
     */
    private function boot(): void
    {
        foreach (self::$bootstrap as $classname) {
            self::make($classname);
        }
    }

    /**
     * @return self
     * @description Bootstrapping the theme by calling the boot method on the singleton instance.
     */
    public static function run(): self
    {
        $instance = self::getInstance();
        $instance->boot();
        return $instance;
    }
}
