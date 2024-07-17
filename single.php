<?php get_header(); ?>

<?php if (have_posts()):
    while (have_posts()) : the_post(); ?>
        <main>
            <div class="wrapper">
                <article class="h-entry content">
                    <h1 class="page-headline">Mit dem Blog bleiben Sie stets auf dem Laufenden.</h1>
                    <div class="entry-content">
                        <div class="left">
                            <?= the_post_thumbnail(); ?>
                        </div>
                        <div class="right">
                            <div class="post-date">
                                <?= get_the_date('d.m.Y'); ?>
                            </div>
                            <div class="post-title">
                                <h3><?= the_title(); ?></h3>
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