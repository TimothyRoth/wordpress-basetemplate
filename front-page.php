<?php get_header();

global $company_details;
global $frontpage_meta;
global $example_meta;
global $example_post_type;
global $directory; ?>

    <main>

        <section id="block-1">
            <div class="wrapper">
                <?php if (get_post_meta(get_the_id(), $frontpage_meta->block_1_headline)) { ?>
                    <h2><?= get_post_meta(get_the_id(), $frontpage_meta->block_1_headline, true) ?></h2>
                <?php } ?>
                <div class="content-wrapper">
                    <div>
                        <?php if (get_post_meta(get_the_id(), $frontpage_meta->block_1_sub_headline_left)) { ?>
                            <h3><?= get_post_meta(get_the_id(), $frontpage_meta->block_1_sub_headline_left, true) ?></h3>
                        <?php } ?>
                        <?php if (get_post_meta(get_the_id(), $frontpage_meta->block_1_text_block_left, true)) { ?>
                            <p class="text-content"><?= get_post_meta(get_the_id(), $frontpage_meta->block_1_text_block_left, true) ?></p>
                        <?php } ?>
                    </div>
                    <div>
                        <?php if (get_post_meta(get_the_id(), $frontpage_meta->block_1_sub_headline_right)) { ?>
                            <h3><?= get_post_meta(get_the_id(), $frontpage_meta->block_1_sub_headline_right, true) ?></h3>
                        <?php } ?>
                        <?php if (get_post_meta(get_the_id(), $frontpage_meta->block_1_text_block_right)) { ?>
                            <p class="text-content"><?= get_post_meta(get_the_id(), $frontpage_meta->block_1_text_block_right, true) ?></p>
                        <?php } ?>
                    </div>
                    <?php if (get_post_meta(get_the_id(), $frontpage_meta->block_1_button_text, true)) { ?>
                        <div class="btn-secondary btn">
                            <a id="appointment_block_1"
                               href="<?= get_post_meta(get_the_id(), $frontpage_meta->block_1_button_link, true) ?>"><?= get_post_meta(get_the_id(), $frontpage_meta->block_1_button_text, true) ?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <section id="example">
            <div class="wrapper">
                <h3>Beispiel Custom Post Type</h3>
                <div class="ad-wrapper">
                    <?php

                    $args = [
                        'post_type' => $example_post_type->name,
                        'posts_per_page' => -1,
                    ];

                    $ex_query = new WP_Query($args);

                    foreach ($ex_query->posts ?? [] as $p) { ?>
                        <div class="single-ad">
                            <?= get_the_post_thumbnail($p->ID) ?>
                            <h5><?= $p->post_title; ?></h5>
                            <?= $p->post_content ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </section>

        <section id="faqs">

            <div class="wrapper">
                <h3>FAQ</h3>
                <?= do_shortcode('[show_faqs]') ?>
            </div>
        </section>

        <section id="blog">
            <div class="wrapper">

                <h3>Blog</h3>
                <?= do_shortcode('[show_blogposts show_archive_button="false" order="DESC"]') ?>

                <div class="btn-secondary">
                    <a id="blog_archive_frontpage" href="/blogarchiv">Alle Beiträge lesen</a>
                </div>
            </div>
        </section>

        <section id="team">
            <div class="wrapper">
                <h3>Ansprechpartner</h3>
                <?= do_shortcode('[show_team amount="3"]') ?>
        </section>

        <section id="review">
            <div class="wrapper">
                <h3>Reviews</h3>
                <div class="reviews">
                    <div class="review-container">
                        <p>Requires oneplusrate or rsr plugin</p>
                        <?= do_shortcode('[oneplusrate_reviews]') ?>
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

<?php get_footer(); ?>