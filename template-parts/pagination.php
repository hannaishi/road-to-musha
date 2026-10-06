<?php
    $pagination_links = paginate_links(
    [
        'type'      => 'array',
        'mid_size'  => 1,
        'end_size'  => 1,
        'prev_text' => '<span class="u-visually-hidden">前のページ</span>',
        'next_text' => '<span class="u-visually-hidden">次のページ</span>',
    ]
    );
?>

<?php if ($pagination_links): ?>
    <nav class="c-pagination" aria-label="ページネーション">
        <?php foreach ($pagination_links as $link): ?>
            <?php
                $link = str_replace(
                    'page-numbers current',
                    'c-pagination-item is-pagination-active',
                    $link
                );

                $link = str_replace(
                    'page-numbers',
                    'c-pagination-item',
                    $link
                );

                $link = str_replace(
                    'c-pagination-item prev',
                    'c-pagination-item c-pagination-item--prev',
                    $link
                );

                $link = str_replace(
                    'c-pagination-item next',
                    'c-pagination-item c-pagination-item--next',
                    $link
                );
            ?>

            <?php echo wp_kses_post($link); ?>
        <?php endforeach; ?>
    </nav>
<?php endif; ?>