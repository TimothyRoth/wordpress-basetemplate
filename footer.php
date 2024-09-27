<?php

use basetemplate\ThemeWizard; ?>

<?php if (class_exists(ThemeWizard::class)) { ?>
    <footer>
        <div class="wrapper">
            <div class="footer-nav">
                <div>
                    <h3>Beispielmenü 2</h3>
                    <?php wp_nav_menu([
                        'theme_location' => 'websites',
                    ]) ?>
                </div>
                <div>
                    <h3>Beispielmenü 1</h3>
                    <?php wp_nav_menu([
                        'theme_location' => 'footer',
                    ]) ?>
                </div>
            </div>
            <div class="social-media">

                <?php
                if (ThemeWizard::SocialMedia()->get_company_instagram()) { ?>
                    <a id="insta_footer" href="<?= ThemeWizard::SocialMedia()->get_company_instagram() ?>"
                       target="_blank">
                        <img src="<?= ThemeWizard::Helper()->get_template_directory_uri() . '/assets/icons/Instagram.svg' ?>"
                             alt="Instagram">
                    </a>
                <?php }
                if (ThemeWizard::SocialMedia()->get_company_facebook()) { ?>
                    <a id="fb_footer" href="<?= ThemeWizard::SocialMedia()->get_company_facebook() ?>"
                       target="_blank">
                        <img src="<?= ThemeWizard::Helper()->get_template_directory_uri() . '/assets/icons/Facebook.svg' ?>"
                             alt="Facebook">
                    </a>
                <?php }
                if (ThemeWizard::SocialMedia()->get_company_linkedin()) { ?>
                    <a id="li_footer" href="<?= ThemeWizard::SocialMedia()->get_company_linkedin() ?>"
                       target="_blank">
                        <img src="<?= ThemeWizard::Helper()->get_template_directory_uri() . '/assets/icons/LinkedIn.svg' ?>"
                             alt="linkedIn">
                    </a>
                <?php }
                if (ThemeWizard::SocialMedia()->get_company_xing()) { ?>
                    <a id="xing_footer" href="<?= ThemeWizard::SocialMedia()->get_company_xing() ?>"
                       target="_blank">
                        <img src="<?= ThemeWizard::Helper()->get_template_directory_uri() . '/assets/icons/Xing.svg' ?>"
                             alt="xing">
                    </a>
                <?php } ?>
            </div>
            <p id="footer-bottom">
                © <?= date('Y') ?> <?= ThemeWizard::CompanyDetails()->get_company_name() ?: bloginfo('name') ?></p>
        </div>
    </footer>
<?php } ?>

<?php wp_footer(); ?>
</body>
</html>