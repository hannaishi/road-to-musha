<?php
/**
 * 武者への道 テーマの機能を読み込む。
 *
 * @package road-to-musha
 */
// テーマサポート・アセット関連
require_once get_template_directory() . '/includes/theme-support.php';

// 投稿一覧・メインクエリ関連
require_once get_template_directory() . '/includes/query.php';

// 投稿設定・カテゴリー・おすすめ記事関連
require_once get_template_directory() . '/includes/post-settings.php';

// SEO関連
require_once get_template_directory() . '/includes/seo.php';

// 管理画面関連
require_once get_template_directory() . '/includes/admin.php';
