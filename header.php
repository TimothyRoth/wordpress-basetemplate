<?php use basetemplate\ThemeWizard; ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <?php wp_head(); ?>
    <title><?php wp_title(); ?></title>
</head>
<body <?php body_class(); ?>>

<?php if (class_exists(ThemeWizard::class)) { ?>
    <header id="header" class="header">

        <div class="wrapper">

            <?= ThemeWizard::HtmlContainer()->custom_logo() ?>

            <div class="info-bar mobile-container">
                <div class="inner">
                    <?= wp_nav_menu([
                        'theme_location' => 'main',
                    ]) ?>
                </div>
                <div class="trigger">
                    <img src="<?= ThemeWizard::Helper()->get_template_directory_uri() ?>/assets/icons/Info.svg"
                         alt="trigger">
                </div>
            </div>
        </div>

        <!-- Modals -->
        <div class="trigger-test modal">
            <div class="inner-modal">
                <div class="close-modal">
                    <img src="<?= ThemeWizard::Helper()->get_template_directory_uri() ?>/assets/icons/close-modal.svg"/>
                </div>
                <p>Diese Modal mit der Klasse trigger-test wird getrigger indem man einen link mit der href #test
                    definiert.</p>
                <p>Also: modal trigger-{name} und link href #{name}</p>
            </div>
        </div>
        <!-- End Modals -->
    </header>
<?php } ?>

