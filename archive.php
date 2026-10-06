<?php get_header(); ?>

<main>
    <!-- page-kv -->
    <div class="c-page-kv">
        <div class="l-container">
            <h1 class="c-title-level1">

                <?php if (is_category()): ?>

                    『<?php echo esc_html(single_cat_title('', false)); ?>』の記事一覧

                <?php elseif (is_day()): ?>

                    <?php echo esc_html(get_query_var('year')); ?>年<?php echo esc_html(get_query_var('monthnum')); ?>月<?php echo esc_html(get_query_var('day')); ?>日の記事一覧

                <?php elseif (is_month()): ?>

                    <?php echo esc_html(get_query_var('year')); ?>年<?php echo esc_html(get_query_var('monthnum')); ?>月の記事一覧

                <?php elseif (is_year()): ?>

                    <?php echo esc_html(get_query_var('year')); ?>年の記事一覧

                <?php endif; ?>

            </h1>
        </div>
    </div>
    <!-- end page-kv -->

    <div class="u-ptb">
        <div class="l-container">

            <?php if (have_posts()): ?>

                <div class="c-posts c-posts--col3">

                    <?php while (have_posts()): ?>
                        <?php the_post(); ?>

                        <?php get_template_part('template-parts/post-card'); ?>

                    <?php endwhile; ?>

                </div>

                <?php get_template_part('template-parts/pagination'); ?>

            <?php else: ?>

                <p class="c-posts-empty">
                    現在、該当する投稿がありません。
                </p>

            <?php endif; ?>

        </div>
    </div>
</main>

<?php get_template_part('template-parts/breadcrumb'); ?>

<?php get_template_part('template-parts/cta'); ?>

<?php get_footer(); ?>