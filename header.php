<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
        <header class="header">
            <div class="header-head">
                <div class="l-container">
                    <div class="header-head-inner">
                        <h1 class="header-logo">
                            <a href="<?php echo esc_url(home_url('/#top')); ?>">
                                <picture>
                                    <source media="(max-width: 559px)" srcset="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo-sp.png 1x, <?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo-sp@2x.png 2x" />
                                    <source media="(min-width: 560px)" srcset="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo.png 1x, <?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo@2x.png 2x" />
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo@2x.png" width="640" height="84" alt="武者への道 Presented by 模写修行" decoding="async" />
                                </picture>
                            </a>
                        </h1>

                        <div class="c-sns">
                            <div class="header-search">
                                <button
                                    class="header-search-button js-search-modal-open-button"
                                    type="button"
                                >
                                    記事検索
                                </button>
                                <?php get_template_part('template-parts/search-modal'); ?>
                            </div>
                            <a href="https://www.google.com/" class="c-sns-icon" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/icon-sns-twitter.svg" width="400" height="400" alt="twitter" decoding="async" loading="lazy" />
                            </a>
                            <a href="https://www.google.com/" class="c-sns-icon" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/icon-sns-facebook.svg" width="1024" height="1024" alt="facebook" decoding="async" loading="lazy" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                $html_css_category       = get_category_by_slug('html-css');
                $javascript_category     = get_category_by_slug('javascript');
                $wordpress_category      = get_category_by_slug('wordpress');
                $web_design_category     = get_category_by_slug('web-design');
                $web_production_category = get_category_by_slug('web-production');
            ?>
            <nav class="header-nav">
                <div class="l-container">
                    <ul class="header-list">
                    <?php if ($html_css_category): ?>
                        <li class="header-item">
                            <a href="<?php echo esc_url(get_category_link($html_css_category->term_id)); ?>">
                                HTML/CSS
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($javascript_category): ?>
                        <li class="header-item">
                            <a href="<?php echo esc_url(get_category_link($javascript_category->term_id)); ?>">
                                JavaScript
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($wordpress_category): ?>
                        <li class="header-item">
                            <a href="<?php echo esc_url(get_category_link($wordpress_category->term_id)); ?>">
                                WordPress
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($web_design_category): ?>
                        <li class="header-item">
                            <a href="<?php echo esc_url(get_category_link($web_design_category->term_id)); ?>">
                                webデザイン
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($web_production_category): ?>
                        <li class="header-item">
                            <a href="<?php echo esc_url(get_category_link($web_production_category->term_id)); ?>">
                                web制作
                            </a>
                        </li>
                    <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- end header-->
