<?php
    $categories = get_the_category();

    if (empty($categories)) {
    return;
    }

    $category       = $categories[0];
    $category_color = get_field(
    'category_color',
    'category_' . $category->term_id
    );
?>

<span
    class="c-label"
    <?php if ($category_color): ?>
        style="background-color: <?php echo esc_attr($category_color); ?>;"
    <?php endif; ?>
>
    <?php echo esc_html($category->name); ?>
</span>