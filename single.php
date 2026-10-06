<?php get_header(); ?>


<main class="u-ptb">
    <div class="l-container-s">
        <!-- single-article -->
        <article class="single-article">

            <div class="c-meta">
            <?php get_template_part('template-parts/category-label'); ?>

                <time
                    datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"
                    class="c-date"
                >
                    <?php echo esc_html(get_the_date('Y/m/d')); ?>
                </time>
            </div>

            <div class="single-title">
                <h1 class="c-title-level1">
                    <?php the_title(); ?>
                </h1>
            </div>

            <div class="single-thumbnail">
                <?php get_template_part('template-parts/post-thumbnail'); ?>
            </div>

            <div class="single-contents">
                <?php the_content(); ?>
            </div>

            <a
                href="https://www.google.com/"
                target="_blank"
                class="single-banner"
                rel="noopener noreferrer"
            >
                <picture>
                    <source
                        media="(max-width: 767px)"
                        srcset="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/banner-sp.png 1x,
                                <?php echo esc_url(get_template_directory_uri()); ?>/assets/img/banner-sp@2x.png 2x"
                    />
                    <source
                        media="(min-width: 768px)"
                        srcset="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/banner.png 1x,
                                <?php echo esc_url(get_template_directory_uri()); ?>/assets/img/banner@2x.png 2x"
                    />
                    <img
                        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/banner@2x.png"
                        width="1520"
                        height="338"
                        alt="模写修行 駆け出しエンジニアのためのコーディング練習教材 詳しくはこちら"
                    />
                </picture>
            </a>

        </article>
        <!-- end single-article -->

        <!-- single-recommend -->
        <aside class="single-recommend">
            <h2 class="single-recommend-title">おすすめ記事</h2>

            <div class="single-recommend-posts">
                <div class="c-posts c-posts--col2">

                    <?php
                        $current_post_id = get_the_ID();
                        $categories      = get_the_category($current_post_id);
                        $category_ids    = wp_list_pluck($categories, 'term_id');

                        $recommend_query = new WP_Query(
                            [
                                'post_type'      => 'post',
                                'posts_per_page' => 6,
                                'post__not_in'   => [$current_post_id],
                                'category__in'   => $category_ids,
                                'orderby'        => 'rand',
                            ]
                        );
                    ?>

                    <?php if ($recommend_query->have_posts()): ?>

                        <?php while ($recommend_query->have_posts()): ?>
                            <?php $recommend_query->the_post(); ?>

                            <?php get_template_part('template-parts/post-card'); ?>

                        <?php endwhile; ?>

                    <?php endif; ?>

                    <?php wp_reset_postdata(); ?>

                </div>
            </div>
        </aside>
        <!-- end single-recommend -->
    </div>
</main>

<?php get_template_part('template-parts/breadcrumb'); ?>

<?php get_template_part('template-parts/cta'); ?>

        <?php get_footer(); ?>
