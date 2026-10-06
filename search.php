<?php
    /**
 * 検索結果ページ
 *
 * @package road-to-musha
 */

    get_header();
?>

<main>
    <!-- page kv -->
    <div class="c-page-kv">
        <div class="l-container">
            <h1 class="c-title-level1">
                『<?php echo esc_html(get_search_query()); ?>』の検索結果
            </h1>
        </div>
    </div>
    <!-- end page kv -->

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

            <p>
                『<?php echo esc_html(get_search_query()); ?>』の検索結果が見つかりませんでした。
            </p>

        <?php endif; ?>

        </div>
    </div>
</main>

<?php get_template_part('template-parts/breadcrumb'); ?>

<?php get_template_part('template-parts/cta'); ?>

<?php get_footer(); ?>