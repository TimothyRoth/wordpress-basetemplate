## What is this project about?

This is a WordPress base template that abstracts repetitive tasks and provides a clean and easy to use structure for
WordPress themes.

# Core Features

- **TemplateFactory** a Factory that provides full IDE support for all implemented classes
- **Custom AJAX** for easy usage of AJAX
- **Custom Cronjob** for easy creation of custom cronjob
- **Easy CSV Generation** adds csv to your posts, pages or emails including a template system
- **Easy Email Sending** includes a build in templating system for emails
- **Easy PDF Generation** add pdfs to your posts, pages or emails including a template system
- **Easy QR-Code Generation** add qr-codes to your posts, pages or emails
- **Custom Fields** for easy creation of custom fields / meta boxes / terms / customizer tabs and options
- **Custom Post Types** for easy creation of custom post types
- **Custom Taxonomies** for easy creation of custom taxonomies
- **Custom Shortcodes** for easy creation of custom shortcodes
- **Custom Menus** for easy creation of custom menus
- **Custom Html Container** for easy creation of custom html containers
- **Custom Helper Methods** to make your life easier providing WordPress specific helper methods with full IDE support
- **node** for JavaScript dependencies
- **Composer** for PHP dependencies
- **Webpack** for asset management
- **Sass** for CSS

# Read through the documentation

**Please read all the comments inside the classes located inside this projects root/inc/ directory .**
**Most of the classes are documented and provide a lot of information on how to use them.**
**Especially focus on the ThemeWizard class as it provides a lot of information on how to use the factory.**

# Install composer dependencies

```bash
composer install
```

## Dependencies

```bash
 "require": {
        "dompdf/dompdf": "^3.0",
        "league/csv": "^9.16"
    }
```

## To be able to build

```bash
npm install
npm run build
```

# Key Concepts

## TemplateFactory

The TemplateFactory is a Factory that provides full IDE support for all implemented classes. It provides static methods
to access all implemented classes and its methods.

### How to use the TemplateFactory

Put this code on top of your functions.php file to access the TemplateFactory:

```php
use basetemplate\ThemeWizard;

if (file_exists(get_template_directory(). '/vendor/autoload.php')) {
    require_once get_template_directory() . '/vendor/autoload.php';
    ThemeWizard::run();
}

ThemeWizard::{your class name}()->{method name}();
```

## The concept auf auto_hook = false / true

The auto_hook parameter is a boolean that is used for methods that extend WordPress functionalities like CPT,
Taxonomies, Shortcodes etc. It basically means whether the method
internally hooks its operation to a WordPress action like 'init' or 'admin_init'. If auto_hook is set to false, the
method will not hook itself.
Most of the time it is okay to leave auto_hook at its default value of false because inside a WordPress theme our code
is executed within the functions.php
file which is already hooked to the 'init' action. If you want to execute a method at a different action, you can set
auto_hook to true and wrap the method
inside a hook like this:

```php
add_action('admin_init', function() {
    ThemeWizard::class()->method();
});
```

## Add custom Classes

### Namespace conventions

- **All classes must be located inside the inc/ directory.**
- **All classes must be namespaced with the basetemplate namespace.**
- **All classes namespaces must include the directory that they are located in.**

**Example: The class located in inc/MyClass/TestClass.php must be namespaced with basetemplate\MyClass.**

```php
namespace basetemplate\MyClass;

class TestClass
{
    // your code here
}
```

### Manually add boilerplate code to the ThemeWizard class

- **add** a use statement importing your class at the top of the ThemeWizard class:

```php
use basetemplate\MyClass\TestClass;
```

- **add** the class to the self::$buildRecipes array inside the ThemeWizard class:

```php
self::$buildRecipes[
    'TestClass' => TestClass::class
]
```

- **add** the class to the self::bootstrap array inside the ThemeWizard class if it executes hooks or filter inside its
  constructor:

```php
self::$bootstrap[
    'TestClass'
]
```

- **add** the annotation to the ThemeWizard class to provide full IDE support / tell your IDE which classes are
  available
  via ThemeWizard:{your class name}():

```php
    * @method static TestClass TestClass()
```

## Everything else

For any other questions, feel free to ask me at [me@timothy-roth.de](mailto:me@timothy-roth.de).

