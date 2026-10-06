<?php

/**
 * テーマ機能を設定する。
 */
function road_to_musha_theme_setup()
{
    // タイトルタグをWordPressで管理する。
    add_theme_support('title-tag');

    // 投稿のアイキャッチ画像を有効にする。
    add_theme_support('post-thumbnails');

    // ブロックエディターにテーマ用スタイルを適用する。
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    // カスタムロゴを有効にする。
    add_theme_support(
        'custom-logo',
        [
            'height'      => 40,
            'width'       => 160,
            'flex-height' => true,
            'flex-width'  => true,
        ]
    );

    // おすすめ記事用メニューを登録する。
    register_nav_menus(
        [
            'pickup' => 'Pickup',
        ]
    );
}
add_action('after_setup_theme', 'road_to_musha_theme_setup');

/**
 * テーマのスタイルシートとスクリプトを読み込む。
 */
function road_to_musha_enqueue_assets()
{
    $theme_version = wp_get_theme()->get('Version');

    $style_path  = get_template_directory() . '/assets/css/style.css';
    $script_path = get_template_directory() . '/assets/js/main.js';

    // デバッグ時はファイルの更新日時をバージョンとして使用する。
    $style_version = WP_DEBUG && file_exists($style_path)
        ? filemtime($style_path)
        : $theme_version;

    $script_version = WP_DEBUG && file_exists($script_path)
        ? filemtime($script_path)
        : $theme_version;

    // Google Fontsを読み込む。
    wp_enqueue_style(
        'road-to-musha-google-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap',
        [],
        null
    );

    // テーマのスタイルシートを読み込む。
    wp_enqueue_style(
        'road-to-musha-style',
        get_template_directory_uri() . '/assets/css/style.css',
        ['road-to-musha-google-fonts'],
        $style_version
    );

    // テーマのJavaScriptを読み込む。
    wp_enqueue_script(
        'road-to-musha-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        $script_version,
        true
    );
}
add_action('wp_enqueue_scripts', 'road_to_musha_enqueue_assets');

/**
 * Contact Form 7の自動pタグを無効化する。
 */
add_filter('wpcf7_autop_or_not', '__return_false');
