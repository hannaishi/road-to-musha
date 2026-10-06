<?php get_header(); ?>

<main>
<!-- top-kv -->
    <div class="top-kv">
        <div class="l-container">
            <div class="top-kv-inner">

                <?php
                    $recommend_query = new WP_Query(
                        [
                            'post_type'      => 'post',
                            'post_status'    => 'publish',
                            'posts_per_page' => 1,
                            'meta_query'     => [
                                [
                                    'key'     => 'is_recommend',
                                    'value'   => '1',
                                    'compare' => '=',
                                ],
                            ],
                        ]
                    );
                ?>

                <?php if ($recommend_query->have_posts()): ?>
                    <?php while ($recommend_query->have_posts()): ?>
                        <?php $recommend_query->the_post(); ?>

                        <article class="top-kv-recommend">
                            <a
                                href="<?php the_permalink(); ?>"
                                class="top-kv-recommend-link"
                            >
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
                <?php endif; ?>

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
<!-- end top-kv -->

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
                    現在、投稿がありません。
                </p>

            <?php endif; ?>

        </div>
    </div>
</main>

<?php get_template_part('template-parts/cta'); ?>

<?php get_footer(); ?>
