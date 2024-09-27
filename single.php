<?php get_header(); ?>

<?php if (have_posts()):
    while (have_posts()) : the_post(); ?>
        <main>
            <div class="wrapper">
                <article class="h-entry content">
                    <div class="entry-content">
                        <div class="post-title">
                            <h1><?= the_title(); ?></h1>
                        </div>
                        <div class="left">
                            <?= the_post_thumbnail(); ?>
                        </div>
                        <div class="right">
                            <div class="post-date">
                                <?= get_the_date('d.m.Y'); ?>
                            </div>

                            <?php the_content(); ?>
                        </div>
                    </div>
                    <a href="/" class="back-button">Zurück</a>
                </article>
            </div>
        </main>
    <?php endwhile;
endif; ?>

<?php get_footer(); ?>