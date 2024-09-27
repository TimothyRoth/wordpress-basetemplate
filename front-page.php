<?php
get_header();

use basetemplate\ThemeWizard;
use basetemplate\Csv\Csv;
use basetemplate\Pdf\Pdf; ?>

<?php if(!class_exists(ThemeWizard::class)) {
    echo "ThemeWizard not found! Please Download the Theme and run 'composer install' in the theme root directory.";
    return;
} ?>

<?php if (class_exists(ThemeWizard::class)) { ?>
    <main>
        <section id="intro">
            <div class="wrapper">
                <h1 class="page-headline"><?= ThemeWizard::Frontpage()->get_headline() ?></h1>
                <div class="btn btn-secondary trigger-ajax-test">
                    <a>Ajax Test</a>
                </div>
            </div>
        </section>

        <section id="block-1">
            <div class="wrapper">
                <?php if (ThemeWizard::Frontpage()->get_block_1_headline()) { ?>
                    <h2><?= ThemeWizard::Frontpage()->get_block_1_headline() ?></h2>
                <?php } ?>
                <div class="content-wrapper">
                    <div>
                        <?php if (ThemeWizard::Frontpage()->get_block_1_sub_headline_left()) { ?>
                            <h3><?= ThemeWizard::Frontpage()->get_block_1_sub_headline_left() ?></h3>
                        <?php } ?>
                        <?php if (ThemeWizard::Frontpage()->get_block_1_text_block_left()) { ?>
                            <p class="text-content"><?= ThemeWizard::Frontpage()->get_block_1_text_block_left() ?></p>
                        <?php } ?>
                    </div>
                    <div>
                        <?php if (ThemeWizard::Frontpage()->get_block_1_sub_headline_right()) { ?>
                            <h3><?= ThemeWizard::Frontpage()->get_block_1_sub_headline_right() ?></h3>
                        <?php } ?>
                        <?php if (ThemeWizard::Frontpage()->get_block_1_text_block_right()) { ?>
                            <p class="text-content"><?= ThemeWizard::Frontpage()->get_block_1_text_block_right() ?></p>
                        <?php } ?>
                    </div>
                    <?php if (ThemeWizard::Frontpage()->get_block_1_button_text()) { ?>
                        <div class="btn-secondary btn">
                            <a id="appointment_block_1"
                               href="<?= ThemeWizard::Frontpage()->get_block_1_button_link() ?>"><?= ThemeWizard::Frontpage()->get_block_1_button_text() ?></a>
                        </div>
                    <?php } ?>
                </div>
                <div>
                    <p><b>Ist die Test Checkbox
                            gesetzt?</b> <?= ThemeWizard::Frontpage()->is_test_checkbox_checked() ? "Ja" : "Nein" ?>
                    </p>
                    <p>Value aus dem Select-Field: <?= ThemeWizard::Frontpage()->get_block_1_select() ?></p>
                </div>
            </div>
        </section>

        <section id="example">
            <div class="wrapper">
                <h3>Beispiel Custom Post Type</h3>
                <div class="ad-wrapper">
                    <?php foreach (ThemeWizard::ExamplePostType()->query() ?? [] as $p) { ?>
                        <div class="single-ad">
                            <?= get_the_post_thumbnail($p->ID) ?>
                            <h5><?= $p->post_title; ?></h5>
                            <?= $p->post_content ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <section id="shortcodes">
            <div class="wrapper">
                <h3>Shortcode</h3>
                <?= ThemeWizard::ExampleShortcode()->render('my_shortcode') ?>
            </div>
        </section>

        <section id="send-mail">
            <div class="wrapper">
                <?php

                $csvBuilder = new Csv();
                $pdfBuilder = new Pdf();

                $csvBuilder->set_headers(['Name', 'E-Mail', 'Telefon']);
                $csvBuilder->add_row(['Max Mustermann', 'test@timothy.de', '123456789']);

                $attachment = [
                    $csvBuilder->save_as_tmp_file('example.csv'),
                    $pdfBuilder->save_as_tmp_file('exampleTemplate', 'example.pdf')
                ];

                if (isset($_POST['action']) && $_POST['action'] === 'send_mail') {
                    $mail = ThemeWizard::Mailer()->send_mail(
                        $_POST['email'],
                        $_POST['subject'],
                        'helloWorld',
                        ['content' => $_POST['welcome_phrase']],
                        $attachment
                    ); ?>

                    <script>
                        alert('E-Mail Status: <?= $mail ?>');
                    </script>

                <?php } ?>
                <h2>E-Mail Templating System</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="send_mail">
                    <p>
                        <label for="email">E-Mail Adresse</label> <br/>
                        <input type="email" name="email" id="email" required>
                    </p>
                    <p>
                        <label for="subject">Betreff</label> <br/>
                        <input type="text" name="subject" id="subject" required>
                    </p>
                    <p>
                        <label for="welcome_phrase">Nachricht (E-Mail Body)</label> <br/>
                        <textarea name="welcome_phrase" id="welcome_phrase" required></textarea>
                    </p>
                    <div class="btn btn-primary">
                        <input type="submit" value="E-Mail senden">
                    </div>
                </form>
            </div>
        </section>

        <section id="generate-qr">
            <div class="wrapper">
                <h3>QR Code Generator</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="generate_qr">
                    <input type="text" name="qr-url" class="qr-input" placeholder="URL eingeben" required>
                    <br/>
                    <br/>
                    <div class="btn btn-secondary">
                        <input type="submit" value="QR Code generieren">
                    </div>
                </form>
                <br/>
                <br/>
                <?php if (isset($_POST['action']) && $_POST['action'] === 'generate_qr') {
                    try {
                        echo ThemeWizard::Qr()->generate_code($_POST['qr-url']);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                } ?>
            </div>
        </section>

        <section id="pdf-generation">
            <div class="wrapper">
                <h3>PDF Templating System</h3>
                <textarea class="optional-pdf-content" placeholder="optionaler Inhalt :)"></textarea>
                <div class="btn btn-primary generate-pdf-test-example">
                    <a>PDF generieren</a>
                </div>
            </div>
        </section>

        <section id="faqs">

            <div class="wrapper">
                <h3>FAQs</h3>
                <p>Requires FAQ and Blogpost Addon for Wordpress</p>
                <p><i>https://gitlab.com/market-port-gmbh-intern/faq-and-blogposs-addon-for-wordpress</i></p>
                <?= ThemeWizard::Shortcode()->render('show_faqs amount="3') ?>
            </div>
        </section>

        <section id="blog">
            <div class="wrapper">

                <h3>Blog</h3>
                <p>Requires FAQ and Blogpost Addon for Wordpress</p>
                <p><i>https://gitlab.com/market-port-gmbh-intern/faq-and-blogposs-addon-for-wordpress</i></p>
                <?= ThemeWizard::Shortcode()->render('show_blogposts show_archive_button="false" order="DESC"') ?>

                <div class="btn-secondary">
                    <a id="blog_archive_frontpage" href="/blogarchiv">Alle Beiträge lesen</a>
                </div>
            </div>
        </section>

        <section id="team">
            <div class="wrapper">
                <h3>Ansprechpartner</h3>
                <p>Requires FAQ and Blogpost Addon for Wordpress</p>
                <p><i>https://gitlab.com/market-port-gmbh-intern/faq-and-blogposs-addon-for-wordpress</i></p>
                <?= ThemeWizard::Shortcode()->render('show_team amount="3"') ?>
        </section>

        <section id="review">
            <div class="wrapper">
                <h3>Reviews</h3>
                <div class="reviews">
                    <div class="review-container">
                        <p>Requires oneplusrate or rsr plugin</p>
                        <?= ThemeWizard::Shortcode()->render('oneplusrate_reviews') ?>
                    </div>
                    <div class="review-trigger">
                        <h3>Ihre Meinung zählt!</h3>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod.</p>
                        <div class="btn btn-primary">
                            <a id="reviews_frontpage" href="#test">Jetzt bewerten</a>
                        </div>
                    </div>
                </div>
        </section>
    </main>
<?php } ?>

<?php get_footer(); ?>