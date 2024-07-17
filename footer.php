<?php
global $company_details;
global $social_media;
global $directory; ?>

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
            <?php global $social_media;
            if (get_theme_mod($social_media->company_instagram)) { ?>
                <a id="insta_footer" href="<?= get_theme_mod($social_media->company_instagram, true) ?>"
                   target="_blank">
                    <img src="<?= get_template_directory_uri() . '/assets/icons/Instagram.svg' ?>" alt="Instagram">
                </a>
            <?php }
            if (get_theme_mod($social_media->company_facebook)) { ?>
                <a id="fb_footer" href="<?= get_theme_mod($social_media->company_facebook, true) ?>" target="_blank">
                    <img src="<?= get_template_directory_uri() . '/assets/icons/Facebook.svg' ?>" alt="Facebook">
                </a>
            <?php }
            if (get_theme_mod($social_media->company_linkedin)) { ?>
                <a id="li_footer" href="<?= get_theme_mod($social_media->company_linkedin, true) ?>" target="_blank">
                    <img src="<?= get_template_directory_uri() . '/assets/icons/LinkedIn.svg' ?>" alt="linkedIn">
                </a>
            <?php }
            if (get_theme_mod($social_media->company_xing)) { ?>
                <a id="xing_footer" href="<?= get_theme_mod($social_media->company_xing) ?>" target="_blank">
                    <img src="<?= get_template_directory_uri() . '/assets/icons/Xing.svg' ?>" alt="xing">
                </a>
            <?php } ?>
        </div>
        <p id="footer-bottom">
            © <?= date('Y') ?> <?= get_theme_mod($company_details->company_name) ? get_theme_mod($company_details->company_name, true) : bloginfo('name') ?></p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>