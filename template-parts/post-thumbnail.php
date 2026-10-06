<?php if (has_post_thumbnail()): ?>
    <?php the_post_thumbnail('full'); ?>
<?php else: ?>
    <img
        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/thumbnail.png"
        width="1200"
        height="630"
        alt=""
    />
<?php endif; ?>