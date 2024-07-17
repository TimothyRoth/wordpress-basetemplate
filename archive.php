<?php get_header(); ?>

<?php if (have_posts()):
    while (have_posts()) : the_post(); ?>
        <main>
            <div class="wrapper">
                <article class="h-entry content">
                    <h1 class="page-headline"><?php the_title(); ?></h1>
                    <div class=" entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            </div>
        </main>
    <?php endwhile;
endif; ?>

<?php get_footer(); ?>