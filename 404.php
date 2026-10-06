<?php get_header(); ?>

<main>
    <div class="c-page-kv">
        <div class="l-container-s">
            <h1 class="c-title-level1 c-title-level1--center">
                404 エラー
            </h1>
        </div>
    </div>

    <div class="error-page-body">
        <div class="l-container-s">
            <div class="error-page-content">

                <p class="error-page-text">
                    申し訳ございません。お探しのページは見つかりませんでした。<br>
                    入力したアドレスが間違っているか、ページが移動・削除された可能性があります。
                </p>

                <a
                    href="<?php echo esc_url(home_url('/')); ?>"
                    class="error-page-button"
                >
                    トップへ
                </a>

            </div>
        </div>
    </div>
</main>

<?php get_template_part('template-parts/breadcrumb'); ?>

<?php get_template_part('template-parts/cta'); ?>

<?php get_footer(); ?>