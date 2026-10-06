<?php get_header(); ?>

<main>

    <?php if (is_front_page()): ?>

        <!-- top-kv -->
        <?php
            $pickup_post_id = road_to_musha_get_pickup_post_id();
        ?>

        <?php if ($pickup_post_id): ?>

            <?php
                $pickup_query = new WP_Query(
                    [
                        'post_type'      => 'post',
                        'post_status'    => 'publish',
                        'posts_per_page' => 1,
                        'post__in'       => [$pickup_post_id],
                        'orderby'        => 'post__in',
                    ]
                );
            ?>

            <?php if ($pickup_query->have_posts()): ?>

                <div class="top-kv">
                    <div class="l-container">
                        <div class="top-kv-inner">

                            <?php while ($pickup_query->have_posts()): ?>
                                <?php $pickup_query->the_post(); ?>

                                <article class="top-kv-recommend">
                                    <a href="<?php the_permalink(); ?>" class="top-kv-recommend-link">

                                        <div class="top-kv-recommend-thumbnail">
                                            <?php get_template_part('template-parts/post-thumbnail'); ?>
                                        </div>

                                        <div class="top-kv-recommend-body">

                                            <?php get_template_part('template-parts/category-label'); ?>

                                            <h2 class="top-kv-recommend-title">
                                                <?php the_title(); ?>
                                            </h2>

                                            <div class="top-kv-recommend-date">
                                                <time
                                                    datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"
                                                    class="c-date"
                                                >
                                                    <?php echo esc_html(get_the_date('Y/m/d')); ?>
                                                </time>
                                            </div>

                                        </div>
                                    </a>
                                </article>

                            <?php endwhile; ?>

                            <?php wp_reset_postdata(); ?>

                            <div class="top-kv-character">
                                <img
                                    srcset="
                                        <?php echo esc_url(get_template_directory_uri()); ?>/assets/img/img-kv-character.png 1x,
                                        <?php echo esc_url(get_template_directory_uri()); ?>/assets/img/img-kv-character@2x.png 2x,
                                        <?php echo esc_url(get_template_directory_uri()); ?>/assets/img/img-kv-character@3x.png 3x
                                    "
                                    src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/img-kv-character@2x.png"
                                    width="400"
                                    height="569"
                                    alt="おすすめの記事"
                                />
                            </div>

                        </div>
                    </div>

                    <div class="top-kv-treat">
                        <img
                            srcset="
                                <?php echo esc_url(get_template_directory_uri()); ?>/assets/img/img-kv-treat.png 1x,
                                <?php echo esc_url(get_template_directory_uri()); ?>/assets/img/img-kv-treat@2x.png 2x
                            "
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/img-kv-treat@2x.png"
                            width="500"
                            height="172"
                            alt=""
                        />
                    </div>
                </div>

            <?php endif; ?>

        <?php endif; ?>
        <!-- end top-kv -->

    <?php elseif (is_search() || is_archive()): ?>

        <!-- page-kv -->
        <div class="c-page-kv">
            <div class="l-container">

                <h1 class="c-title-level1">

                    <?php if (is_search()): ?>

                        『<?php echo esc_html(get_search_query()); ?>』の検索結果

                    <?php elseif (is_category()): ?>

                        『<?php echo esc_html(single_cat_title('', false)); ?>』の記事一覧

                    <?php elseif (is_day()): ?>

                        <?php echo esc_html(get_query_var('year')); ?>年<?php echo esc_html(get_query_var('monthnum')); ?>月<?php echo esc_html(get_query_var('day')); ?>日の記事一覧

                    <?php elseif (is_month()): ?>

                        <?php echo esc_html(get_query_var('year')); ?>年<?php echo esc_html(get_query_var('monthnum')); ?>月の記事一覧

                    <?php elseif (is_year()): ?>

                        <?php echo esc_html(get_query_var('year')); ?>年の記事一覧

                    <?php else: ?>

                        <?php the_archive_title(); ?>

                    <?php endif; ?>

                </h1>

            </div>
        </div>
        <!-- end page-kv -->

    <?php endif; ?>

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

                <?php if (is_search()): ?>

                    <p class="c-posts-empty">
                        『<?php echo esc_html(get_search_query()); ?>』の検索結果が見つかりませんでした。
                    </p>

                <?php elseif (is_front_page()): ?>

                    <p class="c-posts-empty">
                        現在、投稿がありません。
                    </p>

                <?php else: ?>

                    <p class="c-posts-empty">
                        現在、該当する投稿がありません。
                    </p>

                <?php endif; ?>

            <?php endif; ?>

        </div>
    </div>

</main>

<?php if (! is_front_page()): ?>
    <?php get_template_part('template-parts/breadcrumb'); ?>
<?php endif; ?>

<?php get_template_part('template-parts/cta'); ?>

<?php get_footer(); ?>