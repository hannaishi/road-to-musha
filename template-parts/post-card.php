<article class="c-post">
    <div class="c-meta">

        <?php
            $categories = get_the_category();

            if (! empty($categories)):
                $category = $categories[0];

                $category_color = get_field(
                    'category_color',
                    'category_' . $category->term_id
                );
        ?>
            <a
                href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                class="c-label"
                <?php if ($category_color): ?>
                    style="background-color: <?php echo esc_attr($category_color); ?>;"
                <?php endif; ?>
            >
                <?php echo esc_html($category->name); ?>
            </a>
        <?php endif; ?>

        <time
            datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"
            class="c-date"
        >
            <?php echo esc_html(get_the_date('Y/m/d')); ?>
        </time>

    </div>

    <a
        href="<?php the_permalink(); ?>"
        class="c-post-thumbnail"
    >
        <?php get_template_part('template-parts/post-thumbnail'); ?>
    </a>

    <h2 class="c-post-title">
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h2>
</article>