<?php get_header(); ?>

<main class="u-ptb">
    <div class="l-container-s">

        <?php if (have_posts()): ?>
            <?php while (have_posts()): ?>
                <?php the_post(); ?>

                <h1 class="c-title-level1">
                    <?php the_title(); ?>
                </h1>

                <div class="l-page-body">
                    <?php the_content(); ?>
                </div>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</main>

<?php get_template_part('template-parts/breadcrumb'); ?>

<?php if (! is_page('contact')): ?>
    <?php get_template_part('template-parts/cta'); ?>
<?php endif; ?>

<?php get_footer(); ?>